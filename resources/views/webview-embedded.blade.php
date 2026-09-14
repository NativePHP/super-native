<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Embedded PHP runtime</title>
    <style>
        body {
            margin: 0; padding: 24px; background: #eef2ff; color: #111;
            font: 16px -apple-system, system-ui, sans-serif;
        }
        h1 { margin: 0 0 12px; font-size: 22px; }
        p { margin: 0 0 10px; }
        .stat { background: rgba(99, 102, 241, .12); padding: 10px 14px; border-radius: 10px; margin-bottom: 10px; }
        .stat strong { color: #4338ca; }
        a { color: #4338ca; }

        /* ── Keyboard / IME test (mobile-air PR #156) ────────────────────
           The bug being tested resizes the WebView while the keyboard
           animates in, which reflows exactly these two things: viewport
           units and fixed positioning. So the page uses both, and probes
           them from script. */
        h2 { margin: 24px 0 8px; font-size: 17px; }
        input {
            width: 100%; box-sizing: border-box; padding: 12px 14px;
            font-size: 16px; /* < 16px makes Chromium zoom on focus, muddying the test */
            border: 2px solid #c7d2fe; border-radius: 10px; background: #fff;
        }
        input:focus { outline: none; border-color: #4338ca; }
        .verdict { font-weight: 700; }
        .vh-probe { position: absolute; top: 0; left: -9999px; width: 1px; height: 100vh; }
        .fixed-bar {
            position: fixed; left: 0; right: 0; bottom: 0;
            padding: 12px 16px; background: #4338ca; color: #fff; font-size: 13px;
        }
        body { padding-bottom: 76px; } /* clear the fixed bar */
        body.keyboard-visible .fixed-bar { background: #15803d; }
    </style>
</head>
<body>
    <h1>Embedded PHP runtime</h1>
    <p>This page is a plain Laravel web route rendered inside the demo's
        <code>php</code>-mode webview — served by the app's own runtime, not
        a sandboxed foreign page.</p>

    <div class="stat">PHP <strong>{{ PHP_VERSION }}</strong> · Laravel <strong>{{ app()->version() }}</strong></div>
    <div class="stat">Session visits: <strong>{{ $hits }}</strong> — persists across reloads because the app session is shared.</div>
    <div class="stat">Native bridge: <strong id="bridge">checking…</strong></div>

    <p><a href="{{ route('webview.embedded', absolute: false) }}">Reload</a> — bumps the counter and fires <code>&#64;navigated</code>.</p>

    <h2>Keyboard / IME inset test</h2>
    <p>Focus the field to raise the keyboard. The WebView should <em>not</em> be
        resized: the layout viewport and <code>100vh</code> stay put while
        Chromium shrinks the visual viewport and scrolls the field into view.</p>

    <input id="field" type="text" placeholder="Tap here to open the keyboard" autocomplete="off">

    <div class="stat" style="margin-top:10px">layout viewport <code>innerHeight</code>: <strong id="ih">–</strong> · range seen <strong id="ihrange">–</strong></div>
    <div class="stat"><code>100vh</code> resolves to: <strong id="vh">–</strong> · range seen <strong id="vhrange">–</strong></div>
    <div class="stat">visual viewport: <strong id="vv">–</strong> · <code>body.keyboard-visible</code>: <strong id="kb">no</strong></div>
    <div class="stat">verdict: <span class="verdict" id="verdict">focus the field…</span></div>

    <div class="vh-probe" id="vhProbe"></div>
    <div class="fixed-bar">position: fixed bar — should stay pinned to the bottom, not jump mid-animation</div>

    <script>
        // Android injects the bridge at page-finish (iOS at document start),
        // so poll briefly instead of sampling once during parse.
        (function check(tries) {
            var el = document.getElementById('bridge');
            if (window.Native) {
                el.textContent = 'window.Native is available';
            } else if (tries > 0) {
                el.textContent = 'checking…';
                setTimeout(function () { check(tries - 1); }, 100);
            } else {
                el.textContent = 'not available';
            }
        })(30);

        // Keyboard / IME probe. The distinction that matters: `innerHeight`
        // and `100vh` describe the *layout* viewport — the WebView's own box.
        // If the keyboard changes them, the native side resized the WebView
        // and every 100vh/fixed layout reflows mid-animation (the bug PR #156
        // fixes). `visualViewport.height` shrinking is correct and expected;
        // that is Chromium doing its job.
        (function () {
            var ih = document.getElementById('ih'),
                ihRange = document.getElementById('ihrange'),
                vh = document.getElementById('vh'),
                vhRange = document.getElementById('vhrange'),
                vv = document.getElementById('vv'),
                kb = document.getElementById('kb'),
                verdict = document.getElementById('verdict'),
                probe = document.getElementById('vhProbe');

            var minIH, maxIH, minVH, maxVH;

            function sample() {
                var h = window.innerHeight;
                var p = probe.offsetHeight;

                minIH = minIH === undefined ? h : Math.min(minIH, h);
                maxIH = maxIH === undefined ? h : Math.max(maxIH, h);
                minVH = minVH === undefined ? p : Math.min(minVH, p);
                maxVH = maxVH === undefined ? p : Math.max(maxVH, p);

                ih.textContent = h + 'px';
                ihRange.textContent = minIH + '–' + maxIH + 'px';
                vh.textContent = p + 'px';
                vhRange.textContent = minVH + '–' + maxVH + 'px';
                vv.textContent = window.visualViewport
                    ? Math.round(window.visualViewport.height) + 'px'
                    : 'unsupported';
                kb.textContent = document.body.classList.contains('keyboard-visible') ? 'yes' : 'no';

                // A couple of px of slack: browser chrome can jitter by 1–2px
                // without that being a reflow.
                var drift = Math.max(maxIH - minIH, maxVH - minVH);
                if (drift > 4) {
                    verdict.textContent = 'WebView RESIZED — layout viewport moved ' + drift + 'px';
                    verdict.style.color = '#b91c1c';
                } else {
                    verdict.textContent = 'stable — layout viewport held at ' + maxIH + 'px';
                    verdict.style.color = '#15803d';
                }
            }

            sample();
            window.addEventListener('resize', sample);
            if (window.visualViewport) {
                window.visualViewport.addEventListener('resize', sample);
                window.visualViewport.addEventListener('scroll', sample);
            }
            // The class is injected from native and resize events can be
            // coalesced during the animation, so poll as a backstop.
            setInterval(sample, 200);
        })();
    </script>
</body>
</html>

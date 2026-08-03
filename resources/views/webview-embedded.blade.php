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
    </script>
</body>
</html>

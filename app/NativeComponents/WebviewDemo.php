<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class WebviewDemo extends NativeComponent
{
    public string $url = 'https://example.com';

    public string $lastNavigatedUrl = '';

    public string $mode = 'remote';

    public function showRemote(): void
    {
        $this->mode = 'remote';
    }

    public function showLocal(): void
    {
        $this->mode = 'local';
    }

    public function showPhp(): void
    {
        $this->mode = 'php';
    }

    public function showFullscreen(): void
    {
        $this->mode = 'fullscreen';
    }

    public function onUrlChanged(string $url): void
    {
        $this->lastNavigatedUrl = $url;
    }

    public function navTitle(): string
    {
        return 'Webview';
    }

    public function render(): View
    {
        return view('native.webview-demo', [
            'localHtml' => $this->localHtml(),
        ]);
    }

    private function localHtml(): string
    {
        return <<<'HTML'
<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      body { margin: 0; font: 16px -apple-system, system-ui, sans-serif;
             padding: 24px; color: #111; background: #fef3c7; }
      h1 { margin: 0 0 12px; font-size: 22px; }
      p  { margin: 0 0 8px; }
      code { background: rgba(0,0,0,.08); padding: 2px 6px; border-radius: 4px; }
    </style>
  </head>
  <body>
    <h1>Inline HTML slot</h1>
    <p>This document was loaded with <code>baseURL = null</code>, so the
       webview has an opaque origin and cannot reach back into the host app.</p>
    <p>JavaScript is disabled by default — try clicking this:</p>
    <p><a href="https://example.org">example.org</a> (will fire <code>@navigated</code>).</p>
  </body>
</html>
HTML;
    }
}

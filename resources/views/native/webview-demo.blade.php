@if ($mode === 'fullscreen')
    {{-- v3-style takeover: the webview is the entire screen content, extending
         behind the safe areas. Navigate back (top-left chevron) to exit —
         a fresh visit remounts in remote mode. --}}
    <native:webview
        src="{{ $url }}"
        javascript
        fullscreen
        @navigated="onUrlChanged"
        class="w-full h-full"
    />
@else
<native:column class="w-full h-full bg-white">
    <native:row class="px-4 py-3 gap-2 items-center bg-gray-100">
        <native:column
            @press="showRemote"
            class="flex-1 items-center px-2 py-2 rounded-full {{ $mode === 'remote' ? 'bg-blue-500' : 'bg-gray-300' }}">
            <native:text class="text-sm font-semibold {{ $mode === 'remote' ? 'text-white' : 'text-gray-700' }}">
                Remote
            </native:text>
        </native:column>
        <native:column
            @press="showLocal"
            class="flex-1 items-center px-2 py-2 rounded-full {{ $mode === 'local' ? 'bg-blue-500' : 'bg-gray-300' }}">
            <native:text class="text-sm font-semibold {{ $mode === 'local' ? 'text-white' : 'text-gray-700' }}">
                Inline
            </native:text>
        </native:column>
        <native:column
            @press="showPhp"
            class="flex-1 items-center px-2 py-2 rounded-full {{ $mode === 'php' ? 'bg-blue-500' : 'bg-gray-300' }}">
            <native:text class="text-sm font-semibold {{ $mode === 'php' ? 'text-white' : 'text-gray-700' }}">
                PHP
            </native:text>
        </native:column>
        <native:column
            @press="showFullscreen"
            class="flex-1 items-center px-2 py-2 rounded-full {{ $mode === 'fullscreen' ? 'bg-blue-500' : 'bg-gray-300' }}">
            <native:text class="text-sm font-semibold {{ $mode === 'fullscreen' ? 'text-white' : 'text-gray-700' }}">
                Full
            </native:text>
        </native:column>
    </native:row>

    <native:text class="px-4 py-2 text-xs text-gray-500" :max_lines="2">
        Last @navigated → {{ $lastNavigatedUrl ?: '(none yet)' }}
    </native:text>

    @if ($mode === 'remote')
        <native:webview
            src="{{ $url }}"
            javascript
            @navigated="onUrlChanged"
            class="flex-1 w-full"
        />
    @elseif ($mode === 'local')
        <native:webview @navigated="onUrlChanged" class="flex-1 w-full">
            {!! $localHtml !!}
        </native:webview>
    @else
        {{-- Enriched mode: the app's own Laravel webview — embedded runtime,
             shared session, window.Native bridge. src is an app route path. --}}
        <native:webview
            php
            src="/webview-embedded"
            @navigated="onUrlChanged"
            class="flex-1 w-full"
        />
    @endif
</native:column>
@endif

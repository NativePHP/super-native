<column class="w-full h-full safe-area-top">
    <scroll-view scroll-anchor="bottom" :shows-indicators="false" class="w-full flex-1 px-1 py-1">
        @foreach($messages as $message)
            <row class="w-full  mb-2">
                @if($message['mine'])
                    <spacer />
                @endif
                <column class="{{$message['mine'] ? 'bg-blue-600' : 'bg-gray-300'}} rounded-xl px-4 py-2">
                    <text class="{{$message['mine'] ? 'text-white' : 'text-gray-800'}}">{{$message['message']}}</text>
                </column>
                @unless($message['mine'])
                    <spacer />
                @endunless
            </row>
        @endforeach

    </scroll-view>
    <column class="w-full h-20 px-2">
        <row class="border border-purple-500 rounded-full p-2 items-center">
            <bare-text-input native:model="draft" class="w-full px-4 py-2 text-2xl" placeholder="Type a message" />
            <pressable @tap="sendMessage" class="bg-purple-700 rounded-full p-4">
                <native:icon class="text-white" :ios="\App\Icons\Ios::Paperplane" />
            </pressable>
        </row>
    </column>
</column>

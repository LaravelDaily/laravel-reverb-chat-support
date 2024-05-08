<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="">
                        @foreach($chatRoom->chatMessages as $message)
                            <div class="mb-2 @if($chatRoom->user_id != $message->user_id) text-right @endif">
                                <span class="font-bold">{{ $message->user->name }}</span>
                                <p>{{ $message->message }}</p>
                            </div>
                        @endforeach
                        <div id="chat-messages"></div>
                    </div>
                    <div class="mt-4 pt-4 border-t-2">
                        <textarea class="w-full" id="reply"></textarea>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="send">
                            Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/html">
        <div class="mb-2 _POSITION_">
            <span class="font-bold">_NAME_</span>
            <p>_MESSAGE_</p>
        </div>
    </script>

    <script>
        // On reply click send the message
        document.getElementById('send').addEventListener('click', function () {
            let message = document.getElementById('reply').value;

            fetch('{{ route('admin-reply', $chatRoom->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: message
                })
            })
                .then(data => {
                    // Push the message to the chat
                    let template = document.querySelector('script[type="text/html"]').innerHTML;
                    template = template.replace('_POSITION_', 'text-right');
                    template = template.replace('_NAME_', '{{ auth()->user()->name }}');
                    template = template.replace('_MESSAGE_', message);

                    document.getElementById('chat-messages').innerHTML += template;
                    document.getElementById('reply').value = '';
                });
        });

        window.addEventListener('DOMContentLoaded', function () {
            // Listen for new messages
            window.Echo.private('userRepliedToChatRoom.{{ $chatRoom->id }}')
                .listen('UserSentChatMessageEvent', (e) => {
                    let template = document.querySelector('script[type="text/html"]').innerHTML;
                    template = template.replace('_POSITION_', '');
                    template = template.replace('_NAME_', e.chatMessage.user.name);
                    template = template.replace('_MESSAGE_', e.chatMessage.message);

                    document.getElementById('chat-messages').innerHTML += template;
                });
        });
    </script>
</x-app-layout>

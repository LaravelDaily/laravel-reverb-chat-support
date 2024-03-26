<div class="fixed bottom-2 right-2 bg-blue-900 rounded-xl"
     style="width: 64px; height: 64px;">
    <button id="chatbox-button" class="mx-auto flex justify-center items-center "
            style="width: 64px; height: 64px;">
    </button>
</div>
<div id="chatbox-container" class="hidden fixed bottom-24 right-2 bg-gray-200 border-2 border-blue-400"
     style="min-width: 400px; max-width: 30%; height: 600px">
    <div class="p-6 flex flex-col justify-between h-full">
        <div class="pb-4 mb-4 border-b-2 border-b-gray-400">
            <h2 class="text-2xl text-center">Chat with Customer Support</h2>
        </div>
        <div class="overflow-y-scroll h-full" id="messagesList">
            <div class="">
                <div class="font-bold">System</div>
                <p>
                    Hello, how can we help you?
                </p>
            </div>
        </div>
        <div class="pt-4 mt-4 border-t-2 border-t-gray-400">
            <textarea id="message" class="w-full"></textarea>
            <button id="sendMessage" class="w-full bg-blue-300 py-2">Send Message</button>
        </div>
    </div>
</div>

<script type="text/html">
    <div class="_POSITION_">
        <div class="font-bold">_SENDER_</div>
        <p>MESSAGE</p>
    </div>
</script>

<script>
    const MESSAGE_ICON = `
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="-3 -2 32 32" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail p-0 m-0">
        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
        <polyline points="22,6 12,13 2,6"></polyline>
    </svg>
`;

    const CLOSE_ICON = `
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="-3 -2 32 32" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x p-0 m-0">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
`;

    // Set the session identifier
    // This acts as "rooms" for now, and will be cleared on page refresh
    let identifier = '{{ auth()->id() }}-{{ uniqid() }}';

    // Add default chatbox button icon as soon as page loads
    const chatboxButton = document.getElementById('chatbox-button');
    chatboxButton.innerHTML = MESSAGE_ICON;

    // Add event listener to chatbox button (open/close chatbox)
    document.getElementById('chatbox-button').addEventListener('click', function () {
        const chatboxContainer = document.getElementById('chatbox-container');
        chatboxContainer.classList.toggle('hidden');
        if (chatboxContainer.classList.contains('hidden')) {
            chatboxButton.innerHTML = MESSAGE_ICON;
        } else {
            chatboxButton.innerHTML = CLOSE_ICON;
        }
    })


    // Send the message on sendMessage button click
    document.getElementById('sendMessage').addEventListener('click', function () {
        const message = document.getElementById('message').value;
        const messagesList = document.getElementById('messagesList');
        const messageTemplate = document.querySelector('script[type="text/html"]').innerHTML;

        // Post the message to the server
        fetch('{{ route('send-message') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({message: message, identifier: identifier})
        })
            .then(() => {
                const newMessage = messageTemplate
                    .replace('_POSITION_', 'text-right')
                    .replace('_SENDER_', 'You')
                    .replace('MESSAGE', message);
                messagesList.innerHTML += newMessage;

                document.getElementById('message').value = '';
            });
    });
</script>
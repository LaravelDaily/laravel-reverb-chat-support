<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customer Support Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">User Name</th>
                            <th class="border px-4 py-2">Message Count</th>
                            <th class="border px-4 py-2">Last Update</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($chatRooms as $chatRoom)
                            <tr>
                                <td class="border px-4 py-2">{{ $chatRoom->identifier }}</td>
                                <td class="border px-4 py-2">{{ $chatRoom->user->name }}</td>
                                <td class="border px-4 py-2">{{ $chatRoom->chat_messages_count }}</td>
                                <td class="border px-4 py-2">{{ $chatRoom->updated_at }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('chatRooms.show', $chatRoom->id) }}"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            @foreach ($sortedChats->toArray() as $project_id => $chat)
                <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                    <p>Project: {{ $chat["project_title"] }}</p>
                    @if (auth()->user()->role == "freelancer")
                        <p>Customer: {{ $chat["customer"]->name . " " . $chat["customer"]->surname }}</p>
                    @else
                        <p>Freelancer: {{ $chat["freelancer"]->name . " " . $chat["customer"]->surname }}</p>
                    @endif
                    <form action="{{ route("showChat") }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project_id }}">
                            <input type="hidden" name="client_id" value="{{ $chat["customer"]->id }}">
                            <input type="submit" value="{{ auth()->user()->role == "freelancer" ? "Chat with customer" : "Chat with freelancer" }}">
                        </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

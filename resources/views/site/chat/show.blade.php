<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            @foreach ($messages as $message)
                <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; {{ $message->sender_id == auth()->id() ? "text-align: right" : "" }}">
                    <p>{{ $message->sender_id == auth()->id() ? "You" : (auth()->user()->role == "customer" ? "freelancer" : "client") }}</p>
                    <p>{{ $message->created_at }}</p>
                    <p>{{ $message->message }}</p>
                </div>
            @endforeach
            <form action="{{ route("storeMessage")  }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project_id }}">
                <input type="hidden" name="freelancer_id" value="{{ $freelancer_id }}">
                <input type="hidden" name="receiver_id" value="{{ auth()->user()->role == 'customer' ? $freelancer_id : $client_id }}">
                <input type="text" name="message" id="message" required class="text-black">
                <input type="submit" value="Send">
            </form>
        </div>
    </div>
</x-app-layout>

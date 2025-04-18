<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <div>
                <p>Name: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Registered at: {{ $user->created_at }}</p>
            </div>
            <h1>Reviews:</h1>
            @foreach ($reviews as $review)
                <div class="border p-4 my-2">
                    <p>{{ $review->created_at }}</p>
                    <p>{{ $review->reviewer }}</p>
                    <p>Project: {{ $review->project }}</p>
                    <p>Rating: {{ $review->rating }}</p>
                    <p>Comment: {{ $review->comment }}</p>
                </div>
            @endforeach
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

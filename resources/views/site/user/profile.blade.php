<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <div>
                <p>Name: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Registered at: {{ $user->created_at }}</p>
                <p>User id: {{ $user->id }}</p>
                <p>Role: {{ $user->role }}</p>
                <a href="../freelancer-reviews/{{ $user->id }}">Reviews about me</a>
            </div>
        </div>
    </div>
</x-app-layout>

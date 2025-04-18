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
                @if ($user->role == 'freelancer')
                <a href="../freelancer-reviews/{{ $user->id }}" style="display: inline-block; padding: 8px 16px; background-color: #4F46E5; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background-color 0.2s;">Reviews about me</a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

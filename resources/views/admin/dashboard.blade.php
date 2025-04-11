<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            @foreach ($users as $user )
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 15px ;">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>User: {{ $user->name . " " . $user->surname }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>Role: {{ $user->role }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

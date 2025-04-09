<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create dispute') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <form action="{{ route("dispute.store") }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $data["project_id"] }}">
                <input type="hidden" name="respondent_id" value="{{ $data["respondent_id"] }}">
                <p><label for="reason">Reason:</label></p>
                <textarea name="reason" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="Create dispute">
            </form>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Disputes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            
            @foreach ($disputes as $dispute)
                <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                    <p>Complainant: {{$dispute->complainant->name . " " . $dispute->complainant->surname}}</p>
                    <p>Respondent: {{$dispute->respondent->name . " " . $dispute->respondent->surname}}</p>
                    <p>Reason: {{ $dispute->reason }}</p>
                    <p>Result: {{ $dispute->resolution }}</p>
                    <p>Status: {{ $dispute->status }}</p>
                    <p>Created at: {{ $dispute->created_at }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

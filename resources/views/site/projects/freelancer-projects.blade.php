<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            @foreach ($projects as $project)
                <figure style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                    <figcaption>
                        @if ($project->freelancer_id != NULL && $project->status != "completed")
                            <h2 style="color: gold">{{ $project->status }}</h2>
                        @elseif ($project->status == "completed")
                            <h2 style="color: green">{{ $project->status }}</h2>
                        @endif
                        <p>Created at: {{ $project->created_at }}</p>
                        <p>Status: {{ $project->status }}</p>
                        <h2>{{ $project->title }}</h2>
                        <p>Category: {{ $project->category }}</p>
                        <p>{{ $project->description }}</p>
                        <p>Budget: from {{ $project->budget_min}}  to {{ $project->budget_max}}</p>
                        <p>Term: {{ $project->deadline }}</p>
                        @if ($project->status != "completed")
                        <p>Time remain: {{ \Carbon\Carbon::parse($project->updated_at)->addDays($project->deadline)->diffForHumans() }}</p>
                        @endif
                        <form action="{{ route("showChat") }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="client_id" value="{{ $project->client_id }}">
                            <input type="submit" value="Chat with customer">
                        </form>
                        @if ($project->freelancer_id != NULL && $project->status != "completed")
                            <form action="{{ route("dispute.create") }}" method="POST">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <input type="hidden" name="client_id" value="{{ $project->client_id }}">
                                <input type="hidden" name="freelancer_id" value="{{ $project->freelancer_id }}">
                                <input type="submit" value="Arbitrage">
                            </form>
                        @endif
                        <!-- <a href="{{ route('showChat', [$project->id, $project->client_id]) }}" class="text-blue-500 hover:text-blue-700">Chat with customer</a> -->
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</x-app-layout>

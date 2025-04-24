<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <form method="GET" action="{{ route('customerProjects') }}" class="mb-6">
                <label for="status">Filter by status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="ml-2 p-1 rounded border text-black">
                    <option value="">All</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in progress" {{ request('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </form>
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
                        @if ($project->freelancer_id == NULL)
                            <a href="edit-project/{{ $project->id }}" style="background-color: #2196F3; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 5px; text-decoration: none; display: inline-block;">Edit Project</a><br>
                            <a href="project/{{ $project->id }}" style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 5px; text-decoration: none; display: inline-block;">Choose freelancer</a>
                        @elseif ($project->status != "completed")
                            <p>Time remain: {{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($project->updated_at)->addDays($project->deadline), true) }} left</p>
                            <form action="{{ route('closeProject', $project->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 5px;">Complete</button>
                            </form>
                            @if ($project->freelancer_id != NULL)
                                <form action="{{ route("dispute.create") }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <input type="hidden" name="client_id" value="{{ $project->client_id }}">
                                    <input type="hidden" name="freelancer_id" value="{{ $project->freelancer_id }}">
                                    <input type="submit" value="Arbitrage" style="background-color: #ff9800; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 5px;">
                                </form>
                            @endif
                        @endif
                        <form action="{{ route("showChat") }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="client_id" value="{{ $project->client_id }}">
                            <input type="hidden" name="freelancer_id" value="{{ $project->freelancer_id }}">
                            @if ($project->freelancer_id != NULL)
                                <input type="submit" value="Chat with freelancer" style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 5px;">
                            @endif
                        </form>
                        @if ($project->status == "completed")
                            <form action="{{ route('review.create') }}" method="POST">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <input type="hidden" name="recipient_id" value="{{ $project->freelancer_id }}">
                                <input type="submit" value="Leave a comment about freelancer" style="background-color: #2196F3; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 5px;">
                            </form>
                        @elseif ($project->status == "open")
                            <form action="{{ route('project.delete', $project->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background-color: #f44336; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 5px;">Delete project</button>
                            </form>
                        @endif                                            
                    </figcaption>
                </figure>
                
            @endforeach
            <div class="mt-6">
                {{ $projects->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

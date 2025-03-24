<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            @foreach ($projects as $project)
                @if ($project->status != 'completed' || $project->status != 'closed')
                    <figure style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                        <figcaption>
                            @if ($project->freelancer_id != NULL)
                                <h2 style="color: gold">{{ $project->status }}</h2>
                            @endif
                            <p>Created at: {{ $project->created_at }}</p>
                            <p>Status: {{ $project->status }}</p>
                            <h2>{{ $project->title }}</h2>
                            <p>Category: {{ $project->category }}</p>
                            <p>{{ $project->description }}</p>
                            <p>Budget: from {{ $project->budget_min}}  to {{ $project->budget_max}}</p>
                            <p>Term: {{ $project->deadline }}</p>

                            @if ($project->freelancer_id == NULL)
                                <a href="project/{{ $project->id }}">More</a>
                            @endif
                        </figcaption>
                    </figure>
                @endif
                
            @endforeach
        </div>
    </div>
</x-app-layout>

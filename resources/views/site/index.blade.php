<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <h1>Filters</h1>
            
            <form method="GET" action="{{ route('site.index') }}" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="category" class="block mb-2">Category:</label>
                        <select name="category" id="category" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="budget_min" class="block mb-2">Min Budget:</label>
                        <input type="number" name="budget_min" id="budget_min" value="{{ request('budget_min') }}" 
                            class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    
                    <div>
                        <label for="budget_max" class="block mb-2">Max Budget:</label>
                        <input type="number" name="budget_max" id="budget_max" value="{{ request('budget_max') }}" 
                            class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
                
                <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Apply Filters
                </button>
            </form>
            @if ($projects->isEmpty())
            <p>No projects found.</p>
            @else
            <p>Found {{ $projects->count() }} projects.</p>
            @foreach ($projects as $project)
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
            @endforeach
            @endif
        </div>
    </div>
</x-app-layout>

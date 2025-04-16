<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <form action="{{ route("project.update")  }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <input type="hidden" name="freelancer_id" value="{{ $project->freelancer_id }}">
                <input type="file" name="image" id="image">
                <label for="title">Назва</label>
                <p><input type="text" name="title" id="title" value="{{ $project->title }}" class="text-gray-900" required></p>
                <label for="category">Категорія</label>
                <p>
                    <select name="category" id="category" class="text-gray-900" value="{{ $project->category }}">
                        @foreach ($categories as $category)
                            <option value="{{ $category->category }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </p>
                <label for="description">Опис</label>
                <p>
                    <textarea name="description" id="description" cols="30" rows="10" class="text-gray-900">{{ $project->description }}</textarea>
                </p>
                <label for="budget_min">Мінімальний бюджет</label>
                <p><input type="text" name="budget_min" id="budget_min" value="{{ $project->budget_min }}" class="text-gray-900" required></p>
                <label for="max-budget">Максимальний бюджет</label>
                <p><input type="text" name="budget_max" id="budget_max" value="{{ $project->budget_max }}" class="text-gray-900" required></p>
                <label for="deadline">Термін</label>
                <p><input type="text" name="deadline" id="deadline" value="{{ $project->deadline }}" class="text-gray-900" required></p>
                <input type="submit" value="Зберегти">
            </form>
        </div>
    </div></x-app-layout>

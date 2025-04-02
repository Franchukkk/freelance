<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <form action="{{ route("project.store")  }}" method="POST">
                @csrf
                <label for="title">Назва</label>
                <p><input type="text" name="title" id="title" required class="text-gray-900"></p>
                <label for="category">Категорія</label>
                <p>
                    <select name="category" id="category" class="text-gray-900">
                        @foreach ($categories as $category)
                            <option value="{{ $category->category }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </p>
                <label for="description">Опис</label>
                <p>
                    <textarea name="description" id="description" cols="30" rows="10" class="text-gray-900"></textarea>
                </p>
                <label for="budget_min">Мінімальний бюджет</label>
                <p><input type="text" name="budget_min" id="budget_min" required class="text-gray-900"></p>
                <label for="max-budget">Максимальний бюджет</label>
                <p><input type="text" name="budget_max" id="budget_max" required class="text-gray-900"></p>
                <label for="deadline">Термін</label>
                <p><input type="text" name="deadline" id="deadline" required class="text-gray-900"></p>
                <input type="submit" value="Створити">
            </form>
        </div>
    </div></x-app-layout>

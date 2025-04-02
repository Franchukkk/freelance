<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Leave comment about freelancer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <form action="{{ route("review.store")  }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $data["project_id"] }}">
                <input type="hidden" name="recipient_id" value="{{ $data["recipient_id"] }}">
                <label for="rating">Rating</label>
                <p><input type="number" name="rating" id="rating" required class="text-gray-900"></p>
                <label for="comment">Comment</label>
                <p>
                    <textarea name="comment" id="comment" cols="30" rows="10" class="text-gray-900"></textarea>
                </p>
                <input type="submit" value="Leave comment">
            </form>
        </div>
    </div></x-app-layout>

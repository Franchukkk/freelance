<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100">
            <figure style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                <figcaption>
                    <p>Customer: {{ $customer ->name . " " . $customer ->surname }}</p>
                    <p>Created at: {{ $project->created_at }}</p>
                    <p>Status: {{ $project->status }}</p>
                    <h2>{{ $project->title }}</h2>
                    <p>Category: {{ $project->category }}</p>
                    <p>{{ $project->description }}</p>
                    <p>Budget: from {{ $project->budget_min}}  to {{ $project->budget_max}}</p>
                    <p>Term: {{ $project->deadline }}</p>
                </figcaption>
            </figure>

            <div>
                <h2>Make bid</h2>
                @if (!$userHasBid && auth()->user()->role == 'freelancer' && $project->client_id != auth()->id())
                    <form action="{{ route('makeBid') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="client_id" value="{{ $project->client_id }}">
                        <label for="bid_amount">Bid amount</label>
                        <p><input type="text" name="bid_amount" id="bid_amount" required></p>
                        <label for="message">Message</label>
                        <p><textarea name="message" id="message" cols="30" rows="10"></textarea></p>
                        <label for="deadline_time">Deadline</label>
                        <p><input type="text" name="deadline_time" id="deadline_time" required></p>
                        <input type="submit" value="Make bid">
                    </form>
                @elseif (auth()->user()->role == 'customer' && $project->client_id == auth()->id())
                    <p style="color: red;">You can not place bid on your project</p>
                @elseif (auth()->user()->role == 'customer' && $project->client_id != auth()->id())
                    <p style="color: red;">Customers can not place bid</p>
                @else
                    <p style="color: red;">You have already placed a bid for this project.</p>
                @endif
            </div>

            <div>
                <h2>Bids</h2>
                @if ($bids->isNotEmpty())
                @foreach ( $bids as $bid )
                    <figure style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
                        <figcaption>
                            
                            <p>{{ $bid->freelancer }}</p>
                            <p>{{ $bid->created_at }}</p>
                            <p>Bid amount: {{ $bid->bid_amount }}</p>
                            <p>Term: {{ $bid->deadline_time }} days</p>
                            <p>{{ $bid->message }}</p>

                            @if (auth()->user()->role == 'customer' && $project->client_id == auth()->id())
                                <form action="{{ route('acceptBid')  }}" method="get">
                                    @csrf
                                    <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <input type="hidden" name="freelancer_id" value="{{ $bid->freelancer_id }}">
                                    <input type="submit" value="Accept bid and pay" style="background-color: green; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                                </form>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
                @else
                <p>No bids yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

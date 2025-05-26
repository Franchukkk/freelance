<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display the review creation form.
     *
     * @param Request $request The HTTP request containing project, client and freelancer IDs
     * @return \Illuminate\View\View
     */
    public function leaveReview(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'recipient_id' => 'required|exists:users,id'
        ]);

        $data = [
            'project_id' => $validated['project_id'],
            'recipient_id' => $validated['recipient_id']
        ];

        return view('site/review/create', compact('data'));
    }

    /**
     * Store a new review for a project.
     *
     * @param Request $request The HTTP request containing review data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(ReviewRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'project_id' => $validated['project_id'],
            'reviewer_id' => auth()->id(),
            'recipient_id' => $validated['recipient_id'],
            'comment' => $validated['comment'],
            'rating' => $validated['rating'],
        ];
        Review::create($data);

        return to_route('customerProjects');
    }

    /**
     * Display reviews for a freelancer.
     *
     * @param int $id The ID of the freelancer
     * @return View
     */
    public function openFreelancerReview($id)
    {
        $user = User::findOrFail($id);

        $reviews = Review::where('recipient_id', $id)->paginate(1);

        foreach ($reviews as $review) {
            $reviewer = User::findOrFail($review->reviewer_id);
            $review->reviewer = $reviewer->name . ' ' . $reviewer->surname;
            $review->project = Project::findOrFail($review->project_id)->title ?? 'Без назви';
        }

        return view('site/review/view', compact('reviews', 'user'));
    }

}

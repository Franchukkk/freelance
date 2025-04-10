<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

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
        $data = [
            'project_id' => $request->post("project_id"),
            'recipient_id' => $request->post("recipient_id")
        ];

        return view('site/review/create', compact('data'));
    }

    /**
     * Store a new review for a project.
     *
     * @param Request $request The HTTP request containing review data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(Request $request)
    {
        $data = [
            'project_id' => $request->post("project_id"),
            'reviewer_id' => auth()->id(),
            'recipient_id' => $request->post("recipient_id"),
            'comment' => $request->post("comment"),
            'rating' => $request->post("rating"),
        ];
        Review::create($data);

        return to_route('customerProjects');
    }

    public function openFreelancerReview($id)
    {
        $user = User::getById($id);
        $reviews = Review::where('recipient_id', $id)->get();
        foreach ($reviews as $review) {
            $review->reviewer = User::getById($review->reviewer_id)->name . ' ' . User::getById($review->reviewer_id)->surname;
            $review->project = Project::find($review->project_id)->title;
        }
        
        return view('site/review/view', compact('reviews', 'user'));
    }

}

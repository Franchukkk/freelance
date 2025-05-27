<?php

namespace App\Http\Controllers\Site;

use App\Models\Bid;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\BidRequest;

class BidController extends Controller
{
    /**
     * Store a new bid for a project
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeBid(BidRequest $request)
    {
        $project_id = $request->post("project_id");
        $bids = Bid::getBidsByProjectId($project_id);
        $userHasBid = $bids->where('freelancer_id', auth()->user()->id)->isNotEmpty();

        if (!$userHasBid) {
            $data = $request->validated();
            $data['project_id'] = $project_id;
            $data['freelancer_id'] = auth()->user()->id;

            Bid::create($data);
            $userHasBid = true;
        }

        return to_route('project', $project_id);
    }


    public function deleteBid(Request $request)
    {
        $validated = $request->validate([
            'bid_id' => 'required|exists:bids,id',
            'project_id' => 'required|exists:projects,id'
        ]);

        $bid = Bid::findOrFail($validated['bid_id']);
        if ($bid->freelancer_id != auth()->user()->id) {
            abort(403);
        }

        $bid->delete();

        return to_route('project', $validated['project_id']);
    }

    /**
     * Accept a bid for a project
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function acceptBid(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'freelancer_id' => 'required|exists:users,id'
        ]);

        Project::setFreelancerAndChangeStatus($validated['project_id'], $validated['freelancer_id']);

        return to_route('customerProjects', $validated['project_id']);
    }

    /**
     * Display accepted bids for the authenticated freelancer
     *
     * @return View
     */
    public function acceptedBids(Request $request)
    {
        $projects = Project::where('freelancer_id', auth()->id())
            ->latest()
            ->paginate(2)
            ->withQueryString();

        return view('site/projects/freelancer-projects', compact('projects'));
    }

}

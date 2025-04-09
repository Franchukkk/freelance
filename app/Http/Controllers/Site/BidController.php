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
            Bid::create($request->validated());
            $userHasBid = true;
        }

        return to_route('project', $project_id);
    }

    /**
     * Accept a bid for a project
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function acceptBid(Request $request)
    {
        Project::setFreelancerAndChangeStatus($request->post("project_id"), $request->post("freelancer_id"));

        return to_route('customerProjects', $request->post("project_id"));
    }

    /**
     * Display accepted bids for the authenticated freelancer
     *
     * @return View
     */
    public function acceptedBids() 
    {
        $projects = Project::getFreelancerProjects(auth()->id());
        return view('site/projects/freelancer-projects', compact('projects'));
    }
}

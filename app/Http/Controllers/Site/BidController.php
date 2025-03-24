<?php

namespace App\Http\Controllers\Site;
use App\Models\Bid;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function storeBid(Request $request)
    {

        $bids = Bid::getBidsByProjectId($request->project_id);
        $userHasBid = $bids->where('freelancer_id', auth()->user()->id)->isNotEmpty();

        if (!$userHasBid) {
            $data = [
                'project_id' => $request->project_id,
                'freelancer_id' => auth()->id(),
                'bid_amount' => $request->bid_amount,
                'deadline_time' => $request->deadline_time,
                'message' => $request->message,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ];
    
            Bid::storeBid($data);
            $userHasBid = true;
        }

        
        $project = Project::find($request->project_id);
        $customer = User::getById($request->client_id);
        $bids = Bid::getBidsByProjectId($request->project_id);
        
        return view('site/projects/project', compact('project', 'customer', 'bids', 'userHasBid'));
    }

    public function acceptBid(Request $request)
    {
        $projects = Project::getCustomerProjects(auth()->id());

        Project::setFreelancerAndChangeStatus($request->project_id, $request->freelancer_id);

        return view('site/projects/customer-projects', compact('projects'));
    }

    public function acceptedBids() {
        $projects = Project::getFreelancerProjects(auth()->id());
        return view('site/projects/freelancer-projects', compact('projects'));
    }
}

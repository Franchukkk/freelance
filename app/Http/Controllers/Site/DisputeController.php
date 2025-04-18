<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\DisputeRequest;

class DisputeController extends Controller
{

    /**
     * Display a listing of the disputes.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $disputes = Dispute::where('complainant_id', auth()->id())
            ->orWhere('respondent_id', auth()->id())
            ->get();

        foreach ($disputes as $dispute) {
            $dispute->complainant = User::find($dispute->complainant_id);
            $dispute->respondent = User::find($dispute->respondent_id);
            $dispute->project = Project::find($dispute->project_id);
        }
        return view('site/dispute/index', compact('disputes'));
    }
    
    /**
     * Display the dispute creation form.
     *
     * @param Request $request The HTTP request containing project, client and freelancer IDs
     * @return \Illuminate\View\View
     */
    public function createDispute(Request $request)
    {
        $data = [
            'project_id' => $request->post("project_id")
        ];

        if (auth()->user()->role === 'client') {
            $data['respondent_id'] = $request->post("freelancer_id");
        } else {
            $data['respondent_id'] = $request->post("client_id");
        }
        
        return view('site/dispute/create', compact('data'));
    }
    /**
     * Store a new dispute for a project.
     *
     * @param Request $request The HTTP request containing dispute data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeDispute(DisputeRequest $request)
    {
        $data = [
            'project_id' => $request->post("project_id"),
            'complainant_id' => auth()->id(),
            'respondent_id' => $request->post("respondent_id"),
            'description' => $request->post("description"),
            'reason' => $request->post("reason"),
            'status' => 'pending',
        ];

        Dispute::create($data);
        
        return to_route('disputes');
    }

    public function deleteDispute(Request $request)
    {
        $dispute = Dispute::find($request->post("dispute_id"));
        if ($dispute->complainant_id != auth()->user()->id) {
            abort(403);
        }
        if ($dispute) {
            $dispute->delete();
        }

        return to_route('disputes');
    }
}

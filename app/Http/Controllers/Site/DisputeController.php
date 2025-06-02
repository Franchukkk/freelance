<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Services\GoogleTagManagerService;
use App\Models\Dispute;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\DisputeRequest;
use Illuminate\Http\RedirectResponse;

class DisputeController extends Controller
{
    protected GoogleTagManagerService $service;
    public function __construct(GoogleTagManagerService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the disputes.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $disputes = Dispute::where('complainant_id', auth()->id())
            ->orWhere('respondent_id', auth()->id())
            ->paginate(1);

        foreach ($disputes as $dispute) {
            $dispute->complainant = User::findOrFail($dispute->complainant_id);
            $dispute->respondent = User::findOrFail($dispute->respondent_id);
            $dispute->project = Project::findOrFail($dispute->project_id);
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
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'freelancer_id' => 'required_if:role,client|exists:users,id',
            'client_id' => 'required_if:role,freelancer|exists:users,id'
        ]);

        $data = $this->service->createDisputePage([
            'project_id' => $validated['project_id'],
            'respondent_id' => auth()->user()->role === 'client' 
                ? $validated['freelancer_id'] 
                : $validated['client_id'],
            'complainant_id' => auth()->id(),
        ]);

        return view('site/dispute/create', compact('data'));;
    }

    /**
     * Store a new dispute for a project.
     *
     * @param DisputeRequest $request The HTTP request containing dispute data
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

    /**
     * Delete a dispute.
     *
     * @param Request $request The HTTP request containing dispute ID
     * @return RedirectResponse
     */
    public function deleteDispute(Request $request)
    {
        $validated = $request->validate([
            'dispute_id' => 'required|exists:disputes,id'
        ]);

        $dispute = Dispute::findOrFail($validated['dispute_id']);
        
        abort_if($dispute->complainant_id !== auth()->id(), 403);
        
        $dispute->delete();

        return to_route('disputes');
    }
}

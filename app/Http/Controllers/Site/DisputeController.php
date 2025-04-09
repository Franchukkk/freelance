<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    
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
    public function storeDispute(Request $request)
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
        
        return to_route('customerProjects');
    }
}

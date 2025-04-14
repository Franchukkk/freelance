<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dispute;
use App\Models\Project;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin/dashboard', compact('users'));
    }

    public function disputes()
    {
        $disputes = Dispute::where('status', 'pending')->get();
        foreach ($disputes as $dispute) {
            $dispute->complainant = User::find($dispute->complainant_id);
            $dispute->respondent = User::find($dispute->respondent_id);
            $dispute->project = Project::find($dispute->project_id);
        }
        return view('admin/disputes', compact('disputes'));
    }

    public function resolveDispute(Request $request)
    {
        $dispute = Dispute::find($request->post('dispute_id'));
        $dispute->status = 'resolved';
        $dispute->resolution = $request->post('resolution');
        $dispute->save();

        $project = Project::find($dispute->project_id);
        $project->status = 'completed';
        $project->save();

        return $this->disputes();
    }
}

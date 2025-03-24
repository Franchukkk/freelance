<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use App\Models\Bid;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::getAll();
        return view('site/projects/projects', compact('projects'));
    }

    public function createProject()
    {
        $categories = Category::getAll();
        return view('site/projects/create', compact('categories'));
    }

    public function storeProject(Request $request)
    {
        $data = [
            'client_id' => auth()->id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
            'deadline' => $request->deadline,
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
        ];

        $categories = Category::getAll();
        Project::storeProject($data);
        return view('site/projects/create', compact(
            'categories'
        ));
    }

    public function showProject($id)
    {
        $project = Project::find($id);
        $customer = User::getById($project->client_id);
        $bids = Bid::getBidsByProjectId($id);
        $userHasBid = $bids->where('freelancer_id', auth()->user()->id)->isNotEmpty();
        return view('site/projects/project', compact('project', 'customer', 'bids', 'userHasBid'));
    }

    public function customerProjects () {

        $projects = Project::getCustomerProjects(auth()->id());
        return view('site/projects/customer-projects', compact('projects'));
    }
}

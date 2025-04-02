<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return View
     */
    public function index()
    {
        $projects = Project::select(
            "title", 
            "category", 
            "description", 
            "status", 
            "budget_min", 
            "budget_max", 
            "deadline", 
            "created_at"
            )->get();
        return view('site/index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return View
     */
    public function createProject()
    {
        $categories = Category::select("category")->get();
        return view('site/projects/create', compact('categories'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  int  $id
     * @return View
     */
    public function editProject($id)
    {
        $project = Project::find($id);
        $categories = Category::select("category")->get();
        return view('site/projects/edit', compact('project', 'categories'));
    }

    /**
     * Store a newly created project or update an existing one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProject(Request $request)
    {
        $data = [
            'client_id' => auth()->id(),
            'title' => $request->post("title"),
            'category' => $request->post("category"),
            'description' => $request->post("description"),
            'budget_min' => $request->post("budget_min"),
            'budget_max' => $request->post("budget_max"),
            'deadline' => $request->post("deadline"),
            'status' => 'open',
        ];

        if ($request->post("project_id") == null) {
            Project::storeProject($data);
        } else {
            $data['id'] = $request->post("project_id");
            $data['freelancer_id'] = $request->post("freelancer_id");
            $data['status'] = "in progress";
            Project::editProject($data);
        }
   
        return to_route('customerProjects');
    }

    /**
     * Display the specified project.
     *
     * @param  int  $id
     * @return View
     */
    public function showProject($id)
    {
        $project = Project::find($id);
        $customer = User::getById($project->client_id);
        $bids = Bid::getBidsByProjectId($id);
        $userHasBid = $bids->where('freelancer_id', auth()->user()->id)->isNotEmpty();
        return view('site/projects/project', compact('project', 'customer', 'bids', 'userHasBid'));
    }

    /**
     * Display a listing of the customer's projects.
     *
     * @return View
     */
    public function customerProjects () {
        $projects = Project::getCustomerProjects(auth()->id());
        return view('site/projects/customer-projects', compact('projects'));
    }

    /**
     * Close the specified project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeProject($id)
    {
        Project::closeProject($id);
        return to_route('customerProjects');
    }

}

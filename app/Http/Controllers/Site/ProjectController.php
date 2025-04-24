<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'budget_min' => 'required|numeric',
            'budget_max' => 'required|numeric',
            'deadline' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $validated['client_id'] = auth()->id();
        $validated['status'] = "open";  

        if ($request->post("project_id") == null) {
            $project = Project::storeProject($validated);
            if (isset($validated['image'])) {
                $project->addMedia($validated['image'])
                    ->toMediaCollection('images');

                $validated['image'] = $project->getFirstMediaUrl('images');
            }
        } else {
            $validated['id'] = $request->post("project_id");
            $validated['freelancer_id'] = $request->post("freelancer_id");

            // $validated['status'] = "in progress";
            
            $project = Project::find($request->post("project_id"));
            if (isset($validated['image'])) {
                $project->clearMediaCollection('images');
                $project->addMedia($validated['image'])
                    ->toMediaCollection('images');
                $validated['image'] = $project->getFirstMediaUrl('images');
            }
            
            Project::editProject($validated);
        }   
        return to_route('customerProjects');
    }

    /**
     * Delete the specified project.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function deleteProject($id)
    {
        $project = Project::find($id);
        if ($project->client_id != auth()->user()->id) {
            abort(403);
        }
        if ($project) {
            $project->delete();
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
        $project = Project::with(['media'])->find($id);
        $project->image = $project->getFirstMediaUrl('images');
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
    public function customerProjects()
    {
        $query = Project::where('client_id', auth()->id());

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $projects = $query->latest()->paginate(2);

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

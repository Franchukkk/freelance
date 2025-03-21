<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
        $project = new Project();


        // $project::createProject($data);

        return view('site/projects/create');
    }
}

<?php

namespace App\Http\Controllers\Site;
use App\Models\Project;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**  
     * Display the index view 
     * @return \Illuminate\Contracts\View\View
     * */
    public function index()
    {
        $projects = Project::get();
        return view('site/index', compact('projects'));
    }

    /**  
     * Display the tasks view 
     * 
     * @return \Illuminate\Contracts\View\View
     * */
    // public function tasks()
    // {
    //     return view('tasks');
    // }

    /**  
     * Display the chats view 
     * 
     * @return \Illuminate\Contracts\View\View
     * */
    // public function chats()
    // {
    //     return view('chats');
    // }
}

<?php

namespace App\Http\Controllers\Site;

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
        return view('index');
    }


    /**  
     * Display the tasks view 
     * 
     * @return \Illuminate\Contracts\View\View
     * */
    public function tasks()
    {
        return view('tasks');
    }

    /**  
     * Display the chats view 
     * 
     * @return \Illuminate\Contracts\View\View
     * */
    public function chats()
    {
        return view('chats');
    }
}

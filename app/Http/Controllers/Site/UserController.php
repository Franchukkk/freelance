<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the portfolio view
     * @return \Illuminate\Contracts\View\View
     * */

    public function index()
    {
        $user = auth()->user();
        // dd($user->disputes);
        return view('site/user/profile', compact('user'));
    }
}

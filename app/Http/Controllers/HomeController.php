<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Posts::all()->sortByDesc('created_at');;
//        return $this->hasMany(Posts::class)->orderBy('created_at','DESC');
        return view('home',compact('user'));

//        $user_profile = User::find($user);
//        return view('home');
    }
}

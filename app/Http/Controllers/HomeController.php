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
    public function indexs()
    {
        $user = Posts::all()->sortByDesc('created_at');
//        return $this->hasMany(Posts::class)->orderBy('created_at','DESC');
        return view('home',compact('user'));

//        $user_profile = User::find($user);
//        return view('home');
    }

    // Update to utilize pagination
    public function indexer()
    {
//        $user = Posts::paginate(5); // Paginate 10 posts per page
//        $user = Posts::paginate();
//        $user = Posts::simplePaginate(5); // Paginate 10 posts per page
//        dd($user);
//        $user = Posts::all()->sortByDesc('created_at')->paginate(5);
        $user = Posts::orderBy('created_at', 'desc')->paginate(5);
        return view('home',compact('user'));
    }

    public function index (Request $request)
    {
        $query = Posts::query();

        // Apply filters
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('home_type')) {
            $query->where('home_type', $request->home_type);
        }

        if ($request->filled('price_type')) {
            $query->where('price_type', $request->price_type);
        }
        $page = $request->input('page', 1);

        // Paginate results
        $user = $query->orderBy('created_at', 'desc')
//            ->paginate(8)
            ->simplePaginate(8)
//            ->paginate(8, ['*'], 'page', $page)
            ->appends($request->query()); // keep query params in pagination links
        // If empty and not first page, return HTTP 204
        if ($user->isEmpty() && $page > 1) {
            return response()->noContent();
        }
        return view('home', compact('user'));
    }
}

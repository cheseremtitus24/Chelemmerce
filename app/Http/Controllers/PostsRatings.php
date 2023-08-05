<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PostsRatings extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reviewstore(Request $request){
        $review = new \App\Models\PostsRatings;
        $review->post_id = $request->post_id;
        $review->comments= $request->comment;
        $review->star_rating = $request->rating;
        $review->user_id = auth()->user()->id;
//        $review->service_id = $request->service_id;
        $review->save();
        return redirect()->back()->with('flash_msg_success','Your review has been submitted Successfully,');
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }


    public function create()
    {

//        $user_profile = User::find($user);
        return view('posts/create');
    }

    public function document()
    {

//        $user_profile = User::find($user);
        return view('posts/document');
//        return view('posts/create');
    }
    public function preview()
    {

//        $user_profile = User::find($user);
        $user = User::find(auth()->user()->id);

        // PASSING DATA TO THE VIEW

        return view('posts/preview',[
            'user' => $user,
        ]);
//        return view('posts/preview');
    }

    public function store()
    {

//        $user_profile = User::find($user);
        $data = request()->validate(
            [
//                'catch_phrase' => 'required',
                'title' => 'required',
                'image' => 'required',
                'image_description' => '',
                'description' => 'required',
                'amount' => 'required'
            ]
        );

        $json = $data['image'];
//        dd($data['image']);
        $img_desc = $data['image_description'];
//        dd($img_desc);

        $someArray = json_decode($json, true);
//        dd($someArray);
        $someDesc = json_decode($img_desc,true);



        $a=array();
        $imagePath = 0;

        foreach ($someArray as $key => $value)
        {
//            echo $value["id"];
            if (empty($imagePath)) {
                $imagePath = $value['image']; // Sets the first image as the default post image
//                echo $temp . ' is considered empty';
            }

            array_push($a,$value['id']);



        }
//        print_r($a);
//        dd($a);
        $itemTypes = $a;

//        $imagePath = request('image')->store('uploads','public');
//        $image = Image::make(public_path("storage/{$imagePath}"))->fit(600,900);
//        $image->save();

        $post = auth()->user()->posts()->create(
            [
                'title' => $data['title'],
                'image' => $imagePath,
                'description' => $data['description'],
                'amount' => $data['amount'],
            ]);


        Images::whereIn('id', $itemTypes)// Update the grabbed image index with the current post_id
        ->update([
            'posts_id' => "$post->id",
//            'description' => 'Up',

        ]);


        dd($someDesc);

//        foreach ($someDesc as $value)
//        {
//            dd($value);
//        }
////        dd($someDesc[0]);
///TODO: Update the image description with different values based on image_id's
///




//        dd($data);


        return redirect('/profile/'.auth()->user()->id);

    }

    public function show(Posts $post) // Show the posts from the Images Table that match the current post
    {
//        dd($post);
        $images = $post;
        return view('posts.show',compact('post','images'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Mavinoo\Batch\Batch;

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

        return view('posts/preview', [
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
        $img_desc = $data['image_description'];
        $someArray = json_decode($json, true);
        $someDesc = json_decode($img_desc, true);


        $a = array();
        $imagePath = 0;

        foreach ($someArray as $key => $value) {
//            echo $value["id"];
            if (empty($imagePath)) {
                $imagePath = $value['image']; // Sets the first image as the default post image
//                echo $temp . ' is considered empty';
            }

            array_push($a, $value['id']);

        }

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

        $template = ['id' => "", 'description' => ""];
        $final = array();
//        $keys_arr = array_combine($someDesc, $itemTypes);
//        dd($itemTypes);
        foreach ($itemTypes as $key => $value) {
            $template['id'] = $value;
            $template['description'] = $someDesc[$key];
            array_push($final, $template);
//            dd($template);
        }
//        dd($final);


//        $userInstance = new Images;
        $item = new Images();
        $userInstance = $item;
        $value = $final;
        $index = 'id';
//        dd($final);

        Batch::update($userInstance, $value, $index);


        return redirect('/profile/' . auth()->user()->id);

    }

    public function show(Posts $post) // Show the posts from the Images Table that match the current post
    {
//        dd($post);
        $images = $post;
        return view('posts.show', compact('post', 'images'));
    }
}

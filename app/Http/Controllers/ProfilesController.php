<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{

    public function index($user)
    {
//        dd($user);
        // Echoes what $user is and it will stop all successive operations
//        dd(App\ProfilesController::find($user));
//        dd(App\Models\Profile::find($user));
//        dd(User::find($user));
        $user = User::findOrFail($user);
        $posts = $user->posts()->Simplepaginate(8);
        // PASSING DATA TO THE VIEW
        return view('profiles.profile',[
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function edit(User $user)
    {
        // with the following line an unauthenticated user can't access this page [policy]
//        $this->authorize('update', $user->profile);
        return view('profiles.edit',compact('user'));

    }

    public function update_brand(User $user)
    {
        // with the following line an unauthenticated user can't access this page [policy]
//        $this->authorize('update', $user->profile);
        return view('profiles.update_brand',compact('user'));

    }

    public function update_image(User $user)
    {
        // with the following line an unauthenticated user can't access this page [policy]
//        $this->authorize('update', $user->profile);

        $data = request()->validate(
            [
                "image" => 'required|mimes:jpg,png,gif,bpm,webp|max:4096'


            ]
        );
        $imagePath = request('image')->store('profiles','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(400,400);
        $image->save();
        $data=
        [
            'image'=>"$imagePath",
//            'title' => "the ",
//            'description' => 'description ',
//            'url' => "http://test.com"
        ];
//        Only grab the authenticated user by adding auth()
//        dd($data);
        auth()->user()->profile->update($data);
        return redirect("/profile/{$user->id}");
//        return view('profiles.edit',compact('user'));

    }

    public function update_description(User $user)
    {
        // with the following line an unauthenticated user can't access this page [policy]
//        $this->authorize('update', $user->profile);
        $data = request()->validate(
            [

                'title' => "required|unique:profiles",
              'description' => 'required',
              'url' => "url"


            ]
        );
        auth()->user()->profile->update($data);
        return redirect("/profile/{$user->id}");

    }

}

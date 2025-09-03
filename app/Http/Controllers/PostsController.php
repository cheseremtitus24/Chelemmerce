<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Posts;
use App\Models\User;
use App\Models\PostsRatings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Mavinoo\Batch\Batch;
use Illuminate\Support\Facades\Storage;

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



    public function edit(Request $request)
    {
        $user = auth()->user();

        // Query only this user's posts
        $query = $user->posts();

        // Apply filters only if values are non-empty
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
        $posts = $query
            ->orderBy('created_at', 'desc')
            ->simplePaginate(8)
            ->appends($request->query()); // preserve query params in pagination links

        // Return 204 if empty on non-first page
        if ($posts->isEmpty() && $page > 1) {
            return response()->noContent();
        }

        return view('posts.edit', compact('user', 'posts'));
    }


    public function store()
    {
        header('Content-Type: application/json');
        http_response_code(201);
//        $user_profile = User::find($user);
        $data = request()->validate(
            [
//                'catch_phrase' => 'required',
//                'title' => '',// Apartment 1 Room 2 Bathrooms
                'home_name' => '', // Gianna Flats
                'home_type' => '', // Apartment, Bedsitter
                'accommodation_type' => '', // Private/Shared Room
                'num_rooms' => '',
                'num_bathrooms' => '',
                'telephone' => 'required',
                'longitude' => '',
                'latitude' => '',
                'image' => 'required',
                'image_description' => '',
//                'description' => 'required', // Westlands, Nairobi, Entire Home
                'location' => 'required', // Westlands, Nairobi
                'price_type' => 'required', // per_night, per_month
                'price' => 'required'
            ]
        );

        $json = $data['image'];
        $img_desc = $data['image_description'];
        $phoneNumber = $data['telephone'];
        $priceType = $data['price_type'] == 'per_night' ? "per Night" : "per Month";
        $Amount = number_format($data['price'], 2) . ' ' . $priceType;

        $HomeDescription = $data['location'] . " - " . $data['accommodation_type'];

        $title = $data['home_type'];
        $numRooms = $data['num_rooms'] ?? 0;
        $numBathrooms = $data['num_bathrooms'] ?? 0;

        $parts = [];

        if ($numRooms > 0) {
            $roomText = ($numRooms === 1) ? "Room" : "Rooms";
            $parts[] = $numRooms . " " . $roomText;
        }

        if ($numBathrooms > 0) {
            $bathroomText = ($numBathrooms === 1) ? "Bathroom" : "Bathrooms";
            $parts[] = $numBathrooms . " " . $bathroomText;
        }

        if (!empty($parts)) {
            $TitleDescription = $title . " - " . implode(" ", $parts);
        } else {
            $TitleDescription = $title;
        }

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
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(600, 900);
        $image->save();

        $title = "";

        $post = auth()->user()->posts()->create(
            [
                'title' => $TitleDescription,
                'home_name' => $data['home_name'],
                'num_rooms' => $numRooms,
                'num_bathrooms' => $numBathrooms,
                'home_type' => $data['home_type'],
                'accommodation_type' => $data['accommodation_type'],
                'latitude' => $data['latitude'],
                'price_type' => $data['price_type'],
                'location' => $data['location'],
                'longitude' => $data['longitude'],
                'telephone' => $data['telephone'],
                'image' => $imagePath,
                'description' => $HomeDescription,
                'amount' => $Amount, // KES 500 per night
                'price' => $data['price'], // KES 500 per night
            ]);


        Images::whereIn('id', $itemTypes)// Update the grabbed image index with the current post_id
        ->update([
            'posts_id' => "$post->id",

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

        foreach ($final as $imageData) {
            Images::where('id', $imageData['id'])->update([
                'description' => $imageData['description']]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
            'redirect_url' => '/profile/' . auth()->user()->id // Provide URL for frontend to redirect
//            'redirect_url' => '/home' // Provide URL for frontend to redirect
        ], 200); // Return 200 OK status

    }

    public function posts_update(Posts $post)
    {
        $images = $post;
        $user = User::find(auth()->user()->id);
        return view('posts.posts_update', compact('post', 'images', 'user'));
    }

    public function destroy(Posts $post)
    {
//        DB::table('Posts')->where('id', $post)->delete();
        // Delete images linked to the post
        foreach ($post->images as $image) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            // delete database entry for the image.
            $image->delete();
        }

        // Delete the post's main image if it exists
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Delete the post record
        $post->delete();
        return redirect('/p/edit')->withSuccess(__('Post delete successfully.'));
    }

    public function show(Posts $post) // Show the posts from the Images Table that match the current post
    {
//        dd($post);
        $images = $post;
        return view('posts.show', compact('post', 'images'));
    }

}

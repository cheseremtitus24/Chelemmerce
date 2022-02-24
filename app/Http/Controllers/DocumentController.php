<?php

namespace App\Http\Controllers;

use App\Models\document;
use App\Models\Images;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class DocumentController extends Controller
{
    //
    // user must be logged in inorder to access this page

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.document');
    }


    public function saveDocument()
//        todo: Allow adding of image descriptions
    {

        $images = request()->validate(
            [
                'image' =>['required'],
                'image.*' => 'mimes:jpeg,png,jpg,gif,svg'

            ]
        );
        $a = array();
        if (request()->hasFile('image')) {


            foreach ($images as $files) {

                foreach ($files as $file)
                {
                    $imagePath = $file->store('uploads','public');
//                    dd("/storage/{$imagePath}");
//                    dd(public_path("storage/{$imagePath}"));
                    $image = Image::make(public_path("storage/{$imagePath}"))->fit(600,900);//->insert(public_path("storage/profiles/default.jpg"));
//                    $image = Image::make("/storage/{$imagePath}")->fit(600,900);
                    $image->save();
                    $data = auth()->user()->images()->create(
                        [

                            'image' => $imagePath,
                            'description' => '',

                        ]);
                    array_push($a,$data->id);

                }


            }

        }

        $images = Images::findOrFail($a);
        $images_list = Images::findOrFail($a);
//        dd($images);
        $user = User::find(auth()->user()->id);
        return view('/posts/create',[
            'images' => $images,
            'user' => $user,
            'images_list' => $images_list,

        ]);

    }

    public function saveDocumeent(Request $request){
        //validate the files
        $this->validate($request,[
            'image' =>'required',
            'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'public/files/';
                $file_name = time() . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name);
                $data[] = $file_name;
            }
        }
        $file= new document();
        $file->name=json_encode($data);
        $file->save();
        return back()->withSuccess('Great! Image has been successfully uploaded.');
    }

}

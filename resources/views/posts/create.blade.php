@extends('layouts.app')

{{--// todo: Add option to delete and replace images also user can change to sepia b/w and add HDR processing --}}
{{--todo: click on the image title to update. a button should be at the far right and should be a pen.--}}
@section('content')

    <style>


        * {
            box-sizing: border-box;
        }

        img {
            vertical-align: middle;
        }

        /* Position the image container (needed to position the left and right arrows) */
        .container {
            position: relative;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Add a pointer when hovering over the thumbnail images */
        .cursor {
            cursor: pointer;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 40%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 0 3px 3px 0;
            background-color: rgba(0, 0, 0, 0.8);
            user-select: none;
            -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* Container for image text */
        .caption-container {
            text-align: center;
            background-color: #222;
            padding: 2px 16px;
            color: white;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Six columns side by side */
        .column {
            float: left;
            width: 16.66%;
        }

        /* Add a transparency effect for thumnbail images */
        .demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }
    </style>

    <style>
        .form-field {
            width: 400px;
            height: auto;
            min-height: 34px;
            border: 2px solid #737679;
            padding: 8px;
            margin: 8px;
            cursor: text;
            border-radius: 3px;

            box-shadow: 0 2px 6px rgba(25, 25, 25, 0.2);
        }

        .form-field .chips .chip {
            display: inline-block;
            width: auto;

            background-color: #0077b5;
            color: #fff;
            border-radius: 3px;
            margin: 2px;
            overflow: hidden;
        }

        .form-field .chips .chip {
            float: left;
        }

        .form-field .chips .chip .chip--button {
            padding: 8px;
            cursor: pointer;
            background-color: #004471;
            display: inline-block;
        }

        .form-field .chips .chip .chip--text {
            padding: 8px;
            cursor: none;
            display: inline-block;
            pointer-events: none
        }

        .form-field > input {
            padding: 15px;
            display: block;
            box-sizing: border-box;
            width: 100%;
            height: 34px;
            border: none;
            margin: 5px 0 0;
            display: inline-block;
            background-color: transparent;
        }

    </style>

    {{--<h2 style="text-align:center">Slideshow Gallery</h2>--}}

    <h2 style="text-align:center">{{$user->profile->title}}'s New Post</h2>

    <div class="container" style="width: 400px; height: 700px">

        {{--    todo: Dynamically generate the slides based on the number of uploaded images.--}}
        {{--    Make the first input field of the Image to be visible on page post load--}}

        @foreach($images as $post)

            <div class="mySlides">
                <div class="numbertext">{{$loop->index+1}} / {{$loop->count}}</div>
                <img src="/storage/{{$post->image}}" style="width:100%">
            </div>

        @endforeach
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>


        <div class="caption-container">
            <p id="caption"></p>
        </div>


        <div class="row">
            @php
                $total_images = 0;
                $images_array = array();

            @endphp


            @foreach($images as $images)

                <span class="visually-hidden"> {{$total_images++}}</span>


                <div class="column">
                    <img id="image{{$loop->index+1}}" class="demo cursor" src="/storage/{{$images->image}}" style="width:100%"
                         onclick="ShowHideDiv();$('#reply{{$loop->index+1}}').toggle();$('#reply{{$loop->index+1}}').focus();currentSlide({{$loop->index+1}})"
                         alt="{{$images->description?? 'Add Image Description Below'}}">

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

                    <div id="replybutton" class="btn4 like py-2">
                        {{--                    <span class="btn reply" id="replyb" onClick="$('#reply').toggle();currentSlide({{$loop->index+1}})">Edit</span>--}}
                    </div>

                    <input type="text" name="reply{{$loop->index+1}}" id="reply{{$loop->index+1}}"
                           maxlength="20"
                           class="form-control pull-right col-3 "
                           placeholder="Write image{{$loop->index+1}} description..." style="display:none; width: 200px"
                           autofocus="autofocus" onblur="GrabImageDescriptions()"
                    />

                </div>

                <script>

                    function ShowHideDiv() {
                        for (let i = 1; i <= {{$total_images}}; i++) {
                            document.getElementById("reply" + i.toString()).style.display = "none";
                            // console.log("reply" + i.toString());
                        }
                    }
                </script>

            @endforeach






        </div>


        <form action="/p" enctype="multipart/form-data" method="post">
                @csrf
            <div class="row">
                <div class="col-8 offset-2">
                    {{--                Posts Header--}}
                    <div class="pt-3 d-flex justify-content-center align-items-baseline">

                        <h1>Product Details</h1>
                        {{--                    <a href="/profile/<?=auth()->user()->id?>" class="btn col-3 btn-primary btn-outline-light w-25">save</a>--}}


                    </div>

                    {{--                Posts title--}}

                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">Product Type</label>
                        Types of homes: Bedsitter,Flat,Apartment,single room, Hotel, penthouse, Villas, Bungalow
                        <input type="text"
                               id="title"
                               name="title"
                               placeholder="Bedsitter 1 Room 1 Bathroom"
                               class="form-control{{$errors->has('title') ? 'is-invalid':''}}"
                               value="{{old('title')}}"
                               autocomplete="title"
                               autofocus>

                        @if($errors->has('title'))

                            <strong class="alert-danger">{{$errors->first('title')}}</strong>

                        @endif
                    </div>
                    {{--                Posts Name--}}

                    <div class="form-group row">
                        <label for="home_name" class="col-md-4 col-form-label">Your Home Name: </label>
                        <input type="text"
                               id="home_name"
                               name="home_name"
                               placeholder="Gianna Flats"
                               class="form-control{{$errors->has('home_name') ? 'is-invalid':''}}"
                               value="{{old('home_name')}}"
                               autocomplete="home_name"
                               autofocus>

                        @if($errors->has('home_name'))

                            <strong class="alert-danger">{{$errors->first('home_name')}}</strong>

                        @endif
                    </div>

                    {{--                    Posts Captions Description--}}
                    <div class="row">
                        {{--                    <label for="image" class="col-md-4 col-form-label" >Post Caption</label>--}}
                        <input type="text" name="image_description" value="{{$images_list}}" id="image_description" tabindex="-1"
                               class="form-control-file visually-hidden">

                        @if($errors->has('image_description'))

                            <strong class="alert-danger">{{$errors->first('image_description')}}</strong>

                        @endif

                    </div>

                    {{--                    Posts Captions--}}
                    <div class="row">
                        {{--                    <label for="image" class="col-md-4 col-form-label" >Post Caption</label>--}}
                        <input type="text" name="image" value="{{$images_list}}" id="image" tabindex="-1"
                               class="form-control-file visually-hidden">

                        @if($errors->has('image'))

                            <strong class="alert-danger">{{$errors->first('image')}}</strong>

                        @endif

                    </div>

                    {{--                Post Description--}}
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label">Product Description</label>
                        [City] [Suburb/Area] [LandMark/Well Known physical place]<br>
                        [Nairobi] [CBD] [Opposite Afya Center]<br>
                        Separate the Sections using dashes/minus symbol [-]
                        <input type="text"
                               id="description"
                               name="description"
                               placeholder="Nairobi - CBD - Opposite Afya Center"
                               class="form-control{{$errors->has('description') ? 'is-invalid':''}}"
                               value="{{old('description')}}"
                               autocomplete="description"
                               autofocus>

                        @if($errors->has('description'))

                            <strong class="alert-danger">{{$errors->first('description')}}</strong>

                        @endif
                    </div>

                    {{--                Post Unit Amount--}}
                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label">Product Price</label>
                        can be per night, per week or per month
                        <input type="text"
                               id="amount"
                               name="amount"
                               placeholder="700 per night"
                               class="form-control{{$errors->has('amount') ? 'is-invalid':''}}"
                               value="{{old('amount')}}"
                               autocomplete="amount"
                               autofocus>

                        @if($errors->has('amount'))

                            <strong class="alert-danger">{{$errors->first('amount')}}</strong>

                        @endif
                    </div>

                    {{--                Post Submit Button--}}
                    <div class=" p-2 d-flex justify-content-center">
                        <button class="btn btn-primary" >Post</button>
                    </div>
                    <a href="/p/create/f">preview</a>

                </div>
            </div>

            <script>
                const image_descriptions = new Array({{$total_images}}).fill("");
                function GrabImageDescriptions() {
                    for (let i = 1; i <= {{$total_images}}; i++) {

                        // Initialize our constant array that we'll use to store the image description and are accessible via indexes

                        // console.log( document.getElementById("reply" + i.toString()).value);

                        if (document.getElementById("reply" + i.toString()).value.length != 0)
                        {
                            //Update the Image Card Description text by replacing it with user's input
                            document.getElementById("image" + i.toString()).alt = document.getElementById("reply" + i.toString()).value;

                        }
                        //Update array content with non empty strings
                        image_descriptions[i-1] = document.getElementById("reply" + i.toString()).value;
                        //First check that all the fields have been input then commit

                    }
                    var div = document.getElementById('image_description');
                    let json = JSON.stringify(image_descriptions); // Convert array to json so that it is possible to save to html values
                    div.value = json; // Saving to html form value
                    console.log(div.value);

                }

                document.getElementById("reply1").style.display = "block";


            </script>
        </form>

    </div>

    {{--todo: Improve the image qualities by applying HDR High Dynamic Range using OpenCV --}}


    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>



@endsection

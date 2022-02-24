@extends('layouts.app')

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
            user-select: none;
            background-color: rgba(0, 0, 0, 0.8);
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
            background-color: #343a40;
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


    <h2 style="text-align:center">{{$post->title}}</h2>
    <h5 class="align-content-center fw-bold" style="text-align:center">
        <a style="text-decoration:none" href="/profile/{{$post->user->id}}">
            <img class="rounded-circle" width="30" height="30"
                 src="/storage/{{$post->user->profile->image?? 'profiles/default.jpg'}}">
            <span>
            {{$post->user->profile->title}}
        </span>
        </a>
    </h5>

    <div class="card-footer px-5">
        <div class="wcf-left price ">
            <span>Rp {{$post->amount}}</span>

        </div>

        <div class=" price wcf-right">
            <span class=" btn btn-success">Click To Update Price</span>

        </div>

        </div>
    </div>

    <div class="row-cols-3 col-12  container d-flex align-content-stretch ">


        @can('update',$user->profile)
            <div class="  py-4">
{{--                {{$user->id}}--}}
                <a href="/profile/{{$user->id}}" class="btn  btn-primary  btn-outline-light ">Delete Image</a>
            </div>
            <div class="  py-4">
                <a href="/home" class="btn   btn-primary  btn-outline-light ">Replace Image</a>
            </div>
            <div class="  py-4">
                <a href="/p/create/i" class="btn   btn-primary  btn-outline-light ">Add Images</a>
            </div>

            <div class="  py-4">
                <a href="/p/create/i" class="btn   btn-primary  btn-outline-light ">Discard Updates</a>
            </div>


        @endcan


    </div>

    <div class="container" style="width: 400px; height: 700px">


        @foreach($post->images as $post)

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


        {{--TODO: Create thumbnails and employ Lazy Loading--}}
        <div class="row">

            @foreach($images->images as $images)


                <div class="column">
                    <img class="demo cursor" src="/storage/{{$images->image}}" style="width:100%"
                         onclick="currentSlide({{$loop->index+1}})" alt="{{$images->description}}">

                </div>


            @endforeach

        </div>
    </div>





    </div>

    <div class="d-flex justify-content-center">

        <a href="
    @if (!Auth::guest())
        {{--        Load the user's home when  logged in else load Welcome Page--}}
            /home
@else
            /
@endif
            " class="btn btn-primary btn-outline-light">Go to Posts</a>
    </div>



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

    {{--        <img src="/storage/{{$post->image}}" alt="">--}}

@endsection

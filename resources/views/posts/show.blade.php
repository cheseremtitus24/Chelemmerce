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
    <a style="text-decoration:none" href="/profile/{{$post->user->id}}" >
        <img   class="rounded-circle" width="30" height="30" src="/storage/{{$post->user->profile->image?? 'profiles/default.jpg'}}" >
        <span>
            {{$post->user->profile->title}}
        </span>
    </a>
</h5>

<div class="card-footer px-5">
    <div class="wcf-left align-items-baseline">
        <span class="price">$ {{$post->amount}}</span>
        <div class="col">
            <div class="rate">
                <input type="radio" id="star_5" class="rate" name="rating" value="5"/>
                <label for="star5" title="text">5 stars</label>
                <input type="radio" checked id="star_4" class="rate" name="rating" value="4"/>
                <label for="star4" title="text">4 stars</label>
                <input type="radio" id="star_3" class="rate" name="rating" value="3"/>
                <label for="star3" title="text">3 stars</label>
                <input type="radio" id="star_2" class="rate" name="rating" value="2">
                <label for="star2" title="text">2 stars</label>
                <input type="radio" id="star_1" class="rate" name="rating" value="1"/>
                <label for="star1" title="text">1 star</label>
            </div>
        </div>
    </div>



    <div class="wcf-right">
        <a href="#" class="buy-btn">
            <span class="iconify"  data-icon="zmdi:shopping-cart"></span>
            <i class="zmdi zmdi-shopping-basket"></i>
        </a>
    </div>
</div>

<div class="container" style="width: 350px; height: 700px">


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
                <img class="demo cursor" src="/storage/{{$images->image}}" style="width:100%" onclick="currentSlide({{$loop->index+1}})" alt="{{$images->description}}">
            </div>


        @endforeach

    </div>
</div>
{{--Collapsible content--}}
<div class="container d-flex justify-content-center">
    <p class="px-1">

        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Display Description
        </button>
    </p>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
        </div>
    </div>
    <p class="px-1">

        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Total Spending
        </button>
    </p>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
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
<br>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        display: none;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rated:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
    .star-rating-complete{
        color: #c59b08;
    }
    .rating-container .form-control:hover, .rating-container .form-control:focus{
        background: #fff;
        border: 1px solid #ced4da;
    }
    .rating-container textarea:focus, .rating-container input:focus {
        color: #000;
    }
    .rated {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .rated:not(:checked) > input {
        position:absolute;
        display: none;
    }
    .rated:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ffc700;
    }
    .rated:not(:checked) > label:before {
        content: '★ ';
    }
    .rated > input:checked ~ label {
        color: #ffc700;
    }
    .rated:not(:checked) > label:hover,
    .rated:not(:checked) > label:hover ~ label {
        color: #deb217;
    }
    .rated > input:checked + label:hover,
    .rated > input:checked + label:hover ~ label,
    .rated > input:checked ~ label:hover,
    .rated > input:checked ~ label:hover ~ label,
    .rated > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
</style>
@if(!empty($post->star_rating))
    <div class="container">
        <div class="row">
            <div class="col mt-4">
                <p class="font-weight-bold ">Review</p>
                <div class="form-group row">
                    <input type="hidden" name="booking_id" value="{{ $value->id }}">
                    <div class="col">
                        <div class="rated">
                            @for($i=1; $i<=$post->star_rating; $i++)
                                {{-- <input type="radio" id="star{{$i}}" class="rate" name="rating" value="5"/> --}}
                                <label class="star-rating-complete" title="text">{{$i}} stars</label>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <div class="col">
                        <p>{{ $post->comments }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container">
        <div class="row">
            <div class="col mt-4">
                <form class="py-2 px-4" action="{{route('review.store')}}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
                    @csrf
                    <p class="font-weight-bold ">Review</p>
                    <div class="form-group row">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="col">
                            <div class="rate">
                                <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" checked id="star4" class="rate" name="rating" value="4"/>
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" class="rate" name="rating" value="2">
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                <label for="star1" title="text">1 star</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col">
                            <textarea class="form-control" name="comment" rows="6 " placeholder="Comment" maxlength="200"></textarea>
                        </div>
                    </div>
                    <div class="mt-3 text-right">
                        <button class="btn btn-sm py-2 px-3 btn-info">Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
</div>
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
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        captionText.innerHTML = dots[slideIndex-1].alt;
    }
</script>

{{--        <img src="/storage/{{$post->image}}" alt="">--}}

@endsection

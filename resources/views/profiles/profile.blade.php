@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row">
            <div class="col-6 p-2 container">
                <div class="d-flex justify-content-center py-2">
                    <img src="/storage/{{$user->profile->image ?? 'profiles/default.jpg'}}" class="rounded-circle"
                         style="height: 200px;width: 200px;" alt="Profile Image ">
                </div>

                @can('update',$user->profile)
                    <div class="d-flex justify-content-center">
                        <a href="/profile/{{$user->id}}/edit"
                           class="btn col-9 btn-primary justify-content-center btn-outline-light">Update Brand Name/Description/Picture Profile</a>
                    </div>
                @endcan
            </div>

            <div class="justify-content-center">
                <div class="d-flex justify-content-between a">
                    <h1>{{$user->username}}</h1>

                </div>

                <div class="d-flex">
                    <div style="padding-right: 25px"><strong>{{$user->posts->count()}}</strong> posts</div>
                    <div style="padding-right: 25px"><strong>23k</strong> Today's Post Views</div>
                    <div style="padding-right: 25px"><strong>23k</strong> This Month's Purchases</div>
                    <div style="padding-right: 25px"><strong>212</strong> All Time Sales</div>
                </div>

                <div class="pt-4">
                    Brand Name: <strong>{{ $user->profile->title ?? "Default Title" }}</strong>
                </div>

                <div> Brand Description: {{ $user->profile->description ?? "Default Description"}}</div>

                <div>
                    <a href="{{ $user->profile->url ?? 'https://cystar.co.ke'}}"> {{ $user->profile->url ?? 'https://cystar.co.ke'}}</a>
                </div>

            </div>


            @can('update',$user->profile)
                <div class=" justify-content-center py-4">
                    <a href="/p/edit" class="btn col-4  btn-primary justify-content-center btn-outline-light">Delete/Update
                        Posts/Pricing</a>
                </div>
            @endcan


        </div>
        @can('update',$user->profile)
            <div class="container text-center">
                <h1>Your BnB Listings are Shown Below</h1>
                <span>Create With <i class="zmdi zmdi-favorite red"></i>  By: <strong>Deni Kurniawan</strong>  <i><a
                            href="/p/create/i" class="wsk-btn">Add Post</a></i></span>
            </div>
        @endcan

        <div class="shell">
            {{--        bootstrap has 12 columns in total--}}
            <div class="container">
                @if($posts->count())
                    <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-3">
                            <div class="wsk-cp-product">

                                <div class="wsk-cp-img">
                                    {{-- === START: SWIPABLE CAROUSEL IMPLEMENTATION === --}}
                                    {{-- Each wrapper gets a common class for JS to find it --}}
                                    <div class="carousel-wrapper">
                                        <div class="carousel-container">
                                            {{-- Loop through all images for this post --}}
                                            @forelse($post->images as $image)
                                                <img src="/storage/{{ $image->image }}" alt="{{ $post->title }} image"/>
                                            @empty
                                                {{-- Fallback if a post has no images --}}
                                                <img src="/path/to/default-placeholder.jpg" alt="No image available"/>
                                            @endforelse
                                        </div>
                                        <button class="carousel-nav left">&#10094;</button>
                                        <button class="carousel-nav right">&#10095;</button>
                                        <div class="carousel-indicators"></div>
                                    </div>
                                    {{-- === END: SWIPABLE CAROUSEL IMPLEMENTATION === --}}
                                </div>

                                <div class="wsk-cp-text">
                                    <div class="category">
                                        <a class="category" href="/p/{{$post->id}}">
                                            <span>{{$post->user->profile->title}}</span>
                                        </a>
                                    </div>
                                    <div class="title-product">
                                        <h3>{{$post->title}}</h3>
                                    </div>
                                    <div class="description-prod">
                                        {{--                                        <p>{{ str_limit($post->description, 108, " ...") }}</p>--}}
                                        <p>{{ $post->description}}</p>
                                    </div>

                                    {{-- NOTE: These styles should be moved to your main CSS file --}}
                                    <style>
                                        .rate {
                                            float: left;
                                            height: 46px;
                                            padding: 0 10px
                                        }

                                        .rate:not(:checked) > input {
                                            position: absolute;
                                            display: none
                                        }

                                        .rate:not(:checked) > label {
                                            float: right;
                                            width: 1em;
                                            overflow: hidden;
                                            white-space: nowrap;
                                            cursor: pointer;
                                            font-size: 30px;
                                            color: #ccc
                                        }

                                        .rated:not(:checked) > label {
                                            float: right;
                                            width: 1em;
                                            overflow: hidden;
                                            white-space: nowrap;
                                            cursor: pointer;
                                            font-size: 30px;
                                            color: #ccc
                                        }

                                        .rate:not(:checked) > label:before {
                                            content: '★ '
                                        }

                                        .rate > input:checked ~ label {
                                            color: #ffc700
                                        }

                                        .rate:not(:checked) > label:hover, .rate:not(:checked) > label:hover ~ label {
                                            color: #deb217
                                        }

                                        .rate > input:checked + label:hover, .rate > input:checked + label:hover ~ label, .rate > input:checked ~ label:hover, .rate > input:checked ~ label:hover ~ label, .rate > label:hover ~ input:checked ~ label {
                                            color: #c59b08
                                        }

                                        .star-rating-complete {
                                            color: #c59b08
                                        }

                                        .rating-container .form-control:hover, .rating-container .form-control:focus {
                                            background: #fff;
                                            border: 1px solid #ced4da
                                        }

                                        .rating-container textarea:focus, .rating-container input:focus {
                                            color: #000
                                        }

                                        .rated {
                                            float: left;
                                            height: 46px;
                                            padding: 0 10px
                                        }

                                        .rated:not(:checked) > input {
                                            position: absolute;
                                            display: none
                                        }

                                        .rated:not(:checked) > label {
                                            float: right;
                                            width: 1em;
                                            overflow: hidden;
                                            white-space: nowrap;
                                            cursor: pointer;
                                            font-size: 30px;
                                            color: #ffc700
                                        }

                                        .rated:not(:checked) > label:before {
                                            content: '★ '
                                        }

                                        .rated > input:checked ~ label {
                                            color: #ffc700
                                        }

                                        .rated:not(:checked) > label:hover, .rated:not(:checked) > label:hover ~ label {
                                            color: #deb217
                                        }

                                        .rated > input:checked + label:hover, .rated > input:checked + label:hover ~ label, .rated > input:checked ~ label:hover, .rated > input:checked ~ label:hover ~ label, .rated > label:hover ~ input:checked ~ label {
                                            color: #c59b08
                                        }
                                    </style>

                                    <p class="font-weight-bold " style="padding-left: 13%">{{$post->home_name}}</p>
                                    <div class="form-group row">
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <div class="col">
                                            <div class="rate">
                                                <input type="radio" id="star5-{{$post->id}}" class="rate"
                                                       name="rating-{{$post->id}}" value="5"/>
                                                <label for="star5-{{$post->id}}" title="text">5 stars</label>
                                                <input type="radio" checked id="star4-{{$post->id}}" class="rate"
                                                       name="rating-{{$post->id}}" value="4"/>
                                                <label for="star4-{{$post->id}}" title="text">4 stars</label>
                                                <input type="radio" id="star3-{{$post->id}}" class="rate"
                                                       name="rating-{{$post->id}}" value="3"/>
                                                <label for="star3-{{$post->id}}" title="text">3 stars</label>
                                                <input type="radio" id="star2-{{$post->id}}" class="rate"
                                                       name="rating-{{$post->id}}" value="2">
                                                <label for="star2-{{$post->id}}" title="text">2 stars</label>
                                                <input type="radio" id="star1-{{$post->id}}" class="rate"
                                                       name="rating-{{$post->id}}" value="1"/>
                                                <label for="star1-{{$post->id}}" title="text">1 star</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer h-25">
                                        <div class="p-lg-1 wcf-left"><span class="price">KES {{$post->amount}}</span>
                                        </div>
                                        <div class="wcf-right"><a href="#" class="buy-btn"><span class="iconify"
                                                                                                 data-icon="zmdi:shopping-cart"></span><i
                                                    class="zmdi zmdi-shopping-basket"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>
                    <div class="container">
                        <div class="mx-auto">
                            {{$posts->links()}}
                        </div>

                    </div>
                @else
                    <p>No listings found.</p>
                @endif
            </div>

        </div>
    </div>
    <script src="{{ asset('js/carousel.js') }}" defer></script>
@endsection

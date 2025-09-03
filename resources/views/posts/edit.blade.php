@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
    <div class="container">
        <div>
            <div class="row-cols-3 col-12  container d-flex align-content-center position-relative">


                @can('update',$user->profile)
                    <div class="  py-4">
                        <a href="/profile/{{$user->id}}" class="btn  btn-primary  btn-outline-light ">Go To Profile</a>
                    </div>
                    <div class="  py-4">
                        <a href="/home" class="btn   btn-primary  btn-outline-light ">Go To Home</a>
                    </div>
                    <div class="  py-4">
                        <a href="/p/create/i" class="btn   btn-primary  btn-outline-light ">Add Post</a>
                    </div>


                @endcan


            </div>
            <!-- Search Form (search.html) -->
            <form method="GET" action="/p/edit" class="row g-3 align-items-center">
                <div class="col-12 col-md-4">
                    <input type="text" name="location" class="form-control" placeholder="Location (e.g. Nairobi)" value="<?= htmlspecialchars($_GET['location'] ?? '') ?>" />
                </div>
                <div class="col-12 col-md-3">
                    <select name="home_type" class="form-select">
                        <option value="">All House Types</option>
                        <option value="Apartment" <?= ($_GET['home_type'] ?? '') == 'Apartment' ? 'selected' : '' ?>>Apartment</option>
                        <option value="Bungalow" <?= ($_GET['home_type'] ?? '') == 'Bungalow' ? 'selected' : '' ?>>Bungalow</option>
                        <option value="Villa" <?= ($_GET['home_type'] ?? '') == 'Villa' ? 'selected' : '' ?>>Villa</option>
                        <option value="Maisonette" <?= ($_GET['home_type'] ?? '') == 'Maisonette' ? 'selected' : '' ?>>Maisonette</option>
                        <option value="Bedsitter" <?= ($_GET['home_type'] ?? '') == 'Bedsitter' ? 'selected' : '' ?>>Bedsitter</option>
                        <option value="Single Room" <?= ($_GET['home_type'] ?? '') == 'Single Room' ? 'selected' : '' ?>>Single Room</option>
                        <option value="Hostel" <?= ($_GET['home_type'] ?? '') == 'Hostel' ? 'selected' : '' ?>>Hostel</option>
                        <option value="Hotel Room" <?= ($_GET['home_type'] ?? '') == 'Hotel Room' ? 'selected' : '' ?>>Hotel Room</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select name="price_type" class="form-select">
                        <option value="">Any Pricing</option>
                        <option value="per_night" <?= ($_GET['price_type'] ?? '') == 'per_night' ? 'selected' : '' ?>>Per Night</option>
                        <option value="per_month" <?= ($_GET['price_type'] ?? '') == 'per_month' ? 'selected' : '' ?>>Per Month</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </form>

            <div class="shell">
                {{--        bootstrap has 12 columns in total--}}
                <div class="container">
                    <div class="row">
                        @if($posts->count())
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


                                                <div class="d-flex align-content-center ">


                                                    <a href="/d/{{$post->id}}">
                                                        <button class="  btn-danger btn" id="delete-account"
                                                                onclick="hello();"><span class="fw-bold">Delete Post</span>
                                                        </button>
                                                    </a>
                                                    <a href="/p/edit/{{$post->id}}">
                                                        <button class="  btn-success btn " id="delete-account"
                                                                onclick="hello();"><span class="fw-bold">Edit Post</span>
                                                        </button>
                                                    </a>


                                                    <dialog id="confirm-delete" class="site-dialog">
                                                        <header class="dialog-header">
                                                            <h1>Please Confirm</h1>
                                                        </header>
                                                        <div class="dialog-content">
                                                            <p>You are about to close your account. This action is irreversible. It will permanently delete your account along with its associated data. Are you sure you want to continue?</p>
                                                        </div>
                                                        <div class="btn-group cf">
                                                            <button class="btn btn-danger" id="delete">Delete</button>
                                                            <button class="btn btn-edit" id="edit`">Edit</button>
                                                            <button class="btn btn-cancel" id="cancel">Cancel</button>

                                                        </div>
                                                    </dialog>

                                                </div>
                                                <script>
                                                    (function hello() {
                                                        'use strict';

                                                        var $accountDelete = $('#delete-account'),
                                                            $accountDeleteDialog = $('#confirm-delete'),
                                                            transition;

                                                        $accountDelete.on('click', function () {
                                                            $accountDeleteDialog[0].showModal();
                                                            transition = window.setTimeout(function () {
                                                                $accountDeleteDialog.addClass('dialog-scale');
                                                            }, 0.5);
                                                        });

                                                        $('#cancel').on('click', function () {
                                                            $accountDeleteDialog[0].close();
                                                            $accountDeleteDialog.removeClass('dialog-scale');
                                                            clearTimeout(transition);
                                                        });

                                                    })(jQuery);
                                                </script>



                                            </div>


                                            <div class="title-product">
                                                <h3>{{$post->title}}</h3>
                                            </div>
                                            <div class="description-prod">
                                                {{--                                    <p>{{ str_limit($post->description, 108, " ...") }}</p>--}}
                                                <p>{{ $post->description }}</p>
                                            </div>

                                            {{-- NOTE: These styles should be moved to your main CSS file --}}
                                            <style>
                                                .rate{float:left;height:46px;padding:0 10px}.rate:not(:checked)>input{position:absolute;display:none}.rate:not(:checked)>label{float:right;width:1em;overflow:hidden;white-space:nowrap;cursor:pointer;font-size:30px;color:#ccc}.rated:not(:checked)>label{float:right;width:1em;overflow:hidden;white-space:nowrap;cursor:pointer;font-size:30px;color:#ccc}.rate:not(:checked)>label:before{content:'★ '}.rate>input:checked~label{color:#ffc700}.rate:not(:checked)>label:hover,.rate:not(:checked)>label:hover~label{color:#deb217}.rate>input:checked+label:hover,.rate>input:checked+label:hover~label,.rate>input:checked~label:hover,.rate>input:checked~label:hover~label,.rate>label:hover~input:checked~label{color:#c59b08}.star-rating-complete{color:#c59b08}.rating-container .form-control:hover,.rating-container .form-control:focus{background:#fff;border:1px solid #ced4da}.rating-container textarea:focus,.rating-container input:focus{color:#000}.rated{float:left;height:46px;padding:0 10px}.rated:not(:checked)>input{position:absolute;display:none}.rated:not(:checked)>label{float:right;width:1em;overflow:hidden;white-space:nowrap;cursor:pointer;font-size:30px;color:#ffc700}.rated:not(:checked)>label:before{content:'★ '}.rated>input:checked~label{color:#ffc700}.rated:not(:checked)>label:hover,.rated:not(:checked)>label:hover~label{color:#deb217}.rated>input:checked+label:hover,.rated>input:checked+label:hover~label,.rated>input:checked~label:hover,.rated>input:checked~label:hover~label,.rated>label:hover~input:checked~label{color:#c59b08}
                                            </style>

                                            <p class="font-weight-bold " style="padding-left: 13%">{{$post->home_name}}</p>
                                            <div class="form-group row">
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <div class="col">
                                                    <div class="rate">
                                                        <input type="radio" id="star5-{{$post->id}}" class="rate" name="rating-{{$post->id}}" value="5"/>
                                                        <label for="star5-{{$post->id}}" title="text">5 stars</label>
                                                        <input type="radio" checked id="star4-{{$post->id}}" class="rate" name="rating-{{$post->id}}" value="4"/>
                                                        <label for="star4-{{$post->id}}" title="text">4 stars</label>
                                                        <input type="radio" id="star3-{{$post->id}}" class="rate" name="rating-{{$post->id}}" value="3"/>
                                                        <label for="star3-{{$post->id}}" title="text">3 stars</label>
                                                        <input type="radio" id="star2-{{$post->id}}" class="rate" name="rating-{{$post->id}}" value="2">
                                                        <label for="star2-{{$post->id}}" title="text">2 stars</label>
                                                        <input type="radio" id="star1-{{$post->id}}" class="rate" name="rating-{{$post->id}}" value="1"/>
                                                        <label for="star1-{{$post->id}}" title="text">1 star</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer h-25">
                                                <div class="p-lg-1 wcf-left"><span class="price">KES {{$post->amount}}</span></div>
                                                <div class="wcf-right"><a href="#" class="buy-btn"><span class="iconify" data-icon="zmdi:shopping-cart"></span><i class="zmdi zmdi-shopping-basket"></i></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        @else
                            <p>No listings found.</p>
                        @endif



                    </div>


                </div>

            </div>
        </div>
        {{$posts->links()}}
    </div>


    <script src="{{ asset('js/carousel.js') }}" defer></script>
@endsection

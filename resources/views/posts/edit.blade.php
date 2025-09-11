@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">

{{--    overlay image update assets--}}
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>--}}
    <script  src="{{ asset('js/jquery.min.js') }}"></script>
    <script  src="{{ asset('js/bootstrap.min.css') }}"></script>

{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/css/intlTelInput.min.css"/>
    <style>
        /*@import url("https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/css/intlTelInput.min.css");*/
        .chip{
            cursor: pointer;
        }
        .chip.active {
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            padding: .3rem;
        }

        .house-type {
            border: 1px solid #ddd;
            padding: 10px;
            cursor: pointer;
            border-radius: 10px;
            text-align: center;
        }

        .house-type img {
            width: 100%;
            max-height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        .house-type.active {
            border: 2px solid #007bff;
        }

        .hidden {
            display: none;
        }

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <style>
        /*Overlay Leaflet OpenTreeMap
        Leaflet CSS */
        /*@import url("https://unpkg.com/leaflet/dist/leaflet.cs/");*/
        /*<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>*/
        #map {
            height: 100%;
        }

        /* Overlay styles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            z-index: 1000;
            overflow: auto;
        }

        .overlay-content {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 90%;
            max-width: 700px;
            text-align: center;
        }

        .close-btn {
            margin-top: 15px;
            padding: 5px 10px;
            background: #c00;
            color: white;
            border: none;
            cursor: pointer;
        }

        .close-btn:hover {
            background: #900;
        }

        .controls {
            margin-top: 10px;
            background: white;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .controls input, .controls button {
            margin: 5px 0;
            padding: 6px;
            width: 100%;
            box-sizing: border-box;
        }

        .banner {
            background: rgba(25, 118, 210, 0.95);
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        #map {
            height: 400px;
            width: 100%;
            margin-top: 10px;
            border-radius: 5px;
        }

        #toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1100;
        }

        #toast.visible {
            opacity: 1;
        }


    </style>

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
                                                      <img src="/storage/default/default-placeholder.png" alt="No image available"/>
                                                    @endforelse
                                                </div>
                                                <button class="carousel-nav left">&#10094;</button>
                                                <button class="carousel-nav right">&#10095;</button>
                                                <div class="carousel-indicators"></div>
                                            </div>
                                            {{-- === END: SWIPABLE CAROUSEL IMPLEMENTATION === --}}
                                        </div>

                                          <div class="wsk-cp-text">
{{--                                              <div class="d-flex align-content-center" style="padding-bottom: 2rem">--}}
{{--                                                  <a href="/p/edit/{{$post->id}}">--}}
{{--                                                      <button class="  btn-primary btn " id="delete-account"--}}
{{--                                                              onclick="hello();"><span class="fw-bold">Click to Add/Replace/Delete Images</span>--}}
{{--                                                      </button>--}}
{{--                                                  </a>--}}
{{--                                              </div>--}}

                                            <div class="category">


                                                <div class="d-flex align-content-center ">


                                                    <a href="/d/{{$post->id}}">
                                                        <button class="  btn-danger btn" id="delete-account"
                                                                onclick="hello();"><span class="fw-bold">Delete Post</span>
                                                        </button>
                                                    </a>
{{--                                                    <a href="/p/edit/{{$post->id}}">--}}

                                                        <button type="button" class="  btn-success btn " id="delete-account"
                                                                onclick='window.showUpdatePriceModal({{ $post->id }},"{{ $post->home_name }}","{{ $post->telephone }}","{{ $post->home_type }}","{{ $post->accommodation_type }}","{{ $post->num_rooms }}","{{ $post->num_bathrooms }}","{{ $post->location }}","{{ $post->price }}","{{ $post->price_type }}","{{ $post->latitude }}","{{ $post->longitude }}")'>
                                                                <span class="fw-bold">Edit Post</span>
                                                        </button>





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
                            <!-- Update Price Modal -->
                                <div class="modal fade" id="updatePriceModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.hideUpdatePriceModal()"></button>
                                            </div>

                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                                <form id="updatePriceForm">
                                                @csrf

                                                <!-- Home Name -->
                                                    <div class="mb-3">
                                                        <label for="home_name" class="form-label">Home Name (e.g. Gianna Flats)</label>
                                                        <input
                                                            type="text"
                                                            id="home_name"
                                                            name="home_name"
                                                            class="form-control {{ $errors->has('home_name') ? 'is-invalid' : '' }}"
                                                            value="{{ old('home_name') }}"
                                                            autocomplete="home_name"
                                                            required
                                                            autofocus
                                                        />
                                                        @error('home_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Caretaker Contact -->
                                                    <div class="mb-3">
                                                        <label for="telephone" class="form-label">Caretaker Contact</label>
                                                        <input
                                                            type="tel"
                                                            id="telephone"
                                                            name="telephone"
                                                            class="form-control {{ $errors->has('telephone') ? 'is-invalid' : '' }}"
                                                            value="{{ old('telephone') }}"
                                                            autocomplete="tel"
                                                            required
                                                        />
                                                        @error('telephone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- House Type -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Select House Type</label>
                                                        <div class="row g-2" id="houseTypeContainer">
                                                            <!-- Populated dynamically via JS -->
                                                        </div>
                                                    </div>

                                                    <!-- Accommodation Type -->
                                                    <div class="mb-3">
                                                        <label for="accommodation_type" class="form-label">Accommodation Type</label>
                                                        <select id="accommodation_type" name="accommodation_type" class="form-select" required>
                                                            <option disabled selected>Choose...</option>
                                                            <option>Private Room</option>
                                                            <option>Shared Room</option>
                                                            <option>Entire Home</option>
                                                            <option>Dormitory</option>
                                                            <option>Hostel</option>
                                                            <option>Hotel Room</option>
                                                        </select>
                                                    </div>

                                                    <!-- Number of Rooms -->
                                                    <div class="mb-3">
                                                        <label for="numRooms" class="form-label">Number of Rooms</label>
                                                        <input type="number" id="numRooms" name="num_rooms" min="1" class="form-control" />
                                                    </div>

                                                    <!-- Number of Bathrooms -->
                                                    <div class="mb-3">
                                                        <label for="numBaths" class="form-label">Number of Bathrooms</label>
                                                        <input type="number" id="numBaths" name="num_bathrooms" min="1" class="form-control" />
                                                    </div>

                                                    <!-- Location -->
                                                    <div class="mb-3">
                                                        <label for="location" class="form-label">Location (e.g. Westlands, Nairobi)</label>
                                                        <input
                                                            type="text"
                                                            id="location"
                                                            name="location"
                                                            class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                                                            value="{{ old('location') }}"
                                                            autocomplete="address-line1"
                                                            required
                                                        />
                                                        @error('location')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="mb-3">
                                                        <label for="price" class="form-label">Price (in KES)</label>
                                                        <input
                                                            type="number"
                                                            id="price"
                                                            name="price"
                                                            min="0"
                                                            class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                                            value="{{ old('price') }}"
                                                            required
                                                        />
                                                        @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <!-- Price Type -->
                                                        <div class="mt-2" id="priceOptions">
                                                            <span class="chip active" data-value="per_night">Per Night</span>
                                                            <span class="chip" data-value="per_month">Per Month</span>
                                                        </div>
                                                        <input type="hidden" id="priceType" name="price_type" value="per_night" />
                                                    </div>

                                                    <!-- Coordinates -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Latitude & Longitude</label>
                                                        <div class="input-group">
                                                            <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Latitude" readonly />
                                                            @error('latitude')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror

                                                            <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Longitude" readonly />
                                                            @error('longitude')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror

                                                            <button type="button" id="setLocationBtn" class="btn btn-outline-primary">Set Location</button>
                                                        </div>
                                                    </div>

                                                    <!-- Hidden Post ID -->
                                                    <input type="hidden" id="post_id" name="post_id">

                                                    <!-- Actions -->
                                                    <div class="d-flex justify-content-between">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.hideUpdatePriceModal()">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <script>
                                    window.showUpdatePriceModal=function(postId,home_name,telephone,house_type,accommodation_type,numRooms,numBaths,location,price,priceOptions,latitude,longitude) {
                                        document.getElementById('post_id').value = postId;
                                        document.getElementById('home_name').value = home_name;
                                        document.getElementById('telephone').value = telephone;
                                        // document.getElementById('home_type').value = house_type;

                                        // alert(house_type);

                                        /*

                                         */




                                        document.getElementById('accommodation_type').value = accommodation_type;
                                        document.getElementById('numRooms').value = numRooms;
                                        document.getElementById('numBaths').value = numBaths;
                                        document.getElementById('location').value = location;
                                        document.getElementById('price').value = price;
                                        document.getElementById('priceOptions').value = priceOptions;
                                        document.getElementById('latitude').value = latitude;
                                        document.getElementById('longitude').value = longitude;

                                        const modal = new bootstrap.Modal(document.getElementById('updatePriceModal'));
                                        modal.show();
                                    }

                                     window.hideUpdatePriceModal = function() {
                                         const modalEl = document.getElementById('updatePriceModal');
                                         const modal = bootstrap.Modal.getInstance(modalEl);
                                         if (modal) {
                                             modal.hide();
                                         }
                                     }
                                     // window.hideUpdatePriceModal = function() {
                                     //     const modalEl = document.getElementById('updatePriceModal');
                                     //     const modal = bootstrap.Modal.getInstance(modalEl);
                                     //     if (modal) {
                                     //         modal.hide();
                                     //         modalEl.addEventListener('hidden.bs.modal', function () {
                                     //             modalEl.remove(); // removes modal node from DOM
                                     //         }, { once: true });
                                     //     }
                                     // }

                                    document.getElementById('updatePriceForm').addEventListener('submit', async function(e) {
                                        e.preventDefault();

                                        try {
                                            const response = await fetch('/p/update-price', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({
                                                    post_id: document.getElementById('post_id').value,
                                                    amount: document.getElementById('amount').value
                                                })
                                            });

                                            const data = await response.json();
                                            alert('Price updated successfully!');
                                            location.reload();

                                        } catch (error) {
                                            console.error('Error updating price:', error);
                                            alert('Something went wrong. Please try again.');
                                        }
                                    });
                                </script>
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



    {{--todo: Improve the image qualities by applying HDR High Dynamic Range using OpenCV --}}

    {{--    Opentreemap location Selection Scripts--}}
    <!-- Overlay container -->
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <div class="banner">SELECT YOUR HOME ON THE MAP THEN CLICK SAVE</div>

            <div class="controls">
                <button onclick="getCurrentLocation()">📍 Use My Location</button>
                <input type="text" id="searchInput" placeholder="Search location..." />
                <button onclick="searchLocation()">🔍 Search</button>
                <button onclick="saveManually(); hideOverlay()">💾 Save & Close</button>
            </div>

            <div id="map"></div>
            <button class="close-btn" onclick="hideOverlay()">Cancel </button>
            <button onclick="saveManually(); hideOverlay()">💾 Save & Close</button>
        </div>
    </div>
    <!-- Toast Message -->
    <div id="toast"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-1.286389, 36.817223], 13);
        let userMarker = null;
        let gpsMarker = null;
        const toast = document.getElementById('toast');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('visible');
            setTimeout(() => toast.classList.remove('visible'), 3000);
        }

        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    const address = data.display_name || 'Unknown location';
                    showToast(`Saved: ${address}`);
                })
                .catch(() => showToast('Saved, but failed to get address.'));
        }

        function saveToServer(lat, lng) {
            fetch('/api/save-location', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ latitude: lat, longitude: lng })
            })
                .then(res => {
                    if (res.ok) reverseGeocode(lat, lng);
                    else showToast('Failed to save location.');
                })
                .catch(() => showToast('Network error while saving.'));
        }

        function handleMarker(lat, lng) {
            if (!userMarker) {
                userMarker = L.marker([lat, lng], { draggable: true }).addTo(map);
            } else {
                userMarker.setLatLng([lat, lng]);
            }
        }

        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            handleMarker(lat, lng);
        });

        function getCurrentLocation() {
            if (!navigator.geolocation) {
                showToast("Geolocation not supported by browser.");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                position => {
                    const { latitude, longitude } = position.coords;
                    map.setView([latitude, longitude], 16);

                    if (!gpsMarker) {
                        gpsMarker = L.marker([latitude, longitude], {
                            icon: L.icon({
                                iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                                iconSize: [25, 25],
                                iconAnchor: [12, 25]
                            }),
                            title: "Your Location"
                        }).addTo(map);
                    } else {
                        gpsMarker.setLatLng([latitude, longitude]);
                    }

                    showToast("GPS located. Now click to mark your home.");
                },
                () => showToast("Unable to retrieve GPS."),
                { enableHighAccuracy: true, timeout: 5000 }
            );
        }

        function searchLocation() {
            const query = document.getElementById('searchInput').value.trim();
            if (!query) {
                showToast("Please enter a location.");
                return;
            }


            const proxy = 'https://corsproxy.io/?';

            const urldev = `${proxy}${encodeURIComponent(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)}`;
            const urlprod = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;



            fetch(`${urlprod}`)
                .then(res => res.json())
                .then(results => {
                    if (results.length === 0) {
                        showToast("No location found.");
                        return;
                    }

                    const { lat, lon } = results[0];
                    map.setView([lat, lon], 16);
                    showToast("Location found. Click to mark your home.");
                })
                .catch(() => showToast("Search failed."));
        }

        function saveManually() {
            if (!userMarker) {
                showToast("Please select your home on the map first.");
                return;
            }

            const pos = userMarker.getLatLng();
            // saveToServer(pos.lat, pos.lng);
            document.getElementById('latitude').value = pos.lat;
            document.getElementById('longitude').value = pos.lng;
            // document.getElementById('setlocation').innerHTML = "Saved Successfully. Click Again to Update";

        }

        function showOverlay() {
            document.getElementById('overlay').style.display = 'flex';
            setTimeout(() => map.invalidateSize(), 300);  // ensure Leaflet renders map correctly
        }

        function hideOverlay() {
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/intlTelInput.min.js"></script>
    <script>
        const houseTypes = [
            { name: 'Bedsitter', img: 'https://example.com/bedsitter.jpg' },
            { name: 'Single Room', img: 'https://example.com/single-room.jpg' },
            { name: 'Hostel', img: 'https://example.com/hostel.jpg' },
            { name: 'Apartment', img: 'https://example.com/apartment.jpg' },
            { name: 'Maisonette', img: 'https://example.com/maisonette.jpg' },
            { name: 'Bungalow', img: 'https://example.com/bungalow.jpg' },
            { name: 'Villa', img: 'https://example.com/villa.jpg' },
            { name: 'Hotel Room', img: 'https://example.com/hotel-room.jpg' }
        ];

        const container = document.getElementById("houseTypeContainer");
        const numRooms = document.getElementById("numRooms");
        const numBaths = document.getElementById("numBaths");

        houseTypes.forEach((type, i) => {
            const col = document.createElement("div");
            col.className = "col-6 col-md-3";
            col.innerHTML = `
        <div class="house-type" data-type="${type.name}">
          <img src="${type.img}" alt="${type.name}" />
          <p>${type.name}</p>
        </div>
      `;
            container.appendChild(col);
        });

        document.querySelectorAll(".house-type").forEach((el) => {
            el.addEventListener("click", () => {
                document.querySelectorAll(".house-type").forEach(e => e.classList.remove("active"));
                el.classList.add("active");
                const selected = el.dataset.type;
                if (["Bedsitter", "Single Room"].includes(selected)) {
                    numRooms.value = "";
                    numRooms.disabled = true;
                    numBaths.value = "";
                    numBaths.disabled = selected === "Single Room";
                } else {
                    numRooms.disabled = false;
                    numBaths.disabled = false;
                }
            });
        });

        const priceChips = document.querySelectorAll("#priceOptions .chip");
        const priceType = document.getElementById("priceType");
        priceChips.forEach(chip => {
            chip.addEventListener("click", () => {
                priceChips.forEach(c => c.classList.remove("active"));
                chip.classList.add("active");
                priceType.value = chip.dataset.value;
            });
        });

        const phoneInput = intlTelInput(document.getElementById("telephone"), {
            initialCountry: "auto",
            geoIpLookup: callback => {
                fetch("https://ipinfo.io/json?token=YOUR_TOKEN")
                    .then(resp => resp.json())
                    .then(data => callback(data.country))
                    .catch(() => callback("KE"));
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.8/build/js/utils.js",
        });

        document.getElementById("setLocationBtn").addEventListener("click", () => {
            // if (navigator.geolocation) {
            //     navigator.geolocation.getCurrentPosition(pos => {
            //         document.getElementById("latitude").value = pos.coords.latitude;
            //         document.getElementById("longitude").value = pos.coords.longitude;
            //     });
            // } else {
            //     alert("Geolocation is not supported");
            // }
            showOverlay()
        });


        document.getElementById("updatePriceModal").addEventListener("submit", async e => {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(e.target);
            // Assuming 'phoneInput' is defined globally or accessible here
            formData.set("telephone", phoneInput.getNumber());

            const houseType = document.querySelector(".house-type.active")?.dataset.type;
            if (houseType) formData.set("home_type", houseType);
            // Send data to backend here
            console.log(Object.fromEntries(formData.entries()));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (csrfToken) {
                formData.set('_token', csrfToken); // Laravel expects the token as '_token' in form data
            } else {
                console.error("CSRF token not found! Form submission might fail.");
                alert("Security token missing. Please refresh the page and try again.");
                return; // Stop submission if token is not found
            }
            // alert("Form submitted!");
            // Send data to backend here using fetch
            try {
                const response = await fetch('/p', {
                    method: 'POST', // Most likely 'POST' for form submissions that create data
                    body: formData, // FormData directly works with fetch and handles multipart/form-data
                });

                if (response.ok) {
                    // Form submitted successfully
                    const result = await response.json(); // If your backend returns JSON
                    console.log("Form submission successful:", result);
                    alert("Form submitted successfully!");
                    // Optionally, redirect or clear the form
                    // window.location.href = '/success-page';
                    // e.target.reset(); // Resets the form fields
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    } else {
                        // If no redirect_url, maybe just reset form or show a success message
                        e.target.reset();
                    }
                } else {
                    // Server responded with an error status (e.g., 400, 500)
                    const errorData = await response.json(); // Assuming backend sends error details as JSON
                    console.error("Form submission failed:", response.status, errorData);
                    alert("Form submission failed: " + (errorData.message || "An error occurred."));
                }
            }
            catch (error) {
                // Network error or other issues
                console.error("Error during form submission:", error);
                alert("An error occurred while submitting the form. Please try again.");
            }
        });

    </script>

{{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>--}}

    <script  src="{{ asset('js/bnblistform.js') }}"></script>
    <script  src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@endsection

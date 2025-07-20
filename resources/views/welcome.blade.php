@extends('layouts.app')
@section('content')
{{--    <link href="{{ asset('css/style.css') }}" rel="stylesheet">--}}

{{--    <script  src="{{ asset('js/script.js') }}"></script>--}}



        <div class="container">
            <div class="row">

                <div class="col-3 p-5">
                    <a href="#"> <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" class="rounded-circle" style="height: 200px;width: 200px;"> </a>
                </div>
                <div class="col-9 pt-5" >
                    <div >
                        <h1>Trending BnBs</h1>
                    </div>
                    <div class="d-flex">
                        <div style="padding-right: 25px"><strong>153</strong> Released</div>
                        <div style="padding-right: 25px"><strong>23k</strong> Available</div>
                        <div style="padding-right: 25px"><strong>212</strong> Top Rated</div>
                    </div>
                    <div class="pt-4">
                        <strong>BnBsWorld Hosting ShowCases</strong>
                    </div>
                    <div> Trendy, Vintage, Cultural, Rare, Limited Edition BnBs.</div>
                    <div><a href="#"> www.bnbsworld.com</a> </div>
                </div>
            </div>

            <div class="container text-center">
                <h1>BnB Listings</h1>
                <span>Create With <i class="zmdi zmdi-favorite red"></i>  By: <strong>Deni Kurniawan</strong> <i><a href="<?= url('/login'); ?>" class="wsk-btn">BnBs World - Click to Login & List your Home</a></i></span>
            </div>



        </div>

        <div class="shell">
            {{--        bootstrap has 12 columns in total--}}
            <div class="container">
                <div class="row">
                    @foreach($user as $post)


                        <div class="col-md-3">
                            <div class="wsk-cp-product">

                                <div class="wsk-cp-img">
{{--                                    todo: implement swipable vanilla image view--}}
{{--                                    <div class="slider-container">--}}
{{--                                        @foreach($post->images as $poster)--}}
{{--                                            <div >--}}
{{--                                                <img--}}
{{--                                                    src="/storage/{{$poster->image}}"--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
                                    <img
                                        src="/storage/{{$post->image}}"
                                    />



                                </div>

{{--                                <div class="wsk-cp-img">--}}
{{--                                    <img src="/storage/{{$post->image}}" alt="Product" class="img-responsive" />--}}
{{--                                </div>--}}

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
                                        <p>{{ str_limit($post->description,108, " ...")}}</p>
                                    </div>

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



                                    <p class="font-weight-bold " style="padding-left: 13%">{{$post->home_name}}</p>
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


                                    <div class="card-footer h-25">
                                        <div class="p-lg-1 wcf-left"><span class="price">$ {{$post->amount}}</span></div>
                                        <div class="wcf-right"><a href="#" class="buy-btn"><span class="iconify" data-icon="zmdi:shopping-cart"></span><i class="zmdi zmdi-shopping-basket"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--            <div class="col-4 pb-4">--}}
                        {{--               --}}
                        {{--                <img src="/storage/{{$post->image}}" class="w-100">--}}
                        {{--            </div>--}}
                    @endforeach
                </div>


            </div>

        </div>
{{--    <script src="{{ asset('js/script.js') }}" defer></script>--}}
        {{--    Codepen product cards--}}
@endsection

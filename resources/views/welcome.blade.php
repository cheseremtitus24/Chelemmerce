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
                        <h1>Trending Hats</h1>
                    </div>
                    <div class="d-flex">
                        <div style="padding-right: 25px"><strong>153</strong> Released</div>
                        <div style="padding-right: 25px"><strong>23k</strong> Available</div>
                        <div style="padding-right: 25px"><strong>212</strong> Top Rated</div>
                    </div>
                    <div class="pt-4">
                        <strong>A Creative Culture</strong>
                    </div>
                    <div> Trendy, Vintage, Cultural, Rare, Limited Edition Hats.</div>
                    <div><a href="#"> www.hatsworld.com</a> </div>
                </div>
            </div>

            <div class="container text-center">
                <h1>Product ShowCase</h1>
                <span>Create With <i class="zmdi zmdi-favorite red"></i>  By: <strong>Deni Kurniawan</strong> From: <i><a href="<?= url('/login'); ?>" class="wsk-btn">Hats World - Click to Login & Share</a></i></span>
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
                                    <div class="card-footer h-25">
                                        <div class="p-lg-1 wcf-left"><span class="price">Rp {{$post->amount}}</span></div>
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

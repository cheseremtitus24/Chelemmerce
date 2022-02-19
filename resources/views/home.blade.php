@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="row">

        <div class="col-3 p-5">
            <a href="/profile/<?=auth()->user()->id?>"> <img src="/storage/{{auth()->user()->profile->image ?? 'profiles/default.jpg'}}" class="rounded-circle" style="height: 200px;width: 200px;"> </a>
            <div class="d-flex justify-content-start">
                <a href="/profile/<?=auth()->user()->id?>" class="btn btn-primary btn-outline-light ">Edit Brand</a>
            </div>
{{--            <a href="/profile/<?=auth()->user()->id?>"  class="btn btn-success d-flex justify-content-center"> My Profile </a>--}}
        </div>
        <div class="col-9 p-5 " >
            <div >
                <h1>Trending Podcasts</h1>
            </div>
            <div class="d-flex">
                <div style="padding-right: 25px"><strong>153</strong> Released</div>
                <div style="padding-right: 25px"><strong>23k</strong> Available</div>
                <div style="padding-right: 25px"><strong>212</strong> Top Rated</div>
            </div>
            <div class="pt-4">
                <strong>A Creative Mind Fiction</strong>
            </div>
            <div> Alice Nelson and Carry Zylka provide stories. Lots and lots of stories.</div>
            <div><a href="www.acreativemindfiction.com"> www.acreativemindfiction.com</a> </div>
        </div>
    </div>

    <div class="container text-center">
        <h1>Product card</h1>
        <span>Create With <i class="zmdi zmdi-favorite red"></i>  By: <strong>Deni Kurniawan</strong> From: <i><a href="/p/create/i" class="wsk-btn">Add Post</a></i></span>
    </div>



</div>

{{--    Codepen product cards--}}

    <div class="shell">
        {{--        bootstrap has 12 columns in total--}}
        <div class="container">
            <div class="row">
                @foreach($user as $post)


                    <div class="col-md-3">
                        <div class="wsk-cp-product">
                            <div class="wsk-cp-img">
                                <img src="/storage/{{$post->image}}" alt="Product" class="img-responsive" />
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
                                    <p>{{ str_limit($post->description,108, ' ...')}}</p>
                                </div>
                                <div class="card-footer h-25">
                                    <div class="p-lg-1 wcf-left"><span class="price">Rp {{$post->amount}}</span></div>
                                    <div class="wcf-right"><a href="#" class="buy-btn"><span class="iconify" data-icon="zmdi:shopping-cart"></span><i class="zmdi zmdi-shopping-basket"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>


                @endforeach
            </div>


        </div>

    </div>

@endsection

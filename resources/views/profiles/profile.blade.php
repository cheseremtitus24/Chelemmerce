@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 p-2 container">
            <div class="d-flex justify-content-center py-2">
                <img src="/storage/{{$user->profile->image ?? 'profiles/default.jpg'}}" class="rounded-circle" style="height: 200px;width: 200px;" alt="Profile Image ">
            </div>

            @can('update',$user->profile)
                 <div class="d-flex justify-content-center">
                    <a href="/profile/{{$user->id}}/edit" class="btn col-9 btn-primary justify-content-center btn-outline-light">Update Profile</a>
                </div>
            @endcan
        </div>

        <div class="justify-content-center" >
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
            <div><a href="{{ $user->profile->url ?? 'https://cystar.co.ke'}}"> {{ $user->profile->url ?? 'https://cystar.co.ke'}}</a> </div>
        </div>


                @can('update',$user->profile)
            <div class=" justify-content-center py-4">
                <a href="/p/edit" class="btn col-4  btn-primary justify-content-center btn-outline-light">Edit Posts</a>
            </div>
                @endcan


    </div>
    @can('update',$user->profile)
    <div class="container text-center">
        <h1>Product card</h1>
        <span>Create With <i class="zmdi zmdi-favorite red"></i>  By: <strong>Deni Kurniawan</strong>  <i><a href="/p/create/i" class="wsk-btn">Add Post</a></i></span>
    </div>
    @endcan
    <div class="shell">
{{--        bootstrap has 12 columns in total--}}
        <div class="container">
            <div class="row">
            @foreach($user->posts as $post)


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
                                        <h5>{{$post->title}}</h5>
                                    </div>
                                    <div class="description-prod">
                                        <p>{{ str_limit($post->description,108, ' ...')}}</p>
                                    </div>
                                    <div class="card-footer h-25">
                                        <div class="p-lg-1 wcf-left"><span class="price">KES {{$post->amount}}</span></div>
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
@endsection

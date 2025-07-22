@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <form action="/profile/i/{{$user->id}}" enctype="multipart/form-data" method="post">
                @method('PATCH')
                @csrf
                <div class="col-6 p-2 container">

                    <div class="d-flex justify-content-center py-2">
                        <label for="image" style="position:relative; text-align: center;color: white;" >
                            <img src="/storage/{{$user->profile->image ?? "/profiles/default.jpg"}}" class="rounded-circle" style="height: 200px;width: 200px;">
                            <div style="position: absolute; top:50%;left:50%;transform: translate(-50%,-50%);" class="btn btn-primary"> Edit Image  </div>

                        </label>
                        <div class="row">
                            <input style="display:none" class="form-control-file " id="image" name="image" type="file" />


                        </div>


                    </div>
                    @if($errors->has('image'))

                        <strong class="alert-danger d-flex justify-content-center p-2">{{$errors->first('image')}}</strong>
                    @endif
                    <div class="d-flex justify-content-center">
                        <input type="submit" value="Update Image" class="btn col-9 btn-success justify-content-center btn-outline-light">
                    </div>
                </div>
            </form>

            <form action="/profile/d/{{$user->id}}" enctype="multipart/form-data" method="post">
                @method('PATCH')
                @csrf

                <div class="justify-content-center" >
                    <div class="d-flex justify-content-between a">
                        <h1>{{$user->username}}</h1>

                    </div>

                    <div class="d-flex">
                        <div style="padding-right: 25px"><strong>{{$user->posts->count()}}</strong> posts</div>
                        <div style="padding-right: 25px"><strong>23k</strong> followers</div>
                        <div style="padding-right: 25px"><strong>212</strong> following</div>
                    </div>
                    <div class="pt-4">
                        Brand Name: <strong>{{ $user->profile->title ?? "Default Title" }}</strong>
                    </div>
                    <div> Brand Description: {{ $user->profile->description ?? "Default Description"}}</div>
                    <div><a href="{{ $user->profile->url ?? 'https://cystar.co.ke'}}"> {{ $user->profile->url ?? 'https://cystar.co.ke'}}</a> </div>
                </div>
                @can('update',$user->profile)
                <div class=" justify-content-center py-4">

                    <a href="/profile/{{$user->id}}/update_brand" class="btn col-4  btn-primary justify-content-center btn-outline-light">Edit Brand</a>
                </div>
                @endcan

    </form>
        </div>
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
                                            <span>Ethnic</span>
                                        </a>

                                    </div>
                                    <div class="title-product">
                                        <h3>{{$post->title}}</h3>
                                    </div>
                                    <div class="description-prod">
                                        <p>{{$post->description}}</p>
                                    </div>
                                    <div class="card-footer h-25">
                                        <div class="p-lg-1 wcf-left"><span class="price">KES {{$post->amount}}</span></div>
                                        <div class="wcf-right"><a href="#" class="buy-btn"><span class="iconify" data-icon="zmdi:shopping-cart"></span><i class="zmdi zmdi-shopping-basket"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="shell  ">
            {{--        bootstrap has 12 columns in total--}}
            <div class="container" >
                <div class="row">
                    @foreach($user->posts as $post)
                        @if ($loop->first)
                            <div class="col-md-12">
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
                        @endif


                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer h-75 d-flex justify-content-center">
            <button class="btn btn-primary">Publish Post</button>
        </div>

    </div>
@endsection

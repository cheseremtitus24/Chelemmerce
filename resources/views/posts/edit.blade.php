@extends('layouts.app')

@section('content')
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

            <div class="shell">
                {{--        bootstrap has 12 columns in total--}}
                <div class="container">
                    <div class="row">
                        @foreach($user->posts as $post)


                            <div class="col-md-3">
                                <div class="wsk-cp-product">
                                    <div class="wsk-cp-img">
                                        <img src="/storage/{{$post->image}}" alt="Product" class="img-responsive"/>
                                    </div>
                                    <div class="wsk-cp-text">
                                        <div class="category">


                                            <div class="d-flex align-content-center ">
                                                {{--                                            <h4>Delete this account</h4>--}}

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
                                                {{--                                            <p>This action is permanent; think twice before proceeding!</p>--}}

                                                {{--                                            <dialog id="confirm-delete" class="site-dialog">--}}
                                                {{--                                                <header class="dialog-header">--}}
                                                {{--                                                    <h1>Please Confirm</h1>--}}
                                                {{--                                                </header>--}}
                                                {{--                                                <div class="dialog-content">--}}
                                                {{--                                                    <p>You are about to close your account. This action is irreversible. It will permanently delete your account along with its associated data. Are you sure you want to continue?</p>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="btn-group cf">--}}
                                                {{--                                                    <button class="btn btn-danger" id="delete">Delete</button>--}}
                                                {{--                                                    <button class="btn btn-edit" id="edit`">Edit</button>--}}
                                                {{--                                                    <button class="btn btn-cancel" id="cancel">Cancel</button>--}}

                                                {{--                                                </div>--}}
                                                {{--                                            </dialog>--}}

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

                                            {{--                                        <a class="category"  href="/p/{{$post->id}}">--}}
                                            {{--                                            <span style="background-color: green;">Edit</span>--}}
                                            {{--                                        </a>--}}

                                        </div>
                                        <div class="title-product">
                                            <h3>{{$post->title}}</h3>
                                        </div>
                                        <div class="description-prod">
                                            <p>{{ str_limit($post->description,108, ' ...')}}</p>
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

                            {{--            <div class="col-4 pb-4">--}}
                            {{--               --}}
                            {{--                <img src="/storage/{{$post->image}}" class="w-100">--}}
                            {{--            </div>--}}
                        @endforeach
                    </div>


                </div>

            </div>
@endsection

@extends('layouts.app')

@section('content')

    <head>

        <title>Laravel 7+ Multiple Image File Upload</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>

        <style>

            .thumb {

                margin: 10px 5px 0 0;

                width: 300px;

            }

        </style>

    </head>



    <div class="container">

        <div class="row justify-content-center">

            <div class="card" style="margin-top: 4%">


                <div class="card-header bg-secondary dark bgsize-darken-4 white card-header">

                    <h4 class="text-white"> Upload Multiple Product Images(max=6 images) With On the Fly Editing</h4>

                </div>

                <div class="card-body">

                    @if ($message = Session::get('success'))

                        <div class="alert alert-success alert-block">

                            <button type="button" class="close" data-dismiss="alert">×</button>

                            <strong>{{ $message }}</strong>

                        </div>

                        <br>

                    @endif

                    <form id="file-upload-form" class="uploader" action="{{url('save')}}" method="post"
                          accept-charset="utf-8" enctype="multipart/form-data">

                        @csrf

                        <input type="file" id="file-input" onchange="loadPreview(this)" name="image[]" multiple/>

                        <span class="text-danger">{{ $errors->first('image') }}</span>

                        <div id="thumb-output"></div>

                        <br>

                        <button type="submit" class="btn btn-success">Upload</button>

                    </form>

                </div>

            </div>

        </div>

    </div>






    <script>


        function loadPreview(input) {

            var data = $(input)[0].files; //this file data


            $.each(data, function (index, file) {

                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {

                    var fRead = new FileReader();

                    fRead.onload = (function (file) {

                        return function (e) {

                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image thumb element

                            $('#thumb-output').append(img);

                        };

                    })(file);

                    fRead.readAsDataURL(file);

                }

            });

        }


    </script>





@endsection

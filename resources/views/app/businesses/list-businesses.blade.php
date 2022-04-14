@extends('layouts.app')

@section('title', 'Businesses')


@section('content')
    <div class="container ">
        <div class="row justify-content-center">

            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Your Businesses</div>

                    <div class="card-body">
                        @if (count($businesses) == 0)
                            <p class='title h4 text-center'>
                                You don't have any business profile yet!
                                <br>
                                <button class="btn btn-success mt-4" data-toggle="modal" data-target="#CreateForm">
                                    Get started
                                </button>
                                <Br>
                            </p>
                        @else
                            <div class='row'>
                                <div class='col-md-12'>
                                    @foreach ($businesses as $bus)
                                        <a href='businesses/{{ $bus->id }}' class='not '>
                                            <div class='row position-relative  element m-2 border-radius-lg table-bordered'>
                                                <div class="avatar avatar-xl " alt="Logo">
                                                    <img class='w-100 border-radius-lg shadow-sm' src='{{ $bus->logo }}'>
                                                </div>
                                                <h4 class='w-auto my-auto'>
                                                    {{ $bus->name }}
                                                </h4>
                                                <div
                                                    style='position: absolute;width: fit-content;right: 57px;top: 50%;transform: translateY(-50%);'>
                                                    @if ($bus->pivot->is_favorite)
                                                        <i class="fa fa-star text-primary" style='font-size: 1.5rem;'
                                                            aria-hidden="true"></i>
                                                    @else
                                                        <form method='post'
                                                            action='/businesses/{{ $bus->id }}/make-favorite'
                                                            class='d-inline'>
                                                            @csrf
                                                            <button type='submit' class='btn btn-link text-primary p-0'>
                                                                <i class="far fa-star" style='font-size: 1.5rem;'
                                                                aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                                <div style='position: absolute; width: auto; right: 7px; top: 40%;'>
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>

                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <p class='title h4 text-center'>
                                <br>
                                <a class="btn btn-success mt-4 text-white" data-toggle="modal" data-target="#CreateForm">
                                    Add new business profile
                                </a>
                            </p>

                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- CreateForm --}}
    <div class="modal fade" id="CreateForm" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class=" modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Business Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="output_content">
                    <form method="POST" id='create-form' action="create-business-form" enctype="multipart/form-data">
                        @csrf

                        <div class="row  ">
                            <div class="col-md-4 ">
                                <div style='margin:5px; padding :7px; display:inline-block;position: relative;'>
                                    <label for='imgFile'>
                                        <div class='avatar avatar-xl position-relative'>
                                            <img src="{{ asset('img/bizLogo.png') }}" id='imgSrc' alt="profile_image"
                                                class=" border-radius-lg shadow-sm" style='max-width:75px;max-height:75px;'>
                                        </div>
                                    </label>
                                    <input type='file' name='logo' style='display:none' accept="image/*" id='imgFile'
                                        onchange='readImg(this.files[0])'>
                                    <a id='removeBtn'
                                        style='display:none;z-index: 5;position: absolute;top: 0px;left: 5px;color: red;'
                                        onclick='removeImg()'>
                                        <i class="fas fa-times-circle text-danger"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="name" class="col-form-label text-md-end">
                                    Business Name
                                </label>


                                <input id="name" type="name" class="form-control" name="name" required autofocus>

                            </div>
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <a type="submit" class="btn btn-success text-white"
                        onclick="event.preventDefault();
                                                                                                                document.getElementById('create-form').submit();">Create</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function readImg(image) {
            var imgId = "imgSrc";
            var btnId = "removeBtn";
            document.getElementById(imgId).src = window.URL.createObjectURL(image);
            document.getElementById(btnId).style.display = 'inline';
        }

        function removeImg() {
            var imgId = "imgSrc";
            var btnId = "removeBtn";
            var fileId = "imgFile";
            document.getElementById(imgId).src = "{{ asset('img/bizLogo.png') }}";
            document.getElementById(fileId).value = null;
            document.getElementById(btnId).style.display = 'none';
        }
    </script>
@endsection

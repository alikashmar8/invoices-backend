@extends('layouts.app')

@section('title', 'Profile')


@section('content')
<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card-prof p-3 py-4">
                <div class="text-center">
                    <img src="{{asset($user->profile_picture)}}" width="100" class="rounded-circle">
                </div>
                <div class="text-center mt-3">
                    <span class="bg-secondary p-1 px-4 rounded text-white">{{$user->name}}</span>
                    <h5 class="mt-2 mb-0">{{$user->email}}</h5>
                    <span>{{$user->phone_number}}</span> <br>
                    <span class="{{$user->planName}}Text">{{$user->planName}} Plan</span>
                    <div class="px-4 mt-1">
                        <p class="fonts-prof">
                            @if(count(Auth::user()->businesses) > 0)
                            You've created {{count(Auth::user()->businesses)}} business profile(s)
                            @else
                            <a class='btn btn-link' href="/businesses">Create your business profile</a>
                            @endif
                        </p>
                    </div>
                    @if(count(Auth::user()->businesses) > 0)
                    <ul class="social-list-prof">
                        @foreach(Auth::user()->businesses as $bus)
                        <li>
                            <a href='/businesses/{{$bus->id}}' class='not '>
                                <div class="avatar avatar-xl " alt="Logo">
                                    <img class='w-100 border-radius-lg shadow-sm' src='{{asset($bus->logo)}}'>
                                </div>
                            </a>
                        </li>
                        @endforeach

                    </ul>
                    @endif
                    <div class="buttons-prof">
                        <button class="btn btn-outline-primary px-4" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </button>
                        <button class="btn btn-primary px-4 ms-3" data-toggle="modal" data-target="#EditProfileForm">Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-5" id='Notifications'>
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card px-3  ">
                <div class="row">
                    <table class='table table-striped table-hover table-responsive-sm   '>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Actions</th>
                                <th>Date</th>

                            </tr>
                        </thead>
                        @if(count($notifications))
                         
                        <tbody>
                            @foreach($notifications as $not)
                            <tr style='@if(!$not->is_read) font-weight:bold @endif' id='tr_{{$not->id}}'>
                                <td>{{$not->title}}</td>
                                <td>@php echo $not->message @endphp</td>
                                <td>
                                    
                                    <form id="mark_read_{{$not->id}}" method="post" style="display:inline-block" action="javascript:void(0)" >
                                        @csrf
                                        <button type="submit" id="submit_{{$not->id}}" class="btn btn-link p-0 text-secondary">
                                            @if(!$not->is_read)
                                            <i class='fa fa-envelope-open  '></i><small>Mark as read</small>
                                            @else
                                            <i class='fa fa-envelope'></i><small>Mark as unread</small>
                                            @endif
                                        </button>
                                    </form> 
                                    
                                    <form id="delete_{{$not->id}}" method="post" style="display:inline-block"   >
                                        @csrf 
                                        @method('delete')
                                        <button type="submit" class="btn btn-link p-0 text-danger">
                                            <i class='fa fa-trash'></i><small>Delete</small>
                                        </button>
                                    </form>
                                    <script> 
                                    var url_{{$not->id}} = "";
                                    @if(!$not->is_read)
                                        url_{{$not->id}} = "/notifications/{{$not->id}}/mark-read" 
                                    @else 
                                        url_{{$not->id}} = "/notifications/{{$not->id}}/mark-unread" 
                                    @endif
                                        if ($("#mark_read_{{$not->id}}").length > 0) {
                                            $("#mark_read_{{$not->id}}").validate({
                                                submitHandler: function(form) {
                                                    //$('#submit').html('Please Wait...');
                                                    //$("#submit"). attr("disabled", true);
                                                    $.ajax({
                                                        url: url_{{$not->id}},
                                                        type: "POST",
                                                        data: $('#mark_read_{{$not->id}}').serialize(),
                                                        success: function( response ) {
                                                            if(url_{{$not->id}} == "/notifications/{{$not->id}}/mark-read"){ 
                                                                //alert(url_{{$not->id}});
                                                                url_{{$not->id}} = "/notifications/{{$not->id}}/mark-unread" ;
                                                                $('#submit_{{$not->id}}').html('<i class="fa fa-envelope"></i><small>Mark as unread</small>');
                                                                $('#tr_{{$not->id}}').css('font-weight', 'normal');
                                                                numberOfNotifications_int -= 1;
                                                                numberOfNotifications.innerHTML = numberOfNotifications_int;
                                                            }
                                                            else{
                                                                //alert(url_{{$not->id}});
                                                                url_{{$not->id}} = "/notifications/{{$not->id}}/mark-read";
                                                                $('#submit_{{$not->id}}').html('<i class="fa fa-envelope-open  "></i><small>Mark as read</small>');
                                                                $('#tr_{{$not->id}}').css('font-weight', 'bold');
                                                                numberOfNotifications_int += 1;
                                                                numberOfNotifications.innerHTML = numberOfNotifications_int;
                                                                
                                                            }

                                                            document.getElementById("mark_read_{{$not->id}}").reset(); 
                                                            
                                                             
                                                        }
                                                    });
                                                }
                                            })
                                        }
                                                                        
                                        if ($("#delete_{{$not->id}}").length > 0) {
                                            $("#delete_{{$not->id}}").validate({
                                                submitHandler: function(form) { 
                                                    $.ajax({
                                                        url: "/notifications/{{$not->id}}",
                                                        type: "post",
                                                        data: $('#delete_{{$not->id}}').serialize(),
                                                        success: function( response ) {
                                                            $('#btn_{{ $not->id}}').css('display', 'none');
                                                            $('#btn_separator_{{ $not->id}}').css('display', 'none');
                                                            
                                                            $('#tr_{{$not->id}}').css('display', 'none');
                                                                   
                                                            numberOfNotifications_int -= 1;
                                                            numberOfNotifications.innerHTML = numberOfNotifications_int;
                                                                    
                                                        }
                                                    });
                                                }
                                            })
                                        } 
                                    </script> 
                                </td>
                                <td>{{\Carbon\Carbon::parse($not->created_at)->format('g:i A d/m/Y') }}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        <tbody>
                            <tr>
                                <td colspan=4>No notifications to show</td>
                            </tr>
                        </tbody>
                        @endif
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

{{--EditProfileForm--}}
<div class="modal fade" id="EditProfileForm" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class=" modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id='edit-profile-form' action="/edit-profile-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" id="output_content">

                    <div class="row  ">
                        <div class="col-md-4 ">
                            <div style='margin:5px; padding :7px; display:inline-block;position: relative;'>
                                <label for='imgFile'>
                                    <div class='avatar avatar-xl position-relative'>
                                        <img src="{{asset($user->profile_picture)}}" id='imgSrc' alt="profile_picture" class=" rounded-circle shadow-sm" style='max-width:75px;max-height:75px;'>
                                    </div>
                                </label>
                                <input type='file' name='profile_picture' style='display:none' accept="image/*" id='imgFile' onchange='readImg(this.files[0])'>
                                <a id='removeBtn' style='display:none;z-index: 5;position: absolute;top: 0px;left: 5px;color: red;' onclick='removeImg()'>
                                    <i class="fas fa-times-circle text-danger"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="name" class="col-form-label text-md-end">
                                Name
                            </label>
                            <input id="name" type="name" class="form-control" name="name" value='{{$user->name}}' placeholder='Name' required autofocus>

                            <label for="name" class="col-form-label text-md-end">
                                Email address
                            </label>
                            <input id="email" type="email" class="form-control" name="email" value='{{$user->email}}' placeholder='Email' required>

                            <label for="name" class="col-form-label text-md-end">
                                Phone number
                            </label>
                            <input id="phone_number" type="phone" class="form-control" value='{{$user->phone_number}}' placeholder='Phone Number' name="phone_number">

                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-success text-white">Edit</button>

                </div>
            </form>

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
        document.getElementById(imgId).src = "{{asset('img/profile.png')}}";
        document.getElementById(fileId).value = null;
        document.getElementById(btnId).style.display = 'none';
    }
</script>


@endsection

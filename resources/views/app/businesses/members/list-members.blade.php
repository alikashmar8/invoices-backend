@extends('layouts.app')

@section('title', 'Team members')


@section('content')

    {{ !Auth::user()->businesses()->where('business_id', $business->id)->get()->isEmpty() }}
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card-prof p-3 py-4" style='    border: 1px solid #ff556e30;'>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <img src="{{ asset($business->logo) }}" width="100" class="rounded-circle">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-primary">
                                <h5 class="mt-2 mb-0">{{ $business->name }} Team</h5> <br>
                                <ul class="social-list-prof  ">

                                </ul>
                            </div>
                        </div>
                        @if($current_user_business_details->role == 'MANAGER' || $current_user_business_details->role == 'CO_MANAGER')
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-sm btn-block" data-toggle="modal"
                                data-target="#addMemberModal">Add a new member</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card p-3 py-4">
                    <div class="row">
                        <table class='table table-striped table-hover table-responsive-sm'>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($business->users as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->pivot->role }}</td>
                                        <td>
                                            @if ($member->pivot->is_active)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </td>
                                        <td>
                                            @if ($current_user_business_details->role == 'MANAGER' || $current_user_business_details->role == 'CO_MANAGER')
                                                <button type="button" class="btn">
                                                    <i class="fa fa-trash text-primary"></i>
                                                </button>
                                            @endif
                                            @if ($current_user_business_details->role == 'MANAGER' || $current_user_business_details->role == 'CO_MANAGER' || $member->id == Auth::user()->id)
                                                <button type="button" class="btn">
                                                    <i class='fa fa-edit text-primary'></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($invitations) > 0)
                                    @foreach ($invitations as $invitation)
                                        <tr>
                                            <td>{{ $invitation->user->name }}</td>
                                            <td>{{ $invitation->role }}</td>
                                            <td>{{ $invitation->status }}</td>
                                            <td>
                                                <button type="button" class="btn">

                                                    <i class="fa fa-trash text-primary"></i>
                                                    <i class='fa fa-edit text-primary'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Add Member modal --}}
    <div class="modal fade" id="addMemberModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class=" modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a new team member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="output_content">
                    <div class="row" id='controllerForMember'>
                        <form method="POST" id="memberCheckerIfExist" action="javascript:void(0)">
                            @csrf
                            <label for="email1" class="col-form-label text-md-end">
                                Create a new member or invite an existing user:
                            </label>
                            <input id="email1" type="email" class="form-control" name="email1" placeholder='Email'
                                required>
                            <input type='hidden' name="id" value='{{ $business->id }}'>
                            <p class='text-success w-auto' id='isTeamMember' style='display:none'>This account is already in
                                your team</p>
                            <button type="submit" id='next1' class="btn btn-success text-white my-3">Next <i
                                    class='fa fa-arrow-right fa-xs'></i></button>

                        </form>
                    </div>
                    <div class="row" id='createNewMember' style='display:none'>
                        <button class='btn btn-link w-auto' onclick='back()'><i class='fa fa-arrow-left  fa-xs'></i>
                            Back</button>
                        <p class='text-success w-auto'> This email is not registered yet, create a new account: </p>
                        <form method="POST" action="/businesses/{{ $business->id }}/employees"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="name" class="col-form-label text-md-end">
                                    Name
                                </label>
                                <input id="name" type="name" class="form-control" name="name" value='' placeholder='Name'
                                    required autofocus>

                                <label for="email" class="col-form-label text-md-end">
                                    Email address
                                </label>
                                <input id="email2" type="email" class="form-control" disabled>
                                <input id="email22" type="email" style="display:none" name="email">

                                <label for="password" class="col-form-label text-md-end">
                                    Password
                                </label>
                                <input id="password" type="password" class="form-control" value='' placeholder='Password'
                                    name="password">

                                <label for="password_confirmation" class="col-form-label text-md-end">
                                    Confirm Password
                                </label>
                                <input id="password_confirmation" type="password" class="form-control" value=''
                                    placeholder='Confirm Password' name="password_confirmation">

                                <label for="role" class="col-form-label text-md-end">
                                    Role
                                </label>
                                <select name="role" id="role" class="form-control">
                                    <option value="CO-MANAGER">Co Manager</option>
                                    <option value="TEAM_MEMBER" selected>Team Member</option>
                                </select>

                                <button type="submit" class="btn btn-success text-white my-3">Submit</button>

                            </div>
                        </form>
                    </div>

                    <div class="row" id='addExistingMember' style='display:none'>
                        <button class='btn btn-link w-auto' onclick='back()'><i class='fa fa-arrow-left fa-xs'></i>
                            Back</button>

                        <form method="POST" action='/invitations'>
                            @csrf
                            <input type='hidden' name="business_id" value='{{ $business->id }}'>
                            <h4>Invite this user:</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="email" class="col-form-label text-md-end">
                                        Email address
                                    </label>
                                    <input id="email3" type="email" class="form-control" disabled>
                                    <input id="email33" type="email" style="display:none" name="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="role" class="col-form-label text-md-end">
                                        Role
                                    </label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="CO_MANAGER">Co Manager</option>
                                        <option value="TEAM_MEMBER" selected>Team Member</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success text-white my-3">Submit</button>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
        <script>
            var url = "/memberCheckerIfExist";
            if ($("#memberCheckerIfExist").length > 0) {
                $("#memberCheckerIfExist").validate({
                    submitHandler: function(form) {
                        $('#next1').html('Please Wait...');
                        $("#next1").attr("disabled", true);
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: $('#memberCheckerIfExist').serialize(),
                            success: function(response) {
                                $('#next1').html("Next <i class='fa fa-arrow-right fa-xs'></i>");
                                $("#next1").attr("disabled", false);
                                //alert(response['success']);
                                if (response['success'] == 'exist') {
                                    $('#createNewMember').css('display', 'none');
                                    $('#addExistingMember').css('display', 'block');
                                    $('#controllerForMember').css('display', 'none');
                                    $('#isTeamMember').css('display', 'none');
                                    $('#email3').val($('#email1').val());
                                    $('#email33').val($('#email1').val());
                                } else if (response['success'] == 'notExist') {
                                    $('#createNewMember').css('display', 'block');
                                    $('#addExistingMember').css('display', 'none');
                                    $('#controllerForMember').css('display', 'none');
                                    $('#isTeamMember').css('display', 'none');
                                    $('#email2').val($('#email1').val());
                                    $('#email22').val($('#email1').val());
                                } else {
                                    $('#isTeamMember').css('display', 'block');

                                }
                                document.getElementById("memberCheckerIfExist").reset();

                            },
                            error: function() {

                                $('#next1').html("Next <i class='fa fa-arrow-right fa-xs'></i>");
                                $("#next1").attr("disabled", false);
                                alert("Something went wrong! Try again");

                                document.getElementById("memberCheckerIfExist").reset();
                            }
                        });
                    }
                })
            }

            function back() {
                //alert('s')
                document.getElementById("createNewMember").style.display = 'none';
                document.getElementById("addExistingMember").style.display = 'none';
                document.getElementById("controllerForMember").style.display = 'block';
            }
        </script>
    @endsection

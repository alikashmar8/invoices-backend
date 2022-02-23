@extends('layouts.app')

@section('title', $business->name)


@section('content')

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card-prof p-3 py-4" style='    border: 1px solid #ff556e30;'>
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <img src="{{asset($business->logo)}}" width="100" class="rounded-circle">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-primary">
                            <h5 class="mt-2 mb-0">{{$business->name}} <i class='fa fa-edit text-primary ml-3'> </i></h5>
                            <span class="small"><small>Since: {{Carbon\Carbon::parse($business->created_at)->format('M Y')}}</small> </span>
                            <ul class="social-list-prof  ">
                                @foreach($business->users as $member)
                                <li style='padding: 0px; margin:0px'>
                                    <img src="{{asset($member->profile_picture)}}" class="rounded-circle" style='max-width: 30px'>

                                </li>
                                @endforeach
                                @if($current_user_business_details->role == App\Enums\UserRole::MANAGER ||
                                    $current_user_business_details->role == App\Enums\UserRole::CO_MANAGER)
                                <li><a href="/businesses/{{$business->id}}/employees" class="small text-primary">Show more <i class="fas fa-arrow-alt-circle-right"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @if($business->is_active)
                        <span class="bg-primary float-right p-1 px-4 rounded text-white">Active</span>
                        @else
                        <span class="bg-danger float-right p-1 px-4 rounded text-white">Stopped</span>
                        @endif
                        <br><br>
                        @if($current_user_business_details->role != App\Enums\UserRole::MANAGER)
                        <span class="bg-danger float-right p-1 px-4 rounded text-white" data-toggle="modal" data-target="#leave_business_modal">Leave business</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card px-3 ">
                <div class="row">
                    <table class='table table-striped table-hover table-responsive-sm   '>
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Contact</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Alfreds Futterkiste</td>
                                <td>Maria Anders</td>
                                <td>Germany</td>
                            </tr>
                            <tr>
                                <td>Centro comercial Moctezuma</td>
                                <td>Francisco Chang</td>
                                <td>Mexico</td>
                            </tr>
                            <tr>
                                <td>Ernst Handel</td>
                                <td>Roland Mendel</td>
                                <td>Austria</td>
                            </tr>
                            <tr>
                                <td>Island Trading</td>
                                <td>Helen Bennett</td>
                                <td>UK</td>
                            </tr>
                            <tr>
                                <td>Laughing Bacchus Winecellars</td>
                                <td>Yoshi Tannamuri</td>
                                <td>Canada</td>
                            </tr>
                            <tr>
                                <td>Magazzini Alimentari Riuniti</td>
                                <td>Giovanni Rovelli</td>
                                <td>Italy</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leave business modal -->
<div class="modal fade" id="leave_business_modal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class=" modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Leave Business</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="output_content">
                <form method="POST" id='leave_business_form' action="/businesses/{{$business->id}}/leave" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            Are you sure you want to leave {{$business->name}}?
                        </div>
                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <a type="submit" class="btn btn-success text-white" onclick="event.preventDefault();
                                                    document.getElementById('leave_business_form').submit();">Confirm</a>

            </div>

        </div>
    </div>
</div>

@endsection

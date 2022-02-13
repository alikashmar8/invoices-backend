@extends('layouts.app')

@section('title', 'Home')


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
                            <h5 class="mt-2 mb-0">{{$business->name}} <i class='fa fa-edit text-primary'> </i></h5> <br>
                            <ul class="social-list-prof  ">

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @if($business->is_active)
                        <span class="bg-primary float-right p-1 px-4 rounded text-white">Active</span>
                        @else
                        <span class="bg-danger float-right p-1 px-4 rounded text-white">Stoped</span>
                        @endif<br><br>

                        <span class="bg-secondary float-right p-1 px-4 rounded text-white"><small>Since: {{Carbon\Carbon::parse($business->created_at)->format('M Y')}}</small> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-5">
    <h5>Employees:</h5>
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
                            @foreach($business->users as $employee)

                            <!-- <li style='padding: 0px; margin:0px'>
                                <img src="{{asset($employee->profile_picture)}}" class="rounded-circle" style='max-width: 30px'>

                            </li> -->

                            <tr>
                                <td>{{$employee->name}}</td>
                                <td>{{$employee->pivot->role}}</td>
                                <td> @if($employee->pivot->is_active) active @else inactive @endif </td>
                                <td><button type="button" class="btn"><i class="fa fa-trash btn-outline-danger"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

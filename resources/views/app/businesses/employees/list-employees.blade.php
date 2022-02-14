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
                            <h5 class="mt-2 mb-0">My Employees</h5> <br>
                            <ul class="social-list-prof  ">

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</button>
                    </div>
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
                            @foreach($business->users as $employee)
                            <tr>
                                <td>{{$employee->name}}</td>
                                <td>{{$employee->pivot->role}}</td>
                                <td> @if($employee->pivot->is_active) active @else inactive @endif </td>
                                <td>
                                    <button type="button" class="btn">
                                        <i class="fa fa-trash text-primary"></i>
                                        <i class='fa fa-edit text-primary'></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>



{{--Add Employee modal--}}
<div class="modal fade" id="addEmployeeModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class=" modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a new employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="output_content">
                <form method="POST" action="/businesses/{{$business->id}}/employees" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name" class="col-form-label text-md-end">
                                Name
                            </label>
                            <input id="name" type="name" class="form-control" name="name" value='' placeholder='Name' required autofocus>

                            <label for="email" class="col-form-label text-md-end">
                                Email address
                            </label>
                            <input id="email" type="email" class="form-control" name="email" value='' placeholder='Email' required>

                            <label for="password" class="col-form-label text-md-end">
                                Password
                            </label>
                            <input id="password" type="password" class="form-control" value='' placeholder='Password' name="password">

                            <label for="password_confirmation" class="col-form-label text-md-end">
                                Confirm Password
                            </label>
                            <input id="password_confirmation" type="password" class="form-control" value='' placeholder='Confirm Password' name="password_confirmation">

                            <label for="role" class="col-form-label text-md-end">
                                Role
                            </label>
                            <select name="role" id="role" class="form-control">
                                <option value="MANAGER">Manager</option>
                                <option value="EMPLOYEE" selected>Employee</option>
                            </select>

                            <button type="submit" class="btn btn-success text-white my-3">Submit</button>

                        </div>
                    </div>
                </form>
                <hr>
                Or invite an existing user:
                <form method="POST" action='/businesses/{{$business->id}}/employees/invite'>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="email" class="col-form-label text-md-end">
                                Email address
                            </label>
                            <input id="email" type="email" class="form-control" name="email" value='' placeholder='Email' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="role" class="col-form-label text-md-end">
                                Role
                            </label>
                            <select name="role" id="role" class="form-control">
                                <option value="MANAGER">Manager</option>
                                <option value="EMPLOYEE" selected>Employee</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success text-white my-3">Submit</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

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
                            <h5 class="mt-2 mb-0">{{$business->name}} <i class='fa fa-edit text-primary'> </i></h5> <br>
                            <ul class="social-list-prof  ">
                                @foreach($business->users as $member)
                                <li style='padding: 0px; margin:0px'>
                                    <img src="{{asset($member->profile_picture)}}" class="rounded-circle" style='max-width: 30px'>

                                </li>
                                @endforeach
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
                        <a href="/businesses/{{$business->id}}/employees" class=" btn btn-secondary bg-secondary float-right p-1 px-4 rounded text-white">My Employees</a>
                        <br><br>

                        <span class="bg-secondary float-right p-1 px-4 rounded text-white"><small>Since: {{Carbon\Carbon::parse($business->created_at)->format('M Y')}}</small> </span>
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


@endsection

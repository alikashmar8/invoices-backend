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
                            <h5 class="mt-2 mb-0">{{$business->name}} </h5>
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
                        <span class="bg-danger float-right p-1 px-4 rounded text-white" style='cursor: pointer;' data-toggle="modal" data-target="#leave_business_modal">Leave business</span>
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
                                <td>#</td>
                                <td>Title</td>
                                <td>Ammount</td>
                                <td>Status</td>
                                <td>Reference #</td>
                                <td>Added by</td>
                                <td>Actions</td>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($invoices))
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $loop->index }}</td>
                                    <td>{{ $invoice->title }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    <td>
                                        @if($invoice->is_paid) <span class='text-success border border-success p-1'>Paid {{ $invoice->payment_date }}</span>
                                        @else <span class='text-warning border border-warning p-1'>Not Paid</span> {{ $invoice->due_date }}
                                        @endif
                                    </td>
                                    <td>{{$invoice->reference_number }}</td>
                                    <td><img src="{{asset(App\Models\User::findOrFail($invoice->created_by )->first()->profile_picture)}}" class="rounded-circle" style='max-width: 30px'>{{ App\Models\User::findOrFail($invoice->created_by )->first()->name }}</td>
                                    <td>
                                        <button type="button" class="btn col-md-2" data-target="#showModal-{{ $invoice->id }}" data-toggle="modal">
                                            <i class="fa fa-expand text-primary" aria-hidden="true"></i>
                                        </button>

                                        <button type="button" class="btn col-md-2" data-target="#editModal-{{ $invoice->id }}" data-toggle="modal">
                                            <i class="fa fa-edit text-primary"></i>
                                        </button>
                                        
                                        @if (($current_user_business_details->role == 'MANAGER' || $current_user_business_details->role == 'CO_MANAGER')  )
                                        <button type="button" class="btn col-md-2" data-target="#deleteModal-{{ $invoice->id }}" data-toggle="modal">
                                            <i class='fa fa-trash text-primary'></i>
                                        </button>
                                        @endif
                                        
                                    </td>
                                </tr>
                                <!-- delete modal -->
                                <div class="modal fade" id="showModal-{{$invoice->id}}" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class=" modal-dialog" role="document">
                                        <div class="modal-content" >
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$invoice->title }} # {{$invoice->reference_number }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="output_content">
                                                <p><b>Total amount:</b> {{$invoice->total }}	</p>
                                                <p><b>Status:</b> @if($invoice->is_paid) Paid at {{$invoice->payment_date }} @else Not paid	@endif </p>
                                                <p><b>Due date:</b> {{$invoice->due_date }}	</p>
                                                <p><b>Notes:</b> {{$invoice->notes }} </p>
                                                <p><b>Added by:</b> <img src="{{asset(App\Models\User::findOrFail($invoice->created_by )->first()->profile_picture)}}" class="rounded-circle" style='max-width: 30px'>{{ App\Models\User::findOrFail($invoice->created_by )->first()->name }} </p>
                                                <p><b>Discount:</b> {{$invoice->discount }} </p>
                                                <p><b>Extra amount:</b> {{$invoice->extra_amount }} </p>
                                                <p><b>Added on:</b> {{$invoice->created_at }} </p>
                                                @if($invoice->attachment)
                                                <p><b>Attachments</b></p>
                                                    @foreach($invoice->attachment as $attach)
                                                        <a href="{{ asset($attach->url) }}" class='btn btn-info'  download="">Doc{{ $loop->index }} </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-danger">No invoices to show!</td> 
                            </tr> 
                            @endif
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

                <a type="submit" class="btn btn-danger text-white" onclick="event.preventDefault();
                                                    document.getElementById('leave_business_form').submit();">Confirm</a>

            </div>

        </div>
    </div>
</div>

@endsection

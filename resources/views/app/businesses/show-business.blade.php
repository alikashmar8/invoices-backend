@extends('layouts.app')

@section('title', $business->name)


@section('content')  
<br> 
    <div style="width: 100%; height:100%; position: absolute; text-align:center;display:none; z-index:1050; background: white;" id="gocha">
        
    </div>
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
                                <h5 class="mt-2 mb-0">{{ $business->name }} </h5>
                                <span class=""><small>Since:
                                        {{ Carbon\Carbon::parse($business->created_at)->format('M Y') }}</small> </span>
                                <ul class="social-list-prof  ">
                                    @foreach ($business->users as $member)
                                        <li style='padding: 0px; margin:0px'>
                                            <img src="{{ asset($member->profile_picture) }}" class="rounded-circle"
                                                style='max-width: 30px'>

                                        </li>
                                    @endforeach
                                    @if ($current_user_business_details->role == App\Enums\UserRole::MANAGER || $current_user_business_details->role == App\Enums\UserRole::CO_MANAGER)
                                        <li><a href="/businesses/{{ $business->id }}/members"
                                                class="small text-primary">Show more <i
                                                    class="fas fa-arrow-alt-circle-right"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            @if ($business->is_active)
                                <span class="bg-primary2 float-right p-1 px-4 rounded text-white">Active</span>
                            @else
                                <span class="bg-danger float-right p-1 px-4 rounded text-white">Stopped</span>
                            @endif
                            <br><br>
                            <a href="/contacts/business/{{ $business->id }}"
                                class="btn btn-primary float-right p-1 px-4 rounded text-white">
                                Contacts
                            </a>
                            <br><br>
                            @if ($current_user_business_details->role != App\Enums\UserRole::MANAGER)
                                <span class="bg-danger float-right p-1 px-4 rounded text-white" style='cursor: pointer;'
                                    data-toggle="modal" data-target="#leave_business_modal">Leave business</span>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-3 m-auto">
                <button class="btn btn-primary w-100 m-auto" id='incomingLink' onclick="getIncoming()"> Incoming Invoices</button>
            </div>

            <div class="col-md-3 m-auto">
                <button class="btn btn-link w-100 m-auto" id='outgoingLink' onclick="getOutgoing()"> Outgoing Invoices</button>
            </div>
            <div class="col-md-3 m-auto">
                <button class="btn btn-link w-100 m-auto" id='dashboardLink' onclick="getDashboard()" @if ($current_user_business_details->role == App\Enums\UserRole::TEAM_MEMBER ) style='display:none' @endif>Overview</button>
            </div>
             
        </div>
    </div>

    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card px-3 ">
                    <div class="row noScrollBar" style='overflow: scroll;' id='incomingConten'>
                        <div class=" bg-light bg-gradient p-3">
                            <a @if ($user_has_suitable_plan ==1 ) 
                                href='/invoices/create' 
                                @endif
                                class="btn btn-success w-25 text-white
                                @if ( $user_has_suitable_plan ==0 && $current_user_business_details->role == App\Enums\UserRole::MANAGER )
                                gogem
                                @endif
                                "> 
                                @if ( $user_has_suitable_plan ==0 && $current_user_business_details->role == App\Enums\UserRole::TEAM_MEMBER )
                                Access suspended
                                @else 
                                Create new
                                @endif </a>

                            <a class="btn btn-info w-25 float-right text-white" onclick="showFilterInvoices()"> Filter </a>
                            <div class="row p-4" id="filterInvoices">
                                <div class="col-md-4">
                                    <label>Starting date for invoices:</label>
                                    <input type="date" id='startingDateI' class="form-control" <?php if(isset($_GET['startI']) ) echo "value='" . $_GET['startI'] . "'" ; ?> >
                                </div>
                                <div class="col-md-4 ">
                                    <label>Ending date for invoices:</label>
                                    <input type="date" id='endingDateI' class="form-control"  <?php if(isset($_GET['endI']) ) echo "value='" . $_GET['endI'] . "'" ; ?> >
                                </div> 
                                <div class="col-md-4 m-auto"> 
                                    <a class='btn btn-success text-white form-control ' style="width: fit-content" onclick="setFilterInvoices()">
                                        Show result
                                    </a> 
                                    <a class='btn btn-danger text-white form-control'  style="width: fit-content" onclick="clearFilterInvoices()">
                                        Clear
                                    </a> 
                                </div>
                            </div>

                            <!-- old filter script>
                                var invoicesList = [];
                            </script -->
                        </div>
                        <table class='table table-striped table-hover table-responsive-sm' id='myDataTable'>
                            <thead>
                                <tr>
                                    <td class="filterhead">#</td>
                                    <td class="filterhead">Title</td>
                                    <td class="filterhead">Amount</td>
                                    <td class="filterhead">Status</td> 
                                    <td>Actions</td>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($invoices))
                                    @foreach ($invoices as $invoice)
                                    <?php 
                                        if(isset($_GET['startI']) ){
                                            if( $invoice->created_at <= $_GET['startI'] ) continue;
                                        }
                                        if(isset($_GET['endI']) &&  $_GET['endI'] != ''  ){
                                            if( $invoice->created_at > $_GET['endI'] ) continue;
                                        }
                                    ?>
                                        <tr id='{{ $invoice->id }}'>
                                            <td>{{ $invoice->id }}</td>
                                            <td>{{ $invoice->title }}</td>
                                            <td>{{ $invoice->total }}</td>
                                            <td>
                                                @if ($invoice->is_paid)
                                                    <a class='text-success border border-success btn-outline-sm '
                                                        style='white-space: nowrap;'>Paid
                                                        {{ $invoice->payment_date }}</a>
                                                @else
                                                    <a class='text-warning border border-warning btn-outline-sm'
                                                        style='white-space: nowrap;'>Not Paid - Due:
                                                        {{ $invoice->due_date }} </a>
                                                @endif
                                            </td> 
                                            <td>
                                                <button type="button" class="btn col-md-2 p-0 mx-1"
                                                    data-target="#showModal-{{ $invoice->id }}" data-toggle="modal">
                                                    <i class="fa fa-expand text-primary" aria-hidden="true"></i>
                                                </button>

                                                <a type="button" class="btn col-md-2 p-0 mx-1"
                                                    href="/invoices/{{ $invoice->id }}/edit">
                                                    <i class="fa fa-edit text-primary"></i>
                                                </a> 

                                                @if ($current_user_business_details->role == 'MANAGER' || $current_user_business_details->role == 'CO_MANAGER')
                                                    <button type="button" class="btn col-md-2 p-0 mx-1"
                                                        data-target="#deleteModal-{{ $invoice->id }}"
                                                        data-toggle="modal">
                                                        <i class='fa fa-trash text-primary'></i>
                                                    </button>
                                                @endif

                                            </td>
                                        </tr>
                                        <!-- show invoice modal -->
                                        <div class="modal fade" id="showModal-{{ $invoice->id }}" tabindex="1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class=" modal-dialog" style='width:90%; max-width:90%' role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ $invoice->id }} @if($invoice->reference_number) #{{ $invoice->reference_number }} @endif
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" id="output_content1">
                                                        <p><b>Title:</b> {{ $invoice->title }} </p>
                                                        <p><b>Total amount:</b> ${{ $invoice->total }} <small>AUD</small>
                                                        </p>
                                                        
                                                        <p><b>GST:</b> ${{ $invoice->gst }}
                                                            <small>AUD</small>
                                                        </p>
                                                        <p><b>Discount:</b> {{ $invoice->discount }} @if ($invoice->discount_type == App\Enums\DiscountType::PERCENTAGE)
                                                                %
                                                            @else
                                                                $
                                                            @endif
                                                        </p>
                                                        <p><b>Status:</b>
                                                            @if ($invoice->is_paid)
                                                                Paid at {{ $invoice->payment_date }}
                                                            @else
                                                                Not paid
                                                            @endif
                                                        </p>
                                                        <p><b>Due date:</b>
                                                            @if ($invoice->due_date)
                                                                {{ $invoice->due_date }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                        <p><b>Notes:</b>
                                                        <p style='white-space: pre-line;'>{{ $invoice->notes }}</p>
                                                        </p>
                                                        <p><b>Added by:</b> <img
                                                                src="{{ asset($invoice->createdBy->profile_picture) }}"
                                                                class="rounded-circle" style='max-width: 30px'>
                                                              {{ $invoice->createdBy->name }}
                                                        </p>

                                                        <p><b>Added on:</b> {{ $invoice->created_at }} </p>
                                                        <p >
                                                            @if (count($invoice->items) >0)
                                                            
                                                                <p><b>Items Details: </b></p>
                                                                <div class="row  " id="heading">
                                                                    <div class="col-3 border border-dark">Description</div>
                                                                    <div class="col-3 border border-dark">QTY</div>
                                                                    <div class="col-3 border border-dark">GST</div>
                                                                    <div class="col-3 border border-dark">Item Price</div>
                                                                </div> 
                                                                
                                                                @foreach($invoice->items as $item)
                                                                 
                                                                <div class="row  " >
                                                                    <div class="col-3 border border-dark"> {{ $item->description}}</div>
                                                                    <div class="col-3 border border-dark">{{$item->quantity}}</div>
                                                                    <div class="col-3 border border-dark">{{$item->gst}}</div>
                                                                    <div class="col-3 border border-dark">{{$item->item_price}}</div>
                                                                </div> 
                                                                @endforeach
                                                               {{-- <table class="">
                                                                    <tr>
                                                                        <th> Description</th>
                                                                        <th> QTY</th>
                                                                        <th> GST</th>
                                                                        <th> Item Price</th>
                                                                    </tr>
                                                                    @foreach($invoice->items as $item)
                                                                    <tr>
                                                                        <td> {{ $item->description}}</td>
                                                                        <td> {{$item->quantity}}</td>
                                                                        <td> {{$item->gst}} </td>
                                                                        <td> {{$item->item_price}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                        
                                                                </table>--}}
                                                            @endif
                                                        </p>
                                                        @if (count($invoice->attachments) >0)
                                                            <p><b>Attachments</b></p>
                                                            @foreach ($invoice->attachments as $attach)
                                                                <!--a href="{{-- asset($attach->url) --}}" class='btn btn-info'  download="">Doc-{{ $loop->index + 1 }} </a-->
                                                                {{-- TODO:  design --}}
                                                                <div class="col-md-3 m-2"
                                                                    style='position:relative; display: inline-block;  height:150px; border:1px solid #ff556e;border-radius: 7px; padding:1px;'>
                                                                    <embed src="{{ asset($attach->url) }}"
                                                                        style='object-fit:cover ; width:100%; height:100%; border-radius: 7px;'>

                                                                    <div
                                                                        style="position:absolute; width:100%; bottom:0; background:transparent; border-radius: 0 0 7px 7px;">
                                                                        <div class="row w-100 m-0"
                                                                            style="
                                                                                                                display: block;
                                                                                                                width: 100%;
                                                                                                                overflow: hidden;
                                                                                                                white-space: nowrap;
                                                                                                                text-overflow: ellipsis;
                                                                                                                height: 24px;
                                                                                                                font-size: smaller;
                                                                                                                background-color: #a6a6a6a6;">
                                                                            {{ $attach->name }}
                                                                        </div>
                                                                        <div id='doc-{{ $loop->index + 1 }}'
                                                                            class="row w-100 m-0">
                                                                            <a href="{{ asset($attach->url) }}"
                                                                                class='col btn btn-info' target="_blank"
                                                                                style="border-radius: 0 0 0 7px">
                                                                                <i class="fa fa-external-link-alt"
                                                                                    aria-hidden="true"></i></a>
                                                                            <a href="{{ asset($attach->url) }}"
                                                                                class='col btn btn-warning text-white'
                                                                                download="" style="border-radius: 0"> <i
                                                                                    class="fa fa-file-download"
                                                                                    aria-hidden="true"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- old filter script>
                                            invoicesList.push(['{{ $invoice->id }}', '{{ $invoice->created_at }}']);
                                        </script -->
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-danger">No invoices to show!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                    <div class="row noScrollBar" style='overflow: scroll; display:none;' id='outgoingConten'>
                        <div class=" bg-light bg-gradient p-3">
                            <a @if ($user_has_suitable_plan ==1 ) 
                            href='/bills/create'
                            @endif
                            class="btn btn-success w-25 text-white
                            @if ( $user_has_suitable_plan ==0 && $current_user_business_details->role == App\Enums\UserRole::MANAGER )
                            gogem
                            @endif
                            "> 
                            @if ( $user_has_suitable_plan ==0 && $current_user_business_details->role == App\Enums\UserRole::TEAM_MEMBER )
                            Access suspended
                            @else 
                            Create new
                            @endif </a> 

                            <a class="btn btn-info w-25 float-right text-white" onclick="showFilterBills()"> Filter </a>
                            <div class="row p-4" id="filterBills">
                                <div class="col-md-4">
                                    <label>Starting date for bills:</label>
                                    <input type="date" id='startingDateB' class="form-control"  <?php if(isset($_GET['startB']) ) echo "value='" . $_GET['startB'] . "'" ; ?>  >
                                </div>
                                <div class="col-md-4 ">
                                    <label>Ending date for bills:</label>
                                    <input type="date" id='endingDateB' class="form-control"  <?php if(isset($_GET['endB']) ) echo "value='" . $_GET['endB'] . "'" ; ?>  >
                                </div>
                                <div class="col-md-4 m-auto">
                                    <a class='btn btn-success text-white form-control ' style="width: fit-content" onclick="setFilterBills()">
                                        Show result
                                    </a> 
                                    <a class='btn btn-danger text-white form-control' style="width: fit-content" onclick="clearFilterBills()">
                                        Clear
                                    </a>
                                </div>
                            </div>
                            <script>
                                var billsList = [];
                            </script>
                        </div>
                        <table class='table table-striped table-hover table-responsive-sm w-100' id='myDataTable1'>
                            <thead>
                                <tr>
                                    <td class="filterhead1">#</td>
                                    <td class="filterhead1">Title</td>
                                    <td class="filterhead1">Amount</td>
                                    <td class="filterhead1">Status</td> 
                                    <td>Actions</td>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($bills))
                                    @foreach ($bills as $bill)
                                    <?php 
                                        if(isset($_GET['startB']) ){ 
                                            if( $bill->created_at <= $_GET['startB'] ) continue;
                                        }
                                        if(isset($_GET['endB']) &&  $_GET['endB'] != ''  ){
                                            if( $bill->created_at > $_GET['endB'] ) continue;
                                        }
                                    ?>
                                        <tr id="{{ $bill->id }}">
                                            <td>{{ $bill->id }}</td>
                                            <td>{{ $bill->title }}</td>
                                            <td>{{ $bill->total }}</td>
                                            <td>
                                                @if ($bill->is_paid)
                                                    <a class='text-success border border-success btn-outline-sm '
                                                        style='white-space: nowrap;'>Paid
                                                        {{ $bill->payment_date }}</a>
                                                @else
                                                    <a class='text-warning border border-warning btn-outline-sm'
                                                        style='white-space: nowrap;'>Not Paid - Due:
                                                        {{ $bill->due_date }} </a>
                                                @endif
                                            </td> 
                                            <td>
                                                <button type="button" class="btn col-md-2 p-0 mx-1"
                                                    data-target="#showModal-{{ $bill->id }}" data-toggle="modal">
                                                    <i class="fa fa-expand text-primary" aria-hidden="true"></i>
                                                </button>

                                                <button type="button" class="btn col-md-2 p-0 mx-1"
                                                    data-target="#shareModal-{{ $bill->id }}" data-toggle="modal">
                                                    <i class="fa fa-share text-primary" aria-hidden="true"></i>
                                                </button>

                                                <a type="button" class="btn col-md-2 p-0 mx-1"
                                                    href="/bills/{{ $bill->id }}/edit">
                                                    <i class="fa fa-edit text-primary"></i>
                                                </a>

                                                @if ($current_user_business_details->role == 'MANAGER' || $current_user_business_details->role == 'CO_MANAGER')
                                                    <button type="button" class="btn col-md-2 p-0 mx-1"
                                                        data-target="#deleteModal-{{ $bill->id }}"
                                                        data-toggle="modal">
                                                        <i class='fa fa-trash text-primary'></i>
                                                    </button>
                                                @endif

                                                <a type="button" class="btn col-md-2 p-0 mx-1"
                                                    href="/storage/pdf/{{ $bill->id }}.pdf" download>
                                                    <i class="fa fa-file-download text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- show bill modal -->
                                        <div class="modal fade" id="showModal-{{ $bill->id }}" tabindex="1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class=" modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ $bill->id }} To {{$bill->contact->name}}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" id="output_content2">

                                                        <p><b>Title:</b> {{ $bill->title }}</p>
                                                        <p><b>Total amount:</b> ${{ $bill->total }} <small>AUD</small>
                                                        </p>
                                                        <p><b>GST:</b> ${{ $bill->gst }}
                                                            <small>AUD</small>
                                                        </p>
                                                        <p><b>Discount:</b> {{ $bill->discount }} @if ($bill->discount_type == App\Enums\DiscountType::PERCENTAGE)
                                                                %
                                                            @else
                                                                $
                                                            @endif
                                                        </p>
                                                        <p><b>Status:</b>
                                                            @if ($bill->is_paid)
                                                                Paid at {{ $bill->payment_date }}
                                                            @else
                                                                Not paid
                                                            @endif
                                                        </p>
                                                        <p><b>Due date:</b>
                                                            @if ($bill->due_date)
                                                                {{ $bill->due_date }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                        <p><b>Notes:</b>
                                                        <p style='white-space: pre-line;'>{{ $bill->notes }}</p>
                                                        </p>
                                                        <p><b>Added by:</b> <img
                                                                src="{{ asset($bill->createdBy->profile_picture) }}"
                                                                class="rounded-circle" style='max-width: 30px'>
                                                            {{ $bill->createdBy->name }}
                                                        </p>
                                                        <p><b>Added on:</b> {{ $bill->created_at }} </p>
                                                        <a class="btn btn-primary" href="{{asset('storage/pdf/'.$bill->id .'.pdf')}}" target="_blank"> View online </a>
                                                         
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            billsList.push(['{{ $bill->id }}', '{{ $bill->created_at }}']);
                                        </script>

                                        <!-- share bill modal -->
                                        <div class="modal fade" id="shareModal-{{ $bill->id }}" tabindex="1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class=" modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Share bill #{{ $bill->id }}  
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" >
                                                        <b>General access</b>
                                                        <div class="row">
                                                            <form class="form" method='post' name='changeAccessForm' id="changeAccessForm{{$bill->id}}" action="javascript:void(0)" >
                                                                @csrf
                                                                <div class="col-md-8">
                                                                    <select class="form-control" name='restricted' onchange="changeAccessDone{{ $loop->index }}(this.value)">
                                                                        <option value=1 >Restricted </option>
                                                                        <option value=0>Not restricted</option>
                                                                    </select>
                                                                    <small id='changeAccessHint{{ $loop->index }}'></small>
                                                                    <script>
                                                                        function changeAccessDone{{ $loop->index }}(value){
                                                                            if(value == 1){
                                                                                document.getElementById('changeAccessHint{{ $loop->index }}').innerHTML = '<i class="fas fa-lock"></i> Only people with access can open the bill';
                                                                                document.getElementById('peopleWithAccess{{ $loop->index }}').style.display = 'block';
                                                                            }
                                                                                
                                                                            else {
                                                                                document.getElementById('changeAccessHint{{ $loop->index }}').innerHTML = '<i class="fas fa-lock-open"></i> Anyone with the link can open the bill';
                                                                                document.getElementById('peopleWithAccess{{ $loop->index }}').style.display = 'none';
                                                                            }
                                                                                
                                                                            document.getElementById('changeAccessBtn{{ $bill->id }}').disabled = false;
                                                                        }
                                                                    </script>
                                                                </div>                                                                
                                                                <div class="col-md-4">
                                                                    <button type="submit" id='changeAccessBtn{{ $bill->id }}' class="btn btn-info" disabled> Update </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        
                                                        <div id="peopleWithAccess{{ $loop->index }}">
                                                            <hr>
                                                            <b>People with access</b>
                                                            <div id="peopleWithAccessAppend{{ $loop->index }}"> 
                                                            @if(count($bill->bill_accesses ) > 0 )
                                                                @foreach($bill->bill_accesses as $access)
                                                                    <div class="row" >
                                                                
                                                                        <form class="form" method='post' name='removeAccess' id="deleteAccess{{$access->id}}" action="javascript:void(0)" >
                                                                            @csrf
                                                                            <p class="m-0" id="deletePar-{{$access->id}}">
                                                                                {{$access->email}}
                                                                                <button type="submit" id='deleteSubmit-{{$access->id}}' class="btn btn-link" >
                                                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                                                </button> 
                                                                             </p> 
                                                                        </form> 
                                                                    
                                                                    </div>
                                                                    <script>
                                                                         
                                                                        if ($("#deleteAccess{{$access->id}}").length > 0) {
                                                                            $("#deleteAccess{{$access->id}}").validate({
                                                                                submitHandler: function(form) { 
                                                                                    //$('#submit-{{$access->id}}').html('Please Wait...');
                                                                                    $("#deleteSubmit-{{$access->id}}"). attr("disabled", true);
                                                                                    $.ajax({ 
                                                                                        url: "/removeAccess-{{$access->id}}",
                                                                                        type: "post",
                                                                                        data: $('#deleteAccess{{$access->id}}').serialize(),
                                                                                        success: function( response ) {
                                                                                        //alert('Invoice sent successfully');
                                                                                        //$('#submit-{{$access->id}}').html('Sent!');
                                                                                        $("#deleteSubmit-{{$access->id}}").css('display','none');
                                                                                        $("#deletePar-{{$access->id}}").css('text-decoration-line','line-through') ;
                                                                                         
                                                                                        //document.getElementById("deleteAccess{{$access->id}}").reset(); 
                                                                                        }
                                                                                    });
                                                                                }
                                                                            })
                                                                        }
                                                                    </script>

                                                                @endforeach
                                                             
                                                            @endif
                                                            
                                                            </div>
                                                            <hr>
                                                            <b>Add people to access</b>
                                                            <div class="row">
                                                                <form class="form" method='get' name='addAccessForm{{$bill->id}}' id="addAccessForm{{$bill->id}}" action="javascript:void(0)" >
                                                                    @csrf
                                                                    <div class="col-md-8">
                                                                        <input type="email" name="email" id='email-{{$bill->id}}' class="form-control" required >
                                                                        <small>This bill will be sent to the added people</small>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button type="submit" id='submit-{{$bill->id}}' class="btn btn-success">Add</button> 
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" onclick="navigator.clipboard.writeText(window.location.host + '/access/{{$bill->id }}'); this.innerHTML='Copied'; ">Copy link</button>
                                                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                                                    </div>
                                                    <script>
                                                        var url{{ $loop->index }}= "/shareBill/{{$bill->id}}";
                                                        if ($("#addAccessForm{{$bill->id}}").length > 0) {
                                                            $("#addAccessForm{{$bill->id}}").validate({
                                                                submitHandler: function(form) {
                                                                    
                                                                    $('#submit-{{$bill->id}}').html('Please Wait...');
                                                                    $("#submit-{{$bill->id}}"). attr("disabled", true);
                                                                    $.ajax({ 
                                                                        url: url{{ $loop->index }},
                                                                        type: "GET",
                                                                        data: $('#addAccessForm{{$bill->id}}').serialize(),
                                                                        success: function( response ) {
                                                                        
     
var par = document.createElement("p");  
par.innerHTML = document.getElementById('email-{{$bill->id}}').value
par.classList.add("text-success");
par.classList.add("m-0");
{{--
var divRow = document.createElement("div");
divRow.classList.add("row");
divRow.classList.add("mt-3");

var divCol8 = document.createElement("div");
divCol8.classList.add("col-md-8");
divRow.appendChild(divCol8);

var divCol4 = document.createElement("div");
divCol4.classList.add("col-md-4");
divRow.appendChild(divCol4);

var input = document.createElement("INPUT");
input.classList.add("form-control");
input.disabled = true;
input.value = document.getElementById('email-{{$bill->id}}').value;
divCol8.appendChild(input);

var paragraph = document.createElement("button");
paragraph.classList.add("btn");
paragraph.classList.add("btn-success"); 
paragraph.innerHTML = "Sent!";
divCol4.appendChild(paragraph);

var aRemove = document.createElement("a");
aRemove.classList.add("btn");
aRemove.classList.add("btn-link");
aRemove.innerHTML = '<i class="fas fa-trash-alt text-danger"></i>';
divCol4.appendChild(aRemove);
--}}

document.getElementById("peopleWithAccessAppend{{ $loop->index }}").appendChild(par);

                                                                        $('#submit-{{$bill->id}}').html('Add');
                                                                        $("#submit-{{$bill->id}}"). attr("disabled", false);
                                                                        
                                                                        document.getElementById("addAccessForm{{$bill->id}}").reset(); 
                                                                        }
                                                                    });
                                                                }
                                                            })
                                                        }

                                                        if ($("#changeAccessForm{{$bill->id}}").length > 0) {
                                                            $("#changeAccessForm{{$bill->id}}").validate({
                                                                submitHandler: function(form) {
                                                                    
                                                                    $('#changeAccessBtn{{$bill->id}}').html('Please Wait...');
                                                                    $("#changeAccessBtn{{$bill->id}}").attr("disabled", true);
                                                                    $.ajax({ 
                                                                        url: '/changeAccessForm/{{$bill->id}}',
                                                                        type: "post",
                                                                        data: $('#changeAccessForm{{$bill->id}}').serialize(),
                                                                        success: function( response ) {
                                                                            $('#changeAccessBtn{{$bill->id}}').html('Updated!');
                                                                            $("#changeAccessBtn{{$bill->id}}").attr("disabled", false);
                                                                            //document.getElementById("changeAccessForm{{$bill->id}}").reset(); 
                                                                        }
                                                                    });
                                                                }
                                                            })
                                                        }

                                                    </script>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                          

                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-danger">No bills to show!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                    <div class="row noScrollBar p-3" style='overflow: scroll; display:none;' id='dashboardConten'>
                        <h4>Incoming Statistics:</h4>
                        <div class="row text-center my-2">
                            <div class="col-md-4">
                                <h6>Total Paid: ${{ $totalPaid }} - GST: {{$totalPaidGST}}</h6>
                            </div>
                            <div class="col-md-4">
                                <h6>Total Pending: ${{ $totalPending }} - GST: {{$totalPendingGST}}</h6>
                            </div>
                            <div class="col-md-4"><a class="btn btn-dark @if(Auth::user()->plan_id < 3  ) goGem  @endif"
                                    href="/invoices/exportIn/{{ $business->id }}">Export data</a></div>
                        </div>
                        <h4>Outgoing Statistics:</h4>
                        <div class="row text-center my-2">
                            <div class="col-md-4">
                                <h6>Total Earnings: ${{ $totalEarning }} - GST: {{$totalEarningGST}}</h6>
                            </div>
                            <div class="col-md-4">
                                <h6>Total Pending: ${{ $totalPendingEarn }} - GST: {{$totalPendingEarnGST}}</h6>
                            </div>
                            <div class="col-md-4"><a class="btn btn-dark @if(Auth::user()->plan_id < 3  ) goGem  @endif "
                                    href="/invoices/exportOut/{{ $business->id }}">Export data</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     
    <script>
        function getIncoming() {
            document.getElementById('incomingLink').classList.add("btn-primary");
            document.getElementById('incomingLink').classList.remove("btn-link");
            document.getElementById('outgoingLink').classList.remove("btn-primary");
            document.getElementById('outgoingLink').classList.add("btn-link");
            document.getElementById('dashboardLink').classList.remove("btn-primary");
            document.getElementById('dashboardLink').classList.add("btn-link");

            document.getElementById('incomingConten').style.display = 'block';
            document.getElementById('outgoingConten').style.display = 'none';
            document.getElementById('dashboardConten').style.display = 'none';
        }

        function getOutgoing() {
            document.getElementById('outgoingLink').classList.add("btn-primary");
            document.getElementById('outgoingLink').classList.remove("btn-link");
            document.getElementById('incomingLink').classList.remove("btn-primary");
            document.getElementById('incomingLink').classList.add("btn-link");
            document.getElementById('dashboardLink').classList.remove("btn-primary");
            document.getElementById('dashboardLink').classList.add("btn-link");

            document.getElementById('incomingConten').style.display = 'none';
            document.getElementById('outgoingConten').style.display = 'block';
            document.getElementById('dashboardConten').style.display = 'none';
        }

        function getDashboard() {
            document.getElementById('dashboardLink').classList.add("btn-primary");
            document.getElementById('dashboardLink').classList.remove("btn-link");
            document.getElementById('incomingLink').classList.remove("btn-primary");
            document.getElementById('incomingLink').classList.add("btn-link");
            document.getElementById('outgoingLink').classList.remove("btn-primary");
            document.getElementById('outgoingLink').classList.add("btn-link");

            document.getElementById('incomingConten').style.display = 'none';
            document.getElementById('outgoingConten').style.display = 'none';
            document.getElementById('dashboardConten').style.display = 'block';
            @if ($current_user_business_details->role == App\Enums\UserRole::TEAM_MEMBER )
                document.getElementById('dashboardConten').innerHTML = '<h3 class="text-secondary text-center"> The Dashboard page is not accessible to the team members.</h3>';
            @endif
        }

        //old filter JS
        var filterInvoice = false;
        document.getElementById('filterInvoices').style.display = 'none';

        function showFilterInvoices() {
            if (!filterInvoice) {
                document.getElementById('filterInvoices').style.display = 'flex';
                filterInvoice = true;
            } else {
                document.getElementById('filterInvoices').style.display = 'none';
                filterInvoice = false;
            }
        }
        <?php if( (isset($_GET['startI'])  && $_GET['startI']!='') || (isset($_GET['endI'])  && $_GET['endI']!='')  ) {echo "showFilterInvoices();";} ?>
        var currentUrl = window.location.href.split("?")[0]; 
        
        function setFilterInvoices() {
            window.location.replace( currentUrl 
            
            + "?startI=" + document.getElementById('startingDateI').value + "&endI=" + document.getElementById('endingDateI').value 
            + "&startB=" + document.getElementById('startingDateB').value + "&endB=" + document.getElementById('endingDateB').value
            );
        }

        function clearFilterInvoices() {
            window.location.replace( currentUrl);
        }

        var filterBill = false;
        document.getElementById('filterBills').style.display = 'none';

        function showFilterBills() {
            if (!filterBill) {
                document.getElementById('filterBills').style.display = 'flex';
                filterBill = true;
            } else {
                document.getElementById('filterBills').style.display = 'none';
                filterBill = false;
            }
        } 
        <?php if( (isset($_GET['startB']) && $_GET['startB']!='') || (isset($_GET['endB']) && $_GET['endB']!='') ) {echo "showFilterBills();";} ?>
        function setFilterBills() {
            window.location.replace( currentUrl 
            + "?startI=" + document.getElementById('startingDateI').value + "&endI=" + document.getElementById('endingDateI').value 
            + "&startB=" + document.getElementById('startingDateB').value + "&endB=" + document.getElementById('endingDateB').value
            + "&setO=tr" );
        }
        <?php if( isset($_GET['setO']) && $_GET['setO']=='tr') {echo 'setTimeout(getOutgoing, 1000);';} ?>
        function clearFilterBills() {
            window.location.replace( currentUrl);
        } 
        
        //end old filter
        @if(session()->has('msg')) 
            setTimeout(getOutgoing, 1000);
        @endif
    </script>
    <!-- Leave business modal -->
    <div class="modal fade" id="leave_business_modal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class=" modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave Business</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="output_content3">
                    <form method="POST" id='leave_business_form' action="/businesses/{{ $business->id }}/leave"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                Are you sure you want to leave {{ $business->name }}?
                            </div>
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <a type="submit" class="btn btn-danger text-white"
                        onclick="event.preventDefault();
                                                                                                document.getElementById('leave_business_form').submit();">Confirm</a>

                </div>

            </div>
        </div>
    </div>

           
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
    <script type="text/JavaScript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <style>
        table.dataTable thead .sorting_desc:after {
            content: "⇧";
        }

        table.dataTable thead .sorting_asc:after {
            content: "⇩";
        }

        table.dataTable thead .sorting:after {
            opacity: 0.2;
            content: "⬍";
        }

    </style>
    <script>
        var table = $('#myDataTable').DataTable();
        var table1 = $('#myDataTable1').DataTable();
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                "bLengthChange": false,
                "iDisplayLength": 15,
                "orderCellsTop": true,
                "ordering": true,
            });
            var table1 = $('#myDataTable1').DataTable({
                "bLengthChange": false,
                "iDisplayLength": 15,
                "orderCellsTop": true,
                "ordering": true,
            });

            $(".filterhead").each(function(i) {
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(this).empty())
                    .on('change', function() {
                        var term = $(this).val();
                        table.column(i).search(term, false, false).draw();
                    });
                table.column(i).data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });


        });
        var filteredData = table
            .column(0)
            .data()
            .filter(function(value, index) {
                return value > 20 ? true : false;
            });

        var filteredData = table1
            .column(0)
            .data()
            .filter(function(value, index) {
                return value > 20 ? true : false;
            });

    </script>

<script>
    @if(session()->has('gocha')) 
        document.getElementById("gocha").style.display = "block";
        var image = "{{asset('img/tick.gif')}}";
        document.getElementById("gocha").innerHTML = "<img src="+  image+ " >        <h2>Gocha!</h2>"
        function hideGicha() {
            document.getElementById("gocha").style.display = "none";
        }
        setTimeout("hideGicha()", 3000); 
    @endif
</script>
@endsection

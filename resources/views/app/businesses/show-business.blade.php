@extends('layouts.app')

@section('title', $business->name)


@section('content')
    <style>
        #tableContainer::-webkit-scrollbar {
            display: none;
        }

    </style>

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
                                <span class="bg-primary float-right p-1 px-4 rounded text-white">Active</span>
                            @else
                                <span class="bg-danger float-right p-1 px-4 rounded text-white">Stopped</span>
                            @endif
                            <br><br>
                            @if ($current_user_business_details->role != App\Enums\UserRole::MANAGER)
                                <span class="bg-danger float-right p-1 px-4 rounded text-white" style='cursor: pointer;'
                                    data-toggle="modal" data-target="#leave_business_modal">Leave business</span>
                            @endif
                        </div>
                    </div>
                    <div class="row text-center mt-2">
                        <div class="col-md-4">
                            <h6>Total Paid: ${{ $totalPaid }}</h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Total Pending: ${{ $totalPending }}</h6>
                        </div>
                        <div class="col-md-4"><a class="btn btn-dark "
                                href="/invoices/export/{{ $business->id }}">Export invoices</a></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card px-3 ">
                    <div class="row" style='overflow: scroll;' id='tableContainer'>
                        <table class='table table-striped table-hover table-responsive-sm' id='myDataTable'>
                            <thead>
                                <tr>
                                    <td class="filterhead">#</td>
                                    <td class="filterhead">Title</td>
                                    <td class="filterhead">Amount</td>
                                    <td class="filterhead">Status</td>
                                    <td class="filterhead">Reference #</td>
                                    <td class="filterhead">Added by</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($invoices))
                                    @foreach ($invoices as $invoice)
                                        <tr>
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
                                            <td>{{ $invoice->reference_number }}</td>
                                            <td><img src="{{ asset($invoice->createdBy->profile_picture) }}"
                                                    class="rounded-circle" style='max-width: 30px'>
                                                {{ App\Models\User::findOrFail($invoice->created_by)->first()->name }}
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
                                            <div class=" modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ $invoice->title }} # {{ $invoice->reference_number }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" id="output_content">
                                                        <p><b>Total amount:</b> ${{ $invoice->total }} <small>AUD</small>
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
                                                                src="{{ asset(App\Models\User::findOrFail($invoice->created_by)->first()->profile_picture) }}"
                                                                class="rounded-circle" style='max-width: 30px'>
                                                            {{ App\Models\User::findOrFail($invoice->created_by)->first()->name }}
                                                        </p>
                                                        <p><b>Discount:</b> {{ $invoice->discount }} @if ($invoice->discount_type == App\Enums\DiscountType::PERCENTAGE)
                                                                %
                                                            @else
                                                                $
                                                            @endif
                                                        </p>
                                                        <p><b>Extra amount:</b> ${{ $invoice->extra_amount }}
                                                            <small>AUD</small> </p>
                                                        <p><b>Added on:</b> {{ $invoice->created_at }} </p>
                                                        @if ($invoice->attachments)
                                                            <p><b>Attachments</b></p>
                                                            @foreach ($invoice->attachments as $attach)
                                                                <!--a href="{{-- asset($attach->url) --}}" class='btn btn-info'  download="">Doc-{{ $loop->index + 1 }} </a-->
                                                                {{-- TODO:  design --}}
                                                                <div
                                                                    style='position:relative; display: inline-block; width:200px; height:150px; border:1px solid #ff556e;border-radius: 7px;'>
                                                                    <embed src="{{ asset($attach->url) }}"
                                                                        style='object-fit:cover ; width:100%; height:auto'>
                                                                    <div
                                                                        style="position:absolute; width:100%; bottom:0; background:transparent ;border-radius: 7px;">
                                                                        {{-- Remove name if you want --}}
                                                                        <small>{{ $attach->name }}</small>
                                                                        <a class="btn btn-info "
                                                                            href='{{ asset($attach->url) }}'
                                                                            target="blank"> <small> Open <i
                                                                                    class="fa fa-folder-open"></i>
                                                                            </small></a>
                                                                        <a class="btn btn-info "
                                                                            href='{{ asset($attach->url) }}' download>
                                                                            <small> Download <i
                                                                                    class="fa fa-file-download"></i>
                                                                            </small></a>
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
                <div class="modal-body" id="output_content">
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

        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
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
    </script>

@endsection

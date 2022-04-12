@extends('layouts.app')

@section('title', 'Edit Invoice')


@section('content')
    <div class="container">
        <form class="form" method='post' action="
                            {{ route('invoices.update', ['invoice' => $invoice->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header closed">
                    <h5>Payment Details</h5>
                </div>
                <div class="card-body">
                    @if (count($businesses) > 1)
                        <div class="form-group">
                            <label for="business_id" class="required">Choose Business:</label>
                            <select class="form-control" name="business_id" id="business_id" required>
                                @foreach ($businesses as $business)
                                    <option value="{{ $business->id }}" @if ($business->id == $invoice->business_id) selected @endif>
                                        {{ $business->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="business_id" value="{{ $businesses[0]->id }}">
                    @endif

                    <div class="form-group">
                        <label for="title" class="required">
                            Title:
                        </label>
                        <input type="text" name="title" class="form-control" id="invoice-name" required
                            placeholder="Invoice" value="{{ $invoice->title }}">
                    </div>

                    <div class="form-group">
                        <label for="total" class="required">
                            Total Paid <small>AUD</small>:
                        </label>
                        <input type="number" name="total" class="form-control" id="invoice-amount" min="0" required
                            value="{{ $invoice->total }}">
                    </div>

                    <div class="form-check form-switch">
                        <style>
                            .form-check-input:checked {
                                background-color: #ff556e;
                                border-color: #ff556e;
                            }

                            .form-check-input:focus {
                                border-color: #ff556e90;
                                outline: 0;
                                box-shadow: 0 0 0 0.25rem #ff556e80;
                            }

                        </style>
                        <input name="is_paid" class="form-check-input mx-0 my-1 px-2 position-relative" type="checkbox"
                            @if ($invoice->is_paid) checked @endif id="flexSwitchCheckDefault"
                            onclick='paymentCheckbox()'>
                        <label class="form-check-label px-2" for="flexSwitchCheckDefault">Paid invoice</label>
                    </div>

                    <div class="form-group"
                        style='overflow:hidden; @if ($invoice->is_paid) height:75px @else height:0px @endif'
                        id="payment_date_div">
                        <label for="payment_date">Payment Date:</label>
                        <input type="date" id="payment_date" name="payment_date" class="form-control"
                            value="{{ $invoice->payment_date }}">
                    </div>
                    <div class="form-group">
                        <label for="due_date">Due Date:</label>
                        <input type="date" id="due_date" name="due_date" class="form-control"
                            value="{{ $invoice->due_date }}">
                    </div>

                </div>
            </div>
            <br>

            <div class="card ">
                <div class="card-header advancedClick closed">
                    <h5>Advanced Details <i id='advancedClickI' class="fa fa-arrow-circle-down text-primary"
                            style='transition: all .4s ease 0s;' aria-hidden="true"></i> </h5>
                </div>
                <div class="advancedContent " style='overflow: hidden; height:0px'>
                    <div class="card-body  ">
                        <div class="form-group">
                            <label for="extra_amount">Extra Amounts <small>AUD</small>:</label>
                            <input type="number" name="extra_amount" class="form-control" min="0" id="extra_amount"
                                value="{{ $invoice->extra_amount }}">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="discount">Discount:</label>
                                    <input type="number" name="discount" class="form-control" min="0" id="discount"
                                        value="{{ $invoice->discount }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="discountType">Type:</label>
                                    <select name="discount_type" class="form-control">
                                        <option value="1">Percentage (%)</option>
                                        <option value="2" @if ($invoice->discount_type == 2) selected @endif>Amount ($)
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="barcode">Barcode:</label>
                            <input type="text" name="reference_number" class="form-control" id="invoice-code"
                                placeholder="Enter invoice barcode" value="{{ $invoice->reference_number }}">
                        </div>

                        <div class="form-group">
                            <label for="attachments">Additional Attachments:</label>
                            <input type="file" class="form-control" id="attachments" name="attachments[]"
                                multiple="multiple">

                            @if (count($invoice->attachments) > 0)
                                <br>Old Attachments:<br>
                                @foreach ($invoice->attachments as $attach)
                                <div style='position:relative; display: inline-block; width:200px; height:150px; border:1px solid #ff556e;border-radius: 7px;'>
                                    <embed   src="{{ asset($attach->url) }}" style='object-fit:cover ; width:100%; height:auto'  >
                                    

                                    <div style="position:absolute; width:100%; bottom:0; background:transparent ;border-radius: 7px;"> 
                                        <div class="btn-group" role="group"   
                                            id='doc-{{ $loop->index + 1 }}'>
                                            <a href="{{ asset($attach->url) }}" class='btn btn-info'
                                                target="_blank">Doc-{{ $loop->index + 1 }} <i class="fa fa-external-link-alt"
                                                    aria-hidden="true"></i></a>
                                            <a href="{{ asset($attach->url) }}" class='btn btn-warning text-white'
                                                download=""> <i class="fa fa-file-download" aria-hidden="true"></i></a>
                                            <button type="button" class="btn btn-danger"
                                                onclick="markAttachmentAsDelete('{{ $attach->url }}', 'doc-{{ $loop->index + 1 }}' )">  
                                                <i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                     
                                </div>
                                    {{-- <a href="{{ asset($attach->url) }}" class='btn btn-info'  download="">Doc-{{ $loop->index + 1 }} </a>
                                <embed style='width:250px; height:350px; max-width:100%; max-height:100%' name="plugin" src="{{ asset($attach->url) }}" type="application/pdf"> --}}
                                @endforeach

                            @endif
                            <input type="text" class="form-control" id="attachmentsToDelete" name="attachmentsToDelete">
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes:</label>
                            <textarea name="notes" class="form-control" id="notes" rows="3">{{ $invoice->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="mt-2 btn btn-primary">Submit</button>
            <button onclick="history.back()" class="mt-2 btn btn-secondary">Cancel</button>
        </form>

        <script>
            //document.getElementById("payment_date").value = new Date().toISOString().substring(0, 10);
            const payment_date_div = document.querySelector("#payment_date_div");

            const t1 = new TimelineMax();

            function paymentCheckbox() {
                if (document.getElementById("flexSwitchCheckDefault").checked) {
                    t1.fromTo(payment_date_div, 1, {
                        height: "0"
                    }, {
                        height: "75px",
                        ease: Power2.easeInOut
                    });

                } else {
                    t1.fromTo(payment_date_div, 1, {
                        height: "75"
                    }, {
                        height: "0px",
                        ease: Power2.easeInOut
                    });

                }
            }

            $(".advancedClick").click(function() {
                var $this = $(this),
                    $content = $(".advancedContent"),
                    $advancedClickI = $("#advancedClickI"); //$this.find(".content");
                if (!$this.hasClass("closed")) {
                    TweenLite.to($content, 0.5, {
                        height: 0
                    })
                    $this.addClass("closed")
                    document.getElementById("advancedClickI").style.transform = "rotate(0deg)";
                } else {
                    TweenLite.set($content, {
                        height: "auto"
                    })
                    TweenLite.from($content, 0.5, {
                        height: 0
                    })
                    $this.removeClass("closed");
                    document.getElementById("advancedClickI").style.transform = "rotate(180deg)";
                }
            })
            $(".detailsClick").click(function() {
                var $this = $(this),
                    $content = $(".detailsContent"),
                    $detailsClickI = $("#detailsClickI"); //$this.find(".content");detailsClickI
                if (!$this.hasClass("closed")) {
                    TweenLite.to($content, 0.5, {
                        height: 0
                    })
                    $this.addClass("closed")
                    document.getElementById("detailsClickI").style.transform = "rotate(0deg)";
                } else {
                    TweenLite.set($content, {
                        height: "auto"
                    })
                    TweenLite.from($content, 0.5, {
                        height: 0
                    })
                    $this.removeClass("closed");
                    document.getElementById("detailsClickI").style.transform = "rotate(180deg)";
                }
            })

            var attachmentsToDelete = [];

            function markAttachmentAsDelete(AttachmentUrl, DocNum) {
                attachmentsToDelete.push(AttachmentUrl);
                document.getElementById('attachmentsToDelete').value = attachmentsToDelete;
                //document.getElementById(DocNum).innerHTML = '<small class="text-danger"> This document will be deleted when you submit this edit form. To keep this document press cancel.</small>';
            }
        </script>

    </div>

@endsection

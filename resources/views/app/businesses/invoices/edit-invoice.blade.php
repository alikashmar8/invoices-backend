@extends('layouts.app')

@section('title', 'Edit Invoice')


@section('content')
    <div class="container">
        <form class="form" method='post' action="
                                    {{ route('invoices.update', ['invoice' => $invoice->id]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header closed">
                    <h5>Payment Details</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="business_id" value="{{ $invoice->business_id }}">

                    <div class="form-group">
                        <label for="title" class="required">
                            Title:
                        </label>
                        <input type="text" name="title" class="form-control" id="invoice-name" required
                            placeholder="Invoice" value="{{ $invoice->title }}">
                    </div>

                    
                    <div class="form-group noScrollBar" style=" overflow: scroll;">
                         
                        <label for="title">
                            Table of content (optional):
                        </label>
                        <table class="table w-100" id="contentTable" style="table-layout: fixed;">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>QTY</th> 
                                <th>GST	[A$]</th>
                                <th>Item Price [A$]</th>	
                                <th> <a class="btn  btn-success text-white" style='float: right;'onclick="addItem()"> Add </a> </th>
                            </tr>
                            </thead>
                            <tbody id="contentTable">
                                @if(count($invoice_items)>0)
                                    @foreach($invoice_items as $item)
                                    <tr id="{{$item->id}}" >  
                                        <td> <textarea class="form-control" rows=1 name="invoice_items[{{$item->id}}][description]" required>{{$item->description}}</textarea></td>   
                                        <td>
                                            <input type="number" step="0.01" name="invoice_items[{{$item->id}}][quantity]" class="form-control" value={{$item->quantity}} required> 
                                            
                                            <input type="hidden" name="invoice_items[{{$item->id}}][id]" value={{$item->id}} >
                                        </td>   
                                        <td><input type="number" step="0.01" name="invoice_items[{{$item->id}}][gst]" class="form-control gst" value={{$item->gst}} oninput="calculate()" required>	</td>  
                                        <td><input type="number" step="0.01" name="invoice_items[{{$item->id}}][item_price]" class="form-control item_price" value={{$item->item_price}} oninput="calculate()" required></td>  
                                        <td> <a class="btn btn-danger text-white" style="float: right;" onclick="removeItem({{$item->id}})"> <i class="fa fa-ban"></i> </a> </td>  
                                        
                                    </tr>
                                    @endforeach
                                @endif
                            
                            </tbody>
 
                        </table>
                        <script> 
                            var contentTable = document.getElementById('contentTable');
                            var itemId = {{$maxId}}+1; 
                            function addItem(){
                                itemId++ ; 
                                var row = contentTable.insertRow(-1);
                                row.setAttribute("id", itemId);
                                var cell1 = row.insertCell(0);
                                var cell2 = row.insertCell(1);
                                var cell3 = row.insertCell(2);
                                var cell4 = row.insertCell(3);
                                var cell5 = row.insertCell(4); 
                                cell1.innerHTML = '<textarea class="form-control" rows=1 name="invoice_items[' + itemId + '][description]" required></textarea>';
                                cell2.innerHTML = '<input type="number" name="invoice_items[' + itemId + '][quantity]" class="form-control" value=1 min=0  required> <input type="hidden" name="invoice_items[' + itemId + '][id]" value=' + itemId + ' >';
                                cell3.innerHTML = '<input type="number" step="0.01" name="invoice_items[' + itemId + '][gst]" class="form-control gst" oninput="calculate()" value=0 min=0  required>	';
                                cell4.innerHTML = '<input type="number" step="0.01" name="invoice_items[' + itemId + '][item_price]" class="form-control item_price" oninput="calculate()" value=0 min=0  required>';
                                cell5.innerHTML = '<a class="btn btn-danger text-white" style="float: right;" onclick="removeItem(' + itemId + ')"> <i class="fa fa-ban"></i> </a>'; 
                                 
                               // contentTable.innerHTML +=  '<tr id="' + itemId + '" >  <td> <textarea class="form-control" rows=1 name="invoice_items[' + itemId + '][description]" required></textarea></td>   <td><input type="number" name="invoice_items[' + itemId + '][quantity]" class="form-control" required></td>   <td><input type="number" name="invoice_items[' + itemId + '][gst]" class="form-control gst" oninput="calculate()" required>	</td>  <td><input type="number" name="invoice_items[' + itemId + '][item_price]" class="form-control item_price" oninput="calculate()" required></td>  <td> <a class="btn btn-danger text-white" style="float: right;" onclick="removeItem(' + itemId + ')"> <i class="fa fa-ban"></i> </a> </td> </tr>';
                            
                                calculate();
                            }
                            function removeItem(id){
                                document.getElementById(id).remove(); 
                                
                                calculate();
                            }
                            function calculate(){
                                if(contentTable.rows.length-1  > 0 ){
                                    var item_gst = document.getElementsByClassName("gst");
                                    var item_price = document.getElementsByClassName("item_price");
                                    var total_price =0 ;
                                    var total_gst =0 ;
                                    for (var i = 0; i < item_price.length; i++) {
                                        if(!parseInt(item_price[i].value)) item_price[i].value =0;
                                        if(!parseInt(item_gst[i].value)) item_gst[i].value =0;
                                        total_price += parseFloat(item_price[i].value);
                                        total_gst += parseFloat(item_gst[i].value);
                                    }
                                    document.getElementById('total').value = total_price;
                                    document.getElementById('gst').value = total_gst; 
                                }
                            } 

                        </script>
                    </div>

                    <div class="form-group">
                        <label for="total" class="required">
                            Total Amount <small>AUD</small>:
                        </label>
                        <input type="number" step="0.01" name="total" class="form-control"  oninput="calculate()" id="total" min="0" required
                            value="{{ $invoice->total }}">
                    </div>
                    <div class="form-group">
                        <label for="total" class="required">
                            Total GST <small>AUD</small>:
                        </label>
                        <input type="number" step="0.01" name="gst" value="{{ $invoice->gst }}" oninput="calculate()" class="form-control"
                            id="gst" min="0" required>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="discount">Discount:</label>
                                    <input type="number" step="0.01" name="discount" class="form-control" min="0" id="discount"
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
                                <div class="row mx-5">
                                    @foreach ($invoice->attachments as $attach)
                                        <div class="col-md-3 m-2"
                                            style='position:relative; display: inline-block;  height:150px; border:1px solid #ff556e;border-radius: 7px; padding:1px;'>
                                            <embed src="{{ asset($attach->url) }}"
                                                style='object-fit:cover ; width:100%; height:100%; border-radius: 7px;'>

                                            <div
                                                style="position:absolute; width:100%; bottom:0; background:transparent; border-radius: 0 0 7px 7px;">
                                                <div class="row w-100 m-0" style="
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
                                                <div id='doc-{{ $loop->index + 1 }}' class="row w-100 m-0">
                                                    <a href="{{ asset($attach->url) }}" class='col btn btn-info'
                                                        target="_blank" style="border-radius: 0 0 0 7px">
                                                        {{-- Doc-{{ $loop->index + 1 }} --}}
                                                        <i class="fa fa-external-link-alt" aria-hidden="true"></i></a>
                                                    <a href="{{ asset($attach->url) }}"
                                                        class='col btn btn-warning text-white' download=""
                                                        style="border-radius: 0"> <i class="fa fa-file-download"
                                                            aria-hidden="true"></i></a>
                                                    <button type="button" class="col btn btn-danger"
                                                        style="border-radius: 0 0 7px 0"
                                                        onclick="markAttachmentAsDelete('{{ $attach->url }}', 'doc-{{ $loop->index + 1 }}' )">
                                                        <i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <a href="{{ asset($attach->url) }}" class='btn btn-info'  download="">Doc-{{ $loop->index + 1 }} </a>
                                <embed style='width:250px; height:350px; max-width:100%; max-height:100%' name="plugin" src="{{ asset($attach->url) }}" type="application/pdf"> --}}
                                    @endforeach
                                </div>

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

            <button type="submit" class="mt-2 btn btn-primary">Edit</button> 
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

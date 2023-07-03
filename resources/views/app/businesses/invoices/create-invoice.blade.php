@extends('layouts.app')

@section('title', 'Create Invoice')


@section('content')
    <div class="container">
        <form class="form" method='post' action="{{ route('invoices.store') }}" enctype="multipart/form-data">
            @csrf

            <!--div class="card ">
                                                    <div class="card-header detailsClick">
                                                        <h5>Details <i id='detailsClickI' class="fa fa-arrow-circle-down text-primary"
                                                                style='transition: all .4s ease 0s;' aria-hidden="true"></i> </h5>
                                                    </div>
                                                    <div class="detailsContent " style='overflow: hidden; height:0px'>
                                                        <div class="card-body">


                                                        </div>
                                                    </div>
                                                </div-->

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
                                    <option value="{{ $business->id }}"
                                        @if (old('business_id')) @if (old('business_id') == $business->id)
                                                selected @endif
                                    @elseif($business->pivot->is_favorite) selected @endif>
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
                        <input type="text" name="title" max:255 value="{{ old('title') }}" class="form-control"
                            id="invoice-name" required placeholder="Invoice">
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

                            </tbody>
 
                        </table>
                        <script> 
                            var contentTable = document.getElementById('contentTable');
                            var itemId = 0 ;
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
                                cell2.innerHTML = '<input type="number"  name="invoice_items[' + itemId + '][quantity]" class="form-control" value=1 min=0  required>';
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
                        <input type="number" name="total" step="0.01" value="{{ old('total') }}"  oninput="calculate()" class="form-control"
                            id="total" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="total" class="required">
                            Total GST <small>AUD</small>:
                        </label>
                        <input type="number" step="0.01" name="gst" value="{{ old('gst') }}"  oninput="calculate()" class="form-control"
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
                            checked id="flexSwitchCheckDefault" onclick='paymentCheckbox()'>
                        <label class="form-check-label px-2" for="flexSwitchCheckDefault">Paid invoice</label>
                    </div>

                    <div class="form-group" style='overflow:hidden;height:75px' id="payment_date_div">
                        <label for="payment_date">Payment Date:</label>
                        <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date') }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="due_date">Due Date:</label>
                        <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}"
                            class="form-control">
                    </div>

                </div>
            </div>
            <br>

            <div class="card ">
                <div class="card-header advancedClick closed">
                    <h5>Advanced Details <small>(Optional)</small> <i id='advancedClickI' class="fa fa-arrow-circle-down text-primary"
                            style='transition: all .4s ease 0s;' aria-hidden="true"></i> </h5>
                </div>
                <div class="advancedContent " style='overflow: hidden; height:0px'>
                    <div class="card-body  ">
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="discount">Discount:</label>
                                    <input type="number" step="0.01" name="discount" value="{{ old('discount', 0) }}"
                                        class="form-control" value="0" min="0" id="discount">
                                </div>
                                <div class="col-md-6">
                                    <label for="discountType">Type:</label>
                                    <select name="discount_type" class="form-control">
                                        <option value="{{ App\Enums\DiscountType::PERCENTAGE }}" @if (old('discount_type') == App\Enums\DiscountType::PERCENTAGE) selected @endif>
                                            Percentage (%)
                                        </option>
                                        <option value="{{ App\Enums\DiscountType::AMOUNT }}" @if (old('discount_type') == "{{ App\Enums\DiscountType::AMOUNT }}") selected @endif>
                                            Amount ($)
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="barcode">Barcode:</label>
                            <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                                class="form-control" id="invoice-code" placeholder="Enter invoice barcode">
                        </div>

                        <div class="form-group">
                            <label for="attachments">Additional Attachments:</label>
                            <input type="file" class="form-control" id="attachments" name="attachments[]"
                                multiple="multiple">
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes:</label>
                            <textarea name="notes" value="{{ old('notes') }}" class="form-control" id="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="mt-2 btn btn-primary">Submit</button>
        </form>

        <script>
            document.getElementById("payment_date").value = new Date().toISOString().substring(0, 10);
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
        </script>

    </div>

@endsection

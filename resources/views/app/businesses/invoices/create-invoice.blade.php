@extends('layouts.app')

@section('title', 'Create Invoices')


@section('content')
<div class="container">
    <form class="form" method='post' action="/createInvoiceForm" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title"><h5>Title</h5></label>
            <input type="text" name="title" class="form-control" id="invoice-name" required placeholder="Invoice">
        </div>

        
        <div class="form-group">
            <label for="total"><h5>Ammount</h5></label>
            <input type="number" name="total" class="form-control" id="invoice-amount" min="0" required placeholder="$500">
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Payment Date</h5>
            </div>
            <div class="card-body"> 
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
                    <input name="is_paid" class="form-check-input mx-0 my-1 px-2 position-relative" type="checkbox" checked id="flexSwitchCheckDefault" onclick='paymentCheckbox()' >
                    <label class="form-check-label px-2" for="flexSwitchCheckDefault">Paid invoice</label>
                </div> 
                
                <div class="form-group" style='overflow:hidden;height:75px' id="payment_date_div">
                    <label for="payment_date">Payment Date</label>
                    <input type="date" id="payment_date" name="payment_date" class="form-control"  >
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date <small><b>(Optional)</b></small></label>
                    <input type="date" id="due_date" name="due_date" class="form-control"  >
                </div>
             
            </div>
        </div>
        <br>
        <div class="card ">
            <div class="card-header advancedClick closed">
                <h5>Advanced <i id='advancedClickI' class="fa fa-arrow-circle-down text-primary" style='transition: all .4s ease 0s;' aria-hidden="true"></i> </h5>
            </div>
            <div class="advancedContent " style='overflow: hidden; height:0px'>
                <div class="card-body  " > 
                    <div class="form-group">
                        <label for="attachments">Additional Attachments:</label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple="multiple" >
                    </div>
            
                    <div class="form-group">
                        <label for="barcode">Barcode:</label>
                        <input type="text" name="reference_number" class="form-control" id="invoice-code" placeholder="Enter invoice barcode">
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea name="notes" class="form-control" id="notes" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        <div class="card ">
            <div class="card-header detailsClick closed">
                <h5>Details <i id='detailsClickI' class="fa fa-arrow-circle-down text-primary" style='transition: all .4s ease 0s;' aria-hidden="true"></i> </h5>
            </div>
            
            <div class="detailsContent " style='overflow: hidden; height:0px'>
                <div class="card-body"> 
                    <div class="form-group">
                        <label for="invoice-items">Items</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" id="invoice-item-name" placeholder="Item name"></td>
                                    <td><input type="number" class="form-control" id="invoice-item-quantity" placeholder="Item quantity"></td>
                                    <td><input type="number" class="form-control" id="invoice-item-price" placeholder="Item price"></td>
                                    <td><input type="number" class="form-control" id="invoice-item-total" placeholder="Item total" disabled></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            
                    
            
                    <div class="form-group">
                        <label for="discount">Discount:</label>
                        <input type="number" name="discount" class="form-control" min="0" id="discount">
                    </div>
            
                    <div class="form-group">
                        <label for="extra_amount">Extra Amounts:</label>
                        <input type="number" name="extra_amount" class="form-control" min="0" id="extra_amount">
                    </div>
                </div>
            </div>
        </div>
         

        <input type="hidden" name='business_id' value="{{$business->id}}">
        <button type="submit" class="mt-2 btn btn-primary">Submit</button>
    </form>

<script>
    
    document.getElementById("payment_date").value = new Date().toISOString().substring(0, 10);
    const payment_date_div = document.querySelector("#payment_date_div"); 
    
    const t1 = new TimelineMax(); 
    function paymentCheckbox(){
        if(document.getElementById("flexSwitchCheckDefault").checked){
            t1.fromTo(payment_date_div , 1, {height: "0" }, {height: "75px" , ease: Power2.easeInOut});
             
        }else{
            t1.fromTo(payment_date_div , 1, {height: "75" }, {height: "0px" , ease: Power2.easeInOut});
             
        }
    }
    
    $(".advancedClick").click(function(){
        var $this = $(this),
            $content = $(".advancedContent"),
            $advancedClickI = $("#advancedClickI");//$this.find(".content");
        if(!$this.hasClass("closed")){
            TweenLite.to($content, 0.5, {height:0})
            $this.addClass("closed") 
            document.getElementById("advancedClickI").style.transform = "rotate(0deg)";
        }else{
            TweenLite.set($content, {height:"auto"})
            TweenLite.from($content, 0.5, {height:0})
            $this.removeClass("closed"); 
            document.getElementById("advancedClickI").style.transform = "rotate(180deg)";
        }
    })
    $(".detailsClick").click(function(){
        var $this = $(this),
            $content = $(".detailsContent"),
            $detailsClickI = $("#detailsClickI");//$this.find(".content");detailsClickI
        if(!$this.hasClass("closed")){
            TweenLite.to($content, 0.5, {height:0})
            $this.addClass("closed")
            document.getElementById("detailsClickI").style.transform = "rotate(0deg)";
        }else{
            TweenLite.set($content, {height:"auto"})
            TweenLite.from($content, 0.5, {height:0})
            $this.removeClass("closed");
            document.getElementById("detailsClickI").style.transform = "rotate(180deg)";
        }
    })
</script> 

</div>

@endsection

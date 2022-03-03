@extends('layouts.app')

@section('title', 'Create Invoices')


@section('content')
<div class="container">
    <form class="form">
        <div class="form-group">
            <label for="barcode">Barcode:</label>
            <input type="text" name="barcode" class="form-control" id="invoice-name" placeholder="Enter invoice barcode">
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" class="form-control" id="due_date">
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control" id="notes" rows="3"></textarea>
        </div>
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
            <label for="attachments">Additional Attachments:</label>
            <input type="file" class="form-control" id="attachments" name="attachments[]" multiple="multiple" >
        </div>

        <div class="form-group">
            <label for="is_paid">Is Paid?</label>
            <input type="checkbox" class="" name="is_paid" value="true">
        </div>


        <div class="form-group">
            <label for="discount">Discount:</label>
            <input type="number" name="discount" class="form-control" id="discount">
        </div>

        <div class="form-group">
            <label for="extra_amount">Extra Amounts:</label>
            <input type="number" name="extra_amount" class="form-control" id="extra_amount">
        </div>

        <div class="form-group">
            <label for="total">Total:</label>
            <input type="number" name="total" class="form-control" id="invoice-amount" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>

@endsection

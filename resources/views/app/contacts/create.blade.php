@extends('layouts.app')

@section('title', 'Create Contact')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Contact</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name" class="required">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address">
                            </div>
                            <div class="form-group">
                                <label for="abn">ABN:</label>
                                <input type="text" class="form-control" id="company" name="abn" placeholder="Enter abn">
                            </div>
                            <div class="form-group">
                                <label for="business_id" class="required">Business:</label>
                                <select class="form-control" id="business_id" name="business_id">
                                    @foreach ($businesses as $business)
                                        <option value="{{ $business->id }}">{{ $business->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="notes">Notes:</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

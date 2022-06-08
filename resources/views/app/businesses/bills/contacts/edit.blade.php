@extends('layouts.app')

@section('title', 'Edit Contact')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Contact</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('contacts.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name" class="required">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{$contact->name}}" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email"  value="{{$contact->email}}" name="email"
                                    placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" id="phone" name="phone"  value="{{$contact->phone_number}}" placeholder="Enter Phone">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address"  value="{{$contact->address}}"
                                    placeholder="Enter Address">
                            </div>
                            <div class="form-group">
                                <label for="abn">ABN:</label>
                                <input type="text" class="form-control" id="company" name="abn"  value="{{$contact->abn}}" placeholder="Enter abn">
                            </div> 
                            <div class="form-group">
                                <label for="notes">Notes:</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{$contact->notes}}</textarea>
                            </div>
                            <input type="hidden" name='id' value="{{$contact->id}}">
                            <button type="submit" class="btn btn-primary">Edit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

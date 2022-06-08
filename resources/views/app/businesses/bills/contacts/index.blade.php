@extends('layouts.app')

@section('title', 'Contacts')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row"> 
                            <div class="col-md-9">
                            <h4 class="card-title">Contacts</h4>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary btn-sm btn-block text-white " type="button"   href="/contacts/create/{{$business->id}}" >Add a new member</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if (count($contacts))
                                <table class="table">
                                    <thead class=" text-primary">
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> Phone </th>
                                        <th> Address </th>
                                        <th> ABN </th> 
                                        <th> Notes </th>
                                        <th> Actions </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr>
                                                <td> {{ $contact->name }} </td>
                                                <td> {{ $contact->email }} </td>
                                                <td> {{ $contact->phone_number }} </td>
                                                <td> {{ $contact->address }} </td>
                                                <td> {{ $contact->abn }} </td> 
                                                <td> {{ $contact->notes }} </td>

                                                <td>
                                                    <a type="button" class="btn col-md-2 p-0 mx-1" href="/contacts/edit/{{$contact->id}}"> 
                                                        <i class="fa fa-edit text-primary"></i> 
                                                    </a>
                                                    {{--<form action="{{ route('contacts.destroy', $contact->id) }}"
                                                        method="POST" style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No contacts found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

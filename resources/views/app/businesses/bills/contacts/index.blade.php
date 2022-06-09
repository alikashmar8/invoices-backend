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
                        <div class="row"> 
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="myInput" onkeyup="filter()" placeholder="Search for names.." title="Type in a name">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if (count($contacts))
                                <table class="table" id="myTable">
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

    
<script>
    function filter() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
    </script>

@endsection

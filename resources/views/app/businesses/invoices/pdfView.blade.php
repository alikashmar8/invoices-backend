<!DOCTYPE html>
<html>
<head>
    <title>{{$id}}</title>
    <style>
.row {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}
.col-md-4 {
  position: relative;
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  -ms-flex: 0 0 33.333333%;
  flex: 0 0 33.333333%;
  max-width: 33.333333%;
}
    </style>
</head>
<body>
    
    <div class="row" style="display: flex;">
        <div class="col-md-4">
            <img src="{{$businessLogo}}" style="max-width: 100px"><br>
            <p> {{$businessName}}</p>
            <p> {{$businessABN}}</p>
        </div>
        
        <div class="col-md-4">
            @if($is_paid) <h1 >PAID</h1>
            @else <h1> PENDING </h1>
            @endif
        </div>
        <div class="col-md-4"> 
            <p>Date: {{ $updated_at }}</p>
            <p>Due date: {{$due_date}} </p>
            <p>@if($payment_date) Paid at: {{$payment_date}} @endif </p>
        </div>
    </div> 
    
    <div class="row">
        Bill To: <hr>
        <div class="col-md-4">   
            <p>Name: {{$clientName}}</p>
            <p>Email: {{$clientEmail}}</p>
            <p>ABN: {{$clientABN}} </p>
        </div> 
        <div class="col-md-4"> 
            <p>Phone: {{ $clientPhone }}</p>
            <p>Address: {{$clientAddess}} </p>
        </div>
    </div> 
    <p>{{ $total }} {{$currency}}</p>  
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <p>{{ $notes }}</p>
</body>
</html>
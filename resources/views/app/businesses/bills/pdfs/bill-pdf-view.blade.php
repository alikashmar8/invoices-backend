<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>{{$id}}</title>
        <link rel="icon" href="{{ asset('images/favicon.png') }}">
 

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 20px;
                padding-top: 0px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2), .invoice-box table tr td:nth-child(3) ,.invoice-box table tr td:nth-child(4) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2), .invoice-box table tr.total td:nth-child(3), .invoice-box table tr.total td:nth-child(4) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}
            
            .stamp{ 
                font-size: 25px; 
                text-align: center;
                color: #ff556e ;    
            }

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
		 
		<div class="invoice-box">
            
			<table>
                <tr>
                    <td colspan="4">
                        <p class="stamp"><b> @if($is_paid) Paid @else Pending @endif </b></p>
                    </td>
                </tr>
				<tr class="top">
					<td colspan="4">
						<table>
                            

							<tr>
								<td class="title">
									<img src="{{$businessLogo}}"   style=" object-fit: contain ; max-width: 100px" />
								</td>

								<td>
									<b>Invoice #</b> {{$id}}<br />
									Created: {{$created_at}}<br />
                                    @if($payment_date) Paid at: {{$payment_date}} <br /> @endif
									@if($due_date) Due: {{$due_date}} @endif
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4"> 
						<table>
							<tr>
								<td>
                                    <b>Bill To:</b> <br />
									{{$clientName}}<br />
									@if($clientABN) ABN: {{$clientABN}} <br /> @endif 
									@if($clientEmail) Email: {{$clientEmail}} <br /> @endif 
									@if($clientPhone) Phone: {{$clientPhone}} <br /> @endif 
									@if($clientAddress) Address: {{$clientAddress}}   @endif   
								</td>

								<td>
                                    <b>From</b>
									@if($businessName) {{$businessName}}  <br /> @endif  
									@if($businessABN) ABN: {{$businessABN}} <br />  @endif  
									@if($businessAddress) Address: {{$businessAddress}}   @endif   
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				@if(count($bill_items) >0)
				<tr>
					<td colspan="4">
						{{$title}}
					</td>
				</tr>
				@endif
				<tr class="heading">
					<td>Description</td>

					<td>@if(count($bill_items) >0) QTY @endif</td>
					<td>GST</td>
					<td>Price</td>
				</tr>

				@if(count($bill_items) >0)
					@foreach( $bill_items as $item)
						<tr class="details">
							<td>{{$item->description}}</td>

							<td>{{$item->quantity}}</td>
							<td>{{$item->gst}}</td>
							<td>{{$item->item_price}}</td>
						</tr>
					@endforeach
				@endif
                 

				<!--tr class="heading">
					<td>Item</td>

					<td>Price</td>
				</tr>

				<tr class="item">
					<td>Website design</td>

					<td>$300.00</td>
				</tr>

				<tr class="item">
					<td>Hosting (3 months)</td>

					<td>$75.00</td>
				</tr>

				<tr class="item last">
					<td>Domain name (1 year)</td>

					<td>$10.00</td>
				</tr-->
				<tr class="total">
					<td>@if(count($bill_items) >0) Sub total @else {{$title}} @endif</td>
					<td> </td>
					<td>{{$GST}}</td>
					<td>{{$total}}</td>
					
				</tr>
				<tr class="total">
					<td></td>
                    <td></td>
                    <td></td>
					<td >Total: ${{$amount}}</td>
				</tr> 
                <tr>
                    <td  colspan="2">
                        <p > <b><i>Payment Method:</i></b></p>
                        <p style="white-space: pre"> {{$payment_method}}</p>
                    </td>
                    <td colspan="2" style="text-align: left">
                        <p> <b><i>Notes:</i></b></p>
                        <p style="white-space: pre">{{$notes}}</p>
                    </td>
                </tr>
			</table>
			<div>
				
				<img src="{{ $QR }}" style="width: 120px"> 
			</div>
		</div> 
        <img src="{{ $mainLogo }}" style="object-fit: contain ;max-width: 220px">  
        
	</body>
</html>




{{--<!DOCTYPE html>
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
            <p>Address: {{$clientAddress}} </p>
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
--}}
<h2>Hello,</h2>  
<p>{{ $data['sender'] }} from {{ $data['business'] }} is sharing with you an invoice #{{ $data['billId'] }}.</p>
 
<p> You can access the invoice through scanning the QR code below or by clicking this <a href="/access/{{$data['billId']}}"> link.</a>   </p>
<br>
<img src="{{ $data['billQR'] }}" style="max-width: 200px">
<br>  

Thank you for choosing Invoice Gem.
 
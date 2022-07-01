<h2>Hello,</h2>  
<p>{{ $data['sender'] }} from {{ $data['business'] }} is sharing with you an invoice #{{ $data['billId'] }}.</p>
 
<p> You can access the invoice through scanning the QR code below or by clicking this <a href="{{$data['billURL']}}"> link.</a>   </p>
<br>
<img src="{{ $data['billQR'] }}" style="max-width: 250px">
<br>
{{ $data['billQR'] }}
<br>

Thank you for choosing Invoice Gem.
 
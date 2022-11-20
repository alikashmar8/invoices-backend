<h2>Hello friend,</h2>  
<p>{{ $data['sender'] }} from {{ $data['business'] }} is sharing with you an invoice #{{ $data['billId'] }}.</p>
 
<p> You can access the invoice through scanning the QR code below or by clicking this <a href="/access/{{$data['billId']}}"> link.</a>   </p>
<br>
<img src="{{ $data['billQR'] }}" style="max-width: 200px">
<br>  

Thank you for choosing Invoice Gem.
<br>
<p ><small >© 2022 Invoice Gem all rights reserved. Developed by <a href="https://webside.com.au/" target="_blank" style="color: #2740c7">WebSide.com.au</a> </small></p>
 
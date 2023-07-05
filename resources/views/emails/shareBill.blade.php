<h2>Hello friend,</h2>  
<p>{{ $data['sender'] }} from {{ $data['business'] }} is sharing with you an invoice #{{ $data['billId'] }}.</p>
 
<p> You can access the invoice through scanning the QR code below or by clicking this <a style="color: #ff556e" href="{{route('w').'/access/'.$data['billId']}}"> link.</a>   </p>
<br>
<img src="{{ $data['billQR'] }}" style="width:100%; max-width: 200px;">
<br>  

<p>
Thank you for choosing Invoice Gem.
</p>
<img src="{{asset('/images/logoSmall.png')}}" style="max-width: 150px">
<hr>
<p >
    <small><i> If you received this email by mistake please disregard it </i></small>
    <br>
    <small >© 2023 Invoice Gem all rights reserved. Sponsered and developed by <a href="https://webside.com.au/" target="_blank" style="color: #ff556e">WebSide.com.au</a> </small>
</p>
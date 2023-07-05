<h2>Dear {{ $data['name'] }},</h2> 
<p>
Thank you for your recent purchase on Invoice Gem,
</p>


<p>
    This is a confirmation email that your last payment was received successfully. 
</p>
@component('mail::panel')
    {{ $data['plan'] }} Plan (monthly subscription): ${{ $data['price'] }}AUD
@endcomponent  
<br>

<p>
    If you have any questions or need further assistance regarding your purchase, please don't hesitate to contact our <a style="color: #ff556e; " href="{{route('support')}}">customer support team</a>.
<br>
Thank you for choosing Invoice Gem. We strive to provide you with the best services.
</p>

<img src="{{asset('/images/logoSmall.png')}}" style="max-width: 150px">
<hr>
<p >
    <small><i> If you received this email by mistake please disregard it </i></small>
    <br>
    <small >© 2023 Invoice Gem all rights reserved. Sponsered and developed by <a href="https://webside.com.au/" target="_blank" style="color: #ff556e">WebSide.com.au</a> </small>
</p>
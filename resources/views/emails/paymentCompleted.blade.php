<h2>Hello {{ $data['name'] }},</h2> 

<p>
    This is a confirmation email that your last payment was received successfully. 
</p>
@component('mail::panel')
    {{ $data['plan'] }} Plan (monthly subscription): ${{ $data['price'] }}AUD
@endcomponent  
<br>

Thank you for choosing Invoice Gem.
<br>
<p ><small >© 2022 Invoice Gem all rights reserved. Developed by <a href="https://webside.com.au/" target="_blank" style="color: #2740c7">WebSide.com.au</a> </small></p>
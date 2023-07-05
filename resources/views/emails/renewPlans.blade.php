<h3>G'day {{ $user->name }},</h3> 

<p>We want to inform you that your plan will be expired on {{ $user->plan_end_date }}.  Please ensure to renew it before the due date and enjoy our services.</p>
<p>Please note that if you didn't complete this payment before its due date you might lose some access to your business(es) profiles and/or their related data. </p>

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
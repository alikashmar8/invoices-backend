<h3>Dear {{ $data['name'] }},</h3> 

<p> 

We hope this email finds you well. We would like to inform you that you have received {{ $data['number'] }}  new notification(s).
</p>
<p>
Please <a style="color: #ff556e; " href="{{route('login')}}">log in</a> to your account to view the full details of the notification. We recommend checking your account regularly to stay up-to-date with important updates and activities.
</p>

<p>
If you have any questions or need further assistance, please don't hesitate to contact us on our <a style="color: #ff556e; " href="{{route('support')}}">support page</a>.
<br> 
    Thank you for being a valued member of our community! 
</p>

<img src="{{asset('/images/logoSmall.png')}}" style="max-width: 150px">
<hr>
<p >
    <small><i> If you received this email by mistake please disregard it </i></small>
    <br>
    <small >© 2023 Invoice Gem all rights reserved. Sponsered and developed by <a href="https://webside.com.au/" target="_blank" style="color: #ff556e">WebSide.com.au</a> </small>
</p>
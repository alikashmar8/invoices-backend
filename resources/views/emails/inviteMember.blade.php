<h3>Hello {{ $data['name'] }},</h3> 

<p>
    We are thrilled to inform you that {{ $data['sender'] }} is inviting you to join {{ $data['business'] }} team as {{ $data['role'] }}.
</p>

<p>
    At Invoice Gem, we offer an advanced platform designed for invoices management on the go. Whether you're a passionate business owner or simply looking to organize your heap documents and payments, our platform has something special for everyone.
</p>
<p style="color: #ff556e; ">
    <b>To get started, follow these simple steps:</b>
</p>
<ol>
    <li>Visit our <a style="color: #ff556e; " href="{{route('register')}}">Registeration</a> page.</li>
    <li>Fill in the required information, such as your name, email address, and password.</li>
    <li>Customize your profile to make it uniquely yours.</li>
    <li>Inform {{ $data['business'] }} that you've joined Invoice Gem, and to add you to the team.</li>
    <li>Explore our various features and facilitated management system.</li>
</ol>

<p>
    For any further enquiries please contact us anytime at the <a style="color: #ff556e; " href="{{route('support')}}">support page</a>.<br>
Thank you for choosing Invoice Gem.
</p>

<img src="{{asset('/images/logoSmall.png')}}" style="max-width: 150px">
<hr>
<p >
    <small><i> If you received this email by mistake please disregard it </i></small>
    <br>
    <small >© 2023 Invoice Gem all rights reserved. Sponsered and developed by <a href="https://webside.com.au/" target="_blank" style="color: #ff556e">WebSide.com.au</a> </small>
</p>
 
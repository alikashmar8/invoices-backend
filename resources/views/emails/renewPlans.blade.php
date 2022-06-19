<h2>G'day {{ $user->name }},</h2> 
<br>
<p>We would like inform you that your plan will be expired @if($user->expire == 0 ) today. @elseif($user->expire == 1 ) tomorrow. @else in {{$user->expire}} days. @endif Please ensure to renew it before the due date and enjoy our services.</p>
    
Thank you
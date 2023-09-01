@extends('layouts.app')

@section('title', 'Pricing Plans')


@section('content')
<style>@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');</style>
<div class="py-5 header bg-white " style=" border-bottom: 3px solid #eee;">
    <div class="container"  >
        <div class="deco-blue-circle">
            <img src="images/decorative-blue-circle.svg" alt="alternative">
        </div>
        <div class="deco-green-diamond">
            <img src="images/decorative-green-diamond.svg" alt="alternative">
        </div>
        <div class="row">
            <div class="col-md-8">
    <h1>
        Supercharge your business. <font style="color: #ff556e; font-weight: initial"><BR>Start free.</font>
    </h1>

            </div>
            <div class="col-md-4">
<img src="images/pricingBanner1.jpg"  style="width: 100% ; position; absolute;">

            </div>
        </div>
    </div>
</div>
<div class="container mt-5 pt-5 ">
    <p style="font-size: x-large;">Get the best value at every stage of your invoice management journey.</p>
    <BR>
    <div class="row  my-2 noScrollBar" style='overflow: scroll;'> 
        <table class="table-striped table-hover ">
            <colgroup>
            <col width="23.1%">
            <col width="25.1%">
            <col width="26.6%">
            <col width="25.2%">
            </colgroup>
            <thead  >
            <tr>
                <th ></th>
                <th class="BasicBack p-4 text-center text-white">
                    <h3>Basic</h3>  Perfect for starting up businesses 
                </th>
                <th class="GoldBack  p-4 text-center text-white">
                    <h3>Gold</h3> Perfect for medium businesses 
                </th>
                <th class="GemBack p-4 text-center text-white">
                    <h3>Gem</h3> Perfect for large businesses 
                </th>
            </tr>
            </thead>
            <tbody class=" text-center ">
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">24/7 Access</td>
                <td> <svg width="20px" viewBox="0 0 468.293 468.293"><circle style="fill:#ff556e;" cx="234.146" cy="234.146" r="234.146"></circle><polygon style="fill:#fff;" points="357.52,110.145 191.995,275.67 110.773,194.451 69.534,235.684 191.995,358.148   398.759,151.378 "></polygon></svg> </td> 
                <td> <svg width="20px" viewBox="0 0 468.293 468.293"><circle style="fill:#ff556e;" cx="234.146" cy="234.146" r="234.146"></circle><polygon style="fill:#fff;" points="357.52,110.145 191.995,275.67 110.773,194.451 69.534,235.684 191.995,358.148   398.759,151.378 "></polygon></svg> </td> 
                <td> <svg width="20px" viewBox="0 0 468.293 468.293"><circle style="fill:#ff556e;" cx="234.146" cy="234.146" r="234.146"></circle><polygon style="fill:#fff;" points="357.52,110.145 191.995,275.67 110.773,194.451 69.534,235.684 191.995,358.148   398.759,151.378 "></polygon></svg> </td> 
            </tr> 
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Customer Support</td>
                <td> <svg width="20px" viewBox="0 0 468.293 468.293"><circle style="fill:#ff556e;" cx="234.146" cy="234.146" r="234.146"></circle><polygon style="fill:#fff;" points="357.52,110.145 191.995,275.67 110.773,194.451 69.534,235.684 191.995,358.148   398.759,151.378 "></polygon></svg> </td> 
                <td> <svg width="20px" viewBox="0 0 468.293 468.293"><circle style="fill:#ff556e;" cx="234.146" cy="234.146" r="234.146"></circle><polygon style="fill:#fff;" points="357.52,110.145 191.995,275.67 110.773,194.451 69.534,235.684 191.995,358.148   398.759,151.378 "></polygon></svg> </td> 
                <td> <svg width="20px" viewBox="0 0 468.293 468.293"><circle style="fill:#ff556e;" cx="234.146" cy="234.146" r="234.146"></circle><polygon style="fill:#fff;" points="357.52,110.145 191.995,275.67 110.773,194.451 69.534,235.684 191.995,358.148   398.759,151.378 "></polygon></svg> </td> 
            </tr> 
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Business profiles</td>
                <td>One</td>
                <td>One</td>
                <td>Unlimited</td>
            </tr>
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Upload Documents</td>
                <td >50</td>
                <td >500</td>
                <td >Unlimited</td>
            </tr>
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Team members</td>
                <td >1</td>
                <td >10</td>
                <td >Unlimited</td>
            </tr> 
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Monthly price</td>
                <td class="text-primary p-3 font-weight-bold"><h3 style="font-family: 'Bebas Neue', cursive;">Free</h3></td>
                <td class="text-primary p-3 font-weight-bold"><h3 style="font-family: 'Bebas Neue', cursive;">$ 59.00 <small> AUD </small></h3></td>
                <td class="text-primary p-3 font-weight-bold"><h3 style="font-family: 'Bebas Neue', cursive;">$ 99.00 <small> AUD </small></h3></td>
            </tr>
            <tr  > 
                
                @guest
                <td   colspan="4">
                    <a href="/register" class="btn btn-link  " style="font-size: 1.2rem;
                    line-height: 3.875rem;">  Create your new account now!  </a>  
                 
                    
                </td>
                @else

                <td ></td>
                <td class="p-1">
                    <a class="Dis-btn-outline" disabled>Registered</a>
                </td>
                <td >
                    @if(Auth::user()->plan_id >= 2 )
                        <a class="Dis-btn-outline" disable>Registered</a>
                        @else
                        <a href="/plan-2" class=" Gold-btn-outline "> Register </a>
                    @endif
                </td>
                <td>
                    @if(Auth::user()->plan_id == 3 )
                        <a class="Dis-btn-outline" disabled>Registered</a>
                        @else
                        
                        <a href="/plan-3" class="Gem-btn-outline">Register</a>
                    @endif
                </td>
                @endguest
            </tr>
            <br>
            </tbody>
        </table>
    </div>
</div>
@endsection
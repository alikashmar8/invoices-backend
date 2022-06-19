@extends('layouts.app')

@section('title', 'Pricing Plans')


@section('content')
<style>@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');</style>

<div class="container ">
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
                <td class="text-primary p-3 font-weight-bold">Businesses profiles</td>
                <td>One</td>
                <td>One</td>
                <td>Unlimited</td>
            </tr>
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Uplaod Documents</td>
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
                <td ></td>
                <td class="p-1">
                    <a class="Dis-btn-outline" disabled>Default</a>
                </td>
                <td >
                    @guest
                        <a href="/plan-2" class="Gold-btn-outline"> Register </a>
                    @else
                        @if(Auth::user()->plan_id >= 2 )
                        <a class="Dis-btn-outline" disable>Registered</a>
                        @else
                        <a href="/plan-2" class=" Gold-btn-outline "> Register </a>
                        @endif
                    @endguest
                </td>
                <td>
                    @guest
                        <a href="/plan-3" class="Gem-btn-outline">Register</a>
                    @else
                        @if(Auth::user()->plan_id == 3 )
                        <a class="Dis-btn-outline" disabled>Registered</a>
                        @else
                        
                        <a href="/plan-3" class="Gem-btn-outline">Register</a>
                        @endif
                    @endguest
                </td>
            </tr>
            <br>
            </tbody>
        </table>
    </div>
</div>
@endsection
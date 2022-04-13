@extends('layouts.app')

@section('title', 'Pricing Plans')


@section('content')
<div class="container ">
    <div class="row  my-2" style='overflow: scroll;'> 
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
                <th class="bg-success p-4 text-center text-white">
                    <h3>Basic</h3>  Perfect for starting up businesses 
                </th>
                <th class="bg-warning  p-4 text-center text-white">
                    <h3>Pro</h3> Perfect for medium businesses 
                </th>
                <th class="bg-info p-4 text-center text-white">
                    <h3>Advanced</h3> Perfect for large businesses 
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
                <td class="text-primary p-3 font-weight-bold">Uplaod invoice</td>
                <td> Unlimited </td> 
                <td> Unlimited </td> 
                <td> Unlimited </td> 
            </tr>
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Businesses profiles</td>
                <td>One</td>
                <td>One</td>
                <td>Unlimited</td>
            </tr>
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Storage</td>
                <td >1 Gb</td>
                <td >3 Gb</td>
                <td >Unlimited</td>
            </tr>
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Team members</td>
                <td >3</td>
                <td >10</td>
                <td >Unlimited</td>
            </tr> 
            <tr class='border-bottom'>
                <td class="text-primary p-3 font-weight-bold">Monthly price</td>
                <td class="text-primary p-3 font-weight-bold"><h5>Free</h5></td>
                <td class="text-primary p-3 font-weight-bold"><h5>$ 49.00 <small> AUD </small></h5></td>
                <td class="text-primary p-3 font-weight-bold"><h5>$ 99.00 <small> AUD </small></h5></td>
            </tr>
            <tr  > 
                <td ></td>
                <td class="p-1">
                    <a   class="btn btn-secondary text-white " disabled>Default</a>
                </td>
                <td >
                    @guest
                        <a href="/plan-2" class="btn btn-primary"> Register </a>
                    @else
                        @if(Auth::user()->plan_id >= 2 )
                        <a class="btn btn-secondary text-white " disabled>Registered</a>
                        @else
                        <a href="/plan-2" class="btn btn-primary"> Register </a>
                        @endif
                    @endguest
                </td>
                <td>
                    @guest
                        <a href="/plan-3" class=" btn btn-primary">Register</a>
                    @else
                        @if(Auth::user()->plan_id == 3 )
                        <a class="btn btn-secondary text-white " disabled>Registered</a>
                        @else
                        
                        <a href="/plan-3" class=" btn btn-primary">Register</a>
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
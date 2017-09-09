@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="gateway--info">
            <div class="gateway--desc">
                @if(session()->has('message'))
                    <p class="message">
                        {{ session('message') }}
                    </p>
                @endif
                <p><strong>Order Overview !</strong></p>
                <hr>
                <p>Item : Yearly Subscription cost !</p>
                <p>Amount : ${{ $order->amount }}</p>
                <hr>
            </div>
            <div class="gateway--paypal">
                <form method="POST" action="{{ route('checkout.payment.paypal', ['order' => encrypt(mt_rand(1, 20))]) }}">
                    {{ csrf_field() }}
                    <button class="btn btn-pay">
                        <i class="fa fa-paypal" aria-hidden="true"></i> Pay with PayPal
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop

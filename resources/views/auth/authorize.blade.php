@extends('layouts.app')

@section('head')
    <meta http-equiv="refresh" content="15">
@stop

@section('content')
    <div class="container">
        <div class="authorize_holder">
            <div class="authorize__holder--section">
                <div class="text">
                    <h3>Authorize New Device</h3>

                    <p>It looks like you're signing in to <a href="{{ url('/') }}">{{ url('/') }}</a> from a computer or device we haven't seen before, or for some time.</p>
                    <p>
                        Please <strong>click the confirmation link in the email we just sent you.</strong> This is a process that protects the security of your account.
                    </p>
                    <p>Note that you need to access this email with the same device that you are confirming.</p>
                </div>
                <div class="authorize__resend">
                        <form action="{{ route('authorize.resend') }}" method="POST">
                            {{ csrf_field() }}

                            @include('partials.message')

                            <button type="submit" class="btn btn-primary">Email didn't arrive?</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

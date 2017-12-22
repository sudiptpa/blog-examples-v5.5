@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Authorize Login !</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('auth.verifiy.login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                                <label for="code" class="col-md-4 control-label">Email Code</label>
                                <div class="col-md-6">
                                    <input id="code" type="text" class="form-control" placeholder="Code" name="code" value="{{ old('code') }}" required autofocus>
                                    @if ($errors->has('code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal" method="POST" action="{{ route('auth.resend.verifiy.email') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Resend verification code?
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

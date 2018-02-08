@extends('layouts.app')

@section('content')
<div class="bg-image min-height-700" style="background-image: url({{ url('img/London-skyline.jpg') }})">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4 my-5">

                <div class="card mt-5" style="">
                  <div class="card-body">

                    <div class="d-flex justify-content-center align-content-center">
                        <img src="{{ url('img/growthinvest-logo.png') }}" width="250" height="" class="img-fluid logo_normal" alt="GrowthInvest">
                    </div>

                    <hr>

                    <form class="" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <div class="">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <div class="">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>


                            </div>
                        </div>
                    </form>
                  </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style type="text/css">
    header{
        display: none;
    }
</style>
@endsection

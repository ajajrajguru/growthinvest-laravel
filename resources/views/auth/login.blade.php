@extends('layouts.app')

@section('js')
 @parent

<script type="text/javascript" src="{{ asset('js/login.js') }}"></script>

<script type="text/javascript">

</script>
@endsection

@section('content')
<div class="bg-image min-height-700" style="background-image: url({{ url('img/London-skyline.jpg') }})">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4 my-5">

                <div class="card mt-5" style="">
                  <div class="card-body">

                    <div class="d-flex justify-content-center align-content-center px-3">
                        <img src="{{ url('img/growthinvest-logo.png') }}" width="" height="" class="img-fluid logo_normal" alt="GrowthInvest">
                    </div>

                    <hr>

                    <form class="" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
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

                        <div class="form-group mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="password" required psswd-shown="false">

                                <div class="input-group-append border-bottom">
                                    <button class="btn btn-sm btn-link clear-input toggle-password" type="button">
                                        <i class="fa fa-eye text-primary"></i>
                                    </button>
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <a class="btn btn-link pl-0" href="{{ route('password.request') }}" data-toggle="modal" data-target="#forgotPassword">
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

                        <hr>

                        <h5 class="text-center">Not a GrowthInvest Client?</h5>
                        <a href="{{ url('/register') }}" class="btn btn-primary btn-block text-uppercase">
                            register now!
                        </a>

                        <!-- <div class="input-group">
                            <div class="input-group-prepend pr-2">
                                <i class="fa fa-search text-muted"></i>
                            </div>
                            <input type="text" class="form-control datatable-search" placeholder="Search" />
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-link clear-input" type="button">
                                    <i class="fa fa-times text-secondary"></i>
                                </button>
                            </div>
                        </div> -->

                        
                    </form>
                  </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- footer -->
<div></div>
<!-- /footer -->

<!-- forgot password -->
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forgotPassword">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Forgot your password?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!!  View::make('auth.passwords.email')->render() !!}
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<style type="text/css">
    header{
        display: none;
    }
</style>
@include('includes.footer')
@endsection


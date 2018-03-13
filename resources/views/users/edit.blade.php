{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.backoffice')

@section('title', '| Edit User')

@section('backoffice-content')

<div class="container mt-5 mb-5">
<!-- <div class='col-lg-4 col-lg-offset-4'> -->

    <h3><i class='fa fa-user-plus'></i> Edit {{$user->name}}</h3>
    <hr>

    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with user data --}}
    
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::email('email', null, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    

    

    
    <h1 class="section-title font-weight-medium text-primary mt-5 mb-3">Give Role</h1>
    <div class='row mb-5'>
        @foreach ($roles as $role)
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::checkbox('roles[]',  $role->id, $user->roles ) }}
                {{ Form::label($role->name, ucfirst($role->name)) }}
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('password', 'Password') }}<br>
                {{ Form::password('password', array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('password', 'Confirm Password') }}<br>
                {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
            </div>
        </div>
    </div>

    

    

    {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

<!-- </div> -->
</div>

@endsection
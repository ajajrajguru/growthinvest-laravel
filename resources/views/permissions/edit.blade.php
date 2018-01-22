@extends('layouts.app')

@section('title', '| Edit Permission')

@section('content')

<div class='container mt-5'>

    <h3><i class='fa fa-key'></i> Edit {{$permission->name}}</h3>
    <br>
    {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with permission data --}}

    <div class="form-group">
        {{ Form::label('name', 'Permission Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    <br>
    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection
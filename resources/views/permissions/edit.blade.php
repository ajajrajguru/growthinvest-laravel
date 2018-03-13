@extends('layouts.backoffice')

@section('title', '| Edit Permission')

@section('js')
 @parent
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
@endsection

@section('backoffice-content')

<div class='container mt-5'>

    <h3><i class='fa fa-key'></i> Edit {{$permission->name}}</h3>
    <hr>
    {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with permission data --}}
    
    <div class="d-sm-flex justify-content-sm-between align-items-sm-center mb-5">
        <div class="form-group mb-0">
            {{ Form::label('name', 'Permission Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
        
        <div>{{ Form::submit('Edit', array('class' => 'btn btn-sm btn-outline-primary')) }}</div>
    </div>
    

    {{ Form::close() }}

</div>

@endsection
@extends('layouts.backoffice')

@section('title', '| Edit Role')

@section('js')
 @parent
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
@endsection

@section('backoffice-content')

<div class='container mt-5'>
    <h3><i class='fa fa-key'></i> Edit Role: {{$role->name}}</h3>
    <hr>

    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
    
    <div class="d-sm-flex justify-content-sm-between align-items-sm-center mb-5">
        <div class="form-group mb-0">
            {{ Form::label('name', 'Role Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div>
            {{ Form::submit('Edit', array('class' => 'btn btn-sm btn-outline-primary')) }}
        </div>
    </div>
    

    <h1 class="section-title font-weight-medium text-primary mb-0">Assign Permissions</h1>
    <div class="row mt-3">
        @foreach ($permissions as $permission)
        <div class="col-sm-4">
            <div class="form-group">
                {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
                {{Form::label($permission->name, ucfirst($permission->name)) }}
            </div>
        </div>
        @endforeach
    </div>
    
    

    {{ Form::close() }}    
</div>

@endsection
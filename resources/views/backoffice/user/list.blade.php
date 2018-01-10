@extends('layouts.backoffice')

@section('js')
  @parent
 
  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
 
@endsection
@section('backoffice-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $userType}}</div>

                <div class="panel-body">
                    <table id="datatable-users" class="table table-striped users-table" cellspacing="0" width="100%">
                       <thead>
                          
                          <tr>
                             <th width="10%"  >
                                Name
                             </th>
                             <th width="20%"  >
                                Email
                             </th>
                             <th width="20%"  >
                                Role
                             </th>
                             <th width="20%" >
                                 Firm
                             </th>
                             <th width="10%"  >
                                Action
                             </th>
                                     
                          </tr>
                    
                       </thead>
                       <tbody>
                            @foreach($users as $user)
                                <tr >
                                    <td >
                                     {{  $user->first_name.' '.$user->last_name }}
                                    </td>
                                    <td >
                                    <div>{{  $user->email }}</div>
                                    </td>
                                    <td >
                                    {{    $user->roles()->pluck('name')->implode(' ')  }}
                                    </td>
                                    <td>
                                    {{   (!empty($user->firm))?$user->firm->name:'' }}
                                    </td>
                                    <td>
                                    <select data-id="78523" class="firm_actions">
                                    <option>--select--</option>
                                    <option value="edit-intermediary">Edit</option>
                                    </select>
                                    </td>

                                </tr>
                            @endforeach
                          
                       </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

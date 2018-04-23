@extends('layouts.backoffice')

@section('js')
  @parent
<script type="text/javascript">

    var userRoles = <?php echo json_encode($roles);?>;
    console.log(userRoles)
</script>
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $( ".firm_actions" ).change(function() {
           var editUrl = $(this).attr('edit-url')
           window.open(editUrl);
        });
    });
</script>
@endsection
@section('backoffice-content')

<div class="container">

        @php
            echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
        @endphp
         @include('includes.manage-tabs')
        <div class="mt-4 bg-white border border-gray p-4">

            <div class="row">
                <div class="col-md-6">
                    <h1 class="section-title font-weight-medium text-primary mb-0">View Users</h1>

                    <p class="text-muted">View all Intermediaries registered with us.</p>

                </div>
                <div class="col-md-6">
                    <div class="float-right">
                        <a href="{{ url('backoffice/user/add/intermediary-registration')}}" class="btn btn-primary">Add User</a>
                        <a href="{{ url('backoffice/user/export-users')}}" class="btn btn-outline-primary">Download CSV</a>

                    </div>
                </div>
            </div>

            <div class="card bg-light mt-3 d-sm-none" id="toggle-mob">
              <div class="card-body text-center">
                <label class="card-text font-weight-medium">The below table has been optimized for mobile view. Click the below button to view all columns.</label>
                   <div class="btn-group-toggle" data-toggle="buttons">
                       <label class="btn btn-sm btn-outline-primary toggle-btn">
                           <input type="checkbox" checked autocomplete="off" name="toggle-mob"> Toggle Columns
                       </label>
                   </div>
              </div>
            </div>

            @include('backoffice.user.userlist')
            
        </div>
    </div>

    <style type="text/css">
        #datatable-users_filter{
            display: none;
        }
    </style>

@endsection


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
                <div class="panel-heading">Firms</div>

                <div class="panel-body">
                    <table id="datatable-firms" class="table table-striped firms-table" cellspacing="0" width="100%">
                       <thead>
                          
                          <tr>
                             <th width="10%" class="no-sort" >
                                Logo
                             </th>
                             <th width="20%"  >
                                Firm Name
                             </th>
                             <th width="20%"  >
                                Firm Type
                             </th>
                             <th width="20%" >
                                Parent Firm
                             </th>
                             <th width="20%"  >
                                Platform GI Code
                             </th>
                             <th width="10%"  >
                                Action
                             </th>
                                     
                          </tr>
                    
                       </thead>
                       <tbody>
                            @foreach($firms as $firm)
                                <tr >
                                    <td>  </td>
                                    <td >
                                     {{  $firm->name}}
                                    </td>
                                    <td >
                                    <div>{{  $firm->firmType()->name }}</div>
                                    </td>
                                    <td >
                                    {{  (!empty($firm->getParentFirm())) ? $firm->getParentFirm()->name :'' }}
                                    </td>
                                    <td>
                                    {{  $firm->gi_code }}
                                    </td>
                                    <td>
                                    <select data-id="78523" class="firm_actions">
                                    <option>--select--</option>
                                    <option value="view_firm">View Firm Details</option>
                                    <option value="view_wm_commissions">View Investment Clients</option>
                                    <option value="view_introducer_commissions">View Business Clients</option>
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

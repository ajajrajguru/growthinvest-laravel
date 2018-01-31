@extends('layouts.backoffice')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>



@endsection
@section('backoffice-content')

<div class="container">
    @php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp
    <div class="row mt-5 mx-0">
        <div class="col-md-2 bg-white px-0">
            @include('includes.side-menu')
        </div>

        <div class="col-md-10 bg-white border border-gray border-left-0 border-right-0">
            <div class="tab-content">
                <div class="tab-pane fade" id="home" role="tabpanel">
                    <h1>Lorem</h1>

                    <p>Aenean sed lacus id mi scelerisque tristique. Nunc sed ex sed turpis fringilla aliquet in in neque. Praesent posuere, neque rhoncus sollicitudin fermentum, erat ligula volutpat dui, nec dapibus ligula lorem ac mauris. Etiam et leo venenatis purus pharetra dictum.</p>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin tempor mi ut risus laoreet molestie. Duis augue risus, fringilla et nibh ac, convallis cursus purus. Suspendisse potenti. Praesent pretium eros eleifend posuere facilisis. Proin ut magna vitae nulla suscipit eleifend. Ut bibendum pulvinar sapien, vel tristique felis scelerisque et. Sed elementum sapien magna, placerat interdum lacus placerat ut. Integer varius, ligula bibendum laoreet sollicitudin, eros metus fringilla lectus, quis consequat nisl nibh ut nisi. Aenean dignissim, nibh ac fermentum condimentum, ante nisl rutrum sapien, at commodo eros sapien vulputate arcu. Fusce neque leo, blandit nec lectus eu, vestibulum commodo tellus. Aliquam sem libero, tristique at condimentum ac, luctus nec nulla.</p>
                </div>
                <div class="tab-pane fade" id="manage_clients" role="tabpanel">
                    <h1>Ipsum</h1>

                    <p>Aenean pharetra risus quis placerat euismod. Praesent mattis lorem eget massa euismod sollicitudin. Donec porta nulla ut blandit vehicula. Mauris sagittis lorem nec mauris placerat, et molestie elit vehicula. Donec libero ex, condimentum et mi dapibus, euismod ornare ligula.</p>

                    <p>In faucibus tempus ante, et tempor magna luctus id. Ut a maximus ipsum. Duis eu velit nec libero pretium pellentesque. Maecenas auctor hendrerit pulvinar. Donec sed tortor interdum, sodales elit vel, tempor turpis. In tristique vestibulum eros vel congue. Vivamus maximus posuere fringilla. Nullam in est commodo, tristique ligula eu, tincidunt enim. Duis iaculis sodales lectus vitae cursus.</p>
                </div>
                <div class="tab-pane fade show active" id="add_clients" role="tabpanel">
                     <div class="mt-4 p-2">

                        <div class="row ">
                            <div class="col-md-12 mb-5">
                                <label for="">Select Business Type</label>
                                <select name="managebusiness_type" class="form-control " id="managebusiness_type">
                                       <option value="business-listings" selected>Business Proposals/Funds</option>              
                                       <option value="entrepreneurs">Entrepreneurs</option>                            
                                       <option value="current-business-valuation">Current Business Valuation</option>                            
                                       <option value="fundmanagers">Fund Managers</option>                              
                                       <option value="view-invest-listings">Invest Companies</option> 
                                </select>
                            </div>
                           
                        </div>



                        <h1 class="section-title font-weight-medium text-primary mb-0">Current Business Valuation</h1>
                        <p class="text-muted">View All Business Proposals/Funds on your Site</p>

                        <h5 class="mt-2 mb-0"></h5>
                        <div class="p-3 bg-gray">
                             
                             
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="mt-3">
                                
                                <a href="javascript:void(0)" class="btn btn-link btn-sm download-current-business-valuation-csv" >Download CSV</a>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table id="datatable-currentbusinessvaluations" class="table dataFilterTable table-hover table-striped-bg">
                                <thead>
                                    <tr>
                                        <th class="w-search" style="width: 250px;">Proposal Name</th>    
                                        <th class="w-search" style="width: 250px;">Created On</th>
                                        <th class="w-search">Total Valuation</th>   
                                        <th class="w-search">Share Price</th>                                        
                                        <th class="w-search">Action</th>                                        
                                                                             
                                    </tr>
                                </thead>
                                <tbody>


                                   

 

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="investment_offers" role="tabpanel">
                    <h1>Ipsum</h1>

                    <p>Aenean pharetra risus quis placerat euismod. Praesent mattis lorem eget massa euismod sollicitudin. Donec porta nulla ut blandit vehicula. Mauris sagittis lorem nec mauris placerat, et molestie elit vehicula. Donec libero ex, condimentum et mi dapibus, euismod ornare ligula.</p>

                    <p>In faucibus tempus ante, et tempor magna luctus id. Ut a maximus ipsum. Duis eu velit nec libero pretium pellentesque. Maecenas auctor hendrerit pulvinar. Donec sed tortor interdum, sodales elit vel, tempor turpis. In tristique vestibulum eros vel congue. Vivamus maximus posuere fringilla. Nullam in est commodo, tristique ligula eu, tincidunt enim. Duis iaculis sodales lectus vitae cursus.</p>
                </div>
            </div>
        </div>
    </div>

</div>



    <style type="text/css">
        #datatable-entrepreneurs_filter{
            visibility: hidden;
        }
    </style>

@endsection


@extends('layouts.backoffice')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backoffice-investors.js') }}"></script>

<script type="text/javascript" src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}" ></script>
<link rel="stylesheet" href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}" >

<script type="text/javascript">
    
    $(document).ready(function() {
        // select2
        $('.select2-single').select2({
            // placeholder: "Search here"
        });

        $(document).on('change', '.investor_actions', function() {
           var editUrl = $('option:selected', this).attr('edit-url');
           if(editUrl!=''){
            window.open(editUrl);
           }
           
        });
    });


</script>



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
                        <h1 class="section-title font-weight-medium text-primary mb-0">Investors</h1>
                        <p class="text-muted">View the profile and the portfolio of the investors registered with us.</p>

                        <h5 class="mt-2 mb-0">Selection Filters</h5>
                        
                        <div class="p-3 bg-gray">
                            <div class="row">
                                <div class="col-md-4 mb-3 mb-sm-0">
                                    <label for="">Firm Name</label>
                                    <select name="firm_name" class="form-control investorSearchinput select2-single" id="investor_nominee">
                                        <option value="">All Firms</option>
                                        @foreach($firms as $firm)
                                        <option @if(isset($requestFilters['firm']) && $requestFilters['firm'] == $firm->id) selected @endif value="{{ $firm->id }}">{{ $firm->name }}</option>
                                        @endforeach

                                    </select>
                                    <em class="small">Select the firm whose investors you need to view</em>
                                    
                                </div>
                                <div class="col-md-4 mb-3 mb-sm-0">
                                    <label for="">Investor Name</label>
                                    <select name="investor_name" class="form-control investorSearchinput select2-single" id="investor_nominee">
                                        <option value="">--</option>
                                        @foreach($investors as $investor)
                                        <option @if(isset($requestFilters['investor']) && $requestFilters['investor'] == $investor->id) selected @endif value="{{ $investor->id }}">{{ $investor->first_name.' '.$investor->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Client Categories</label>
                                    <select name="client_category" class="form-control investorSearchinput" id="investor_nominee">
                                        <option value="">All client categories</option>
                                        @foreach($clientCategories as $clientCategory)
                                        <option @if(isset($requestFilters['client-category']) && $requestFilters['client-category'] == $clientCategory->id) selected @endif value="{{ $clientCategory->id }}">{{ $clientCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 mb-3 mb-sm-0">
                                    <label for="">Client Certifications</label>
                                    <select name="client_certification" class="form-control investorSearchinput" id="investor_nominee">
                                        <option value="">All Certifications</option>
                                        @foreach($certificationTypes as $key=>$certificationType)
                                        <option @if(isset($requestFilters['client-certification']) && $requestFilters['client-certification'] == $key) selected @endif value="{{ $key }}">{{ $certificationType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 mb-sm-0">
                                    <label for="">Nominee Account</label>
                                    <select name="investor_nominee" class="form-control investorSearchinput" id="investor_nominee">
                                        <option value="">--</option>
                                        <option @if(isset($requestFilters['investor-nominee']) && $requestFilters['investor-nominee'] == "nominee") selected @endif value="nominee">Yes</option>
                                        <option @if(isset($requestFilters['investor-nominee']) && $requestFilters['investor-nominee'] == "non_nominee") selected @endif value="non_nominee">No</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 mb-sm-0">
                                    <label for="">ID Verification</label>
                                    <select name="idverified" class="form-control investorSearchinput" id="idverified">
                                        <option value="">--</option>
                                        <option @if(isset($requestFilters['idverified']) && $requestFilters['idverified'] == "yes") selected @endif value="yes">Yes</option>
                                        <option @if(isset($requestFilters['idverified']) && $requestFilters['idverified'] == "no") selected @endif value="no">No</option>
                                    </select>
                                </div>
                                <div class="col-md-3 align-self-end text-right">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm reset-filters">Reset filter</a>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="mt-3">
                                <a href="{{ url('backoffice/investor/registration')}}" class="btn btn-primary btn-sm">Add Investors</a>
                                <a href="javascript:void(0)" class="btn btn-link btn-sm download-investor-csv" >Download CSV</a>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table id="datatable-investors" class="table dataFilterTable table-hover table-solid-bg">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="w-search" style="width: 250px;">Investor Name</th>
                                        <th class="w-search">Certification Date</th>
                                        <th class="w-search">Client Categorisation</th>
                                        <th class="w-search" style="width: 100px;" width="100"> Parent Firm </th>
                                        <th class="w-search"> Registered Date </th>
                                        <th style="min-width: 100px;">Action</th>
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
        #datatable-investors_filter{
            visibility: hidden;
        }
    </style>

@endsection


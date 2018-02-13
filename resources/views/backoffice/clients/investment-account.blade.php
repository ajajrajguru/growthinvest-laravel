@extends('layouts.backoffice')

@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/backoffice-investors.js') }}"></script>


  <script type="text/javascript">

    $(document).ready(function() {
        // select2
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        $('[data-toggle="tooltip"]').tooltip()
    });
        

  </script>


@endsection
@section('backoffice-content')

<div class="container">
    @php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp
    <div class="d-flex flex-row mt-5 bg-white border border-gray">
        @include('includes.side-menu')

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
                 
                <div class="p-2">
                    <div class="row mb-4">
                        <div class="col-md-5">
                            <h1 class="section-title font-weight-medium text-primary mt-4 mb-0">Add Investor</h1>
                            <p class="text-muted">Register a new client on the platform</p>
                        </div>
                        <div class="col-md-7">
                            <div class="bg-gray p-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ url('img/image-transfer-asset.jpg')}}" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="font-weight-normal text-dark">Download our Client Registration Guide</h5>
                                        <p class="mb-1">A straightforward guide to getting your clients up and running on the platform.</p>
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert bg-primary text-white alert-dismissible fade show d-none" role="alert">
                        Your client registration details added successfully and being redirected to certification stage
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @include('includes.notification')
                    <div class="progress-indicator_scroller">
                        <div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="border border-primary border-2 bg-gray p-3 mb-4">
                                        <div class="text-center">
                                            <h5 class="m-0">
                                                <small class=" font-weight-medium">
                                                    Platform Account Registration
                                                </small>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="border border-primary border-2 bg-gray p-3 mb-4">
                                        <div class="text-center">
                                            <h5 class="m-0">
                                                <small class=" font-weight-medium">
                                                    Investment Account
                                                </small>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="progress-indicator">
                                <li class="completed">
                                    <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/registration') }}">Registration</a>
                                    <span class="bubble"></span>
                                </li>
                                <li class="completed">
                                    <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/client-categorisation')}}">Client Categorisation</a>
                                    <span class="bubble"></span>
                                </li>
                                <li class="completed">
                                    <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/additional-information') }}">Additional Information</a>
                                    <span class="bubble"></span>
                                </li>
                                <li  class="active">
                                    <a href="javascript:void(0)">Investment Account</a>
                                    <span class="bubble"></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="profile-content p-4">
                    <h5 class="mt-3 mb-2">
                        4: <i class="fa fa-info-circle text-primary"> </i> <span class="text-primary"> 
                        @if(Auth::user()->hasPermissionTo('is_wealth_manager'))
                         Client Investment Account 
                        @else
                        Investment Account
                        @endif
                     </span>
                    </h5>
                    @if($investor->id)
                                         <a href="javascript:void(0)" class="btn btn-primary btn-sm editUserBtn  @if($mode=='edit') d-none  @endif">Edit Details</a>
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm  cancelUpdateBtn @if($mode=='view') d-none @endif">Cancel Updates</a>
                                    @endif
                    <hr class="my-3">

                    <!-- Investment Account Content HERE -->
                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))
                        <p>In order to start making investments on the platform or consolidating any existing assets, we need to upgrade your client's existing GrowthInvest account to an Investment Account and carry out some additional identity verification checks, as well as confirm information around your client's bank account and preferences around communication and payment methods for your client's investments.</p>

                        <p>In providing this service we have partnered with Platform One Limited, an FCA regulated custodian and nominee service.</p>

                        <p>Please complete the form below and, once finished, click the Submit Button.  Once submitted, your client will be asked to check and sign the form via our partners Adobe Sign. Any identity checks  will also be started at this point.</p> 

                        <p>If your client need to return to the form at a later stage, please use the Save button at the bottom of the form to save all current details until your client is ready to submit.</p>  
                    @else
                        <p>In order to start making investments on the platform or consolidating any existing assets, we need to upgrade your existing GrowthInvest account to an Investment Account and carry out some additional identity verification checks, as well as confirm information around your bank account and your preferences around communication and payment methods for your investments.</p>

                        <p>In providing this service we have partnered with Platform One Limited, an FCA regulated custodian and nominee service.</p>

                        <p>Please complete the form below and, once finished, click the Submit Button.  Once submitted, you will be asked to check and sign the form via our partners Adobe Sign. Any identity checks  will also be started at this point.</p> 

                        <p>If you need to return to the form at a later stage, please use the Save button at the bottom of the form to save all current details until you are ready to submit.</p>
                    @endif

                    <form method="post" action="{{ url('backoffice/investor/'.$investor->gi_code.'/save-investment-account') }}" data-parsley-validate name="add-investor-ia" id="add-investor-ia" enctype="multipart/form-data">
                    <!-- collapse -->
                    <div id="" role="tablist" class="gi-collapse">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapse1" role="button">
                                    <span class="px-0 col-md-10 col-8">
                                        SECTION 1: CLIENT ACCOUNT DETAILS
                                        <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                                    </span>


                                    
                                    <span class="text-md-right text-center px-0 col-md-2 col-4">

                                        <small class="mr-sm-3 mr-0 d-block d-md-inline-block section1-status">{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][1])) ? ucfirst($nomineeDetails['section_status'][1]) : 'Incomplete'  }}</small>
                                        <i class="fa fa-lg fa-plus-square-o"></i>
                                        <i class="fa fa-lg fa-minus-square-o"></i>
                                        <input type="hidden" name="section_status[1]" class="section1-status-input sectionstatus-input" value="{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][1])) ? $nomineeDetails['section_status'][1] : 'incomplete'  }}">
                                    </span>
                                </a>
                            </div>

                            <div id="collapse1" class="collapse show parent-tabpanel" role="tabpanel" data-section='1' >
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="required">Title</label>
                                                <select name="title" id="user-title" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please select title.">    

                                                <option value="">Select</option>
                                                @php
                                                $selTitile = '';
                                                if(!empty($nomineeDetails) && isset($nomineeDetails['title'])){
                                                    $selTitile = $nomineeDetails['title'];
                                                }
                                                else
                                                {
                                                    $selTitile = $investor->title;
                                                }
                                                @endphp                                                                                                    
                                                <option value="mr" @if($selTitile == "mr") selected @endif >Mr</option>                                                                                            
                                                <option value="mrs" @if($selTitile == "mrs") selected @endif>Mrs</option>                                                                                           
                                                <option value="miss" @if($selTitile == "miss") selected @endif>Miss</option>                                                                                           
                                                 <option value="ms" @if($selTitile == "ms") selected @endif>Ms</option>                                                                
                                             </select>
                                             <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ title_case($selTitile) }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Surname <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="surname" placeholder="" data-parsley-required data-parsley-required-message="Please enter the surname." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['surname'])){{ $nomineeDetails['surname'] }}@else{{$investor->last_name}}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['surname'])){{ $nomineeDetails['surname'] }}@else{{$investor->last_name}}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Forename <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="forename" placeholder="" data-parsley-required data-parsley-required-message="Please enter the forename." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['forename'])){{ $nomineeDetails['forename'] }}@else{{$investor->first_name}}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['forename'])){{ $nomineeDetails['forename'] }}@else{{$investor->first_name}}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Date of Birth <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control datepicker text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="dateofbirth" placeholder="" data-parsley-required data-parsley-required-message="Please enter the date of birth." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['dateofbirth'])){{ $nomineeDetails['dateofbirth'] }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['dateofbirth'])){{ $nomineeDetails['dateofbirth'] }}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>National Insurance Number <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
  
                                                <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif"  name="nationalinsuranceno" data-parsley-trigger="keyup" placeholder="" data-parsley-required data-parsley-required-message="Please enter the national insurance number." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['nationalinsuranceno'])){{ $nomineeDetails['nationalinsuranceno'] }}@endif" data-parsley-maxlength="9">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['nationalinsuranceno'])){{ $nomineeDetails['nationalinsuranceno'] }}@endif</div>
 
 
                                                <small  class="form-text text-muted">
                                                @if(Auth::user()->hasPermissionTo('is_wealth_manager'))    
                                                    If your client does not have a National Insurance number, please tick here
                                                @else
                                                    If you do not have a National Insurance number, please tick here
                                                @endif

                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                  <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif value="1" id="ch1" name="nonationalinsuranceno" @if(!empty($nomineeDetails) && isset($nomineeDetails['nonationalinsuranceno']) && $nomineeDetails['nonationalinsuranceno'] =='1') checked @endif>
                                                  <label class="custom-control-label" for="ch1">If you do not have a National Insurance number, please tick here</label>
                                                </div>
                                            </div>


                                            <div class="nonationalinsuranceno-container @if(!empty($nomineeDetails) && isset($nomineeDetails['nonationalinsuranceno']) && $nomineeDetails['nonationalinsuranceno'] =='') d-none @endif @if(!empty($nomineeDetails) && !isset($nomineeDetails['nonationalinsuranceno'])) d-none @endif @if(empty($nomineeDetails)) d-none  @endif">
                                            <div class="form-group">
                                                <label>Nationality <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control  @if(!empty($nomineeDetails) && isset($nomineeDetails['nonationalinsuranceno']) && $nomineeDetails['nonationalinsuranceno'] =='1') text-input-status completion_status @endif editmode @if($mode=='view') d-none @endif" placeholder="" name="nationality" placeholder=""   data-parsley-required-message="Please enter the nationality." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['nationality'])){{ $nomineeDetails['nationality'] }}@endif" @if(!empty($nomineeDetails) && isset($nomineeDetails['nonationalinsuranceno']) && $nomineeDetails['nonationalinsuranceno'] =='1') data-parsley-required @endif>
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['nationality'])){{ $nomineeDetails['nationality'] }}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Domiciled <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control  @if(!empty($nomineeDetails) && isset($nomineeDetails['nonationalinsuranceno']) && $nomineeDetails['nonationalinsuranceno'] =='1') text-input-status completion_status @endif editmode @if($mode=='view') d-none @endif" placeholder="" name="domiciled" data-parsley-required-message="Please enter the domiciled." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['domiciled'])){{ $nomineeDetails['domiciled'] }}@endif" @if(!empty($nomineeDetails) && isset($nomineeDetails['nonationalinsuranceno']) && $nomineeDetails['nonationalinsuranceno'] =='1') data-parsley-required @endif>
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['domiciled'])){{ $nomineeDetails['domiciled'] }}@endif</div>
                                            </div>
                                            
                                            <p>If you live outside the UK and in a European Union (EU) member state, please supply one of the following reportable pieces of information for the EU Savings Directive.</p>
                                            <p class="mt-3 text-center">EITHER</p>
                                                
                                            <div class="form-group">
                                                <input type="text" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" name="tinnumber" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['tinnumber'])){{ $nomineeDetails['tinnumber'] }}@endif" >
                                                
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['tinnumber'])){{ $nomineeDetails['tinnumber'] }}@endif</div>

                                                <small  class="form-text text-muted">your Tax Identification Number (TIN) - This is a number assigned to you by your government or local authority. It is the reference number usually used on your tax return.</small>
                                            </div>

                                            <p class="text-center">OR</p>


                                            
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" name="account_city" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['city'])){{ $nomineeDetails['city'] }}@else{{ $investor->city }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['city'])){{ $nomineeDetails['city'] }}@else{{ $investor->city }}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Country</label>
                                                <select class="form-control editmode @if($mode=='view') d-none @endif" name="account_country">
                                                    <option value="">Please Select</option>
                                                    @php
                                                    $countryName = '';
                                                    
                                                    @endphp 
                                                    @foreach($countryList as $code=>$country)
                                                        @php
                                                        $selected = '';
                                                        if(!empty($nomineeDetails) && isset($nomineeDetails['country']) && $nomineeDetails['country']==$code){
                                                            $selected = 'selected';
                                                            $countryName = $country;
                                                        }
                                                        if(empty($nomineeDetails) && $investor->country==$code){
                                                            $selected = 'selected';
                                                            $countryName = $country;
                                                        }
                                                            
                                                        @endphp
                                                        <option value="{{ $code }}" {{ $selected }}>{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ $countryName }}</div>
                                                <small class="form-text text-muted">Place of birth (city and country, as on your passport)</small>
                                            </div>
                                        </div>


                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Telephone <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="account_telephone" placeholder="" data-parsley-required data-parsley-required-message="Please enter the telephone." data-parsley-type="number" data-parsley-minlength="10" data-parsley-minlength-message="The telephone number must be atleast 10 characters long!" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['telephone'])){{ $nomineeDetails['telephone'] }}@else{{ $investor->telephone_no }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['telephone'])){{ $nomineeDetails['telephone'] }}@else{{ $investor->telephone_no }}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Address <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <textarea name="account_address" id="" cols="30" rows="3" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the address.">@if(!empty($nomineeDetails) && isset($nomineeDetails['address'])){{ $nomineeDetails['address'] }}@else{{$investor->address_1}}@endif</textarea>
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['address'])) {{ $nomineeDetails['address'] }}@else{{ $investor->address_1 }}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Postcode <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" name="account_postcode" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" placeholder="" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['postcode'])){{ $nomineeDetails['postcode'] }}@else{{$investor->postcode}}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['postcode'])){{ $nomineeDetails['postcode'] }}@else{{$investor->postcode}}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Email Address <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input readonly type="email" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" placeholder="" name="account_email" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['email'])){{ $nomineeDetails['email'] }}@else{{$investor->email}}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['email'])){{ $nomineeDetails['email'] }}@else{{$investor->email}}@endif</div>

                                                <small  class="form-text text-muted">You will not be able to access your account online, without a valid e-mail address. If you do not provide an e-mail address, any communications to service your account will be sent to you by post.</small>
                                            </div>

                                            <div class="form-group">
                                                <p>A US person is an individual to whom one or more of the following applies:</p>
                                                <ul>
                                                    <li>Dual citizens of the US and another country</li>
                                                    <li>US citizen even if residing outside the United States</li>
                                                    <li>US passport holder</li>
                                                    <li>Born in the US, unless citizenship has been renounced</li>
                                                    <li>Lawful permanent resident of the US</li>
                                                    <li>A ‘substantially present’ person as declared by the US tax regulator</li>
                                                </ul>
                                            </div>

                                            <div class="form-group">
                                                <label>
                                                @if(Auth::user()->hasPermissionTo('is_wealth_manager'))    
                                                    Is your client a US Person?
                                                @else
                                                    Are you a US Person?
                                                @endif

                                                     <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <div class="editmode @if($mode=='view') d-none @endif">
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                      <input type="radio" id="yes2" name="areuspersonal" class="custom-control-input checked-input-status completion_status" value="yes" data-parsley-required @if(!empty($nomineeDetails) && $isUsPerson =='yes') checked @endif>
                                                      <label class="custom-control-label" for="yes2">Yes</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                      <input type="radio" id="no2" name="areuspersonal" class="custom-control-input completion_status"  value="no" @if(!empty($nomineeDetails) && $isUsPerson =='no') checked @endif >
                                                      <label class="custom-control-label" for="no2">No</label>
                                                    </div>
                                                </div>
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails)) {{ title_case($isUsPerson)}} @endif</div>
                                                <small  class="form-text text-muted">If you have ticked ‘Yes’, Platform One will not be able to accept your application.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card ia-card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapse2" role="button" class="collapsed">
                                    <span class="px-0 col-md-10 col-8">
                                        SECTION 2: TAX CERTIFICATES
                                        <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                                    </span>

                                    <span class="text-md-right text-center px-0 col-md-2 col-4">
                                        <small class="mr-sm-3 mr-0 d-block d-md-inline-block section2-status">{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][2])) ? ucfirst($nomineeDetails['section_status'][2]) : 'Incomplete'  }}</small>
                                        <i class="fa fa-lg fa-plus-square-o"></i>
                                        <i class="fa fa-lg fa-minus-square-o"></i>
                                        <input type="hidden" name="section_status[2]" class="section2-status-input sectionstatus-input" value="{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][2])) ? $nomineeDetails['section_status'][2] : 'incomplete'  }}">
                                    </span>     
                                  
                                </a>
                            </div>

                            <div id="collapse2" class="collapse parent-tabpanel" role="tabpanel" data-section='2'>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Please indicate where you would like the original tax certificate sent to:</label>
                                        <div class="editmode @if($mode=='view') d-none @endif">
                                            <div class="custom-control custom-radio">
                                              <input type="radio" id="yourself" name="sendtaxcertificateto" class="custom-control-input completion_status" value="yourself"  @if(!empty($nomineeDetails) && $taxCertificateSentTo =='yourself') checked  @endif >
                                              <label class="custom-control-label" for="yourself">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))    
                                              Client Address*
                                            @else
                                              Yourself*
                                            @endif 
                                          </label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                              <input type="radio" id="adviser" name="sendtaxcertificateto" class="custom-control-input completion_status" value="adviser" @if(!empty($nomineeDetails) && $taxCertificateSentTo =='adviser') checked  @endif @if(empty($nomineeDetails)) checked  @endif>
                                              <label class="custom-control-label" for="adviser">Adviser**</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                              <input type="radio" id="accountant" name="sendtaxcertificateto" class="custom-control-input completion_status" value="accountant" @if(!empty($nomineeDetails) && $taxCertificateSentTo =='accountant') checked  @endif>
                                              <label class="custom-control-label" for="accountant">Accountant**</label>
                                            </div>
                                        </div>

                                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails)) {{ title_case($taxCertificateSentTo)}} @endif</div>
                                    </div>

                                    <p class="mb-1 @if($mode=='view') d-none @endif">* Will be correspondence address if filled out</p>
                                    <p class="@if($mode=='view') d-none @endif">** If you have indicated that you would like your Accountant or Financial Adviser to receive your EIS Certificates please provide their details below:</p>

                                    <div class="row sendtaxcertificateto-yourself @if(!empty($nomineeDetails) && $taxCertificateSentTo =='yourself') d-none  @endif ">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Firm Name <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="txcertificatefirmname" @if(!empty($nomineeDetails) && $taxCertificateSentTo !='yourself') data-parsley-required  @endif @if(empty($nomineeDetails)) data-parsley-required  @endif   data-parsley-required-message="Please enter the firm name." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificatefirmname'])){{ $nomineeDetails['txcertificatefirmname'] }} @endif">

                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificatefirmname'])){{ $nomineeDetails['txcertificatefirmname'] }} @endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Contact <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="txcertificatecontact" @if(!empty($nomineeDetails) && $taxCertificateSentTo !='yourself') data-parsley-required  @endif @if(empty($nomineeDetails)) data-parsley-required  @endif data-parsley-required-message="Please enter the conatct." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificatecontact'])){{ $nomineeDetails['txcertificatecontact'] }}@endif">

                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificatecontact'])){{ $nomineeDetails['txcertificatecontact'] }}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Telephone <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="tel" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="txcertificatetelephone" @if(!empty($nomineeDetails) && $taxCertificateSentTo !='yourself') data-parsley-required  @endif @if(empty($nomineeDetails)) data-parsley-required  @endif data-parsley-required-message="Please enter the telephone." data-parsley-type="number" data-parsley-minlength="10" data-parsley-minlength-message="The telephone number must be atleast 10 characters long!" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificatetelephone'])){{ $nomineeDetails['txcertificatetelephone'] }}@endif">

                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificatetelephone'])){{ $nomineeDetails['txcertificatetelephone'] }}@endif</div>
                                            </div>

                                            <div class="form-group">
                                                <label>Email Address <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="email" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="txcertificateemail" @if(!empty($nomineeDetails) && $taxCertificateSentTo !='yourself') data-parsley-required  @endif @if(empty($nomineeDetails)) data-parsley-required  @endif data-parsley-required-message="Please enter the email." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificateemail'])){{ $nomineeDetails['txcertificateemail'] }}@endif">

                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificateemail'])){{ $nomineeDetails['txcertificateemail'] }}@endif</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Address <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <textarea id="" cols="30" rows="3" name="txcertificateaddress" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" @if(!empty($nomineeDetails) && $taxCertificateSentTo !='yourself') data-parsley-required  @endif @if(empty($nomineeDetails)) data-parsley-required  @endif data-parsley-required-message="Please enter the address.">@if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificateaddress'])){{ $nomineeDetails['txcertificateaddress'] }}@endif</textarea>

                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['txcertificateaddress'])){{ $nomineeDetails['txcertificateaddress'] }}@endif</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CLIENT BANK ACCOUNT DETAILS -->
                        <div class="card ia-card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapse3" role="button" class="collapsed">
                                    <span class="px-0 col-md-10 col-8">
                                        SECTION 3: CLIENT BANK ACCOUNT DETAILS
                                        <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                                    </span>

                                    <span class="text-md-right text-center px-0 col-md-2 col-4">
                                        <small class="mr-sm-3 mr-0 d-block d-md-inline-block section3-status">{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][3])) ? ucfirst($nomineeDetails['section_status'][3]) : 'Not started'  }}</small>
                                        <i class="fa fa-lg fa-plus-square-o"></i>
                                        <i class="fa fa-lg fa-minus-square-o"></i>
                                        <input type="hidden" name="section_status[3]" class="section3-status-input sectionstatus-input" value="{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][3])) ? $nomineeDetails['section_status'][3] : 'incomplete'  }}">
                                    </span>  
                                </a>
                            </div>

                            <div id="collapse3" class="collapse parent-tabpanel" role="tabpanel" data-section='3'>
                                <div class="card-body">
                                    @if(Auth::user()->hasPermissionTo('is_wealth_manager')) 
                                    <p>Please provide details of the bank account to which your client would like any distributions paid to.</p>
                                    @else
                                    <p>Please provide details of the bank account to which you would like any distributions paid to.</p>

                                    @endif
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Name of Account Holder(s) <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="bankaccntholder1" data-parsley-required data-parsley-required-message="Please enter the account holder name." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntholder1'])){{ $nomineeDetails['bankaccntholder1'] }}@endif">
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="bankaccntholder2" data-parsley-required data-parsley-required-message="Please enter the account holder name." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntholder2'])){{ $nomineeDetails['bankaccntholder2'] }}@endif">

                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntholder1'])){{ $nomineeDetails['bankaccntholder1'] }}@endif <br> @if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntholder2'])){{ $nomineeDetails['bankaccntholder2'] }}@endif</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Bank Name <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="bankname" data-parsley-required data-parsley-required-message="Please enter the bank name." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['bankname'])){{ $nomineeDetails['bankname'] }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['bankname'])){{ $nomineeDetails['bankname'] }}@endif</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Account Number <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="bankaccntnumber" data-parsley-required data-parsley-required-message="Please enter the account number." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntnumber'])){{ $nomineeDetails['bankaccntnumber'] }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntnumber'])){{ $nomineeDetails['bankaccntnumber'] }}@endif</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Bank Address <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <textarea   id="" cols="30" rows="1" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="bankaddress" data-parsley-required data-parsley-required-message="Please enter the bank address.">@if(!empty($nomineeDetails) && isset($nomineeDetails['bankaddress'])){{ $nomineeDetails['bankaddress'] }}@endif</textarea>
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['bankaddress'])){{ $nomineeDetails['bankaddress'] }}@endif</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Sort Code <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="bankaccntsortcode" data-parsley-required data-parsley-required-message="Please enter the sort code." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntsortcode'])){{ $nomineeDetails['bankaccntsortcode'] }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['bankaccntsortcode'])){{ $nomineeDetails['bankaccntsortcode'] }}@endif</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Postcode <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <input type="text" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" placeholder="" name="clientbankpostcode" data-parsley-required data-parsley-required-message="Please enter the post code." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['clientbankpostcode'])){{ $nomineeDetails['clientbankpostcode'] }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['clientbankpostcode'])){{ $nomineeDetails['clientbankpostcode'] }}@endif</div>
                                            </div>
                                        </div>
                                    </div>

                                    <p>Please note: If the account is in the name of a third party it will be necessary to complete a full identity check on the third party.</p>
                                </div>
                            </div>
                        </div>
                        <!-- /CLIENT BANK ACCOUNT DETAILS -->
                        
                        <!-- SECTION 4: FEES & CHARGES -->
                        <div class="card ia-card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapse4" role="button" class="collapsed">
                                    <span class="px-0 col-md-10 col-8">
                                        SECTION 4: FEES & CHARGES
                                        <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                                    </span>

                                    <span class="text-md-right text-center px-0 col-md-2 col-4">
                                        <small class="mr-sm-3 mr-0 d-block d-md-inline-block section4-status">{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][4])) ? ucfirst($nomineeDetails['section_status'][4]) : 'Incomplete'  }}</small>
                                        <i class="fa fa-lg fa-plus-square-o"></i>
                                        <i class="fa fa-lg fa-minus-square-o"></i>
                                        <input type="hidden" name="section_status[4]" class="section4-status-input sectionstatus-input" value="{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][4])) ? $nomineeDetails['section_status'][4] : 'incomplete'  }}">
                                    </span>
                                </a>
                            </div>

                            <div id="collapse4" class="collapse parent-tabpanel" role="tabpanel" data-section='4'>
                                <div class="card-body">
                                    <p>Please review all fees and charges below in both sections 4.1 and 4.2. All the latest account charges are listed in the <a href="javascript:void(0);">GrowthInvest Fees and Charges document</a></p>

                                    <!-- collapse -->
                                    <!-- SECTION 4.1: GROWTHINVEST ANNUAL CHARGE -->

                                    @php
                                    $readonlyInvPer = '';
                                    $readonlyInvAmt = '';
                                    $readonlyagreeInvPer = '';
                                    $readonlyagreeInvAmt = '';

                                    if(!empty($nomineeDetails) && isset($nomineeDetails['adviserinitialinvestpercent']) && isset($nomineeDetails['ongoingadvinitialinvestpercent']) && $nomineeDetails['adviserinitialinvestpercent']!="" && $nomineeDetails['ongoingadvinitialinvestpercent']!=""){
                                        $readonlyInvAmt = 'readonly';
                                        $readonlyagreeInvPer = 'readonly';
                                        $readonlyagreeInvAmt = 'readonly';
                                    }


                                    if(!empty($nomineeDetails) && isset($nomineeDetails['adviserinitialinvestfixedamnt']) && isset($nomineeDetails['ongoingadvinitialinvestfixedamnt']) && $nomineeDetails['adviserinitialinvestfixedamnt']!="" && $nomineeDetails['ongoingadvinitialinvestfixedamnt']!=""){
                                        $readonlyInvPer = 'readonly';
                                        $readonlyagreeInvPer = 'readonly';
                                        $readonlyagreeInvAmt = 'readonly';
                                    }

                                    if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryinitialinvestpercent']) && $nomineeDetails['intermediaryinitialinvestpercent']!=""){
                                        $readonlyInvPer = 'readonly';
                                        $readonlyInvAmt = 'readonly';
                                        $readonlyagreeInvAmt = 'readonly'; 

                                    } 


                                    if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryinitialinvestfixedamnt']) && $nomineeDetails['intermediaryinitialinvestfixedamnt']!=""){
                                        $readonlyInvPer = 'readonly';
                                        $readonlyInvAmt = 'readonly';
                                        $readonlyagreeInvPer = 'readonly';
                                    } 

                                    @endphp
                                    <div class="card">
                                        <div class="card-header" role="tab" id="headingOne">
                                            <a data-toggle="collapse" href="#collapse4-1" role="button" class="collapsed">
                                              SECTION 4.1: GROWTHINVEST ANNUAL CHARGE
                                              <i class="fa fa-lg fa-plus-square-o"></i>
                                              <i class="fa fa-lg fa-minus-square-o"></i>
                                            </a>
                                        </div>

                                        <div id="collapse4-1" class="collapse" role="tabpanel" >
                                            <div class="card-body">
                                                <p>There is an annual fee applied as a percentage of your overall portfolio value. This is applied on a tiered basis, starting at 0.5% on portfolios up to £100,000, with a minimum annual charge of £150. Any agreed variation to the current standard terms will be detailed below:</p>
                                                
                                                <h6>GROWTHINVEST ANNUAL CHARGE</h6>
                                                <div class="row border py-3 bg-light align-items-md-center mx-0">
                                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                                        <!-- <div class="form-group"> -->
                                                            <label>% of investment</label>
                                                            <input type="number" class="form-control invest-perc investment-input editmode @if($mode=='view') d-none @endif" {{ $readonlyInvPer }} placeholder="" name="adviserinitialinvestpercent" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['adviserinitialinvestpercent'])){{ $nomineeDetails['adviserinitialinvestpercent'] }}@endif">
                                                            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['adviserinitialinvestpercent'])){{ $nomineeDetails['adviserinitialinvestpercent'] }} @else - @endif</div>
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="col-sm-1 text-center mb-3 mb-sm-0">OR</div>
                                                    <div class="col-sm-5 mb-3 mb-sm-0">
                                                        <!-- <div class="form-group"> -->
                                                            <label>Fixed amount: (applicable to each payment in)</label>
                                                            <input type="number" class="form-control invest-amount investment-input editmode @if($mode=='view') d-none @endif" {{ $readonlyInvAmt }} placeholder="" name="adviserinitialinvestfixedamnt" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['adviserinitialinvestfixedamnt'])){{ $nomineeDetails['adviserinitialinvestfixedamnt'] }}@endif">
                                                            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['adviserinitialinvestfixedamnt'])){{ $nomineeDetails['adviserinitialinvestfixedamnt'] }} @else - @endif</div>
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Is VAT to be applied?</label>
                                                        <div class="editmode @if($mode=='view') d-none @endif">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                              <input type="radio" id="adviservattobeapplied_yes" name="adviservattobeapplied" class="custom-control-input" value="yes" @if(!empty($nomineeDetails) && isset($nomineeDetails['adviservattobeapplied']) && $nomineeDetails['adviservattobeapplied']=='yes') checked  @endif>
                                                              <label class="custom-control-label" for="adviservattobeapplied_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                              <input type="radio" id="adviservattobeapplied_no" name="adviservattobeapplied" class="custom-control-input" value="no" @if(!empty($nomineeDetails) && isset($nomineeDetails['adviservattobeapplied']) && $nomineeDetails['adviservattobeapplied']=='no') checked  @endif>
                                                              <label class="custom-control-label" for="adviservattobeapplied_no">No</label>
                                                            </div>
                                                        </div>

                                                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['adviservattobeapplied'])) {{ title_case($nomineeDetails['adviservattobeapplied']) }}  @endif</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /SECTION 4.1: GROWTHINVEST ANNUAL CHARGE -->
                                    
                                    <!-- SECTION 4.2: ADVISER DETAILS & CHARGES (IF APPLICABLE) -->
                                    <div class="card">
                                        <div class="card-header" role="tab" id="headingOne">
                                            <a data-toggle="collapse" href="#collapse4-2" role="button" class="collapsed">
                                              SECTION 4.2: ADVISER DETAILS & CHARGES (IF APPLICABLE)
                                              <i class="fa fa-lg fa-plus-square-o"></i>
                                              <i class="fa fa-lg fa-minus-square-o"></i>
                                            </a>
                                        </div>

                                        <div id="collapse4-2" class="collapse" role="tabpanel" >
                                            <div class="card-body">
                                                <p>If you have a financial adviser please complete the following section. If you are applying as a direct investor please tick not applicable</p>

                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif  name="advdetailsnotapplicable" value="1" id="ch5" @if(!empty($nomineeDetails) && isset($nomineeDetails['advdetailsnotapplicable']) && $nomineeDetails['advdetailsnotapplicable']=='1') checked @endif>
                                                      <label class="custom-control-label" for="ch5">Not applicable</label>
                                                    </div>
                                                </div>

                                                <div class="adv-details-applicable-data">
                                                    @php
                                                    $completionClasses = false;
                                                    if(!empty($nomineeDetails) && isset($nomineeDetails['advdetailsnotapplicable']) && $nomineeDetails['advdetailsnotapplicable']==''){
                                                        $completionClasses = true;
                                                    }  
                                                    @endphp
                                                 @include('backoffice.clients.firm-data')
                                                </div>

                                                <h5>Client Agreed Adviser Remuneration</h5>
                                                <p>GrowthInvest can facilitate the payment of fees to your adviser. Please specify the agreed adviser remuneration below:</p>

                                                <h6 class="mt-4">ON-GOING ADVISER CHARGE*</h6>
                                                <div class="row border py-3 bg-light align-items-md-center mx-0">
                                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                                        <!-- <div class="form-group"> -->
                                                            <label>% of investment</label>
                                                            <input type="number" name="ongoingadvinitialinvestpercent" {{ $readonlyInvPer }} class="form-control investment-input invest-perc editmode @if($mode=='view') d-none @endif" placeholder="" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['ongoingadvinitialinvestpercent'])){{ $nomineeDetails['ongoingadvinitialinvestpercent'] }}@endif">

                                                            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['ongoingadvinitialinvestpercent'])){{ $nomineeDetails['ongoingadvinitialinvestpercent'] }} @else - @endif</div>
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="col-sm-1 text-center mb-3 mb-sm-0">OR</div>
                                                    <div class="col-sm-5 mb-3 mb-sm-0">
                                                        <!-- <div class="form-group"> -->
                                                            <label>Fixed amount: (applicable to each payment in)</label>
                                                            <input type="number" name="ongoingadvinitialinvestfixedamnt" {{ $readonlyInvAmt }} class="form-control  invest-amount investment-input editmode @if($mode=='view') d-none @endif" placeholder="" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['ongoingadvinitialinvestfixedamnt'])){{ $nomineeDetails['ongoingadvinitialinvestfixedamnt'] }}@endif">

                                                            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['ongoingadvinitialinvestfixedamnt'])){{ $nomineeDetails['ongoingadvinitialinvestfixedamnt'] }} @else - @endif</div>
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Is VAT to be applied?</label>
                                                        <div class="editmode @if($mode=='view') d-none @endif">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                              <input type="radio" id="ongoingadvchargesvatyettobeapplied_yes" name="ongoingadvchargesvatyettobeapplied" value="yes" class="custom-control-input" @if(!empty($nomineeDetails) && isset($nomineeDetails['ongoingadvchargesvatyettobeapplied']) && $nomineeDetails['ongoingadvchargesvatyettobeapplied']=='yes') checked  @endif>
                                                              <label class="custom-control-label" for="ongoingadvchargesvatyettobeapplied_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                              <input type="radio" id="ongoingadvchargesvatyettobeapplied_no" name="ongoingadvchargesvatyettobeapplied" value="no" class="custom-control-input" @if(!empty($nomineeDetails) && isset($nomineeDetails['ongoingadvchargesvatyettobeapplied']) && $nomineeDetails['ongoingadvchargesvatyettobeapplied']=='no') checked  @endif>
                                                              <label class="custom-control-label" for="ongoingadvchargesvatyettobeapplied_no">No</label>
                                                            </div>
                                                        </div>

                                                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['ongoingadvchargesvatyettobeapplied'])) {{ title_case($nomineeDetails['ongoingadvchargesvatyettobeapplied'])}}   @endif</div>
                                                    </div>
                                                </div>

                                                <h6 class="mt-4">AGREED INITIAL CHARGES**</h6>
                                                <div class="row border py-3 bg-light align-items-md-center mx-0">
                                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                                        <!-- <div class="form-group"> -->
                                                            <label>% of investment</label>
                                                            <input type="number" {{ $readonlyagreeInvPer }} class="form-control aic-investment-perc  aic-investment-input editmode @if($mode=='view') d-none @endif" name="intermediaryinitialinvestpercent" placeholder="" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryinitialinvestpercent'])){{ $nomineeDetails['intermediaryinitialinvestpercent'] }}@endif">

                                                            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryinitialinvestpercent'])){{ $nomineeDetails['intermediaryinitialinvestpercent'] }} @else - @endif</div>
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="col-sm-1 text-center mb-3 mb-sm-0">OR</div>
                                                    <div class="col-sm-5 mb-3 mb-sm-0">
                                                        <!-- <div class="form-group"> -->
                                                            <label>Fixed amount: (applicable to each payment in)</label>
                                                            <input type="number" {{ $readonlyagreeInvAmt }} class="form-control aic-investment-amount aic-investment-input editmode @if($mode=='view') d-none @endif" name="intermediaryinitialinvestfixedamnt" placeholder="" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryinitialinvestfixedamnt'])){{ $nomineeDetails['intermediaryinitialinvestfixedamnt'] }}@endif">

                                                            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryinitialinvestfixedamnt'])){{ $nomineeDetails['intermediaryinitialinvestfixedamnt'] }} @else - @endif</div>
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Is VAT to be applied?</label>
                                                        <div class="editmode @if($mode=='view') d-none @endif">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                              <input type="radio" id="intermediaryvattobeapplied_yes" name="intermediaryvattobeapplied" value="yes" class="custom-control-input" @if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryvattobeapplied']) && $nomineeDetails['intermediaryvattobeapplied']=='yes') checked  @endif>
                                                              <label class="custom-control-label" for="intermediaryvattobeapplied_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                              <input type="radio" id="intermediaryvattobeapplied_no" name="intermediaryvattobeapplied" value="no" class="custom-control-input" @if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryvattobeapplied']) && $nomineeDetails['intermediaryvattobeapplied']=='no') checked  @endif>
                                                              <label class="custom-control-label" for="intermediaryvattobeapplied_no">No</label>
                                                            </div>
                                                        </div>
                                                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if(!empty($nomineeDetails) && isset($nomineeDetails['intermediaryvattobeapplied'])) {{ title_case($nomineeDetails['intermediaryvattobeapplied'])}}  @endif</div>
                                                    </div>
                                                </div>

                                                <p class="mt-3">* The on-going adviser charge will be applied monthly in arrears on the overall portfolio value</p>
                                                <p>** Any agreed initial charges on investments should be entered here and will be applied automatically to new investments. Ad hoc fees and charges can also be facilitated on each individual investment on instructions the specific investment application form.</p>

                                                <p class="mb-1">Please see the below notes for further information for adviser charge requests:</p>
                                                <ol>
                                                    <li>All charges entered on this form will be stored on our system and will be used to validate all charge requests made by you or set up on your behalf.</li>
                                                    <li>Ad hoc charges must be requested by completing an ad hoc advisor charge form, or via written request signed by the client.</li>
                                                    <li>Where VAT has been selected, it will be applied on top of the charge calculations.</li>
                                                    <li>In signing this form, you confirm that the stated adviser is an authorised third party. GrowthInvest will send copies of relevant information, and accept reasonable instruction from your authorised adviser unless instructed otherwise in writing.</li>
                                                </ol>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /SECTION 4.2: ADVISER DETAILS & CHARGES (IF APPLICABLE) -->
                                    <!-- /collapse -->
                                </div>
                            </div>
                        </div>
                        <!-- /SECTION 4: FEES & CHARGES -->
                        
                        <!-- SECTION 5: CLIENT DECLARATION & DATA PROTECTION -->
                        <div class="card ia-card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapse5" role="button" class="collapsed">
                                    <span class="px-0 col-md-10 col-8">
                                        SECTION 5: CLIENT DECLARATION & DATA PROTECTION
                                        <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                                    </span>

                                    <span class="text-md-right text-center px-0 col-md-2 col-4">
                                        <small class="mr-sm-3 mr-0 d-block d-md-inline-block section5-status">{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][5])) ? ucfirst($nomineeDetails['section_status'][5]) : 'Incomplete'  }}</small>
                                        <i class="fa fa-lg fa-plus-square-o"></i>
                                        <i class="fa fa-lg fa-minus-square-o"></i>
                                        <input type="hidden" name="section_status[5]" class="section5-status-input sectionstatus-input" value="{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][5])) ? $nomineeDetails['section_status'][5] : 'incomplete'  }}">
                                    </span>
                                </a>
                            </div>

                            <div id="collapse5" class="collapse parent-tabpanel" role="tabpanel" data-section='5'>
                                <div class="card-body">
                                    <p>Please carefully read and acknowledge both of the statements below</p>

                                    <!-- collapse -->
                                    <div class="card">
                                        <div class="card-header" role="tab" id="headingOne">
                                            <a data-toggle="collapse" href="#collapse5-1" role="button" class="collapsed">
                                              SECTION 5.1: CLIENT DECLARATION
                                              <i class="fa fa-lg fa-plus-square-o"></i>
                                              <i class="fa fa-lg fa-minus-square-o"></i>
                                            </a>
                                        </div>

                                        <div id="collapse5-1" class="collapse " role="tabpanel" >
                                            <div class="card-body">
                                                <p>Before signing this declaration you should read the GrowthInvest Terms & Conditions, the GrowthInvest Charges document and Investment Agreement carefully. These documents give you important information about your GrowthInvest Account and form the basis of the contract between you and GrowthInvest. If there is anything that you do not understand, you should contact your Financial Adviser or any member of the GrowthInvest Team*. As part of this document you will automatically open a Platform One account for asset custody purposes.</p>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <ol>
                                                            <li>I/we wish to open an Account with GrowthInvest in accordance with the published Terms and Conditions, Investor Agrement and the GrowthInvest Platform Charges, which I/we acknowledge having received and to which I/we agree to be bound and any subsequent amendments which Platform One and GrowthInvest may inform me/us of from time to time.</li>
                                                            <li>I/we acknowledge that neither GrowthInvest nor Platform One are providing investment, legal, financial, tax or other advice and that any tax information provided is in the context of an investment into the Platform.</li>
                                                            <li>I/we confirm the my/our Financial Adviser has authorisation to deduct their charges as detailed in section 4. I/we understand that on cancellation or closure of the account, Platform One will not refund these Adviser Charges. I/we will need to negotiate with my/our Financial Adviser about refunding any of these Adviser Charges.</li>
                                                            <li>I/We confirm that the bank account details given in Section 3 are those of my/our bank account and that I/we have given my/our Financial Adviser instruction to use this account for cash withdrawals.</li>
                                                            <li>I/We declare that this application has been completed to the best of my knowledge and belief.</li>
                                                            <li>I/We confirm that the information contained within this application form is true and correct. I/We agree to notify you immediately in the event that the information I/we have provided changes.</li>
                                                            <li>I/we have read and understood the GrowthInvest Platform Charges.</li>
                                                        </ol>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <ol>
                                                            <li value="8">I/we confirm that I/we have categorised myself/ourselves on GrowthInvest, or have done so with my/our Financial Adviser and selected ‘advised Client’. I/We understand therefore that:
                                                            <ul style="list-style-type: upper-alpha;">
                                                                <li>I/we can receive financial promotions that may not have been approved by a person authorised by the Financial Conduct Authority.</li>
                                                                <li>The content of such financial promotions may not conform to rules issued by the financial Conduct Authority.</li>
                                                                <li>I/we may have no right to seek compensation from the Financial Services Compensation Scheme.</li>
                                                                <li>I/we may have no right to complain to either the Financial Conduct Authority or the Financial Ombudsman Scheme.</li>
                                                            </ul>
                                                            </li>
                                                            <li value="9">I am/We are aware that it is open to me/us to seek advice from someone who specialises in advising on investments.</li>
                                                            <li value="10">I/We understand that I/we have the right to re-register the SEIS/EIS shares into my own name at any time after the shares have been issued. However they will no longer appear in my Platform One portfolio.</li>
                                                            <li value="11">I am/We are over age 18 and a UK resident. If I/we cease to be a UK resident I/we will advise GrowthInvest in writing within 30 days.</li>
                                                        </ol>
                                                    </div>
                                                </div>

                                                <p>*GrowthInvest is unable to provide advice, unless you register as a Professional Client</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" role="tab" id="headingOne">
                                            <a data-toggle="collapse" href="#collapse5-2" role="button" class="collapsed">
                                              SECTION 5.2: DATA PROTECTION
                                              <i class="fa fa-lg fa-plus-square-o"></i>
                                              <i class="fa fa-lg fa-minus-square-o"></i>
                                            </a>
                                        </div>

                                        <div id="collapse5-2" class="collapse" role="tabpanel" >
                                            <div class="card-body">
                                                <p>Platform One and GrowthInvest will treat the information supplied on this form, along with information we obtain from other sources, as confidential and solely for administering your investments. In doing so Platform One may use external agents, custodians and outsourced administrators to provide some of the services necessary to run your portfolios and shall ensure that such external agents, custodians and outsourced administrators are also obliged to treat this information as confidential.</p>

                                                <p>This information may also be passed to our regulator, auditors, legal and financial advisers, other financial institutions connected with the provision of your investments (e.g. fund managers), authorised agents, third party service providers, authorised law enforcement agencies and local authorities. However, your personal information will not be passed to any other external parties unless we have your permission to do so or we are under a legal obligation or have a duty to do so.</p>

                                                <p>To ensure the efficient running of your investments, we may share the information provided by you with other data processors acting on our behalf and who may be outside the European Economic Area. In this event we are bound by our obligations under the Data Protection Act to ensure your information is adequately protected.</p>

                                                <p>If you provide us with information about other investors, you confirm that they have appointed you to act for them to consent to the processing of their personal data and that you have informed them of our identity and the purposes (as set out above) for which their personal data will be processed.</p>

                                                <p>We will carry out an identity authentication check to verify your identity. This may involve checking the details you supply against those held on databases that may be accessed by the reputable third party company that carries out checks on our behalf. This includes information from the Electoral Register and fraud prevention agencies. We will use scoring methods to verify your identity. A record of this search will be kept and may be used to help other companies to verify your identity. We may also pass information to other organisations involved in the prevention of fraud and money laundering, to protect ourselves and our customers from fraud and theft. If false or inaccurate information is provided or fraud is suspected, this will be recorded and may be shared with other organisations.</p>

                                                <p>Under the terms of the Data Protection Act 2003, you are entitled to ask for a copy of the information we hold on you. A fee may be charged for this service. In addition, if any of the information we hold on you is inaccurate or incorrect, please let us know and we will correct it. Requests should be made in writing to: GrowthInvest, Candlewick House, 120 Cannon St, London EC4N 6A.</p>


                                                <div>
                                                    <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input completion_status checked-input-status disabledInput"  @if($mode=='view') disabled @endif id="agreeclientdeclarationch2" name="agreeclientdeclaration" value="1" @if(!empty($nomineeDetails) && isset($nomineeDetails['agreeclientdeclaration']) && $nomineeDetails['agreeclientdeclaration'] =='1') checked @endif>
                                                      <label class="custom-control-label" for="agreeclientdeclarationch2">Please Tick here to confirm and agree with the Client Declaration and the Data Protection Policy</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /collapse -->
                                </div>
                            </div>
                        </div>
                        <!-- /SECTION 5: CLIENT DECLARATION & DATA PROTECTION -->

                        <!-- SECTION 6: CONFIRMATION OF VERIFICATION OF IDENTITY -->
                        <div class="card ia-card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapse6" role="button" class="collapsed">
                                    <span class="px-0 col-md-10 col-8">
                                        SECTION 6: CONFIRMATION OF VERIFICATION OF IDENTITY
                                        <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                                    </span>

                                    <span class="text-md-right text-center px-0 col-md-2 col-4">
                                        <small class="mr-sm-3 mr-0 d-block d-md-inline-block section6-status">{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][6])) ? ucfirst($nomineeDetails['section_status'][6]) : 'Not started'  }}</small>
                                        <i class="fa fa-lg fa-plus-square-o"></i>
                                        <i class="fa fa-lg fa-minus-square-o"></i>
                                        <input type="hidden" name="section_status[6]" class="section6-status-input sectionstatus-input" value="{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][6])) ? $nomineeDetails['section_status'][6] : 'incomplete'  }}">
                                    </span>
                                </a>
                            </div>

                            <div id="collapse6" class="collapse parent-tabpanel" role="tabpanel" data-section='6'>
                                <div class="card-body">
                                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))
                                    <p>
                                      Please read the following statements and, if you wish to confirm and proceed, please then select one of the two options regarding identity verification
                                      <ol>
                                        <li> I have obtained evidence to verify the identity of my client(s), which meets the standard evidence criteria set out within the guidance for the UK Financial Sector issued by the Joint Money Laundering Steering Group.</li>
                                        <li> I understand and agree that GrowthInvest and Platform One are reliant on me having completed this money laundering check. I also agree to provide you with copies of the ID relied upon should that be required for legal and compliance audit purposes and agree that Growthinvest and Platform One may need to carry out a further risk assessment should my client not be physically present for identification purposes and that Platform One will apply enhanced due diligence checks for politically checks against the HMRC sanctions list.</li>
                                        <li> I confirm that the investor is a customer of our firm and we have assessed the investment suitability for the Applicant.</li>
                                      </ul>
                                     </p>


                                      <div class="text-info" ><i class="fa  fa-exclamation-circle" ></i> Please tick one of the boxes below to indicate Know Your Customer & Anti-Money Laundering preferences </div>
                                      <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checked-input-status completion_status complete-pending-evidence-input disabledInput" id="complete_pending_evidence" @if($mode=='view') disabled @endif name="nomineeverification" value="complete_pending_evidence" @if(!empty($nomineeDetails) && $idVerificationStatus =='complete_pending_evidence') checked @endif  data-text="Complete Pending Evidence" >
                                            <label class="custom-control-label normal" for="complete_pending_evidence">  I/We have obtained evidence that meets the standard requirements which are defined withing the guidance for the UK financial Sector issued by the JMLSG.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input disabledInput" id="yeshappy2" @if($mode=='view') disabled @endif name="nomverificationwithoutface" value="yes"  @if(!empty($nomineeDetails) && isset($nomineeDetails['nomverificationwithoutface']) && $nomineeDetails['nomverificationwithoutface'] =='yes') checked @endif>
                                            <label class="custom-control-label normal" for="yeshappy2">Please tick this box if your client's identity was verified without face to face contact. </label>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checked-input-status completion_status requested-input disabledInput" id="requested" @if($mode=='view') disabled @endif name="nomineeverification" value="requested" @if(!empty($nomineeDetails) && $idVerificationStatus =='requested') checked @endif  data-text="Requested">
                                            <label class="custom-control-label normal" for="requested">  Please tick this box if like your client's identity to be verified via GrowthInvest partner, Onfido.com KYC/AML. </label>
                                        </div>
                                    </div> 

                                    @else
                                    <p>Once all the necessary details have been completed, in order to set up a full, investor account with GrowthInvest, we need to do final verification of your identity. To do this, we use our GrowthInvest partner <a href="https://www.onfido.com/" target="_blank">onfido.com</a></p>

                                    <p>Please confirm that you wish for us to proceed with this final verification, and move onto next phase</p>

                                    <p class="mb-1">Please provide details below of the amount you will be transferring to your Investment Account.</p>
                                    <div class="form-group">
                                        <div>
                                            <div class="custom-control custom-radio">
                                              <input type="radio" id="yes" name="nomineeverification" value="requested" class="checked-input-status completion_status custom-control-input" @if(!empty($nomineeDetails) && $idVerificationStatus =='requested') checked @endif data-text="Requested">
                                              <label class="custom-control-label" for="yes">Request Identity and anti-money laundering checks</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                              <input type="radio" id="no" name="rnomineeverification" value="complete_pending_evidence" class="checked-input-status completion_status custom-control-input" @if(!empty($nomineeDetails) && $idVerificationStatus =='complete_pending_evidence') checked @endif @if(empty($nomineeDetails)) checked @endif data-text="Complete Pending Evidence">
                                              <label class="custom-control-label" for="no">I have already completed the KYC and AML checks through an FCA regulated person and will provide a copy of this.</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @php
                                    $vStatus = 'Not Yet Requested';

                                    if(!empty($nomineeDetails) && $idVerificationStatus =='requested'){
                                        $vStatus = 'Requested';
                                    }
                                    elseif(!empty($nomineeDetails) && $idVerificationStatus =='complete_pending_evidence'){
                                        $vStatus = 'Complete Pending Evidence';
                                    }
 
                                    @endphp
                                    <div class="form-group">
                                    <label for="">Status</label>
                                    <input type="text" readonly class="form-control edit_element completion_status" name="verdisplaystatus" value="{{ $vStatus }}"  id="verdisplaystatus" value=""  >
                                  </div>
                                </div>
                            </div>
                        </div>
                        <!-- /SECTION 6: CONFIRMATION OF VERIFICATION OF IDENTITY -->
                        
                        <!-- SECTION 7: TRANSFER DETAILS -->
                        <div class="card ia-card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" href="#collapse7" role="button" class="collapsed">
                                    <span class="px-0 col-md-10 col-8">
                                        SECTION 7: TRANSFER DETAILS
                                        <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                                    </span>

                                    <span class="text-md-right text-center px-0 col-md-2 col-4">
                                        <small class="mr-sm-3 mr-0 d-block d-md-inline-block section7-status">{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][7])) ? ucfirst($nomineeDetails['section_status'][7]) : 'Incomplete'  }}</small>
                                        <i class="fa fa-lg fa-plus-square-o"></i>
                                        <i class="fa fa-lg fa-minus-square-o"></i>
                                        <input type="hidden" name="section_status[7]" class="section7-status-input sectionstatus-input" value="{{ (!empty($nomineeDetails) && isset($nomineeDetails['section_status'][7])) ? $nomineeDetails['section_status'][7] : 'incomplete'  }}">
                                    </span>
                                </a>
                            </div>

                            <div id="collapse7" class="collapse parent-tabpanel" role="tabpanel" data-section='7'>
                                <div class="card-body">
                                    <p class="mb-1">Please provide details below of the amount you will be transferring to your Investment Account.</p>

                                    <div class="form-group">
                                        <div class="editmode @if($mode=='view') d-none @endif">
                                            <div class="custom-control custom-radio">
                                              <input type="radio" id="transfer_at_later_stage_no" name="transfer_at_later_stage" class="custom-control-input completion_status"  value="no" @if(!empty($nomineeDetails) && isset($nomineeDetails['transfer_at_later_stage']) && $nomineeDetails['transfer_at_later_stage'] =='no') checked @endif >
                                              <label class="custom-control-label" for="transfer_at_later_stage_no">I will transfer funds immediately and provide details below</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                              <input type="radio" id="transfer_at_later_stage_yes" name="transfer_at_later_stage" class="custom-control-input completion_status text-input-status" value="yes"  @if(!empty($nomineeDetails) && isset($nomineeDetails['transfer_at_later_stage']) && $nomineeDetails['transfer_at_later_stage'] =='yes') checked @endif >
                                              <label class="custom-control-label" for="transfer_at_later_stage_yes"> I will transfer funds at a later stage</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="mb-0">Transfer: </h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label mt-4">Bank Transfer <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <div class="col-sm-8">
                                                    @php
                                                    $dataParsley = '';
                                                    $completionClasses = '';
                                                    $readonlyInp = '';
                                                    if(!empty($nomineeDetails) && (isset($nomineeDetails['transfer_at_later_stage']) && $nomineeDetails['transfer_at_later_stage'] =='no')){
                                                        $dataParsley = 'data-parsley-required';
                                                        $completionClasses = 'completion_status text-input-status';
                                                    }

                                                    if(!empty($nomineeDetails) && (isset($nomineeDetails['transfer_at_later_stage']) && $nomineeDetails['transfer_at_later_stage'] =='yes')){
                                                        $readonlyInp = 'readonly';
                                                    }

                                                    if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntcheq']) && $nomineeDetails['subscriptioninvamntcheq']!=''){
                                                        $dataParsley = '';
                                                        $completionClasses = '';
                                                    }

                                                    @endphp

                                                    <label for="">Deposit Amount</label>
                                                    <input type="text" {{ $readonlyInp }} class="form-control bank-input  {{ $completionClasses }} editmode @if($mode=='view') d-none @endif" id="" name="subscriptioninvamntbank" placeholder="" {{ $dataParsley }} data-parsley-required-message="Please enter the deposite amount." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntbank'])){{ $nomineeDetails['subscriptioninvamntbank'] }}@endif" @if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntcheq']) && $nomineeDetails['subscriptioninvamntcheq']!='') readonly @endif>
                                                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntbank'])){{ $nomineeDetails['subscriptioninvamntbank'] }}@endif</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Expected Date of Bank Transfer</label>
                                                <input type="text" {{ $readonlyInp }} class="form-control datepicker bank-input text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="subscriptiontransferdate" placeholder="" value="@if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptiontransferdate'])){{ $nomineeDetails['subscriptiontransferdate'] }}@endif">
                                                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptiontransferdate'])){{ $nomineeDetails['subscriptiontransferdate'] }}@endif</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Cheque <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <div class="col-sm-8">
                                                    @php
                                                    $dataParsley = '';
                                                    $completionClasses = '';
                                                    if(!empty($nomineeDetails) && (isset($nomineeDetails['transfer_at_later_stage']) && $nomineeDetails['transfer_at_later_stage'] =='no')){
                                                        $dataParsley = 'data-parsley-required';
                                                        $completionClasses = 'completion_status text-input-status';
                                                    }

                                                    if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntbank']) && $nomineeDetails['subscriptioninvamntbank']!=''){
                                                        $dataParsley = '';
                                                        $completionClasses = '';
                                                    }

                                                    

                                                    @endphp
                                                    <input type="number" {{ $readonlyInp }} name="subscriptioninvamntcheq" class="form-control bank-input {{ $completionClasses }} editmode @if($mode=='view') d-none @endif" id="" placeholder=""  {{ $dataParsley }} data-parsley-required-message="Please enter the cheque." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntcheq'])){{ $nomineeDetails['subscriptioninvamntcheq'] }}@endif" @if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntbank']) && $nomineeDetails['subscriptioninvamntbank']!='') readonly @endif>
                                                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptioninvamntcheq'])){{ $nomineeDetails['subscriptioninvamntcheq'] }}@endif</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="mt-3">P1 GrowthInvest Bank Account Details:</h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Bank Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control editmode @if($mode=='view') d-none @endif" name="subscriptionbankname" id="" placeholder="" value="HSBC">
                                                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> HSBC</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Sort Code</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control editmode @if($mode=='view') d-none @endif" name="subscriptionsortcode" id="" placeholder="" value="401307">
                                                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">401307</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Account Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control editmode @if($mode=='view') d-none @endif" id="" name="subscriptionaccountname" placeholder="" value="P1 GrowthInvest">
                                                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">P1 GrowthInvest</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Account No.</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control editmode @if($mode=='view') d-none @endif" name="subscriptionaccountno" id="" placeholder="" value="93671402">
                                                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> 93671402</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Reference: <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" {{ $readonlyInp }} class="form-control completion_status text-input-status bank-input editmode @if($mode=='view') d-none @endif" id="" name="subscriptionreffnamelname" placeholder="" @if(!empty($nomineeDetails) && isset($nomineeDetails['transfer_at_later_stage']) && $nomineeDetails['transfer_at_later_stage'] =='no') data-parsley-required @endif data-parsley-required-message="Please enter the reference." value="@if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptionreffnamelname'])){{ $nomineeDetails['subscriptionreffnamelname'] }}@endif">
                                                    
                                                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if(!empty($nomineeDetails) && isset($nomineeDetails['subscriptionreffnamelname'])){{ $nomineeDetails['subscriptionreffnamelname'] }}@endif</div>
                                                    <small class="form-text text-muted">First and Last Name</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                        <!-- /SECTION 7: TRANSFER DETAILS -->


                    </div>
                    <!-- /collapse -->

                    <hr>
                    <div class="d-md-flex justify-content-md-between align-items-md-start">
                        <p class="mb-0">
                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))
                        If your client needs to return to the Investment Account form at a later stage
                    @else
                        If you need to return to the Investment Account form at a later stage   
                    @endif
                    , please use the Save button  to save all current details until you are ready to submit for online signature or download the form.</p>
                        <button type="submit" class="btn btn-primary editmode @if($mode=='view') d-none @endif save-nominee validate-nominee-data" >Save</button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="send_signature">
                <input type="hidden" name="gi_code" value="{{ $investor->gi_code }}">
                    </div>
                     </form>
                    <hr>

                    <p>Thank you for providing the final information required to open your GrowthInvest Investment Account.</p>
                    <p>This will now be reviewed by our Client Services team and we will quickly get back to you with any questions or queries, before confirming that your account is open and ready to make investments.</p>
                    <p>If you have submitted the form you should shortly receive an email with a link to an online form supplied by our partners Adobe Sign. Please follow the simple instructions to complete and sign the form online. If you would prefer to complete and sign offline, please download the prepopulated form using the Download button.</p>

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/additional-information')}}"  class="btn btn-outline-primary mt-4"><i class="fa fa-angle-double-left"></i> Prev</a>
                        </div>
                        <div>
                            @if($isUsPerson !="")
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/download-investor-nominee')}}" target="_blank"  class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
                            @endif

                            @php
                            
                            $disableSubmit = '';
                            if(isset($nomineeDetails['section_status']) && !empty($nomineeDetails['section_status']) && in_array('incomplete',$nomineeDetails['section_status'])){
                                $disableSubmit = 'disabled';
                            }
                            
                            if($adobeDocKey != '')
                            {
                                $disableSubmit = 'disabled';
                            }

                            if(empty($nomineeDetails))
                            {
                                $disableSubmit = 'disabled';
                            }
                            @endphp
                            <button type="button" class="btn btn-primary editmode @if($mode=='view') d-none @endif submit-signature validate-nominee-data" {{ $disableSubmit }} doc-key-exist="{{ ($adobeDocKey != '')? 'yes' : 'no' }}"  @if($adobeDocKey != '')  data-toggle="tooltip"  title="Nominee Application is already sent for signature" data-original-title="Nominee Application is already sent for signature" @endif ><i class="fa fa-send"></i> Submit</button>
                        </div>
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



    <style type="text/css">
        #datatable-investors_filter{
            display: none;
        }
    </style>

@endsection


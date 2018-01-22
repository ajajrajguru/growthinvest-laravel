@extends('layouts.backoffice')

@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section('backoffice-content')

<div class="container">

        @php
            echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
        @endphp

        @include('includes.notification')

        <div class="mt-4 bg-white border border-gray p-4">
        <h1 class="section-title font-weight-medium text-primary mb-0">Add Investor</h1>
        <p class="text-muted">Register a new client on the platform.</p>



        <ul class="progress-indicator my-5">
            <li class="active">
                <a href="javascript:void(0)">Registartion</a>
                <span class="bubble"></span>
            </li>
            <li>
                <a href="{{ ($investor->id) ? url('backoffice/investor/'.$investor->gi_code.'/client-categorisation'): 'javascript:void(0)'}}">Client Categorisation</a>
                <span class="bubble"></span>
            </li>
            <li>
                <a href="{{ ($investor->id) ? url('backoffice/investor/'.$investor->gi_code.'/additional-information'): 'javascript:void(0)'}}">Additional Information</a>
                <span class="bubble"></span>
            </li>
            <li>
                <a href="{{ ($investor->id) ? url('backoffice/investor/'.$investor->gi_code.'/investment-account'): 'javascript:void(0)'}}">Investment Account</a>
                <span class="bubble"></span>
            </li>
        </ul>

        <div class="profile-content px-md-4 px-sm-0">
            <div class="row">
                <div class="col-6">
                    <h6 class="mt-0">1: <i class="fa fa-pencil brand-text"></i><span class="text-primary"> Client Registration</span></h6>
                </div>
                <div class="col-6">
                @if($investor->id)
                    <a href="javascript:void(0)" class="btn btn-primary editUserBtn">Edit Details</a>
                    <a href="javascript:void(0)" class="btn btn-primary d-none cancelUpdateBtn">Cancel Updates</a>
                @endif
                </div>
            </div>


            <hr class="my-3">

            <form method="post" action="{{ url('backoffice/investor/save-registration') }}" data-parsley-validate name="add-investor-reg" id="add-investor-reg" enctype="multipart/form-data">


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Title  </label>
                            <select name="title" id="user-title" class="form-control editmode @if($mode=='view') d-none @endif">                                
                                <option value="">Select</option>                                                                                                    
                                <option value="mr">Mr</option>                                                                                            
                                <option value="mrs">Mrs</option>                                                                                           
                                <option value="miss">Miss</option>                                                                                           
                                 <option value="ms">Ms</option>                                                                
                             </select>
                             
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->first_name}}</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>First Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="first_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the first name." placeholder="Eg. John" value="{{ ($investor->id) ? $investor->first_name :old('first_name')}}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->first_name}}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="last_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the last name." placeholder="Eg. Smith" value="{{ ($investor->id) ? $investor->last_name :old('last_name') }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->last_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Address <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="email" name="email" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-type="email" data-parsley-required data-parsley-required-message="Please enter email." placeholder="Eg. john_smith@mailinator.com" value="{{ ($investor->id) ? $investor->email :old('email')}}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->email}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telephone Number <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="tel" name="telephone" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter telephone." data-parsley-type="number" placeholder="Eg: 020 7071 3945" value="{{ ($investor->id) ? $investor->telephone_no :old('telephone') }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->telephone_no}}</span>
                        </div>
                    </div>
                </div>

                @if($investor->id)
                <div class="row editmode @if($mode=='view') d-none @endif">
                    <div class="col-md-12">
                        <a id="change_pwd" href="javascript:void(0)"><i class="fa fa-unlock-alt"></i> Set password</a>
                        <a id="cancel_pwd" href="javascript:void(0)"  class="d-none btn-link">Cancel</a>
                    </div>
                </div>
                @endif
                <div class="row setpassword-cont @if($investor->id) d-none @endif">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Password <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="password" name="password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-pattern="/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{6,99}$/" data-parsley-pattern-message="The password does not meet the minimum requirements!" id="userpassword" @if(!$investor->id) data-parsley-required data-parsley-required-message="Please enter password." @endif placeholder="" data-toggle="popover" data-html="true" data-trigger="focus" data-placement="bottom" data-content="<ul class='pwd-rules clearfix'> <li>PASSWORD RULES</li> <li>At least 6 characters</li> <li>At least 1 x letter</li> <li>At least 1 x number</li> </ul>"  data-original-title="" >

                            <span class="viewmode @if($mode=='edit') d-none @endif"> </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="password" name="confirm_password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-equalto="#userpassword" @if(!$investor->id) data-parsley-required data-parsley-required-message="Please enter confirm password." @endif placeholder="">
                            <span class="viewmode @if($mode=='edit') d-none @endif"> </span>
                        </div>
                    </div>
                </div>
 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 1 </label>
                            <input type="text" name="address_line_1" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investor->address_1 :old('address_line_1') }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->address_1}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 2 </label>
                            <input type="text" name="address_line_2" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investor->address_2 :old('address_line_2') }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->address_2}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Town/City</label>
                            <input type="text" name="town_city" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investor->city :old('town_city')  }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->city}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>County</label>{{ old('county') }}
                            <select class="form-control editmode @if($mode=='view') d-none @endif" name="county">
                                <option value="">Please Select</option>
                                @php
                                $countyName = '';
                                @endphp
                                @foreach($countyList as $county)
                                    @php
                                    $selected = '';
                                    if($investor->county == $county){
                                        $countyName = $county;
                                        $selected = 'selected';
                                    }

                                    if(!$investor->id && old('county') == $county)
                                        $selected = 'selected';

                                    @endphp
                                    <option value="{{ $county }}" {{ $selected }}>{{ $county }}</option>
                                @endforeach
                            </select>
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $countyName}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Postcode <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="postcode" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" data-parsley-required data-parsley-required-message="Please enter postcode." value="{{ ($investor->id) ? $investor->postcode :old('postcode')  }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->postcode}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control editmode @if($mode=='view') d-none @endif" name="country">
                                <option value="">Please Select</option>
                                @php
                                $countryName = '';
                                @endphp
                                @foreach($countryList as $code=>$country)
                                    @php
                                    $selected = '';
                                    if($investor->country == $code){
                                        $countryName = $country;
                                        $selected = 'selected';
                                    }

                                    if(!$investor->id && old('country') == $code)
                                        $selected = 'selected';

                                    @endphp
                                    <option value="{{ $code }}" {{ $selected }}>{{ $country }}</option>
                                @endforeach
                            </select>
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $countryName }}</span>
                        </div>
                    </div>
                </div>
 
                <div class="row">
             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Firm <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <select class="form-control editmode @if($mode=='view') d-none @endif" name="firm" data-parsley-required data-parsley-required-message="Please select the firm.">
                                <option value="">Please Select</option>
                                @php
                                $firmName = '';
                                $firmGICode = '';
                                @endphp
                                @foreach($firms as $firm)
                                    @php
                                    $selected = '';
                                    if($investor->firm_id == $firm->id){
                                        $firmName = $firm->name;
                                        $firmGICode = $firm->gi_code;
                                        $selected = 'selected';
                                    }

                                    if(!$investor->id && old('firm') == $firm->id)
                                        $selected = 'selected';


                                    @endphp
                                <option value="{{ $firm->id }}" {{ $selected }}>{{ $firm->name }}</option>
                                @endforeach
                            </select>
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $firmName }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Client Investment Account Number</label>
                            <input type="text" name="investment_account_number" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investor->city :old('investment_account_number')  }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->city}}</span>
                        </div>
                    </div>
                </div>

                @if($investor->id && $investor->firm_id)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Platform Account Number</label>
                               {{ $firmGICode }}


                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
                @endif

                <div class="row">
                    @if($investor->id)
                     <div class="col-md-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input editmode @if($mode=='view') d-none @endif" name="is_suspended" @if($investor->suspended) checked @endif @if(!$investor->id && old('is_suspended')=='on') checked @endif placeholder="">
                            <label class="form-check-label">Suspended</label>
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ ($investor->suspended) ?  'Yes' : 'No' }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-12">
                        @if(!$investor->id)
                        <div class="g-recaptcha" data-sitekey="{{ env('captcha_site_key') }}"></div>
                        @endif
                    </div>
                </div>


          

                <button type="submit" class="btn btn-primary mt-3 editmode @if($mode=='view') d-none @endif">Save</button>
                @if($investor->id)
                <a href="{{ url('backoffice/user/'.$investor->gi_code.'/step-two')}}" class="btn btn-primary mt-3 ">Next</a>
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="gi_code" value="{{ $investor->gi_code }}">
            </form>
        </div>
    </div>
    </div>

    <style type="text/css">
        #datatable-users_filter{
            display: none;
        }
    </style>

@endsection


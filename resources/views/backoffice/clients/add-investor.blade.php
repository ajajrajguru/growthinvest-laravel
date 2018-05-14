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
    @include('includes.notification')

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
            <div class="border border-transparent border-2 bg-gray p-3 mb-4">
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
        <li class="active">
            <a href="javascript:void(0)">Registration</a>
            <span class="bubble"></span>
        </li>
        <li >
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
</div>

<div class="profile-content p-4">
    <div class="text-right">
        @if($investor->id)
            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/client-categorisation')}}" class="btn btn-primary mb-4">Next<i class="fa fa-angle-double-right"></i></a> 
        @endif
    </div>

    <div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-3">
        <h5 class="mt-0 mb-0">
            1: <i class="fa fa-pencil text-primary"> </i> <span class="text-primary">  Client Registration</span>
        </h5>
        <div class="">
            @if($investor->id)
                <a href="javascript:void(0)" class="btn btn-sm btn-primary editUserBtn">Edit Details</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-outline-danger d-none cancelUpdateBtn">Cancel Updates</a>

            <!-- <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/client-categorisation')}}" class="btn btn-primary mb-4">Next<i class="fa fa-angle-double-right"></i></a>  -->
            @endif
        </div>
    </div>
    <hr class="my-3">
    
   

    <form method="post" action="{{ url('backoffice/investor/save-registration') }}" data-parsley-validate name="add-investor-reg" id="add-investor-reg" enctype="multipart/form-data">


<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Title  </label>
            <select name="title" id="user-title" class="form-control editmode @if($mode=='view') d-none @endif" >    

                <option value="">Select</option>                                                                                                    
                <option value="mr" @if(!$investor->id && old('title') == "mr") selected @endif @if($investor->id && $investor->title == "mr") selected @endif >Mr</option>                                                                                            
                <option value="mrs" @if(!$investor->id && old('title') == "mrs") selected @endif @if($investor->id && $investor->title == "mrs") selected @endif>Mrs</option>                                                                                           
                <option value="miss" @if(!$investor->id && old('title') == "miss") selected @endif @if($investor->id && $investor->title == "miss") selected @endif>Miss</option>                                                                                           
                 <option value="ms" @if(!$investor->id && old('title') == "ms") selected @endif @if($investor->id && $investor->title == "ms") selected @endif>Ms</option>                                                                
             </select>
             
            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->first_name}}</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>First Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
            <input type="text" name="first_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the first name." placeholder="Eg. John" value="{{ ($investor->id) ? $investor->first_name :old('first_name')}}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->first_name}}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Last Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
            <input type="text" name="last_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the last name." placeholder="Eg. Smith" value="{{ ($investor->id) ? $investor->last_name :old('last_name') }}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->last_name}}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Email Address <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
            <input type="email" name="email" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-type="email" data-parsley-required data-parsley-required-message="Please enter email." placeholder="Eg. john_smith@mailinator.com" value="{{ ($investor->id) ? $investor->email :old('email')}}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->email}}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Telephone Number <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
            <input type="tel" name="telephone" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter telephone." data-parsley-type="number" data-parsley-minlength="10" data-parsley-minlength-message="The telephone number must be atleast 10 characters long!" placeholder="Eg: 020 7071 3945" value="{{ ($investor->id) ? $investor->telephone_no :old('telephone') }}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->telephone_no}}</div>
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
            <label>Choose Password </label>
            <input type="password" name="password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-pattern="/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{6,99}$/" data-parsley-pattern-message="The password does not meet the minimum requirements." id="userpassword" placeholder="" data-toggle="popover" data-html="true" data-trigger="focus" data-placement="bottom" data-content="<ul class='pwd-rules clearfix'> <li>PASSWORD RULES</li> <li>At least 6 characters</li> <li>At least 1 x letter</li> <li>At least 1 x number</li> </ul>"  data-original-title="" >

            <div class="viewmode @if($mode=='edit') d-none @endif"> </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Confirm Password </label>
            <input type="password" name="confirm_password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-equalto="#userpassword"  placeholder="">
            <div class="viewmode @if($mode=='edit') d-none @endif"> </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Address Line 1 <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
            <input type="text" name="address_line_1" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investor->address_1 :old('address_line_1') }}" data-parsley-required data-parsley-required-message="Please enter the address line 1.">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->address_1}}</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Address Line 2 </label>
            <input type="text" name="address_line_2" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investor->address_2 :old('address_line_2') }}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->address_2}}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Town/City</label>
            <input type="text" name="town_city" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investor->city :old('town_city')  }}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->city}}</div>
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
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $countyName}}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Postcode <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
            <input type="text" name="postcode" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" data-parsley-required data-parsley-required-message="Please enter postcode." value="{{ ($investor->id) ? $investor->postcode :old('postcode')  }}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investor->postcode}}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Country <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
            <select class="form-control editmode @if($mode=='view') d-none @endif" name="country" data-parsley-required data-parsley-required-message="Please select country.">
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
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $countryName }}</div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label>Firm </label>
            <select class="form-control editmode @if($mode=='view') d-none @endif" name="firm" >
                <!-- <option value="">Please Select</option> -->
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
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $firmName }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Client Investment Account Number</label>

            <input type="text" name="investment_account_number" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($investor->id) ? $investmentAccountNumber :old('investment_account_number')  }}">
            <div class="viewmode @if($mode=='edit') d-none @endif">{{ $investmentAccountNumber }}</div>
        </div>
    </div>
</div>

@if($investor->id)
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Platform Account Number</label>
               {{ $investor->gi_code }}


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




<button type="submit" class="btn btn-primary save-btn mt-3 editmode @if($mode=='view') d-none @endif ld-ext-right">Save <div class="ld ld-ring ld-spin"></div></button>
@if($investor->id)
<a href="{{ url('backoffice/investor/'.$investor->gi_code.'/client-categorisation')}}" class="btn btn-primary mt-3 ">Next</a> 
@endif
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="gi_code" value="{{ $investor->gi_code }}">
</form>
</div>
@extends('layouts.frontend')
@section('css')
  @parent
    <link  href="{{ asset('bower_components/cropper/dist/cropper.css') }}" rel="stylesheet">
 
@endsection
@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/frontend.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/cropper/dist/cropper.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/plupload/js/plupload.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/aj-uploads.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        uploadCropImage('profile-picture','pickfiles','user-profile-picture','{{ url("upload-cropper-image") }}');
       
    });
</script> 

@endsection


 
@section('frontend-content')


<div class="container pb-5">

<!-- mobile filter --> 
<div class="mobile-filter-btn rounded-circle pulse d-md-none"> 
    <i class="fa fa-filter"></i> 
</div> 
<!-- /mobile filter -->

 
<!-- tabs -->
<div class="squareline-tabs mt-5">

    @include('frontend.entrepreneur.topmenu')
</div>
<!-- /tabs -->
                 <div class="d-flex justify-content-between">
                        <div class="">
                            
                        </div>
                        <div class="">
                            @if($entrepreneur->id)
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary mb-4 editUserBtn">Edit Details</a>
                                <a href="javascript:void(0)" class="btn btn-outline-danger mb-4 d-none cancelUpdateBtn">Cancel Updates</a>

                            
                            @endif
                             
                        </div>
                    </div>
                   
                    <hr class="my-3">
 
    <form method="post" action="{{ url('user-dashboard/entrepreneur/save-profile') }}" data-parsley-validate name="add-investor-reg" id="add-investor-reg" enctype="multipart/form-data">


                <div class="row">
                    
                    <div class="col-sm-6 text-center">
                        <label>Profile Picture</label>
                        <div class="image" id="profile-picture">
                            <img class="mx-auto d-block img-responsive user-profile-picture" src="{{ $profilePic }}" >
                            <div class="action-btn"> 
                                <button type="button" id="pickfiles" class="btn btn-primary btn-sm mt-2  editmode @if($mode=='view') d-none @endif"><i class="fa fa-camera"></i> Select Image</button>   <a href="javascript:void(0)" class="delete-image @if(!$hasProfilePic) d-none @endif" object-type="App\User" object-id="{{ $entrepreneur->id }}" type="profile_picture" image-class="user-profile-picture"><i class="fa fa-trash text-danger editmode @if($mode=='view') d-none @endif"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="first_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the first name." placeholder="Eg. John" value="{{ ($entrepreneur->id) ? $entrepreneur->first_name :old('first_name')}}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->first_name}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="last_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the last name." placeholder="Eg. Smith" value="{{ ($entrepreneur->id) ? $entrepreneur->last_name :old('last_name') }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->last_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Address <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="email" name="email" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-type="email" data-parsley-required data-parsley-required-message="Please enter email." placeholder="Eg. john_smith@mailinator.com" value="{{ ($entrepreneur->id) ? $entrepreneur->email :old('email')}}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->email}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telephone Number <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="tel" name="telephone" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter telephone." data-parsley-type="number" data-parsley-minlength="10" data-parsley-minlength-message="The telephone number must be atleast 10 characters long!" placeholder="Eg: 020 7071 3945" value="{{ ($entrepreneur->id) ? $entrepreneur->telephone_no :old('telephone') }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->telephone_no}}</span>
                        </div>
                    </div>
                </div>

               

                @if($entrepreneur->id)
                <div class="row editmode @if($mode=='view') d-none @endif">
                    <div class="col-md-12">
                        <a id="change_pwd" href="javascript:void(0)"><i class="fa fa-unlock-alt"></i> Set password</a>
                        <a id="cancel_pwd" href="javascript:void(0)"  class="d-none btn-link">Cancel</a>
                    </div>
                </div>
                @endif
                <div class="row setpassword-cont @if($entrepreneur->id) d-none @endif">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Password </label>
                            <input type="password" name="password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-pattern="/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{6,99}$/" data-parsley-pattern-message="The password does not meet the minimum requirements." id="userpassword" placeholder="" data-toggle="popover" data-html="true" data-trigger="focus" data-placement="bottom" data-content="<ul class='pwd-rules clearfix'> <li>PASSWORD RULES</li> <li>At least 6 characters</li> <li>At least 1 x letter</li> <li>At least 1 x number</li> </ul>"  data-original-title="" >

                            <span class="viewmode @if($mode=='edit') d-none @endif"> </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password </label>
                            <input type="password" name="confirm_password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-equalto="#userpassword"  placeholder="">
                            <span class="viewmode @if($mode=='edit') d-none @endif"> </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="company" class="form-control editmode @if($mode=='view') d-none @endif"   placeholder="" value="{{(!empty($additionalInfo) && isset($additionalInfo['company'])) ? $additionalInfo['company']:''
                        }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{(!empty($additionalInfo) && isset($additionalInfo['company'])) ? $additionalInfo['company']:'' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Website</label>
                            <input type="text" name="website" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg: 020 7071 3945" value="{{(!empty($additionalInfo) && isset($additionalInfo['website'])) ? $additionalInfo['website']:''
                        }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{(!empty($additionalInfo) && isset($additionalInfo['website'])) ? $additionalInfo['website']:''
                        }}</span>
                        </div>
                    </div>
                </div>

 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 1 <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="address_line_1" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($entrepreneur->id) ? $entrepreneur->address_1 :old('address_line_1') }}" data-parsley-required data-parsley-required-message="Please enter the address line 1.">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->address_1}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 2 </label>
                            <input type="text" name="address_line_2" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($entrepreneur->id) ? $entrepreneur->address_2 :old('address_line_2') }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->address_2}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Town/City</label>
                            <input type="text" name="town_city" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($entrepreneur->id) ? $entrepreneur->city :old('town_city')  }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->city}}</span>
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
                                    if($entrepreneur->county == $county){
                                        $countyName = $county;
                                        $selected = 'selected';
                                    }

                                    if(!$entrepreneur->id && old('county') == $county)
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
                            <input type="text" name="postcode" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" data-parsley-required data-parsley-required-message="Please enter postcode." value="{{ ($entrepreneur->id) ? $entrepreneur->postcode :old('postcode')  }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $entrepreneur->postcode}}</span>
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
                                    if($entrepreneur->country == $code){
                                        $countryName = $country;
                                        $selected = 'selected';
                                    }

                                    if(!$entrepreneur->id && old('country') == $code)
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
                                    if($entrepreneur->firm_id == $firm->id){
                                        $firmName = $firm->name;
                                        $firmGICode = $firm->gi_code;
                                        $selected = 'selected';
                                    }

                                    if(!$entrepreneur->id && old('firm') == $firm->id)
                                        $selected = 'selected';


                                    @endphp
                                <option value="{{ $firm->id }}" {{ $selected }}>{{ $firm->name }}</option>
                                @endforeach
                            </select>
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $firmName }}</span>
                        </div>
                    </div> 
                    
                </div>

                @if($entrepreneur->id=='')
                @php $roles = auth()->user()->getRoleNames();
                @endphp 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Custom Email Content </label>
                            <textarea class="form-control" name="customemailcontent">You have been registered as an Entrepreneur on GrowthInvest, the home of quality tax-efficient investment opportunities.  You were registered by  {{ $roles[0]}}, {{auth()->user()->first_name}}{{auth()->user()->first_name}}.&#13;&#10;&#13;&#10;GrowthInvest focuses on helping entrepreneurs gain access to our portfolio of investors, helping create a meeting place. By working with the GrowthInvest  team we will help you find a clear path to funding.&#13;&#10;&#13;&#10;Be sure to complete your profile and carefully read through the profile of any potential investor to make sure that your venture completely matches their preferred investment criteria.&#13;&#10;&#13;&#10;</textarea> 
                            
                        </div>
                    </div>
                </div>
                @endif

                @if($entrepreneur->id)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Platform Account Number</label>
                               {{ $entrepreneur->gi_code }}


                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
                @endif
 

          

                <button type="submit" class="btn btn-primary save-btn mt-3 editmode @if($mode=='view') d-none @endif ld-ext-right">Save <div class="ld ld-ring ld-spin"></div></button>
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="gi_code" value="{{ $entrepreneur->gi_code }}">
            </form>
             

 
</div> <!-- /container -->
 
 
 
@php
$cropModalData = ['objectType'=>'App\User','objectId'=>$entrepreneur->id,'aspectRatio'=>1,'heading'=>'Crop Profile Image','imageClass'=>'user-profile-picture','minContainerWidth' =>450,'minContainerHeight'=>200,'displaySize'=>'medium_1x1','imageType'=>'profile_picture'];
@endphp
{!! View::make('includes.crop-modal')->with($cropModalData)->render() !!}

@include('includes.footer')
@endsection
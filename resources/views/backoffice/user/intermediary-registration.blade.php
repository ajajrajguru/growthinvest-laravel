    <div class="mt-4 bg-white border border-gray p-4">
    @if($mode=='view')
        <h1 class="section-title font-weight-medium text-primary mb-0">
                Edit User
        </h1>
        <p class="text-muted">Edit details of intermediary.</p>
    @else
        <h1 class="section-title font-weight-medium text-primary mb-0">
            Add User
        </h1>
        <p class="text-muted">Add details of intermediary.</p>
    @endif



    <ul class="progress-indicator my-5">
        <li class="active">
            <a href="javascript:void(0)">Intermediary Registration</a>
            <span class="bubble"></span>
        </li>
        <li>
            <a href="{{ ($user->id) ? url('backoffice/user/'.$user->gi_code.'/intermediary-profile'): 'javascript:void(0)'}}">Intermediary Profile</a>
            <span class="bubble"></span>
        </li>
    </ul>

    @if($mode=='view')
    <div class="row no-gutters viewmode @if($mode=='edit') d-none @endif">
        <div class="col-sm-3 p-1 p-md-4 bg-primary">
            <div class="d-flex flex-column justify-content-between p-4">
                <div class="">
                    <h4 class="mt-0 mb-4 text-white">Step 1<br> <span class="font-weight-medium">Intermediary Registration</span></h4>
                </div>
                <div class="">
                @if($user->id)
                    <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm editUserBtn">Edit Details</a>
                @endif
                </div>
            </div>
        </div>
        <div class="col-sm-9 p-4 border border-gray">
            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark"> @if ($user->first_name) {{ $user->first_name}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    <label class="font-weight-medium">First Name</label>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark"> @if ($user->last_name) {{ $user->last_name}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    <label class="font-weight-medium">Last Name</label>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark"> @if ($user->email) {{ $user->email}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    <label class="font-weight-medium">Email Address</label>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark"> @if ($user->telephone_no) {{ $user->telephone_no}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    <label class="font-weight-medium">Telephone Number</label>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    @php
                    if($user->id){
                       $compName =  (isset($userData['company'])) ? $userData['company'] : '';
                    }
                    else{
                        $compName = old('company_name');
                     }
                    @endphp
                    <div class="word-break text-large text-dark"> {{ (isset($userData['company'])) ? $userData['company'] : ''}}</div>
                    <label class="font-weight-medium">Company Name</label>
                </div>
                <div class="col-sm-6 mb-4">
                    @php
                    if($user->id){
                       $compWebsite =  (isset($userData['website'])) ? $userData['website'] : '';
                    }
                    else{
                        $compWebsite = old('company_website');
                     }
                    @endphp
                    <div class="word-break text-large text-dark"> {{ (isset($userData['website'])) ? $userData['website'] : ''}}</div>
                    <label class="font-weight-medium">Company Website</label>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark">@if ($user->address_1) {{ $user->address_1}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">Address Line 1</label>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark">@if ($user->address_2) {{ $user->address_2}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">Address Line 2</label>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark">@if ($user->city) {{ $user->city}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    <label class="font-weight-medium">Town/City</label>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="d-none">
                        @php
                        $countyName = '';
                        @endphp
                        @foreach($countyList as $county)
                            @php
                            $selected = '';
                            if($user->county == $county){
                                $countyName = $county;
                                $selected = 'selected';
                            }

                            if(!$user->id && old('county') == $county)
                                $selected = 'selected';

                            @endphp
                        @endforeach
                    </div>
                    <div class="word-break text-large text-dark">@if ($countyName) {{ $countyName}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">County</label>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark">@if ($user->postcode) {{ $user->postcode}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">Postcode</label>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="d-none">
                        @php
                        $countryName = '';
                        @endphp
                        @foreach($countryList as $code=>$country)
                            @php
                            $selected = '';
                            if($user->country == $code){
                                $countryName = $country;
                                $selected = 'selected';
                            }

                            if(!$user->id && old('country') == $code)
                                $selected = 'selected';

                            @endphp
                        @endforeach
                    </div>
                    <div class="word-break text-large text-dark">@if ($countryName) {{ $countryName}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">Country</label>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    @php
                    if($user->id){
                       $compFcaCode =  (isset($userData['companyfca'])) ? $userData['companyfca'] : '';
                    }
                    else{
                        $compFcaCode = old('company_fca_number');
                     }
                    @endphp
                    <div class="word-break text-large text-dark">{{ (isset($userData['companyfca'])) ? $userData['companyfca'] : ''}} </div>
                    <label class="font-weight-medium">Company FCA number</label>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="d-none">
                        @php
                        $compDescription = '';
                        @endphp
                        @foreach($companyDescription as $description)
                            @php
                            $selected = '';
                            if(isset($userData['typeaccount']) && $userData['typeaccount'] == $description){
                                $compDescription = $description;
                                $selected = 'selected';
                            }

                            if(!$user->id && old('company_description') == $description)
                                $selected = 'selected';

                            @endphp
                        @endforeach
                    </div>
                    <div class="word-break text-large text-dark">@if ($compDescription) {{ $compDescription}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">Company Description</label>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-sm-6 mb-4">
                    <div class="d-none">
                        @php
                        $roleName = '';
                        @endphp
                        @foreach($roles as $role)
                            @php
                            $selected = '';
                            if($user->hasRole($role->name)){
                                $roleName = $role->display_name;
                                $selected = 'selected';
                            }

                            if(!$user->id && old('roles') == $role->name)
                                $selected = 'selected';

                            @endphp
                        @endforeach
                    </div>
                    <div class="word-break text-large text-dark">@if ($roleName) {{ $roleName}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">Role</label>
                </div>
                <div class="col-sm-6 mb-4">
                    <div class="d-none">
                        @php
                        $firmName = '';
                        $firmGICode = '';
                        @endphp
                        @foreach($firms as $firm)
                            @php
                            $selected = '';
                            if($user->firm_id == $firm->id){
                                $firmName = $firm->name;
                                $firmGICode = $firm->gi_code;
                                $selected = 'selected';
                            }

                            if(!$user->id && old('firm') == $firm->id)
                                $selected = 'selected';


                        @endphp
                        @endforeach
                    </div>
                    <div class="word-break text-large text-dark">@if ($firmName) {{ $firmName}} @else <span class="text-muted text-small">N/A</span> @endif  </div>
                    <label class="font-weight-medium">Firm</label>
                </div>
            </div>

            <div class="row align-items-end">
                @if($user->id )
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark">@if ($user->gi_code) {{ $user->gi_code}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    <label class="font-weight-medium">Platform Account Number</label>
                </div>
                @endif
                <div class="col-sm-6 mb-4">
                    <div class="word-break text-large text-dark">{{ ($user->suspended) ?  'Yes' : 'No' }} </div>
                    <label class="font-weight-medium">Suspended</label>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="profile-content px-md-4 px-sm-0 editmode @if($mode=='view') d-none @endif">
        <div class="d-flex justify-content-between">
            <div class="">
                <h5 class="mt-0">Step 1: <span class="text-primary">Intermediary Registration</span></h5>
            </div>
            <div class="">
            @if($user->id)
                <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm d-none cancelUpdateBtn">Cancel Updates</a>
            @endif
            </div>
        </div>


        <hr class="my-3">

        <form method="post" action="{{ url('backoffice/user/save-step-one') }}" data-parsley-validate name="add-user-step1" id="add-user-step1" enctype="multipart/form-data">


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <input type="text" name="first_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the first name." placeholder="Eg. John" value="{{ ($user->id) ? $user->first_name :old('first_name')}}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> @if ($user->first_name) {{ $user->first_name}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <input type="text" name="last_name" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the last name." placeholder="Eg. Smith" value="{{ ($user->id) ? $user->last_name :old('last_name') }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->last_name) {{ $user->last_name}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Address <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <input type="email" name="email" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-type="email" data-parsley-required data-parsley-required-message="Please enter email." placeholder="Eg. john_smith@mailinator.com" value="{{ ($user->id) ? $user->email :old('email')}}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->email) {{ $user->email}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telephone Number <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <input type="tel" name="telephone" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter telephone." data-parsley-type="number" placeholder="Eg: 020 7071 3945" value="{{ ($user->id) ? $user->telephone_no :old('telephone') }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->telephone_no) {{ $user->telephone_no}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>
            </div>

            <div class="row setpassword-cont @if($user->id) d-none @endif">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Choose Password <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <input type="password" name="password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-pattern="/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!@#$%^&*]{6,99}$/" data-parsley-pattern-message="The password does not meet the minimum requirements." id="userpassword" @if(!$user->id) data-parsley-required data-parsley-required-message="Please enter password." @endif placeholder="" data-toggle="popover" data-html="true" data-trigger="focus" data-placement="bottom" data-content="<ul class='pwd-rules clearfix'> <li>PASSWORD RULES</li> <li>At least 6 characters</li> <li>At least 1 x letter</li> <li>At least 1 x number</li> </ul>"  data-original-title="" >

                        <div class="viewmode @if($mode=='edit') d-none @endif"> </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm Password <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <input type="password" name="confirm_password" class="form-control editmode @if($mode=='view') d-none @endif" data-parsley-equalto="#userpassword" @if(!$user->id) data-parsley-required data-parsley-required-message="Please re-enter password." @endif placeholder="">
                        <div class="viewmode @if($mode=='edit') d-none @endif"> </div>
                    </div>
                </div>
            </div>

            @if($user->id)
            <div class="mb-4 editmode @if($mode=='view') d-none @endif">
                <a id="change_pwd" class="btn btn-outline-primary btn-sm" href="javascript:void(0)"><i class="fa fa-unlock-alt"></i> Set password</a>
                <a id="cancel_pwd" href="javascript:void(0)"  class="d-none btn btn-outline-danger btn-sm">Cancel</a>
            </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Name<span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        @php
                        if($user->id){
                           $compName =  (isset($userData['company'])) ? $userData['company'] : '';
                        }
                        else{
                            $compName = old('company_name');
                         }
                        @endphp
                        <input type="text" name="company_name" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" data-parsley-required data-parsley-required-message="Please enter the company name." value="{{ $compName }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">{{ (isset($userData['company'])) ? $userData['company'] : ''}}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Website</label>
                        @php
                        if($user->id){
                           $compWebsite =  (isset($userData['website'])) ? $userData['website'] : '';
                        }
                        else{
                            $compWebsite = old('company_website');
                         }
                        @endphp

                        <input type="text" name="company_website" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" data-parsley-type="url" value="{{ $compWebsite }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">{{ (isset($userData['website'])) ? $userData['website'] : ''}}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="@if($mode=='edit') col-md-12 @endif  @if($mode=='view') col-md-6 @endif">
                    <div class="form-group">
                        <label>Address Line 1 </label>
                        <input type="text" name="address_line_1" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($user->id) ? $user->address_1 :old('address_line_1') }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->address_1) {{ $user->address_1}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>

                <div class="@if($mode=='edit') col-md-12 @endif  @if($mode=='view') col-md-6 @endif">
                    <div class="form-group">
                        <label>Address Line 2 </label>
                        <input type="text" name="address_line_2" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($user->id) ? $user->address_2 :old('address_line_2') }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->address_2) {{ $user->address_2}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Town/City</label>
                        <input type="text" name="town_city" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" value="{{ ($user->id) ? $user->city :old('town_city')  }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->city) {{ $user->city}} @else <span class="text-muted text-small">N/A</span> @endif </div>
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
                                if($user->county == $county){
                                    $countyName = $county;
                                    $selected = 'selected';
                                }

                                if(!$user->id && old('county') == $county)
                                    $selected = 'selected';

                                @endphp
                                <option value="{{ $county }}" {{ $selected }}>{{ $county }}</option>
                            @endforeach
                        </select>
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($countyName) {{ $countyName}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Postcode <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <input type="text" name="postcode" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" data-parsley-required data-parsley-required-message="Please enter postcode." value="{{ ($user->id) ? $user->postcode :old('postcode')  }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->postcode) {{ $user->postcode}} @else <span class="text-muted text-small">N/A</span> @endif </div>
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
                                if($user->country == $code){
                                    $countryName = $country;
                                    $selected = 'selected';
                                }

                                if(!$user->id && old('country') == $code)
                                    $selected = 'selected';

                                @endphp
                                <option value="{{ $code }}" {{ $selected }}>{{ $country }}</option>
                            @endforeach
                        </select>
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($countryName) {{ $countryName}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company FCA number</label>
                        @php
                        if($user->id){
                           $compFcaCode =  (isset($userData['companyfca'])) ? $userData['companyfca'] : '';
                        }
                        else{
                            $compFcaCode = old('company_fca_number');
                         }
                        @endphp

                        <input type="text" class="form-control editmode @if($mode=='view') d-none @endif" name="company_fca_number" placeholder="" value="{{ $compFcaCode }}">
                        <em class="small editmode @if($mode=='view') d-none @endif">FCA number if a regulated UK intermediary firm</em>

                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">{{ (isset($userData['companyfca'])) ? $userData['companyfca'] : ''}}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Description</label>
                        <select class="form-control editmode @if($mode=='view') d-none @endif" name="company_description">
                            <option value="">Please Select</option>
                            @php
                            $compDescription = '';
                            @endphp
                            @foreach($companyDescription as $description)
                                @php
                                $selected = '';
                                if(isset($userData['typeaccount']) && $userData['typeaccount'] == $description){
                                    $compDescription = $description;
                                    $selected = 'selected';
                                }

                                if(!$user->id && old('company_description') == $description)
                                    $selected = 'selected';

                                @endphp
                                <option value="{{ $description }}" {{ $selected }}>{{ $description }}</option>
                            @endforeach
                        </select>
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($compDescription) {{ $compDescription}} @else <span class="text-muted text-small">N/A</span> @endif</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role  <span class="text-danger reqField @if($mode=='view') d-none @endif">*</span></label>
                        <select class="form-control editmode @if($mode=='view') d-none @endif" name="roles" data-parsley-required data-parsley-required-message="Please select role.">
                            <option value="">Please Select</option>
                            @php
                            $roleName = '';
                            @endphp
                            @foreach($roles as $role)
                                @php
                                $selected = '';
                                if($user->hasRole($role->name)){
                                    $roleName = $role->display_name;
                                    $selected = 'selected';
                                }

                                if(!$user->id && old('roles') == $role->name)
                                    $selected = 'selected';

                                @endphp
                            <option value="{{ $role->name }}" {{ $selected }}>{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($roleName) {{ $roleName}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>
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
                                if($user->firm_id == $firm->id){
                                    $firmName = $firm->name;
                                    $firmGICode = $firm->gi_code;
                                    $selected = 'selected';
                                }

                                if(!$user->id && old('firm') == $firm->id)
                                    $selected = 'selected';


                                @endphp
                            <option value="{{ $firm->id }}" {{ $selected }}>{{ $firm->name }}</option>
                            @endforeach
                        </select>
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($firmName) {{ $firmName}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>
            </div>

            @if($user->id )
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Platform Account Number</label>
                           <div class="editmode @if($mode=='view') d-none @endif">{{ $user->gi_code }}</div>
                           <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">@if ($user->gi_code) {{ $user->gi_code}} @else <span class="text-muted text-small">N/A</span> @endif </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="viewmode @if($mode=='edit') d-none @endif">
                        <label>Suspended</label>
                        <div class="form-check-label text-large text-primary">{{ ($user->suspended) ?  'Yes' : 'No' }}</div>
                    </div>

                    <div class="editmode @if($mode=='view') d-none @endif">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input " id="suspendedUser" name="is_suspended" @if($user->suspended) checked @endif @if(!$user->id && old('is_suspended')=='on') checked @endif>
                            <label class="custom-control-label" for="suspendedUser">Suspended</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @if(!$user->id)
                    <div class="g-recaptcha mt-3" data-sitekey="{{ env('captcha_site_key') }}"></div>
                    @endif
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <div>
                    <button type="submit" class="btn btn-primary mt-2 ld-ext-right editmode save-btn @if($mode=='view') d-none @endif">
                        Save <i class="fa fa-check"></i>
                         <div class="ld ld-ring ld-spin"></div>
                    </button>
                </div>
                @if($user->id)
                    <a href="{{ url('backoffice/user/'.$user->gi_code.'/intermediary-profile')}}" class="btn btn-outline-primary mt-2 ">Next <i class="fa fa-angle-double-right"></i></a>
                @endif
            </div>

            
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="gi_code" value="{{ $user->gi_code }}">
        </form>
    </div>
</div>



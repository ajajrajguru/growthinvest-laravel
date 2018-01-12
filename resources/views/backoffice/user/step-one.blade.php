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

        <div class="mt-4 bg-white border border-gray p-4">
        <h1 class="section-title font-weight-medium text-primary mb-0">Add User</h1>
        <p class="text-muted">Add details of intermediary.</p>

        <ul class="progress-indicator my-5">
            <li class="active">
                <a href="javascript:void(0)">Intermediary Registration</a>
                <span class="bubble"></span>
            </li>
            <li>
                <a href="javascript:void(0)">Intermediary Profile</a>
                <span class="bubble"></span>
            </li>
        </ul>

        <div class="profile-content p-4">
            <h6 class="mt-0">Step 1: <span class="text-primary">Intermediary Registration</span></h6>
            <hr class="my-3">

            <form method="post" action="{{ url('backoffice/user/save-step-one') }}" data-parsley-validate name="add-user-step1" id="add-user-step1" enctype="multipart/form-data">
            

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="first_name" class="form-control @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the first name." placeholder="Eg. John" value="{{ $user->first_name}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->first_name}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="last_name" class="form-control @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter the last name." placeholder="Eg. Smith" value="{{ $user->last_name}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->last_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Address <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="email" name="email" class="form-control @if($mode=='view') d-none @endif" data-parsley-type="email" data-parsley-required data-parsley-required-message="Please enter email." placeholder="Eg. john_smith@mailinator.com" value="{{ $user->email}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->email}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telephone Number <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="tel" name="telephone" class="form-control @if($mode=='view') d-none @endif" data-parsley-required data-parsley-required-message="Please enter telephone." placeholder="Eg: 020 7071 3945" value="{{ $user->telephone_no}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->telephone_no}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Password <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="password" name="password" class="form-control @if($mode=='view') d-none @endif" id="userpassword" data-parsley-required data-parsley-required-message="Please enter password." placeholder="">
                            <span class="@if($mode=='edit') d-none @endif"> </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="password" name="confirm_password" class="form-control @if($mode=='view') d-none @endif" data-parsley-equalto="#userpassword" data-parsley-required data-parsley-required-message="Please enter confirm password." placeholder="">
                            <span class="@if($mode=='edit') d-none @endif"> </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Name<span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="company_name" class="form-control @if($mode=='view') d-none @endif" placeholder="" data-parsley-required data-parsley-required-message="Please enter the company name." value="{{ (isset($userData['company'])) ? $userData['company'] : ''}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ (isset($userData['company'])) ? $userData['company'] : ''}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Website</label>
                            <input type="text" name="company_website" class="form-control @if($mode=='view') d-none @endif" placeholder="" data-parsley-type="url" value="{{ (isset($userData['website'])) ? $userData['website'] : ''}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ (isset($userData['website'])) ? $userData['website'] : ''}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 1 </label>
                            <input type="text" name="address_line_1" class="form-control @if($mode=='view') d-none @endif" placeholder="" value="{{ $user->address_1}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->address_1}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 2 </label>
                            <input type="text" name="address_line_2" class="form-control @if($mode=='view') d-none @endif" placeholder="" value="{{ $user->address_2}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->address_2}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Town/City</label>
                            <input type="text" name="town_city" class="form-control @if($mode=='view') d-none @endif" placeholder="" value="{{ $user->city}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->city}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>County</label>
                            <select class="form-control @if($mode=='view') d-none @endif" name="county">
                                <option value="">Please Select</option>
                                @php
                                $countyName = '';
                                @endphp
                                @foreach($countyList as $county)
                                    @php
                                    if($user->county == $county)
                                        $countyName = $county;
 
                                    @endphp
                                    <option value="{{ $county }}" @if($user->county == $county) selected @endif>{{ $county }}</option>
                                @endforeach
                            </select>
                            <span class="@if($mode=='edit') d-none @endif">{{ $countyName}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Postcode <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <input type="text" name="postcode" class="form-control @if($mode=='view') d-none @endif" placeholder="" data-parsley-required data-parsley-required-message="Please enter postcode." value="{{ $user->postcode}}">
                            <span class="@if($mode=='edit') d-none @endif">{{ $user->postcode}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control @if($mode=='view') d-none @endif" name="country">
                                <option value="">Please Select</option>
                                @php
                                $countryName = '';
                                @endphp
                                @foreach($countryList as $code=>$country)
                                    @php
                                    if($user->country == $code)
                                        $countryName = $country;
 
                                    @endphp
                                    <option value="{{ $code }}" @if($user->country == $code) selected @endif>{{ $country }}</option>
                                @endforeach
                            </select>
                            <span class="@if($mode=='edit') d-none @endif">{{ $countryName }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company FCA number</label>
                            <input type="text" class="form-control @if($mode=='view') d-none @endif" name="company_fca_number" placeholder="" value="{{ (isset($userData['companyfca'])) ? $userData['companyfca'] : ''}}">

                            <span class="@if($mode=='edit') d-none @endif">{{ (isset($userData['companyfca'])) ? $userData['companyfca'] : ''}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Description</label>
                            <select class="form-control @if($mode=='view') d-none @endif" name="company_description">
                                <option value="">Please Select</option>
                                @php
                                $compDescription = '';
                                @endphp
                                @foreach($companyDescription as $description)
                                    @php
                                    if(isset($userData['typeaccount']) && $userData['typeaccount'] == $description)
                                        $compDescription = $description;
 
                                    @endphp
                                    <option value="{{ $description }}" @if(isset($userData['typeaccount']) && $userData['typeaccount'] == $description) selected @endif>{{ $description }}</option>
                                @endforeach
                            </select>
                            <span class="@if($mode=='edit') d-none @endif">{{ $compDescription}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Roles</label>
                            <select class="form-control @if($mode=='view') d-none @endif" name="roles">
                                <option value="">Please Select</option>
                                @php
                                $roleName = '';
                                @endphp
                                @foreach($roles as $role)
                                    @php
                                    if($user->hasRole($role->name))
                                        $roleName = $role->display_name;
 
                                    @endphp
                                <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            <span class="@if($mode=='edit') d-none @endif">{{ $roleName }}</span> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Firm <span class="text-danger @if($mode=='view') d-none @endif">*</span></label>
                            <select class="form-control @if($mode=='view') d-none @endif" name="firm" data-parsley-required data-parsley-required-message="Please select the firm.">
                                <option value="">Please Select</option>
                                @php
                                $firmName = '';
                                @endphp
                                @foreach($firms as $firm)
                                    @php
                                    if($user->firm_id == $firm->id)
                                        $firmName = $firm->name;

                                     
                                    @endphp
                                <option value="{{ $firm->id }}" @if($user->firm_id == $firm->id) selected @endif>{{ $firm->name }}</option>
                                @endforeach
                            </select>
                            <span class="@if($mode=='edit') d-none @endif">{{ $firmName }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Suspended</label>
                            <input type="checkbox" class="form-control @if($mode=='view') d-none @endif" name="is_suspended" @if($user->suspended) checked @endif placeholder=""> 
                            <span class="@if($mode=='edit') d-none @endif">{{ ($user->suspended) ?  'Yes' : 'No' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                       
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 @if($mode=='view') d-none @endif">Save</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
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


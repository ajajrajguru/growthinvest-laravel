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
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" placeholder="Eg. John">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" placeholder="Eg. Smith">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Eg. john_smith@mailinator.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telephone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="telephone" class="form-control" placeholder="Eg: 020 7071 3945">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Name<span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Website</label>
                            <input type="text" name="company_website" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 1 </label>
                            <input type="text" name="address_line_1" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address Line 2 </label>
                            <input type="text" name="address_line_2" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Town/City</label>
                            <input type="text" name="town_city" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>County</label>
                            <select class="form-control" name="county">
                                <option value="">Please Select</option>
                                @foreach($countyList as $county)
                                    <option value="{{ $county }}">{{ $county }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Postcode <span class="text-danger">*</span></label>
                            <input type="text" name="postcode" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" name="country">
                                <option value="">Please Select</option>
                                @foreach($countryList as $code=>$country)
                                    <option value="{{ $code }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company FCA number</label>
                            <input type="text" class="form-control" name="company_fca_number" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Description</label>
                            <select class="form-control" name="company_description">
                                <option value="">Please Select</option>
                                 
                                @foreach($companyDescription as $description)
                                    <option value="{{ $description }}">{{ $description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Roles</label>
                            <select class="form-control" name="roles">
                                <option value="">Please Select</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Firm <span class="text-danger">*</span></label>
                            <select class="form-control" name="firm">
                                <option value="">Please Select</option>
                                @foreach($firms as $firm)
                                <option value="{{ $firm->id }}">{{ $firm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save</button>
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


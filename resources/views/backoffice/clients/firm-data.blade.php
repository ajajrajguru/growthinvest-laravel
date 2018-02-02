@php
$compClasses = (isset($completionClasses) && $completionClasses==true) ? 'completion_status text-input-status' :'';

@endphp
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Firm Name</label>

            <input type="text" class="form-control {{ $compClasses }}  editmode @if($mode=='view') d-none @endif" name="companyname" value="{{ (!empty($investorFai) && isset($investorFai['companyname'])) ? $investorFai['companyname']:'' }}">
            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['companyname'])) ? $investorFai['companyname']:'' }}</div>
        </div>
        <div class="form-group">
            <label>FCA Firm Reference Number</label>
            <input type="text" class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="fcanumber" value="{{ (!empty($investorFai) && isset($investorFai['fcanumber'])) ? $investorFai['fcanumber']:'' }}">
            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['fcanumber'])) ? $investorFai['fcanumber']:'' }}</div>
        </div>
        <div class="form-group">
            <label>Primary Contact Name</label>
            <input type="text" class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="principlecontact" value="{{ (!empty($investorFai) && isset($investorFai['principlecontact'])) ? $investorFai['principlecontact']:'' }}">
            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['principlecontact'])) ? $investorFai['principlecontact']:'' }}</div>
        </div>
        <div class="form-group">
            <label>Primary Contact's FCA Number</label>
            <input type="text" class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="primarycontactfca" value="{{ (!empty($investorFai) && isset($investorFai['primarycontactfca'])) ? $investorFai['primarycontactfca']:'' }}">
            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['primarycontactfca'])) ? $investorFai['primarycontactfca']:'' }}</div>
        </div>
        <div class="form-group">
            <label>Primary Contact Email Address</label>
            <input type="email" class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="email"  data-parsley-type="email" value="{{ (!empty($investorFai) && isset($investorFai['email'])) ? $investorFai['email']:'' }}">
            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['email'])) ? $investorFai['email']:'' }}</div>
        </div>
        <div class="form-group">
            <label>Primary Contact Phone Number</label>
            <input type="text" class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="telephone" data-parsley-type="number" data-parsley-minlength="10" data-parsley-minlength-message="The telephone number must be atleast 10 characters long!" value="{{ (!empty($investorFai) && isset($investorFai['telephone'])) ? $investorFai['telephone']:'' }}">
            <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['telephone'])) ? $investorFai['telephone']:'' }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <fieldset>
            <legend>Firm Address</legend>
            <div class="form-group">
                <label>Address 1</label>
                <textarea class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="address">{{ (!empty($investorFai) && isset($investorFai['address'])) ? $investorFai['address']:'' }}</textarea>
                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif">{{ (!empty($investorFai) && isset($investorFai['address'])) ? $investorFai['address']:'' }}</div>
            </div>
            <div class="form-group">
                <label>Address 2</label>
                <textarea class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="address2">{{ (!empty($investorFai) && isset($investorFai['address2'])) ? $investorFai['address2']:'' }}</textarea>
                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['address2'])) ? $investorFai['address2']:'' }}</div>
            </div>
            <div class="form-group">
                <label>Town</label>
                <input type="text" class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="city" value="{{ (!empty($investorFai) && isset($investorFai['city'])) ? $investorFai['city']:'' }}">
                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['city'])) ? $investorFai['city']:'' }}</div>
            </div>
            <div class="form-group">
                <label>County</label>
                <select class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="county">
                    <option value="">Please Select</option>
       
                    @foreach($countyList as $county) 
                        <option value="{{ $county }} " @if(!empty($investorFai) && isset($investorFai['county']) && $investorFai['county'] == $county) selected @endif >{{ $county }}</option>
                    @endforeach
                </select>
                <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['county'])) ? $investorFai['county']:'' }}</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Postcode</label>
                        <input type="text" class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="postcode" value="{{ (!empty($investorFai) && isset($investorFai['postcode'])) ? $investorFai['postcode']:'' }}">
                        <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ (!empty($investorFai) && isset($investorFai['postcode'])) ? $investorFai['postcode']:'' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Country</label>
                    <select class="form-control {{ $compClasses }} editmode @if($mode=='view') d-none @endif" name="country">
                        <option value="">Please Select</option>
                        @php
                        $countryName = '';
                        
                        @endphp 
                        @foreach($countryList as $code=>$country)
                            @php
                            $selected = '';
                            if(!empty($investorFai) && isset($investorFai['country']) && $investorFai['country'] == $code){
                                $countryName = $country;
                                $selected = 'selected';
                            }
                                
                            @endphp
                            <option value="{{ $code }}" {{ $selected }}>{{ $country }}</option>
                        @endforeach
                    </select>
                    <div class="viewmode text-large text-primary @if($mode=='edit') d-none @endif"> {{ $countryName }}</div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
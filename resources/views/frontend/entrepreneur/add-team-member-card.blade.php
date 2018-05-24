@php
if(isset($teamMemberDetail['picture']) && $teamMemberDetail['picture']!=''){
	$profilePic = $teamMemberDetail['picture'];
	$hasProfilePic = true ;
}
else
{
	$profilePic = getDefaultImages('member_picture');
	$hasProfilePic = false ;
}

$mediaLinks = (isset($teamMemberDetail['socialmedia-link'])) ? $teamMemberDetail['socialmedia-link'] : [];

@endphp
<div class="team-member">
	<fieldset>
	    <legend>Member {{ $memberCount }}</legend>
	<div class="row">                    
		<div class="col-md-3"> 
		    <label> Member Name</label>                    
		</div>                    
		<div class="col-md-9">                        
			 <input type="text" class="form-control editmode " name="member_name_{{ $memberCount }}" value="@if(isset($teamMemberDetail['name'])){{ $teamMemberDetail['name'] }}@endif">
			 <small class="form-text text-muted">Eg: John Mayer.</small>
		</div> 
	</div>
	<div class="row">                    
		<div class="col-md-3"> 
		   <label> Position within The Company </label>        
		</div>                    
		<div class="col-md-9">                        
			 <input type="text" class="form-control editmode " name="member_position_{{ $memberCount }}" value="@if(isset($teamMemberDetail['position'])){{ $teamMemberDetail['position'] }}@endif">
			 <small class="form-text text-muted">Eg: Manager.</small>
		</div>	 
	</div>
	<div class="row">                    
		<div class="col-md-3"> 
		    <label>Short Bio</label>
		</div>                    
		<div class="col-md-9">                        
			 <textarea class="form-control editmode " name="member_bio_{{ $memberCount }}" placeholder="" >@if(isset($teamMemberDetail['bio'])){{ $teamMemberDetail['bio'] }}@endif</textarea>
			 <small class="form-text text-muted">max 1000 words</small>
		</div>	 
	</div>
	<div class="row">                    
		<div class="col-md-3"> 
		   <label> Employment Status Pre-investment</label>
		</div>                    
		<div class="col-md-9">                        
			<select type="text" name="member_preinvestment_{{ $memberCount }}" id="preinvestment" placeholder="" class="form-control " >                         
	           	<option value=""> Select </option>                                                                                
	           <option value="Part-time" @if(isset($teamMemberDetail['preinvestment']) && $teamMemberDetail['preinvestment']=="Part-time") selected @endif>Part-time</option>                    
	           <option value="Full-time" @if(isset($teamMemberDetail['preinvestment']) && $teamMemberDetail['preinvestment']=="Full-time") selected @endif>Full-time</option>                                                                    
	       </select>
		</div>	 
	</div>
	<div class="row">                    
		<div class="col-md-3"> 
		    <label>Employment Status Post-investment</label>
		</div>                    
		<div class="col-md-9">                        
			<select type="text" name="member_postinvestment_{{ $memberCount }}" id="postinvestment" placeholder="" class="form-control " value="@if(isset($teamMemberDetail['name'])){{ $teamMemberDetail['name'] }}@endif">                         
	           	<option value=""> Select </option>                                                                                
	           <option value="Part-time" @if(isset($teamMemberDetail['postinvestment']) && $teamMemberDetail['postinvestment']=="Part-time") selected @endif>Part-time</option>                    
	           <option value="Full-time" @if(isset($teamMemberDetail['postinvestment']) && $teamMemberDetail['postinvestment']=="Full-time") selected @endif>Full-time</option>                                                                    
	       </select>
		</div>
	</div>
	<div class="row">                    
		<div class="col-md-3"> 
		    <label>Equity holding % (pre-investment)   </label>        
		</div>                    
		<div class="col-md-9">                        
			 <input type="text" class="form-control editmode " name="member_equitypreinvestment_{{ $memberCount }}" value="@if(isset($teamMemberDetail['equitypreinvestment'])){{ $teamMemberDetail['equitypreinvestment'] }}@endif">
		</div>	 
	</div>
	<div class="row">                    
		<div class="col-sm-3 text-center">
            <label>Upload Picture</label>
            <div class="image" id="member-picture-{{ $memberCount }}">
            	<input type="hidden" name="cropped_image_url_{{ $memberCount }}" class="cropped_image_url">
            	<input type="hidden" name="image_url_{{ $memberCount }}" class="image_url" value="{{ $profilePic }}">
                <img class="mx-auto d-block img-responsive member-profile-picture-{{ $memberCount }}" src="{{ $profilePic }}" height="150" >
                <div class="action-btn"> 
                    <button type="button" id="mem-picfile-{{ $memberCount }}" class="btn btn-primary btn-sm mt-2  editmode "><i class="fa fa-camera"></i> Select Image</button>   <a href="javascript:void(0)" class="delete-image @if(!$hasProfilePic) d-none @endif" object-type="App\BusinessListing" object-id="" type="member_picture_{{ $memberCount }}" image-class="member-profile-picture-{{ $memberCount }}"><i class="fa fa-trash text-danger editmode"></i></a>
                </div>
            </div>
        </div>                   
		 
	</div>

	<div class="add-socialmedia-link">
		@php
			$sm = 1;
		@endphp
		@if(!empty($mediaLinks))
	 		@foreach($mediaLinks as $mediaLink)
			<div class="row social-link-row">                    
				<div class="col-sm-4 text-center">
		            <label>Social Media Link </label>
		            <input type="text" name="social_link_{{ $memberCount }}_{{ $sm }}" class="form-control editmode" value="@if(isset($mediaLink['social_link'])){{ $mediaLink['social_link'] }}@endif">   
		        </div> 
		        <div class="col-sm-4 text-center">
		            <label>Link Type</label>
		            <select type="text" name="link_type_{{ $memberCount }}_{{ $sm }}" placeholder="" class="form-control " >                         
						<option value="">--select--</option>
						<option value="Facebook" @if(isset($mediaLink['link_type']) && $mediaLink['link_type']=="Facebook") selected @endif>Facebook</option>
						<option value="Twitter" @if(isset($mediaLink['link_type']) && $mediaLink['link_type']=="Twitter") selected @endif>Twitter</option> 
						<option value="LinkedIn" @if(isset($mediaLink['link_type']) && $mediaLink['link_type']=="LinkedIn") selected @endif>LinkedIn</option>
						<option value="Other Weblink" @if(isset($mediaLink['link_type']) && $mediaLink['link_type']=="Other Weblink") selected @endif>Other Weblink</option>                                                               
			       </select>
		        </div> 
		        <div class="col-sm-2 text-center">
	 				<a href="javascript:void(0)" class="btn btn-default remove-social-link"><i class="fa fa-trash"></i></a> 
		        </div>                   
				 
			</div>
			@php
			$sm++;
			@endphp
			@endforeach
		@else

			<div class="row social-link-row">                    
				<div class="col-sm-4 text-center">
		            <label>Social Media Link </label>
		            <input type="text" name="social_link_{{ $memberCount }}_{{ $sm }}" class="form-control editmode">   
		        </div> 
		        <div class="col-sm-4 text-center">
		            <label>Link Type</label>
		            <select type="text" name="link_type_{{ $memberCount }}_{{ $sm }}" placeholder="" class="form-control " >                         
						<option>--select--</option>
						<option>Facebook</option>
						<option>Twitter</option> 
						<option>LinkedIn</option>
						<option>Other Weblink</option>                                                               
			       </select>
		        </div> 
		        <div class="col-sm-2 text-center">
	 				<a href="javascript:void(0)" class="btn btn-default remove-social-link"><i class="fa fa-trash"></i></a> 
		        </div>                   
				 
			</div>
			 
		@endif



		<button type="button" class="btn btn-primary text-right editmode add-social-link" >Add Social Media Link</button>
		<input type="hidden" name="socialmedia_link_counter_{{ $memberCount }}" class="completion_status" value="{{ $sm }}">
		<button type="button" class="btn btn-primary text-right editmode delete-team-member" >Delete member</button>
	</div>
	</fieldset>
</div>
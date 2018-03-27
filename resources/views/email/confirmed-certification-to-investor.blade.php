@extends('layouts.email')

@section('content')

Hi  {{ $name }},<br/><br/>

@if(!$invHasCertification)
	Thanks for your Confirmation as an Investor.<br/>
	Kindly find attached your Certification Confirmation Document.<br/><br/>
@else
	Thanks for your Re-certification.<br/>
	Kindly find attached your Certification Confirmation Document.<br/><br/>
@endif

You can login with the login credentials provided by you during Registration.<br/><br/>

Browse and Participate in Business Proposals on GrowthInvest.<br/><br/>

 @endsection
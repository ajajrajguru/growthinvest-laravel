@extends('layouts.email')

@section('content')

Hi  {{ $toName }},<br/><br/>

@if(!$invHasCertification) Certification @else Re-Certification @endif of {{ $name }}  of Firm <b><i>{{ $firmName }}</i></b> has been confirmed.<br/><br/>


<strong>Certification Details:</strong><br/><br/>

Name: {{ $name }}<br>
Certification: {{ $certification }}<br>
Certified Date: {{ date('d-m-Y', strtotime($certificationDate)) }}<br>
Certificate Expiry Date: {{  date('d-m-Y', strtotime($certificationExpiryDate)) }}<br><br>

<strong>Certification done by:</strong> {{ $registeredBy }}<br><br>
To view more details visit the following address   <a href="{{ url('backoffice/investor/'.$giCode.'/investor-profile')}}">View Profile</a>.

 @endsection
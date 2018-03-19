@extends('layouts.email')

@section('content')

Hi  {{ $toName }},<br/><br/>

Certification of {{ $name }}  of Firm <b><i>{{ $firmName }}</i></b> has been confirmed.<br/><br/>


<strong>Certification Details:</strong><br/><br/>

Name: {{ $name }}<br>
Certification: {{ $certification }}<br>
Certified Date: {{ $certificationDate }}<br>
Certificate Expiry Date: {{ $certificationExpiryDate }}<br><br>

<strong>Certification done by:</strong> {{ $registeredBy }}<br><br>
To view more details visit the following address   <a href="{{ url('backoffice/investor/'.$giCode.'/investor-profile')}}">View Profile</a>.

 @endsection
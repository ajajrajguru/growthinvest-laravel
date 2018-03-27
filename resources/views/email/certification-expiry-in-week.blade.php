@extends('layouts.email')

@section('content')

Hi {{ $name }},<br/><br/>

Self certification for the below detailed investor is close to expiry.  Please ensure
renewal so that the investor is able to continue to use the platform.<br/><br/>

<b>Details: </b><br/>
Investor Name: {{ $investorName }}<br>
Certification Name: {{ $certification }}<br/>
Expiry Date: {{  date('d-m-Y', strtotime($expiryDate)) }}<br/><br/>

You can log into the site and view the details
<a href="{{ url('backoffice/investor/'.$investorGiCode.'/investor-profile')}}">Click here</a><br/><br/>

 @endsection
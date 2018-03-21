@extends('layouts.email')

@section('content')

Hi  {{ $name }},<br/><br/>

Your Self Certification will expire in 1 week. Kindly renew your certificate at your earliest
convenience so that you can continue to use the platform.<br/><br/>


<b>Below are the details:</b><br/>
Certification Name: {{ $certification }}<br/>
Expiry Date: {{  date('d-m-Y', strtotime($expiryDate)) }}<br/><br/>

You can log in to the site and view the details
<a href="{{ url('backoffice/investor/'.$investorGiCode.'/investor-profile')}}">Click here</a><br/><br/>

 @endsection
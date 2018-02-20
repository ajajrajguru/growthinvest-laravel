@extends('layouts.email')

@section('content')


Welcome {{ $name }},<br/><br/>

{{ $name }} has signed up as an Investor under <b><i>{{ $firmName }}</i></b> .<br/><br/>


<strong>Details of the Account:</strong><br/><br/>

Name: {{ $name }}<br>
E-mail: {{ $email }} <br>
Contact #: {{ $telephone }}<br>
Location: {{ $address }}<br><br>

Added by: {{ $registeredBy }}<br><br>
Please log in to the Site to view more details.  <a href="{{ url('backoffice/investor/'.$giCode.'/investor-profile')}}">view more details</a>. On your dashboard you will find the certificate relating to your certification category. This document is downloadable and there for your reference.

 @endsection
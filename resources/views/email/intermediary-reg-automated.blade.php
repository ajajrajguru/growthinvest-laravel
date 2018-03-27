@extends('layouts.email')

@section('content')

<strong>Reg Type:  ADVISER</strong><br>
Name: {{$name}} <br>
E-mail: {{$email}}<br>
Contact Nr.: {{$telephone}}<br>
 

Account created by: {{$registeredBy}}
/end

 @endsection
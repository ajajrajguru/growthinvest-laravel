@extends('layouts.email')

@section('content')


Hi {{ $toName }},<br/><br/>

New User account created for {{ $name }} by {{ $registeredBy }} in firm {{ $firmName }} with the role {{ $role }}.<br/><br/>


<strong>Details of the User:</strong><br/><br/>

Name: {{ $name }}<br>
E-mail: {{ $email }} <br>
Firm: {{ $firmName }} <br>
Role: {{ $role }} <br><br>

Please log in to the Site to view more details.<br>

 @endsection
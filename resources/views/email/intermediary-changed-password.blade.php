@extends('layouts.email')

@section('content')

Hi {{ $name }},<br/><br/> 

Your GrowthInvest account\'s password was recently changed.<br/><br/>

Your new password is: {{ $password }} <br/><br/>

If you didn\'t make this change, please let us know straight away on 020 7071 3945.<br/><br/>

Thanks 

 @endsection
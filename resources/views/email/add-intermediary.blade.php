@extends('layouts.email')

@section('content')

Hello {{$name}},<br/><br/>

Thanks for your interest in joining our Platform.<br/><br/>

We have received your Registration Form for {{$accountType}} Account.<br/>
Our team will contact you for further verification.<br/><br/>

Once we verify your details, we will Activate your Account and mail you the Login credentials.<br/><br/>

If you have any questions please feel free to contact a member of the team on 020 7071 3945 or
<a href='mailto:enquiries@growthinvest.com'>enquiries@growthinvest.com</a>.<br/><br/>

Please note that until we activate your Account, you won't be able to log into our Platform.

 @endsection
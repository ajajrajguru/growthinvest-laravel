@extends('layouts.email')

@section('content')


Dear {{ $name }},<br/><br/>

Investor {{ $investorName }} with the email id {{ $investorEmail }}, has onfido request failed, due to following error that occurred upon submission. <br/><br/> {!! $errorHtml !!}

 @endsection
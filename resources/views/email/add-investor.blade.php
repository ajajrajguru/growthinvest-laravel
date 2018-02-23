@extends('layouts.email')

@section('content')

Hello {{ $name }},<br><br>

Welcome to {{ $firmName }}, the home of tax efficient investments. You recently registered with us, and we are delighted to welcome you to our platform where you can see and manage all your alternative and tax efficient investments in one place.  Benefits include: <br/>

    <ul>
        <li>Wide range of tax efficient investments</li>
        <li>   Consolidate, analyse and build your tax efficient portfolio </li>
        <li>   No hidden fees with our clear transparent pricing structure </li>
        <li>   Tax relief available on all investments </li>
        <li>   Clear due diligence accessible on all investments </li>
        <li>   Direct engagement with  businesses </li>
        <li>   Invest alongside our experienced network of investors </li>
        <li>   Manage and build your portfolio with our bespoke set of dashboards </li>
        <li>   Excellent professional service from our experienced team </li>
        <li>   Regular events and communications  </li>
    </ul><br/>

    <strong>Your login details are as follows:</strong><br/><br/>
            Username: {{ $email }}<br/>
            Password: {{ $password }}<br/><br/>


    <b>Next Steps: </b><br/><br/>
    Please log in and complete your profile as soon as you can.Once you have done so you\'ll be able to start using the full platform, view your own dashboards, and explore the investment opportunities we offer. A copy of all relevant certification and any investment documents will be held in your document library.<br/><br/>

    Please do complete as much of the Investor Profile Questionnaire as possible. This enables us to select and deliver the most appropriate opportunities for your investment requirements, and gives us a better idea of how we can help and assist. <br/><br/>
    Finally, please do not hesitate to contact us at any time via the platform, on 020 7071 3945, or on email at <a href="mailto:support@growthinvest.com" target="_blank">support@growthinvest.com</a>. <br/><br/>

 @endsection
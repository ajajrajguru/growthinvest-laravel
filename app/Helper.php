<?php
/**
generic method to fetch list of records from model
$modelName : 'App/User';
$filters: ['id'=>1]
$orderDataBy: ['id'=>'desc']
 **/
function getModelList($modelName, $filters = [], $skip = 0, $length = 0, $orderDataBy = [])
{

    $model = new $modelName;

    if (empty($filters)) {
        $modelQuery = $model::select('*');
    } else {
        $modelQuery = $model::where($filters);
    }

    foreach ($orderDataBy as $columnName => $orderBy) {
        $modelQuery->orderBy($columnName, $orderBy);
    }

    if ($length > 1) {
        $listCount = $modelQuery->get()->count();
        $list      = $modelQuery->skip($skip)->take($length)->get();
    } else {
        $list      = $modelQuery->get();
        $listCount = $list->count();
    }

    return ['listCount' => $listCount, 'list' => $list];

}

/**
check if provided permission has access to th user
 */
function hasAccess($uriPermission)
{
    $guard       = $uriPermission['guard'];
    $permissions = $uriPermission['permissions'];
    $access      = false;

    if (!empty($permissions)) {
        //check for permission

        if (!hasPermission($permissions, $guard)) {
            $access = false;
        } else {
            $access = true;
        }

    }

    return $access;
}

/***
checks if user has permission
$uriPermission : array of permission
 **/

function hasPermission($permissions, $guard)
{

    if (Auth::check() && Auth::user()->hasAnyPermission($permissions)) {
        return true;
    } else {
        return false;
    }

}

function getCounty()
{
    return ['Avon', 'Bedfordshire', 'Berkshire', 'Borders', 'Buckinghamshire', 'Cambridgeshire', 'Central', 'Cheshire', 'Cleveland', 'Clwyd', 'Cornwall', 'County Antrim', 'County Armagh', 'County Down', 'County Fermanagh', 'County Londonderry', 'County Tyrone', 'Cumbria', 'Derbyshire', 'Devon', 'Dorset', 'Dumfries and Galloway', 'Durham', 'Dyfed', 'East Sussex', 'Essex', 'Fife', 'Gloucestershire', 'Grampian', 'Greater Manchester', 'Gwent', 'Gwynedd County', 'Hampshire', 'Herefordshire', 'Hertfordshire', 'Highlands and Islands', 'Humberside', 'Isle of Wight', 'Kent', 'Lancashire', 'Leicestershire', 'Lincolnshire', 'London', 'Lothian', 'Merseyside', 'Mid Glamorgan', 'Norfolk', 'North Yorkshire', 'Northamptonshire', 'Northumberland', 'Nottinghamshire', 'Oxfordshire', 'Powys', 'Rutland', 'Shropshire', 'Somerset', 'South Glamorgan', 'South Yorkshire', 'Staffordshire', 'Strathclyde', 'Suffolk', 'Surrey', 'Tayside', 'Tyne and Wear', 'Warwickshire', 'West Glamorgan', 'West Midlands', 'West Sussex', 'West Yorkshire', 'Wiltshire', 'Worcestershire'];
}

function getCountry()
{
    return ["GB" => "United Kingdom", "AF" => "Afghanistan", "AX" => "Aland Islands", "AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua And Barbuda", "AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria", "AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados", "BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda", "BT" => "Bhutan", "BO" => "Bolivia", "BA" => "Bosnia And Herzegovina", "BW" => "Botswana", "BV" => "Bouvet Island", "BR" => "Brazil", "IO" => "British Indian Ocean Territory", "BN" => "Brunei Darussalam", "BG" => "Bulgaria", "BF" => "Burkina Faso", "BI" => "Burundi", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada", "CV" => "Cape Verde", "KY" => "Cayman Islands", "CF" => "Central African Republic", "TD" => "Chad", "CL" => "Chile", "CN" => "China", "CX" => "Christmas Island", "CC" => "Cocos (Keeling) Islands", "CO" => "Colombia", "KM" => "Comoros", "CG" => "Congo", "CD" => "Congo,Democratic Republic", "CK" => "Cook Islands", "CR" => "Costa Rica", "CI" => "Cote D'Ivoire", "HR" => "Croatia", "CU" => "Cuba", "CY" => "Cyprus", "CZ" => "Czech Republic", "DK" => "Denmark", "DJ" => "Djibouti", "DM" => "Dominica", "DO" => "Dominican Republic", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea", "ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FK" => "Falkland Islands (Malvinas)", "FO" => "Faroe Islands", "FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia", "TF" => "French Southern Territories", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany", "GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea", "GW" => "Guinea-Bissau", "GY" => "Guyana", "HT" => "Haiti", "HM" => "Heard Island & Mcdonald Islands", "VA" => "Holy See (Vatican City State)", "HN" => "Honduras", "HK" => "Hong Kong", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India", "ID" => "Indonesia", "IR" => "Iran, Islamic Republic Of", "IQ" => "Iraq", "IE" => "Ireland", "IM" => "Isle Of Man", "IL" => "Israel", "IT" => "Italy", "JM" => "Jamaica", "JP" => "Japan", "JE" => "Jersey", "JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KI" => "Kiribati", "KR" => "Korea", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LA" => "Lao People's Democratic Republic", "LV" => "Latvia", "LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libyan Arab Jamahiriya", "LI" => "Liechtenstein", "LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macao", "MK" => "Macedonia", "MG" => "Madagascar", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "YT" => "Mayotte", "MX" => "Mexico", "FM" => "Micronesia, Federated States Of", "MD" => "Moldova", "MC" => "Monaco", "MN" => "Mongolia", "ME" => "Montenegro", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "MM" => "Myanmar", "NA" => "Namibia", "NR" => "Nauru", "NP" => "Nepal", "NL" => "Netherlands", "AN" => "Netherlands Antilles", "NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria", "NU" => "Niue", "NF" => "Norfolk Island", "MP" => "Northern Mariana Islands", "NO" => "Norway", "OM" => "Oman", "PK" => "Pakistan", "PW" => "Palau", "PS" => "Palestinian Territory, Occupied", "PA" => "Panama", "PG" => "Papua New Guinea", "PY" => "Paraguay", "PE" => "Peru", "PH" => "Philippines", "PN" => "Pitcairn", "PL" => "Poland", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RE" => "Reunion", "RO" => "Romania", "RU" => "Russian Federation", "RW" => "Rwanda", "BL" => "Saint Barthelemy", "SH" => "Saint Helena", "KN" => "Saint Kitts And Nevis", "LC" => "Saint Lucia", "MF" => "Saint Martin", "PM" => "Saint Pierre And Miquelon", "VC" => "Saint Vincent And Grenadines", "WS" => "Samoa", "SM" => "San Marino", "ST" => "Sao Tome And Principe", "SA" => "Saudi Arabia", "SN" => "Senegal", "RS" => "Serbia", "SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SK" => "Slovakia", "SI" => "Slovenia", "SB" => "Solomon Islands", "SO" => "Somalia", "ZA" => "South Africa", "GS" => "South Georgia And Sandwich Isl.", "ES" => "Spain", "LK" => "Sri Lanka", "SD" => "Sudan", "SR" => "Suriname", "SJ" => "Svalbard And Jan Mayen", "SZ" => "Swaziland", "SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syrian Arab Republic", "TW" => "Taiwan", "TJ" => "Tajikistan", "TZ" => "Tanzania", "TH" => "Thailand", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau", "TO" => "Tonga", "TT" => "Trinidad And Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TM" => "Turkmenistan", "TC" => "Turks And Caicos Islands", "TV" => "Tuvalu", "UG" => "Uganda", "UA" => "Ukraine", "AE" => "United Arab Emirates", "US" => "United States", "UM" => "United States Outlying Islands", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VU" => "Vanuatu", "VE" => "Venezuela", "VN" => "Viet Nam", "VG" => "Virgin Islands, British", "VI" => "Virgin Islands, U.S.", "WF" => "Wallis And Futuna", "EH" => "Western Sahara", "YE" => "Yemen", "ZM" => "Zambia", "ZW" => "Zimbabwe"];
}

function getCountryNameByCode($code)
{
    $countries = getCountry();

    if (isset($countries[$code])) {
        $counry = $countries[$code];
    } else {
        $counry = '';
    }

    return $counry;
}

function getCompanyDescription()
{
    return ["Wealth Manager", "Accountant", "Solicitor", "Business Advisor", "Investment Network", "Financial Advisor"];
}

/***
generates unique GI code for the modal
 ***/
function generateGICode(\Illuminate\Database\Eloquent\Model $model, $refernceKey, $args)
{
    $randomNo    = rand($args['min'], $args['max']);
    $formattedGI = $args['prefix'] . $randomNo;

    $record = $model->where([$refernceKey => $formattedGI])->first();

    if (empty($record)) {
        $result = $formattedGI;
    } else {
        $result = $this->generateGICode($model, $refernceKey, $args);
    }

    return $result;

}

function getRegulationTypes()
{
    return ['da' => 'Directly Authorised', 'ar' => 'Appointed Representative', 'uo' => 'Unregulated/Other'];
}

function getRegisteredIndRange()
{
    return ['1' => '1', '2' => '2 - 5', '3' => '6 - 10', '4' => '11 - 25', '5' => '25 - 100', '6' => '100+'];
}

function getSource()
{
    return ['internet' => 'Internet', 'personal' => 'Referral', 'recommendation' => 'Recommendation', 'email' => 'Email', 'event' => 'Event', 'LGBR Capital' => 'LGBR Capital'];
}

function certificationTypes()
{
    return ['self_certified' => 'Self Certified', 'approved' => 'Approved', 'uncertified' => 'Uncertified'];
}

function getCaptchaKey()
{
    return env('captcha_private_key');
}

function recaptcha_validate($recaptcha)
{
    $captcha    = $recaptcha;
    $privatekey = env('captcha_private_key');
    $url        = 'https://www.google.com/recaptcha/api/siteverify';
    $data       = array(
        'secret'   => $privatekey,
        'response' => $captcha,
        'remoteip' => $_SERVER['REMOTE_ADDR'],
    );

    $curlConfig = array(
        CURLOPT_URL            => $url,
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => $data,
    );

    $ch = curl_init();
    curl_setopt_array($ch, $curlConfig);
    $response = curl_exec($ch);
    curl_close($ch);

    $jsonResponse = json_decode($response);
    return $jsonResponse;
}

/** Generate Firm Invite Key
 ***/
function generate_firm_invite_key(\Illuminate\Database\Eloquent\Model $model, $firm_id)
{

    //  if($firm_id=="")
    //    return '';
    $firn_invite_key = uniqid() . $firm_id;
    // $firn_invite_key = time()+rand();

    $record = $model->where(['invite_key' => $firn_invite_key])->first();

    if (empty($record)) {
        $result = $firn_invite_key;
    } else {
        $result = generate_firm_invite_key($model, $firm_id);
    }

    return $result;

}
/**
$fileName = 'approved_intermediary';
$header = ['Platform GI Code Name','Email','Role','Firm','Telephone No'];
$userData = [
[FIRMCR272, 272 User, user272@mail.com, Wealth Manager, '01010100'  ]
[FIRMCR272, 272 User, user272@mail.com, Wealth Manager, '01010100'  ]
];
 */
function generateCSV($header, $data, $filename)
{
    $filePath = public_path("export-csv/" . $filename . ".csv");
    $handle   = fopen($filePath, 'w');
    fputcsv($handle, $header);

    foreach ($data as $row) {
        fputcsv($handle, $row);
    }

    header('Content-type: text/csv');
    header('Content-Length: ' . filesize($filePath));
    header('Content-Disposition: attachment; filename=' . $filename . '.csv');
    while (ob_get_level()) {
        ob_end_clean();
    }
    readfile($filePath);

    //Remove the local original file once all sizes are generated and uploaded
    unlink($filePath);
    exit();
}

function getCertificationQuesionnaire()
{
    $questionnaires = \App\CertificationQuestionaire::select('*')->orderBy('certification_default_id', 'asc')->orderBy('order', 'asc')->get()->toArray();

    return $questionnaires;
}

/** Function to geth the quiz questions/options, statements, declarations on elective professional investors
 */
function getElectiveProfInvestorQuizStatementDeclaration($pdf = false, $isElectiveProfInv = false)
{
    $hideIagree = ($isElectiveProfInv) ? 'd-none' : '';
    if ($pdf == true) {

        /* markup for certification pdf */
        $statement = '
        <table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; font-size: 14px;">

            <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 100%; border:none;">





            <h6>Elective Professional Investor Statement</h6><br/>
              <div style="margin-bottom: 10px; margin-bottom: 10px;"><b>The statement below details the rights and protections afforded to Retail investors that are
                lost when the client opts up to be designated as a Professional.</b></div>

                <div style="margin-bottom: 10px; margin-bottom: 10px; font-size: 14px;"><b>Please confirm that you have read and understood the statement below:</b></div>

                <div style="margin-bottom: 10px; margin-bottom: 10px; font-size: 14px;"><b>STATEMENT</b></div>

                <div style="margin-bottom: 10px; margin-bottom: 10px; font-size: 14px;">Financial Conduct Authority (“FCA”) Classification</div>

                <div style="margin-bottom: 10px; margin-bottom: 10px; font-size: 14px;">On the basis of information we have about you, or you have given us, and with reference to the rules
                  of the FCA (see http://fshandbook.info/FS/html/FCA/COBS/3/5), we have categorised you as a Professional
                  client by reason of your expertise, experience and knowledge in relation to investing in our financial
                  products and other investment opportunities.</div>

                  <div style="margin-bottom: 10px; margin-bottom: 10px; font-size: 14px;">Please note that your categorisation as an elective Professional client applies only for the
                    purpose of enabling us or our affiliates to promote financial products and investment opportunities to
                    you, and that you will not be treated as our client for any other purpose.</div>

                    <p style="font-size: 14px;">As a consequence of this categorisation, we are informing you that you will lose the protections
                      afforded exclusively to Retail clients under the FCA rules.  In particular:</p>

                      <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                         <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Communications and financial promotions made to you will not be subject to the detailed form and content requirements of the FCA’s rules, including those regarding costs and associated charges, that apply in the case of Retail clients.</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                         <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">When communicating with you, we are required to ensure that such communications are fair,
                            clear and not misleading. However, we may take into consideration your status as a Professional
                            client when complying with such requirements and in assessing whether any communication to you
                            is likely to be understood by you and contains appropriate information for you to make an
                            informed assessment of its subject matter;</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                         <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">We will not be restricted from promoting financial products and investment opportunities
                              which are not regulated in the UK and in doing so need not warn you further as regards the
                              protections you will lose;</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                         <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Because participants in our financial products and investment opportunities are not
                                (or will not on first participating be) Retail clients, we are able to agree with any fund
                                investment that we do not owe a duty of best execution;</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                         <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Because participants in our financial products and investment opportunities are not
                                  Retail clients, the detailed FCA rules on periodic statements are dis-applied.  You will
                                  however still receive statements in accordance with the other constitutional documents;</p></td>
                         </tr>
                     </table>


                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                         <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">In the event that we cease to provide investment advisory services, we are not required
                                    to ensure that any business which is outstanding is properly completed but we will nevertheless
                                    agree to do so; and</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                         <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You will have no right of access to the UK’s Financial Ombudsman Service.</p></td>
                         </tr>
                     </table>



                                  Please read and sign the declaration below to confirm you have read and understand this written
                                  notice and wish to be treated as a Professional client.

                                  <p font-size: 14px;>If you do not agree to the signing of this declaration, we are unable to categorise you as
                                    an Elective Professional client in conducting business with you in regard to the financial
                                    products and investment opportunities we wish to communicate and market to you.</p>

                                    <p font-size: 14px;>Yours sincerely,</p>

                                    <p font-size: 14px;>Daniel Rodwell,<br>Managing Director<br>'; /*Seed EIS Platform*/
        $statement .= 'GrowthInvest</p>

                                  </td>
            </tr>
        </table>';

        $declaration = ' <table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; font-size: 14px;">

            <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 100%; border:none;">

                <h6>Declaration</h6>
                        <br/>
                        <p style="font-size: 14px;">Declaration: Notice of Wish to be treated as a Professional client</p>

                          <p style="font-size: 14px;">Under the EU’s Markets in Financial Instruments Directive (MiFID), I wish to be treated as an
                          elective Professional client if, subject to your assessment of my expertise, experience, and
                          knowledge of me you are reasonably assured, in light of the nature of the transactions or services
                          envisaged, that I am capable of making my own investment decisions and understand the risks
                          involved. In making your assessment I understand you may rely on information already in your
                          possession and you may request further additional information from me if necessary.</p>

                          <p style="font-size: 14px;">As a consequence of this assessment and classification as a Professional client I understand you
                          will be able to promote various financial products and investment opportunities to me. I also
                          understand you are required to obtain written acknowledgement from me that I have been provided
                          with a written notice (as detailed in the above letter) in regards of me being treated as a
                          Professional client.</p>

                          <p style="font-size: 14px;">I warrant that I have the necessary expertise, experience and knowledge of making my own
                          investment decisions and understand the risks involved in investing in the financial products and
                          investment opportunities being marketed to me.</p>

                          <p style="font-size: 14px;">I also confirm that I have read and understand the differences between the treatment of
                          Professional and Retail clients and that I fully understand the protections and compensation
                          rights that I may lose and the consequences of losing such protections.</p>

                          <p style="font-size: 14px;">I am fully aware that it is up to me to keep the firm informed of any change that could
                          affect my categorisation.</p>

                          <p style="font-size: 14px;">On the basis of the above information I can confirm that the firm may treat me as a
                          Professional client.</p></td>
            </tr>
        </table><br/>';
        /* end markup for certification pdf */

    } else {

        $statement = '<div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <a data-toggle="collapse" href="#epiStatement" role="button" class="collapsed">
                                          Elective Professional Investor Statement
                                          <i class="fa fa-lg fa-plus-square-o"></i>
                                          <i class="fa fa-lg fa-minus-square-o"></i>
                                        </a>
                                    </div>

                                    <div id="epiStatement" class="collapse " role="tabpanel" >
                                        <div class="card-body">
                                            <p><b>The statement below details the rights and protections afforded to Retail investors that are lost when the client opts up to be designated as a Professional.</b></p>
                                            <p><b>Please confirm that you have read and understood the statement below:</b></p>
                                            <p><b>STATEMENT</b></p>
                                            <p>Financial Conduct Authority (“FCA”) Classification</p>
                                            <p>On the basis of information we have about you, or you have given us, and with reference to the rules of the FCA (see http://fshandbook.info/FS/html/FCA/COBS/3/5), we have categorised you as a Professional client by reason of your expertise, experience and knowledge in relation to investing in our financial products and other investment opportunities.</p>
                                            <p>Please note that your categorisation as an elective Professional client applies only for the purpose of enabling us or our affiliates to promote financial products and investment opportunities to you, and that you will not be treated as our client for any other purpose.</p>
                                            <p>As a consequence of this categorisation, we are informing you that you will lose the protections afforded exclusively to Retail clients under the FCA rules. In particular:</p>
                                            <ul class="disc">
                                                <li>Communications and financial promotions made to you will not be subject to the detailed form and content requirements of the FCA’s rules, including those regarding costs and associated charges, that apply in the case of Retail clients.</li>
                                                <li>When communicating with you, we are required to ensure that such communications are fair, clear and not misleading. However, we may take into consideration your status as a Professional client when complying with such requirements and in assessing whether any communication to you is likely to be understood by you and contains appropriate information for you to make an informed assessment of its subject matter;</li>
                                                <li>We will not be restricted from promoting financial products and investment opportunities which are not regulated in the UK and in doing so need not warn you further as regards the protections you will lose;</li>
                                                <li>Because participants in our financial products and investment opportunities are not (or will not on first participating be) Retail clients, we are able to agree with any fund investment that we do not owe a duty of best execution;</li>
                                                <li>Because participants in our financial products and investment opportunities are not Retail clients, the detailed FCA rules on periodic statements are dis-applied. You will however still receive statements in accordance with the other constitutional documents;</li>
                                                <li>In the event that we cease to provide investment advisory services, we are not required to ensure that any business which is outstanding is properly completed but we will nevertheless agree to do so; and</li>
                                                <li>You will have no right of access to the UK’s Financial Ombudsman Service.</li>
                                            </ul>Please read and sign the declaration below to confirm you have read and understand this written notice and wish to be treated as a Professional client.
                                            <p>If you do not agree to the signing of this declaration, we are unable to categorise you as an Elective Professional client in conducting business with you in regard to the financial products and investment opportunities we wish to communicate and market to you.</p>
                                            <p>Yours sincerely,</p>
                                            <p>Daniel Rodwell,<br>
                                            Managing Director<br>
                                            GrowthInvest</p>

                                          <button class="btn btn-primary btn-sm elective-prof-inv-btn  ' . $hideIagree . '" data-agree="no">I Agree</button>

                                        </div>
                                    </div>
                                </div>';

        $declaration = '<h4 class="my-3">
                                Declaration
                            </h4>
                            <p>Declaration: Notice of Wish to be treated as a Professional client</p>
                            <p>Under the EU’s Markets in Financial Instruments Directive (MiFID), I wish to be treated as an
                                elective Professional client if, subject to your assessment of my expertise, experience, and
                                knowledge of me you are reasonably assured, in light of the nature of the transactions or services
                                envisaged, that I am capable of making my own investment decisions and understand the risks
                                involved. In making your assessment I understand you may rely on information already in your
                                possession and you may request further additional information from me if necessary.</p>
                            <p>As a consequence of this assessment and classification as a Professional client I understand you
                                will be able to promote various financial products and investment opportunities to me. I also
                                understand you are required to obtain written acknowledgement from me that I have been provided
                                with a written notice (as detailed in the above letter) in regards of me being treated as a
                                Professional client.</p>
                            <p>I warrant that I have the necessary expertise, experience and knowledge of making my own
                                investment decisions and understand the risks involved in investing in the financial products and
                                investment opportunities being marketed to me.</p>
                            <p>I also confirm that I have read and understand the differences between the treatment of
                                Professional and Retail clients and that I fully understand the protections and compensation
                                rights that I may lose and the consequences of losing such protections.</p>
                            <p>I am fully aware that it is up to me to keep the firm informed of any change that could
                                affect my categorisation.</p>
                            <p>On the basis of the above information I can confirm that the firm may treat me as a
                                Professional client.</p>';
    }

    /* <p>Name:</p>
    <p>Email Id:</p>
    <p>Date:</p>'; */

    $electiveProfInvestorQuizStatementDeclaration = array(
        'statement'   => $statement,
        'declaration' => $declaration,
    );

    return $electiveProfInvestorQuizStatementDeclaration;
}

function genActiveCertificationValidityHtml($investorCertification, $fileId)
{
    $certificationDate = $investorCertification->created_at;
    $certificationName = $investorCertification->certification()->name;
    $expiryDate        = date('Y-m-d', strtotime($certificationDate . '+1 year'));

    $d1       = new \DateTime($expiryDate);
    $d2       = new \DateTime();
    $interval = $d2->diff($d1);

    $validity = '';
    // if($interval->y == 1)
    // {
    //     $validity = 'a Year';
    // }
    // elseif($interval->m > 1)
    // {
    //     $validity = $interval->m.' months';
    // }
    // elseif($interval->m == 1)
    // {
    //     $validity = $interval->m.' months';
    // }
    // elseif($interval->d > 1)
    // {
    //     $validity = $interval->d.' days';
    // }
    // elseif($interval->d == 1)
    // {
    //     $validity = $interval->d.' day';
    // }

    if ($interval->y == 1) {
        $validity .= 'a Year ';
    }

    if ($interval->m > 1) {
        $validity .= $interval->m . ' months';
    } elseif ($interval->m == 1) {
        $validity .= $interval->m . ' month';
    }

    if ($interval->m >= 1) {
        $validity .= ' and ';
    }

    if ($interval->d > 1) {
        $validity .= $interval->d . ' days';
    } elseif ($interval->d == 1) {
        $validity .= $interval->d . ' day';
    }

    // $validity = $interval->format('%y years %m months and %d days');

    $html = '<div class="alert bg-gray certification-success">
        <div class="l-30">
        <h5 class="">' . $certificationName . ' Certification</h5>

            <i class="icon icon-ok text-success"></i> Certified on
         <span class="date-rem">' . date('d/m/Y', strtotime($certificationDate)) . '
            <a href="' . url('backoffice/investor/download-certification/' . $fileId) . '" target="_blank">(Click to download)</a>
        </span>&nbsp;
        <span class="text-danger">
            and valid for: ' . $validity . '
        </span>
        </div>
    </div>';

    return $html;

}

function getSectors()
{
    return ['Transport', 'Technology ( Social )', 'Technology ( Platform )', 'Technology ( App )', 'Bloodstock', 'Research', 'Publishing', 'Music', 'Film', 'Exports', 'Nutrition', 'Estate Agency', 'Marketing', 'Financial', 'Home Improvement', 'Dentistry', 'Advertising', 'Security', 'Environmental', 'Fashion'];
}

/**
 * Gets the ordinal number. used for business round display
 *
 * @param      array|integer|string  $number  The number
 *
 * @return     array|integer|string  The ordinal number.
 */
function get_ordinal_number($number)
{

    if ($number == 0 || $number == "") {
        return "";
    }

    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if (($number % 100) >= 11 && ($number % 100) <= 13) {
        $abbreviation = $number . 'th';
    } else {
        $abbreviation = $number . $ends[$number % 10];
    }

    return $abbreviation;

}

function check_null($num)
{

    if (is_null($num)) {
        return 0;
    } else {
        return $num;
    }

}

function format_amount($amount, $decimal = 0, $prefix = false, $commafy = true)
{

    if (($amount === '') || (is_null($amount))) {
        return '';
    }

    $commafy_char = "";
    if ($commafy) {
        $commafy_char = ",";
    }

    $amount = number_format($amount, $decimal, '.', $commafy_char);

    if ($prefix) {

        $amount = " &pound; " . $amount;

    }

    return $amount;
}

function getObjectComments($objectType, $objectId, $parent)
{
    $commentData = [];
    $comments    = \App\Comment::where('object_type', $objectType)->where('object_id', $objectId)->where('parent', $parent)->orderBy('created_at', 'desc')->get();

    if ($comments->count()) {
        foreach ($comments as $key => $comment) {
            $comment['reply'] = getObjectComments($objectType, $objectId, $comment->id);
        }
    }

    return $comments;

}



/**
 * Store logged in user menu in session
 */

function storeUserMenus($user)
{

    $user_permissions = [];

    $user_permissions_ar = $user->getAllPermissions();
    $user_roles          = $user->getRoleNames(); // Returns a collection

    foreach ($user_permissions_ar as $key => $value) {
        $user_permissions[] = ($value->getAttribute('name'));
    }

    $admin_menus = getUserAdminMenus($user_permissions);
    //$dashboard_menus = $this->getUserDashboardMenus($user_roles,$user_permissions);

    $user_data['role'] = isset($user_roles[0]) ? $user_roles[0] : '';

    session(['user_data' => $user_data]);
    session(['user_menus' => array('admin' => $admin_menus)]);

}

function getUserAdminMenus($user_permissions)
{
    $menus = [];

    if (count(array_intersect($user_permissions, array('manage_options', 'edit_my_firm'))) > 0) {

        if (count(array_intersect($user_permissions, array('manage_options', 'view_firms'))) > 0) {

            $menus[] = ['url' => url('backoffice/user/all'), 'name' => 'Manage'];
        }

        if (in_array('manage_options', $user_permissions)) {

            $menus[] = ['url' => '#Statistics', 'name' => 'Statistics'];
            $menus[] = ['url' => '#View-document-templates', 'name' => 'View Document Templates'];
            $menus[] = ['url' => '#View-email-templates', 'name' => 'View Email Templates'];

            if (in_array('view_groups', $user_permissions)) {

                $menus[] = ['url' => '#view-groups', 'name' => 'View Groups'];
            }

            if (count(array_intersect($user_permissions, array('view_firm_leads', 'view_all_leads'))) > 0) {

                $menus[] = ['url' => '#view-leads', 'name' => 'View Leads'];
            }

        }

    }

    return $menus;
}

<?php
/**
generic method to fetch list of records from model
$modelName : 'App/User';
$filters: ['id'=>1]
$orderDataBy: ['id'=>'desc']
 **/
function getModelList($modelName, $filters = [], $skip = 0, $length = 0, $orderDataBy = [], $inCond = [])
{

    $model = new $modelName;

    if (empty($filters)) {
        $modelQuery = $model::select('*');
    } else {
        $modelQuery = $model::where($filters);
    }

    foreach ($inCond as $key => $values) {
        $modelQuery->whereIn($key, $values);
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

function isUser($object,$hasRolePermission){
    if($object->hasAnyRole($hasRolePermission))
        return true;
    else
        return false;
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

function getDefaultImages($type)
{
    $url = url('img/dummy/logo.png');
    if (in_array($type, ['profile_picture'])) {
        $url = url('img/dummy/avatar.png');
    } elseif (in_array($type, ['company_logo', 'firm_logo'])) {
        $url = url('img/dummy/logo.png');
    } elseif (in_array($type, ['business_logo'])) {
        $url = url('img/dummy/seedavtar.jpg');
    }

    return $url;
}

function investmentOfferType()
{
    return ["fund" => "Fund", "proposal" => "Single Company"];
}

function investmentTaxStatus()
{
    return ["eis" => "EIS", "seis" => "SEIS", "vct" => "VCT", "iht" => "BR", "sitr" => "SITR"];
}

function typeOfAssets()
{
    $staticarr = ['single_company' => 'Single Company',
        'seis_eis_portfolio'           => 'SEIS/EIS Portfolio',
        'iht_service'                  => 'IHT Service',
        'vct'                          => 'VCT'];

    return $staticarr;
}

function getCountry()
{
    return ["GB" => "United Kingdom", "AF" => "Afghanistan", "AX" => "Aland Islands", "AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua And Barbuda", "AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria", "AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados", "BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda", "BT" => "Bhutan", "BO" => "Bolivia", "BA" => "Bosnia And Herzegovina", "BW" => "Botswana", "BV" => "Bouvet Island", "BR" => "Brazil", "IO" => "British Indian Ocean Territory", "BN" => "Brunei Darussalam", "BG" => "Bulgaria", "BF" => "Burkina Faso", "BI" => "Burundi", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada", "CV" => "Cape Verde", "KY" => "Cayman Islands", "CF" => "Central African Republic", "TD" => "Chad", "CL" => "Chile", "CN" => "China", "CX" => "Christmas Island", "CC" => "Cocos (Keeling) Islands", "CO" => "Colombia", "KM" => "Comoros", "CG" => "Congo", "CD" => "Congo,Democratic Republic", "CK" => "Cook Islands", "CR" => "Costa Rica", "CI" => "Cote D'Ivoire", "HR" => "Croatia", "CU" => "Cuba", "CY" => "Cyprus", "CZ" => "Czech Republic", "DK" => "Denmark", "DJ" => "Djibouti", "DM" => "Dominica", "DO" => "Dominican Republic", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea", "ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FK" => "Falkland Islands (Malvinas)", "FO" => "Faroe Islands", "FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia", "TF" => "French Southern Territories", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany", "GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea", "GW" => "Guinea-Bissau", "GY" => "Guyana", "HT" => "Haiti", "HM" => "Heard Island & Mcdonald Islands", "VA" => "Holy See (Vatican City State)", "HN" => "Honduras", "HK" => "Hong Kong", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India", "ID" => "Indonesia", "IR" => "Iran, Islamic Republic Of", "IQ" => "Iraq", "IE" => "Ireland", "IM" => "Isle Of Man", "IL" => "Israel", "IT" => "Italy", "JM" => "Jamaica", "JP" => "Japan", "JE" => "Jersey", "JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KI" => "Kiribati", "KR" => "Korea", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LA" => "Lao People's Democratic Republic", "LV" => "Latvia", "LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libyan Arab Jamahiriya", "LI" => "Liechtenstein", "LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macao", "MK" => "Macedonia", "MG" => "Madagascar", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "YT" => "Mayotte", "MX" => "Mexico", "FM" => "Micronesia, Federated States Of", "MD" => "Moldova", "MC" => "Monaco", "MN" => "Mongolia", "ME" => "Montenegro", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "MM" => "Myanmar", "NA" => "Namibia", "NR" => "Nauru", "NP" => "Nepal", "NL" => "Netherlands", "AN" => "Netherlands Antilles", "NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria", "NU" => "Niue", "NF" => "Norfolk Island", "MP" => "Northern Mariana Islands", "NO" => "Norway", "OM" => "Oman", "PK" => "Pakistan", "PW" => "Palau", "PS" => "Palestinian Territory, Occupied", "PA" => "Panama", "PG" => "Papua New Guinea", "PY" => "Paraguay", "PE" => "Peru", "PH" => "Philippines", "PN" => "Pitcairn", "PL" => "Poland", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RE" => "Reunion", "RO" => "Romania", "RU" => "Russian Federation", "RW" => "Rwanda", "BL" => "Saint Barthelemy", "SH" => "Saint Helena", "KN" => "Saint Kitts And Nevis", "LC" => "Saint Lucia", "MF" => "Saint Martin", "PM" => "Saint Pierre And Miquelon", "VC" => "Saint Vincent And Grenadines", "WS" => "Samoa", "SM" => "San Marino", "ST" => "Sao Tome And Principe", "SA" => "Saudi Arabia", "SN" => "Senegal", "RS" => "Serbia", "SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SK" => "Slovakia", "SI" => "Slovenia", "SB" => "Solomon Islands", "SO" => "Somalia", "ZA" => "South Africa", "GS" => "South Georgia And Sandwich Isl.", "ES" => "Spain", "LK" => "Sri Lanka", "SD" => "Sudan", "SR" => "Suriname", "SJ" => "Svalbard And Jan Mayen", "SZ" => "Swaziland", "SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syrian Arab Republic", "TW" => "Taiwan", "TJ" => "Tajikistan", "TZ" => "Tanzania", "TH" => "Thailand", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau", "TO" => "Tonga", "TT" => "Trinidad And Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TM" => "Turkmenistan", "TC" => "Turks And Caicos Islands", "TV" => "Tuvalu", "UG" => "Uganda", "UA" => "Ukraine", "AE" => "United Arab Emirates", "US" => "United States", "UM" => "United States Outlying Islands", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VU" => "Vanuatu", "VE" => "Venezuela", "VN" => "Viet Nam", "VG" => "Virgin Islands, British", "VI" => "Virgin Islands, U.S.", "WF" => "Wallis And Futuna", "EH" => "Western Sahara", "YE" => "Yemen", "ZM" => "Zambia", "ZW" => "Zimbabwe"];
}

function getCountrycodeAlpha2ToAlpha3()
{

    $country_code['AF'] = 'AFG';
    $country_code['AL'] = 'ALB';
    $country_code['DZ'] = 'DZA';
    $country_code['AS'] = 'ASM';
    $country_code['AD'] = 'AND';
    $country_code['AO'] = 'AGO';
    $country_code['AI'] = 'AIA';
    $country_code['AQ'] = 'ATA';
    $country_code['AG'] = 'ATG';
    $country_code['AR'] = 'ARG';
    $country_code['AM'] = 'ARM';
    $country_code['AW'] = 'ABW';
    $country_code['AU'] = 'AUS';
    $country_code['AT'] = 'AUT';
    $country_code['AZ'] = 'AZE';
    $country_code['BS'] = 'BHS';
    $country_code['BH'] = 'BHR';
    $country_code['BD'] = 'BGD';
    $country_code['BB'] = 'BRB';
    $country_code['BY'] = 'BLR';
    $country_code['BE'] = 'BEL';
    $country_code['BZ'] = 'BLZ';
    $country_code['BJ'] = 'BEN';
    $country_code['BM'] = 'BMU';
    $country_code['BT'] = 'BTN';
    $country_code['BO'] = 'BOL';
    $country_code['BA'] = 'BIH';
    $country_code['BW'] = 'BWA';
    $country_code['BV'] = 'BVT';
    $country_code['BR'] = 'BRA';
    $country_code['IO'] = 'IOT';
    $country_code['VG'] = 'VGB';
    $country_code['BN'] = 'BRN';
    $country_code['BG'] = 'BGR';
    $country_code['BF'] = 'BFA';
    $country_code['BI'] = 'BDI';
    $country_code['KH'] = 'KHM';
    $country_code['CM'] = 'CMR';
    $country_code['CA'] = 'CAN';
    $country_code['CV'] = 'CPV';
    $country_code['KY'] = 'CYM';
    $country_code['CF'] = 'CAF';
    $country_code['TD'] = 'TCD';
    $country_code['CL'] = 'CHL';
    $country_code['CN'] = 'CHN';
    $country_code['CX'] = 'CXR';
    $country_code['CC'] = 'CCK';
    $country_code['CO'] = 'COL';
    $country_code['KM'] = 'COM';
    $country_code['CD'] = 'COD';
    $country_code['CG'] = 'COG';
    $country_code['CK'] = 'COK';
    $country_code['CR'] = 'CRI';
    $country_code['CI'] = 'CIV';
    $country_code['CU'] = 'CUB';
    $country_code['CY'] = 'CYP';
    $country_code['CZ'] = 'CZE';
    $country_code['DK'] = 'DNK';
    $country_code['DJ'] = 'DJI';
    $country_code['DM'] = 'DMA';
    $country_code['DO'] = 'DOM';
    $country_code['EC'] = 'ECU';
    $country_code['EG'] = 'EGY';
    $country_code['SV'] = 'SLV';
    $country_code['GQ'] = 'GNQ';
    $country_code['ER'] = 'ERI';
    $country_code['EE'] = 'EST';
    $country_code['ET'] = 'ETH';
    $country_code['FO'] = 'FRO';
    $country_code['FK'] = 'FLK';
    $country_code['FJ'] = 'FJI';
    $country_code['FI'] = 'FIN';
    $country_code['FR'] = 'FRA';
    $country_code['GF'] = 'GUF';
    $country_code['PF'] = 'PYF';
    $country_code['TF'] = 'ATF';
    $country_code['GA'] = 'GAB';
    $country_code['GM'] = 'GMB';
    $country_code['GE'] = 'GEO';
    $country_code['DE'] = 'DEU';
    $country_code['GH'] = 'GHA';
    $country_code['GI'] = 'GIB';
    $country_code['GR'] = 'GRC';
    $country_code['GL'] = 'GRL';
    $country_code['GD'] = 'GRD';
    $country_code['GP'] = 'GLP';
    $country_code['GU'] = 'GUM';
    $country_code['GT'] = 'GTM';
    $country_code['GN'] = 'GIN';
    $country_code['GW'] = 'GNB';
    $country_code['GY'] = 'GUY';
    $country_code['HT'] = 'HTI';
    $country_code['HM'] = 'HMD';
    $country_code['VA'] = 'VAT';
    $country_code['HN'] = 'HND';
    $country_code['HK'] = 'HKG';
    $country_code['HR'] = 'HRV';
    $country_code['HU'] = 'HUN';
    $country_code['IS'] = 'ISL';
    $country_code['IN'] = 'IND';
    $country_code['ID'] = 'IDN';
    $country_code['IR'] = 'IRN';
    $country_code['IQ'] = 'IRQ';
    $country_code['IE'] = 'IRL';
    $country_code['IL'] = 'ISR';
    $country_code['IT'] = 'ITA';
    $country_code['JM'] = 'JAM';
    $country_code['JP'] = 'JPN';
    $country_code['JO'] = 'JOR';
    $country_code['KZ'] = 'KAZ';
    $country_code['KE'] = 'KEN';
    $country_code['KI'] = 'KIR';
    $country_code['KP'] = 'PRK';
    $country_code['KR'] = 'KOR';
    $country_code['KW'] = 'KWT';
    $country_code['KG'] = 'KGZ';
    $country_code['LA'] = 'LAO';
    $country_code['LV'] = 'LVA';
    $country_code['LB'] = 'LBN';
    $country_code['LS'] = 'LSO';
    $country_code['LR'] = 'LBR';
    $country_code['LY'] = 'LBY';
    $country_code['LI'] = 'LIE';
    $country_code['LT'] = 'LTU';
    $country_code['LU'] = 'LUX';
    $country_code['MO'] = 'MAC';
    $country_code['MK'] = 'MKD';
    $country_code['MG'] = 'MDG';
    $country_code['MW'] = 'MWI';
    $country_code['MY'] = 'MYS';
    $country_code['MV'] = 'MDV';
    $country_code['ML'] = 'MLI';
    $country_code['MT'] = 'MLT';
    $country_code['MH'] = 'MHL';
    $country_code['MQ'] = 'MTQ';
    $country_code['MR'] = 'MRT';
    $country_code['MU'] = 'MUS';
    $country_code['YT'] = 'MYT';
    $country_code['MX'] = 'MEX';
    $country_code['FM'] = 'FSM';
    $country_code['MD'] = 'MDA';
    $country_code['MC'] = 'MCO';
    $country_code['MN'] = 'MNG';
    $country_code['MS'] = 'MSR';
    $country_code['MA'] = 'MAR';
    $country_code['MZ'] = 'MOZ';
    $country_code['MM'] = 'MMR';
    $country_code['NA'] = 'NAM';
    $country_code['NR'] = 'NRU';
    $country_code['NP'] = 'NPL';
    $country_code['AN'] = 'ANT';
    $country_code['NL'] = 'NLD';
    $country_code['NC'] = 'NCL';
    $country_code['NZ'] = 'NZL';
    $country_code['NI'] = 'NIC';
    $country_code['NE'] = 'NER';
    $country_code['NG'] = 'NGA';
    $country_code['NU'] = 'NIU';
    $country_code['NF'] = 'NFK';
    $country_code['MP'] = 'MNP';
    $country_code['NO'] = 'NOR';
    $country_code['OM'] = 'OMN';
    $country_code['PK'] = 'PAK';
    $country_code['PW'] = 'PLW';
    $country_code['PS'] = 'PSE';
    $country_code['PA'] = 'PAN';
    $country_code['PG'] = 'PNG';
    $country_code['PY'] = 'PRY';
    $country_code['PE'] = 'PER';
    $country_code['PH'] = 'PHL';
    $country_code['PN'] = 'PCN';
    $country_code['PL'] = 'POL';
    $country_code['PT'] = 'PRT';
    $country_code['PR'] = 'PRI';
    $country_code['QA'] = 'QAT';
    $country_code['RE'] = 'REU';
    $country_code['RO'] = 'ROU';
    $country_code['RU'] = 'RUS';
    $country_code['RW'] = 'RWA';
    $country_code['SH'] = 'SHN';
    $country_code['KN'] = 'KNA';
    $country_code['LC'] = 'LCA';
    $country_code['PM'] = 'SPM';
    $country_code['VC'] = 'VCT';
    $country_code['WS'] = 'WSM';
    $country_code['SM'] = 'SMR';
    $country_code['ST'] = 'STP';
    $country_code['SA'] = 'SAU';
    $country_code['SN'] = 'SEN';
    $country_code['CS'] = 'SCG';
    $country_code['SC'] = 'SYC';
    $country_code['SL'] = 'SLE';
    $country_code['SG'] = 'SGP';
    $country_code['SK'] = 'SVK';
    $country_code['SI'] = 'SVN';
    $country_code['SB'] = 'SLB';
    $country_code['SO'] = 'SOM';
    $country_code['ZA'] = 'ZAF';
    $country_code['GS'] = 'SGS';
    $country_code['ES'] = 'ESP';
    $country_code['LK'] = 'LKA';
    $country_code['SD'] = 'SDN';
    $country_code['SR'] = 'SUR';
    $country_code['SJ'] = 'SJM';
    $country_code['SZ'] = 'SWZ';
    $country_code['SE'] = 'SWE';
    $country_code['CH'] = 'CHE';
    $country_code['SY'] = 'SYR';
    $country_code['TW'] = 'TWN';
    $country_code['TJ'] = 'TJK';
    $country_code['TZ'] = 'TZA';
    $country_code['TH'] = 'THA';
    $country_code['TL'] = 'TLS';
    $country_code['TG'] = 'TGO';
    $country_code['TK'] = 'TKL';
    $country_code['TO'] = 'TON';
    $country_code['TT'] = 'TTO';
    $country_code['TN'] = 'TUN';
    $country_code['TR'] = 'TUR';
    $country_code['TM'] = 'TKM';
    $country_code['TC'] = 'TCA';
    $country_code['TV'] = 'TUV';
    $country_code['VI'] = 'VIR';
    $country_code['UG'] = 'UGA';
    $country_code['UA'] = 'UKR';
    $country_code['AE'] = 'ARE';
    $country_code['GB'] = 'GBR';
    $country_code['UM'] = 'UMI';
    $country_code['US'] = 'USA';
    $country_code['UY'] = 'URY';
    $country_code['UZ'] = 'UZB';
    $country_code['VU'] = 'VUT';
    $country_code['VE'] = 'VEN';
    $country_code['VN'] = 'VNM';
    $country_code['WF'] = 'WLF';
    $country_code['EH'] = 'ESH';
    $country_code['YE'] = 'YEM';
    $country_code['ZM'] = 'ZMB';
    $country_code['ZW'] = 'ZWE';

    return $country_code;

};

function durationType($type='all')
{
    if($type=='all'){
        $duration = [
            "today"        => "Today",
            "last7d"       => "Last 7 Days",
            "lastfd"       => 'Last 15 Days',
            "thismonth"    => 'This Month',
            "lastmonth"    => 'Last Month',
            "lasttwomonth" => 'Last Two Month',
            "thisquater"   => 'This Quarter',
            "lastquater"   => 'Last Quarter',
            "yeartodate"   => 'Year to Date',
            "last12month"  => 'Last 12 Months',
        ];
    }
    else{
        $duration = [
            "thisquater"   => 'This Quarter',
            "lastquater"   => 'Last Quarter',
            "yeartodate"   => 'Year to Date',
            "last12month"  => 'Last 12 Months',
        ];
    }
    

    return $duration;

}

function getDateByPeriod($period,$arg=[])
{
    $fromDate = '';
    $toDate   = '';

    $currentDate  = date('Y-m-d');
    $currentMonth = date('m');
    $currentYear  = date('Y');

    if ($period == 'today') {
        $fromDate = $currentDate;
        $toDate   = $currentDate;
    } elseif ($period == 'last7d') {
        $fromDate = date('Y-m-d', strtotime('- 7 days'));
        $toDate   = date('Y-m-d');
    } elseif ($period == 'lastfd') {
        $fromDate = date('Y-m-d', strtotime('- 15 days'));
        $toDate   = date('Y-m-d');
    } elseif ($period == 'lastfd') {
        $fromDate = date('Y-m-d', strtotime('- 15 days'));
        $toDate   = date('Y-m-d');
    } elseif ($period == 'thismonth') {
        $fromDate = date('Y-m-01');
        $toDate   = date('Y-m-t');
    } elseif ($period == 'lastmonth') {
        $fromDate = date('Y-m-d', strtotime('first day of last month'));
        $toDate   = date('Y-m-d', strtotime('last day of last month'));
    } elseif ($period == 'lasttwomonth') {
        $fromDate = date('Y-m-d', strtotime('- 2 months'));
        $toDate   = date('Y-m-d');
    } elseif ($period == 'thisquater') {

        if ($currentMonth >= 1 && $currentMonth <= 3) {
            $startDate = strtotime('01-01-' . $currentYear); // timestamp or 1-Januray 12:00:00 AM
            $endDate   = strtotime('01-04-' . $currentYear); // timestamp or 1-April 12:00:00 AM means end of 31 March
        } else if ($currentMonth >= 4 && $currentMonth <= 6) {
            $startDate = strtotime('01-04-' . $currentYear); // timestamp or 1-April 12:00:00 AM
            $endDate   = strtotime('01-07-' . $currentYear); // timestamp or 1-July 12:00:00 AM means end of 30 June
        } else if ($currentMonth >= 7 && $currentMonth <= 9) {
            $startDate = strtotime('01-07-' . $currentYear); // timestamp or 1-July 12:00:00 AM
            $endDate   = strtotime('01-10-' . $currentYear); // timestamp or 1-October 12:00:00 AM means end of 30 September
        } else if ($currentMonth >= 10 && $currentMonth <= 12) {
            $startDate = strtotime('01-10-' . $currentYear); // timestamp or 1-October 12:00:00 AM
            $endDate   = strtotime('01-01-' . ($currentYear + 1)); // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
        }

        $fromDate = date("Y-m-d", $startDate);
        $toDate   = date("Y-m-d", strtotime('-1 day', $endDate));
    } elseif ($period == 'lastquater') {

        if ($currentMonth >= 1 && $currentMonth <= 3) {
            $startDate = strtotime('01-10-' . ($currentYear - 1)); // timestamp or 1-October Last Year 12:00:00 AM
            $endDate   = strtotime('01-01-' . $currentYear); // // timestamp or 1-January  12:00:00 AM means end of 31 December Last year
        } else if ($currentMonth >= 4 && $currentMonth <= 6) {
            $startDate = strtotime('01-01-' . $currentYear); // timestamp or 1-Januray 12:00:00 AM
            $endDate   = strtotime('01-04-' . $currentYear); // timestamp or 1-April 12:00:00 AM means end of 31 March
        } else if ($currentMonth >= 7 && $currentMonth <= 9) {
            $startDate = strtotime('01-04-' . $currentYear); // timestamp or 1-April 12:00:00 AM
            $endDate   = strtotime('01-07-' . $currentYear); // timestamp or 1-July 12:00:00 AM means end of 30 June
        } else if ($currentMonth >= 10 && $currentMonth <= 12) {
            $startDate = strtotime('01-07-' . $currentYear); // timestamp or 1-July 12:00:00 AM
            $endDate   = strtotime('01-10-' . $currentYear); // timestamp or 1-October 12:00:00 AM means end of 30 September
        }
        $fromDate = date("Y-m-d", $startDate);
        $toDate   = date("Y-m-d", strtotime('-1 day', $endDate));
    } elseif ($period == 'yeartodate') {
        $fromDate = date('Y-01-01');
        $toDate   = date('Y-12-31');
    } elseif ($period == 'last12month') {
        $fromDate = date('Y-m-d', strtotime('- 12 months'));
        $toDate   = date('Y-m-d');
    }
    elseif ($period == 'financialyr') {
        $year = $arg['year'];
        $splitDate=explode('-', $year);
        $startDate = strtotime('6-April-'.$splitDate[0]);  // timestamp or 1-Januray 12:00:00 AM
        $endDate = strtotime('5-April-'.$splitDate[1]);
        $fromDate=date("Y-m-d", $startDate);
        $toDate=date("Y-m-d",  $endDate);
    }

    return ['fromDate' => $fromDate, 'toDate' => $toDate];
}

function activityTypeList()
{
    $activity_array = [
        'watchlist'                                   => 'Watch List',
        'registered_interest'                         => 'Expressed Interest',
        'request_meeting'                             => 'Request Meeting',
        'pledge_added'                                => 'Pledge Added',
        'pledge_updated'                              => 'Pledge Updated',
        'request_extra_dd_added'                      => 'Request Additional Information Added',
        'request_extra_dd_updated'                    => 'Request Additional Information Updated',
        'invested'                                    => 'Invested',
        'download'                                    => 'Download Key And Additional',
        'certification'                               => 'Certification',
        'registration'                                => 'Registration',
        'proposal_creation'                           => 'Proposal Creation',
        'fund_creation'                               => 'Fund Creation',
        'proposal_status_update'                      => 'Proposal Status Update',
        'fund_status_update'                          => 'Fund Status Update',
        'proposal_details_update'                     => 'Proposal Details Update',
        'fund_details_update'                         => 'Fund Details Update',
        'proposal_post_update'                        => 'Proposal Post Update',
        'due_diligence_update'                        => 'Due Diligence Update',
        'investor_message'                            => 'Investor Message',
        'qa_message'                                  => 'QA Message',
        'nominee_application'                         => 'Nominee Application',
        'auth_fail'                                   => 'Login Failed',
        'view_proposal'                               => 'Viewed Proposal',
        'onfido_requested'                            => 'Onfido - Requested',

        'stage1_investor_registration'                => 'Stage 1 Investor Registration',
        'entrepreneur_account_registration'           => 'Entrepreneur Account Registration',
        'fundmanager_account_registration'            => 'Fundmanager Account Registration',
        'onfido_confirmed'                            => 'Onfido - Confirmed',
        'fund_proposal_post_update'                   => 'Fund Proposal Post Update',
        'download_summary'                            => 'Download Summary',
        'removed_from_watchlist'                      => 'Removed From Watchlist',
        'download_fund_summary'                       => 'Download Fund Summary',
        'download_dd_report'                          => 'Download Platform DD Report',
        'download_dd_report1'                         => 'Download DD Report 1',
        'download_dd_report2'                         => 'Download DD Report 2',
        'download_finan_proj'                         => 'Download Financial Projection',
        'download_presentatation'                     => 'Download Presentation',
        'download_information_memorandum'             => 'Download - Information Memorandum',
        'download_app_forms'                          => 'Download - App Forms',
        'social_media_facebook'                       => 'Social Media - Facebook',
        'social_media_twitter'                        => 'Social Media - Twitter',
        'social_media_linkedin'                       => 'Social Media - Linkedin',
        'social_media_google'                         => 'Social Media - G+',
        'management_team_linked_in_clicks'            => 'Management Team - Linked-in clicks',
        'invest_button_proposal'                      => 'Invest Button (proposal)',
        'fund_investment_button'                      => 'Fund Investment Button',
        'invest_button_invest_tab'                    => 'Invest Button (Invest tab)',
        'successful_logins'                           => 'Successful Login',

        'download_client_registration_guide'          => 'Download Client Registration Guide',
        'download_investor_csv'                       => 'Download Investor CSV',
        'download_transfer_asset_guide'               => 'Download Transfer Asset Guide',
        'download_vct_asset_transfer_form'            => 'Download VCT Asset Transfer Form',
        'download_single_company_asset_transfer_form' => 'Download Single Company Asset Transfer Form',
        'download_iht_product_asset_transfer_form'    => 'Download IHT Product Asset Transfer Form',
        'download_portfolio_asset_transfer_form'      => 'Download Portfolio Asset Transfer Form',
        'download_stock_transfer_form'                => 'Download Stock Transfer Form',
        'submitted_transfers'                         => 'Submitted Transfers',
        'status_changes_for_asset_transfers'          => 'Status Changes For Asset Transfers',
        'transfers_deleted'                           => 'Transfers Deleted',
        'new_provider_added'                          => 'New Provider Added',
        'start_adobe_sign'                            => 'Start Adobe Sign',
        'completed_adobe_sign'                        => 'Completed Adobe Sign',
        'external_downloads'                          => 'External Downloads',
        'stage_3_profile_details'                     => 'Stage 3 Profile Details',
        'cash_deposits'                               => 'Cash deposits',
        'cash_withdrawl'                              => 'Cash withdrawal',
    ];

    asort($activity_array);
    return $activity_array;

}

function convertCountrycodeAlpha2Alpha3($alpha2_country_code)
{

    $country_codes = getCountrycodeAlpha2ToAlpha3();
    if (isset($country_codes[$alpha2_country_code])) {
        return $country_codes[$alpha2_country_code];
    } else {
        return false;
    }

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

/**
 * This function is used to send email for each event
 * This function will send an email to given recipients
 * @param data can contain the following extra parameters
 *   @param template_data
 *   @param to
 *   @param cc
 *   @param bcc
 *   @param from
 *   @param name
 *   @param subject
 *   @param delay  - @var integer
 *   @param priority - @var string -> ['low','default','high']
 *   @param attach - An Array of arrays each containing the following parameters:
 *           @param file - base64 encoded raw file
 *           @param as - filename to be given to the attachment
 *           @param mime - mime of the attachment
 */
function sendEmail($event = 'welcome', $data = [])
{
    $email = new \Ajency\Comm\Models\EmailRecipient();
    /* from */
    $from = (isset($data['from'])) ? $data['from'] : config('constants.email.defaultID');
    $name = (isset($data['name'])) ? $data['name'] : config('constants.email.defaultName');
    $from = sendEmailTo($from, 'from');
    $email->setFrom($from, $name);
    /* to */
    if (!isset($data['to'])) {
        $data['to'] = [];
    } else
    if (!is_array($data['to'])) // If not in array format
    {
        $data['to'] = [$data['to']];
    }

    // $to = sendEmailTo($data['to'], 'to');
    $to = $data['to'];
    $email->setTo($to);
    /* cc */
    $cc = isset($data['cc']) ? sendEmailTo($data['cc'], 'cc') : sendEmailTo([], 'cc');
    if (!is_array($cc)) {
        $cc = [$cc];
    }

    $email->setCc($cc);
    /* bcc */
    if (isset($data['bcc'])) {
        $bcc = sendEmailTo($data['bcc'], 'bcc');
        $email->setCc($bcc);
    }

    $params = (isset($data['template_data'])) ? $data['template_data'] : [];
    if (!is_array($params)) {
        $params = [$params];
    }

    $params['email_subject'] = (isset($data['subject'])) ? $data['subject'] : "";

    $email->setParams($params);
    if (isset($data['attach'])) {
        $email->setAttachments($data['attach']);
    }

    $notify = new \Ajency\Comm\Communication\Notification();
    $notify->setEvent($event);
    $notify->setRecipientIds([$email]);
    // if(isset($data['delay']))  $data['delay'] = config('constants.send_delay_dev');

    if (isset($data['delay']) and is_integer($data['delay'])) {

        Illuminate\Support\Facades\Log::info('send email delay: ' . $data['delay']);
        $notify->setDelay($data['delay']);
    }
    if (isset($data['priority'])) {
        $notify->setPriority($data['priority']);
    }

    // dd($notify);
    // $notify->setRecipientIds([$email,$email1]);
    AjComm::sendNotification($notify);

}

/**
 *
 */
function getUploadFileUrl($id)
{
    $url = '';
    if (!empty($id)) {
        $fileUrl = \DB::select('select url  from  fileupload_files where id =' . $id);

        if (!empty($fileUrl)) {
            $url = $fileUrl[0]->url;
        }
    }

    return $url;
}

function getFileMimeType($ext)
{

    $mimeTypes = ['gif' => 'image/gif', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg', 'png' => 'image/png', 'svg' => 'image/svg+xml', 'pdf' => 'application/pdf', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'doc' => 'application/msword'];

    $mimeType = $mimeTypes[$ext];
    return $mimeType;
}

/**
 * This function is used to determine whether the Server Hosted is in Development or Production Mode
 * @return boolean
 */
function in_develop()
{
    if (in_array(env('APP_ENV'), config('constants.app_dev_envs'))) {
        return true;
    } else {
        return false;
    }
}

/**
 * This function will return Email IDs based on ENV if it is Development or Production mode
 */
function sendEmailTo($emails = [], $type = 'to')
{
    if (in_develop()) {
        $emails = config('constants.email_' . $type . '_dev');
    }

    return $emails;
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
    $investor          = $investorCertification->user;

    $today = date('Y-m-d');

    if (env('APP_ENV') == 'local') {
        $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 day'));
    } else {
        $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 year'));
    }

    // $validity = $interval->format('%y years %m months and %d days');

    $html = '<div class="alert bg-gray certification-success">
        <div class="l-30">
        <h5 class="">' . $certificationName . ' Certification</h5>';

    if ($today >= $expiryDate) {
        $invGiCode = $investorCertification->user->gi_code;
        $html .= '<span class="text-danger"> Date Expired : </span> <button class="btn btn-danger save-re-certification ld-ext-right" exp-client-category="' . $investorCertification->certification_default_id . '" type="button" get-input-class="retail-input">Re-Certify <div class="ld ld-ring ld-spin"></div></button>';
    } else {

        $d1       = new \DateTime($expiryDate);
        $d2       = new \DateTime();
        $interval = $d2->diff($d1);

        $validity = '';

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
        } else if ($interval->d == 0 && $d1 > $d2) {
            $validity .= '1 day';
        }

        $html .= '<i class="icon icon-ok text-success"></i> Certified on
             <span class="date-rem">' . date('d/m/Y', strtotime($certificationDate)) . '
                <a href="' . url('backoffice/investor/download-certification/' . $investor->gi_code) . '" target="_blank">(Click to download)</a>
            </span>&nbsp;
            <span class="text-danger">
                and valid for: ' . $validity . '
            </span>';
    }

    $html .= '</div>
    </div>';

    return $html;

}

function getSectors()
{
    return ['Transport', 'Technology ( Social )', 'Technology ( Platform )', 'Technology ( App )', 'Bloodstock', 'Research', 'Publishing', 'Music', 'Film', 'Exports', 'Nutrition', 'Estate Agency', 'Marketing', 'Financial', 'Home Improvement', 'Dentistry', 'Advertising', 'Security', 'Environmental', 'Fashion'];
}

function custodyType()
{
    return ['aic'=>'Custody', 'ainc'=>'Non-Custody'];
}

function getBusinessSectors()
{
    return \App\Defaults::where('type', 'business-sector')->where('status', '1')->get();
}

function aicSectors()
{
    return ['generalist'        => 'Generalist',
        'generalist_pre_qualifying' => 'Generalist Pre-Qualifying',
        'aim_quoted'                => 'AIM Quoted',
        'specialist_environmental'  => 'Specialist: Environmental',
        'specialist_technology'     => 'Specialist: Technology',
        'specialist_infrastructure' => 'Specialist: Infrastructure'];
}

function getDefaultValues($type){
    return \App\Defaults::where('type', $type)->where('status', '1')->get();
}

function getDueDeligence()
{
    // return \App\Defaults::where('type', 'approver')->where('status', '1')->get();
    return \App\Defaults::join('business_has_defaults', function ($join) {
        $join->on('defaults.id', '=', 'business_has_defaults.default_id');
    })->where('defaults.type', 'approver')->where('defaults.status', '1')->groupby('business_has_defaults.default_id')->select('defaults.*')->get();

}

function getStageOfBusiness()
{
    return \App\Defaults::join('business_has_defaults', function ($join) {
        $join->on('defaults.id', '=', 'business_has_defaults.default_id');
    })->where('defaults.type', 'stage_of_business')->where('defaults.status', '1')->groupby('business_has_defaults.default_id')->select('defaults.*')->get();

    // return \App\Defaults::where('type', 'stage_of_business')->where('status', '1')->get();
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

function calculateFiscalYearForDate($inputDate, $fyStart, $fyEnd){
    $date = strtotime($inputDate);
    $inputyear = strftime('%Y',$date);

    $fystartdate = strtotime($fyStart.'/'.$inputyear);
    $fyenddate = strtotime($fyEnd.'/'.$inputyear);

    if($date < $fyenddate){
       $fy = intval($inputyear);
       $prevyr = intval(intval($inputyear) - 1);
       $fyear=$prevyr.'-'.substr($fy, 2,4);
    }else{
       $fy = intval(intval($inputyear) + 1);
       $fyear=$inputyear.'-'.substr($fy, 2,4);
    }

    return $fyear;

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

function getFinancialYears($endYear=2011){
    $currYear = date('Y');
    $years = [];
    for ($i=$endYear; $i <= $currYear ; $i++) { 
        $j = $i-1;
        
        $years[] = $j.'-'.substr($i, -2);
    }
    krsort($years);
    return $years;
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

/* USER MENU END*/

/* CDN START */

function cdn($asset)
{

    //Check if we added cdn's to the config file

    if (!Config::get('app.cdn') || Config::get('app.cdn') == "") {
        return asset($asset);
    }

    //Get file name & cdn's

    $cdns = Config::get('app.cdn');

    $assetName = basename($asset);

    //remove any query string for matching

    $assetName = explode("?", $assetName);

    $assetName = $assetName[0];

    //Find the correct cdn to use

    foreach ($cdns as $cdn => $types) {

        if (preg_match('/^.*\.(' . $types . ')$/i', $assetName)) {
            return cdnPath($cdn, $asset);
        }

    }

    //If we couldnt match a cdn, use the last in the list.

    end($cdns);

    return cdnPath(key($cdns), $asset);

}

function cdnPath($cdn, $asset)
{

    return "//" . rtrim($cdn, "/") . "/" . ltrim($asset, "/");

}
/* CDN END */

function getRecipientsByCapability($recipients, $capabilities, $firmId = 0)
{

    if ($firmId) {
        $userEmails = \App\User::permission('add_user')->where('firm_id', $firmId)->select(\DB::raw("CONCAT(first_name,' ',last_name)  AS display_name"), 'email')->pluck('display_name', 'email')->toArray();
    } else {
        $userEmails = \App\User::permission('add_user')->select(\DB::raw("CONCAT(first_name,' ',last_name)  AS display_name"), 'email')->pluck('display_name', 'email')->toArray();
    }

    $recipients += $userEmails;

    //send only to one user if local
    if (env('APP_ENV') == 'local') {
        $rec = [];
        foreach ($recipients as $key => $recipient) {
            $rec[$key] = $recipient;
            break;
        }

        $recipients = $rec;
    }

    return $recipients;

}

function saveActivityLog($component, $userId, $type, $itemId, $action, $content = '', $secItemId = 0, $primaryLink = "")
{
    $giArgs = array('prefix' => "GIAC", 'min' => 90000001, 'max' => 100000000);

    $activity = new \App\Activity;
    $giCode   = generateGICode($activity, 'gi_platform_code', $giArgs);

    $activity->user_id           = $userId;
    $activity->component         = $component;
    $activity->type              = $type;
    $activity->action            = $action;
    $activity->content           = $content;
    $activity->primary_link      = $primaryLink;
    $activity->item_id           = $itemId;
    $activity->secondary_item_id = $secItemId;
    $activity->gi_platform_code  = $giCode;
    $activity->date_recorded     = date('Y-m-d H:i:s');
    $activity->save();

    return $activity;
}

function saveActivityMeta($activityId, $key, $value = [])
{
    $activityMeta              = new \App\ActivityMeta;
    $activityMeta->activity_id = $activityId;
    $activityMeta->meta_key    = $key;
    $activityMeta->meta_value  = $value;
    $activityMeta->save();
    return $activityMeta;
}

function activityQueryBuilder()
{

    $type_lists = \App\Actvity::select('distinct type')->get()->toArray(); //("select distinct type from activity " . $typewhere . "");

    $count               = 0;
    $union               = '';
    $select_activity_log = '';
    foreach ($type_lists as $type_list) {

        if ($count != 0) {
            $union = " union ";
        }

        $mainselect = "select a1.id,a1.component,a1.type,a1.action,a1.content,a1.primary_link,p2.post_title as firmname,a1.secondary_item_id";
        $maintable  = " from activity a1 ";
        $mainjoin   = " INNER JOIN " . $this->db->prefix . "posts p2 on p2.ID=a1.secondary_item_id";
        // $mainwhere = " where  a1.type='".$type_list->type."' ".$userwhere.$wheredate.$firmwhere;
        //$groupby=" group by a1.component,a1.type,date(a1.date_recorded),a1.secondary_item_id,a1.user_id,a1.item_id";
        $orderby = " order by date_recorded desc";

        switch ($type_list->type) {
            case 'nominee_application':
            /*case 'identity_verification_requested': */
            case 'onfido_requested':
            case 'onfido_confirmed':
            case 'certification':
            case 'registration':
            case 'stage1_investor_registration':
            case 'entrepreneur_account_registration':
            case 'fundmanager_account_registration':
            case 'successful_logins':
            case 'download_client_registration_guide':
            case 'download_investor_csv':
            case 'download_transfer_asset_guide':
            case 'download_vct_asset_transfer_form':
            case 'download_single_company_asset_transfer_form':
            case 'download_iht_product_asset_transfer_form':
            case 'download_portfolio_asset_transfer_form':
            case 'download_stock_transfer_form':
            case 'submitted_transfers':
            case 'status_changes_for_asset_transfers':
            case 'transfers_deleted':
            case 'start_adobe_sign':
            case 'completed_adobe_sign':
            case 'external_downloads':
            case 'stage_3_profile_details':
            case 'auth_fail':
            case 'cash_withdrawl':
            case 'cash_deposits':
                $customfieldselect = " ,a1.item_id as user_id,'' as itemname,u1.display_name as username ,u1.user_email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " LEFT OUTER JOIN " . $this->db->prefix . "users u1 on u1.ID=a1.item_id ";
                $customwhere       = $parent_child_firms;
                //overide the condition
                if ($parameters['userid'] != '') {
                    $userwhere = " and a1.item_id='" . $parameters['userid'] . "' ";
                }

                $mainjoin  = " LEFT OUTER JOIN " . $this->db->prefix . "posts p2 on p2.ID=a1.secondary_item_id";
                $mainwhere = " where  a1.type='" . $type_list->type . "' " . $userwhere . $wheredate . $firmwhere;
                $groupby   = "";
                break;
            case 'new_provider_added':
                $customfieldselect = " ,a1.item_id as user_id,cmp.name as itemname,u1.display_name as username ,u1.user_email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " INNER JOIN " . $this->db->prefix . "users u1 on u1.ID=a1.user_id
                               LEFT JOIN company_master cmp on  a1.item_id = cmp.id";
                $customwhere = $parent_child_firms;
                //overide the condition
                if ($parameters['userid'] != '') {
                    $userwhere = " and a1.item_id='" . $parameters['userid'] . "' ";
                }

                $mainwhere = " where  a1.type='" . $type_list->type . "' " . $userwhere . $wheredate . $firmwhere;
                $groupby   = "";
                break;

            case 'investor_message':
            case 'entrepreneur_message':
                /*  $customfieldselect =" ,a1.item_id as user_id , '' as itemname,u2.display_name as username ,'' as itemid,a1.date_recorded as date_recorded";
                $customjoin =" INNER JOIN ".$this->db->prefix."users u1 on u1.ID=a1.item_id
                INNER JOIN ".$this->db->prefix."users u2 on u2.ID=a1.user_id";
                $customwhere=$parent_child_firms;*/

                $customfieldselect = " ,a1.user_id as user_id,u1.display_name as itemname,u2.display_name as username ,u2.user_email as email,a1.item_id as itemid ,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " INNER JOIN " . $this->db->prefix . "users u1 on u1.ID=a1.item_id
                INNER JOIN " . $this->db->prefix . "users u2 on u2.ID=a1.user_id";
                $customwhere = $parent_child_firms;

                //overide the condition
                if ($parameters['userid'] != '') {
                    $userwhere = " and a1.item_id='" . $parameters['userid'] . "' ";
                }

                $mainwhere = " where  a1.type='" . $type_list->type . "' " . $userwhere . $wheredate . $firmwhere;
                $groupby   = "";
                break;

            case 'proposal_details_update':
            case 'fund_details_update':
                $customfieldselect = " ,a1.user_id as user_id,p1.post_title as itemname,u1.display_name as username ,u1.user_email as email,a1.item_id as itemid,max(a1.date_recorded) as date_recorded,p1.post_name as item_slug";
                $customjoin        = " INNER JOIN " . $this->db->prefix . "users u1 on u1.ID=a1.user_id
                         INNER JOIN " . $this->db->prefix . "posts p1 on p1.ID=a1.item_id";
                $customwhere = $parent_child_firms;

                //overide the condition
                if ($parameters['userid'] != '') {
                    $userwhere = " and a1.user_id='" . $parameters['userid'] . "' ";
                }

                if ($parameters['prop_id'] != '') {
                    $propwhere = " and a1.item_id='" . $parameters['prop_id'] . "' ";
                }

                $mainwhere = " where  a1.type='" . $type_list->type . "' " . $userwhere . $propwhere . $wheredate . $firmwhere;
                $groupby   = " group by a1.component,a1.type,date(a1.date_recorded),a1.secondary_item_id,a1.user_id,a1.item_id";
                break;

            /*case 'site_visitors':

            $mainjoin = "LEFT JOIN ".$this->db->prefix."posts p2 on p2.ID=a1.secondary_item_id";
            $customfieldselect =" ,a1.item_id as user_id,p1.post_title as itemname,u1.display_name as username ,'' as itemid,a1.date_recorded as date_recorded";
            $customjoin =" LEFT JOIN ".$this->db->prefix."users u1 on u1.ID=a1.user_id
            LEFT JOIN ".$this->db->prefix."posts p1 on p1.ID=a1.item_id";
            $customwhere=$parent_child_firms;
            //overide the condition
            if($parameters['userid']!='')
            $userwhere=" and a1.item_id='".$parameters['userid']."' ";

            $mainwhere = " where  a1.type='".$type_list->type."' ".$userwhere.$wheredate.$firmwhere;
            $groupby="";
            break;*/

            case 'invested':
                $customfieldselect = " ,a1.user_id as user_id,p1.post_title as itemname,u1.display_name as username ,u1.user_email as email,a1.item_id as itemid,a1.date_recorded as date_recorded,p1.post_name as item_slug";
                $customjoin        = " LEFT JOIN " . $this->db->prefix . "users u1 on u1.ID=a1.user_id
                         LEFT JOIN " . $this->db->prefix . "posts p1 on p1.ID=a1.item_id";
                $customwhere = $parent_child_firms;

                //overide the condition
                if ($parameters['userid'] != '') {
                    $userwhere = " and a1.user_id='" . $parameters['userid'] . "' ";
                }

                if ($parameters['prop_id'] != '') {
                    $propwhere = " and a1.item_id='" . $parameters['prop_id'] . "' ";
                }

                $mainwhere = " where  a1.type='" . $type_list->type . "' " . $userwhere . $propwhere . $wheredate . $firmwhere;
                $groupby   = "";
                break;

            default:
                $customfieldselect = " ,a1.user_id as user_id,p1.post_title as itemname,u1.display_name as username ,u1.user_email as email,a1.item_id as itemid,a1.date_recorded as date_recorded,p1.post_name as item_slug";
                $customjoin        = " INNER JOIN " . $this->db->prefix . "users u1 on u1.ID=a1.user_id
                         INNER JOIN " . $this->db->prefix . "posts p1 on p1.ID=a1.item_id";
                $customwhere = $parent_child_firms;

                //overide the condition
                if ($parameters['userid'] != '') {
                    $userwhere = " and a1.user_id='" . $parameters['userid'] . "' ";
                }

                if ($parameters['prop_id'] != '') {
                    $propwhere = " and a1.item_id='" . $parameters['prop_id'] . "' ";
                }

                $mainwhere = " where  a1.type='" . $type_list->type . "' " . $userwhere . $propwhere . $wheredate . $firmwhere;
                $groupby   = "";
                break;
        }

        //exclude the admin ids in summary data  MC130
        //echo $parameters['exclude_admin_activity']."<br/><Br/>";

        /*if($parameters['exclude_admin_activity'] == 'yes'){

        $mainwhere.=" AND a1.user_id not in (".$admins_to_exclude.") ";
        }*/

        $select_activity_log .= $union . $mainselect . $customfieldselect . $maintable . $mainjoin . $customjoin . $mainwhere . $customwhere . $groupby;

        $count++;
    }
}

function get_header_page_markup($args){

     
    $backtop = isset($args['backtop'])?$args['backtop']:"25mm";    
    $backbottom = isset($args['backbottom'])?$args['backbottom']:"14mm";
    $backleft = isset($args['backleft'])?$args['backleft']:"14mm";
    $backright = isset($args['backright'])?$args['backright']:"14mm";
    $headerimg = isset($args['headerimg'])?$args['headerimg']:public_path("img/pdf/header-edge-main.png");
    $footerimg = isset($args['footerimg'])?$args['footerimg']:public_path("img/pdf/footer_ta_pdf-min.png");
    $header_txt = isset($args['headertxt'])?$args['headertxt']:"Transfer Asset PDF";


    $header_footer_start_html ='<page  ';
    if(isset($args['hideheader'])){
        $header_footer_start_html.='  hideheader="'.$args['hideheader'].'" ';
    }


    if(isset($args['hidefooter'])){
        $header_footer_start_html.='  hidefooter="'.$args['hidefooter'].'" ';
    }

    $header_footer_start_html.='backimgx="0px" backimgy="0px" backimgw="100%" backimg="'.$headerimg.'" backtop="'.$backtop.'" backbottom="'.$backbottom.'" backleft="'.$backleft.'"  backright="'.$backleft.'" style="font-size: 12pt">
    <page_header > ';

    if($header_txt!=""){
        $header_footer_start_html.='<table style="border: none; background-color:#FFF; margin-top:100px; margin-left:'.$backleft.'"  class="w50per"  >
            <tr>
                <td style="text-align: left;"  class="w100per">
                   <h3 style="font-weight:500; color: grey;">'.$header_txt.'</h3> 
                </td>                 
            </tr>
        </table>';  
      }
    $header_footer_start_html.=' </page_header>
    <page_footer>
        <table style="border: none; background-color:#FFF; width: 100%;  "  >
            <tr>
                <td style="text-align:center;"  class="w100per" >
                  <img src="'.$footerimg.'" class="w90per"  />
                </td>                
            </tr>
            <tr>
                <td style="text-align: center;    width: 100%">page [[page_cu]]/[[page_nb]]</td> 
            </tr>
        </table>
    </page_footer>';

    return $header_footer_start_html;

}

function is_in_array($array, $key, $key_value)
{
    $within_array = 'no';
    foreach ($array as $k => $v) {
        if (is_array($v)) {
            $within_array = is_in_array($v, $key, $key_value);
            if ($within_array == 'yes') {
                break;
            }
        } else {
            if ($v == $key_value && $k == $key) {
                $within_array = 'yes';
                break;
            }
        }
    }
    return $within_array;
}

/**
migration
 **/
function updateVCTData()
{
    $vctData = \App\BusinessListingData::where('data_key', 'fundvct_details')->get();
    foreach ($vctData as $key => $vct) {
        $dataValue = $vct->data_value;

        $dataValue = unserialize($dataValue);
        if (!empty($dataValue) && !is_array($dataValue)) {
            $dataValue = unserialize($dataValue);

            $vctType              = new \App\BusinessListingData;
            $vctType->business_id = $vct->business_id;
            $vctType->data_key    = 'vcttype';
            $vctType->data_value  = (isset($dataValue['vcttype'])) ? $dataValue['vcttype'] : '';
            $vctType->save();

            $investmentstrategy              = new \App\BusinessListingData;
            $investmentstrategy->business_id = $vct->business_id;
            $investmentstrategy->data_key    = 'investmentstrategy';
            $investmentstrategy->data_value  = (isset($dataValue['investmentstrategy'])) ? $dataValue['investmentstrategy'] : '';
            $investmentstrategy->save();

            $offeringtype              = new \App\BusinessListingData;
            $offeringtype->business_id = $vct->business_id;
            $offeringtype->data_key    = 'offeringtype';
            $offeringtype->data_value  = (isset($dataValue['offeringtype'])) ? $dataValue['offeringtype'] : '';
            $offeringtype->save();

            $aicsector              = new \App\BusinessListingData;
            $aicsector->business_id = $vct->business_id;
            $aicsector->data_key    = 'aicsector';
            $aicsector->data_value  = (isset($dataValue['aicsector'])) ? $dataValue['aicsector'] : '';
            $aicsector->save();

            $vct->data_value = serialize($dataValue);
            $vct->save();

        }
    }
}

/**
migration
 **/
function updateInvestorsCurrentCerification()
{
    $users          = \App\User::whereNotNull('current_certification')->get();
    $notUpdatedUser = [];
    foreach ($users as $key => $user) {
        $userCertification = $user->userCertification()->where('certification_default_id', $user->current_certification)->first();
        if (!empty($userCertification)) {
            $userCertification->last_active = 1;
            $userCertification->save();
        } else {
            $notUpdatedUser[] = $user->email;
        }

    }
    // $userHasCer = \App\UserHasCertification::where('active','1')->where('last_active','0')->get(); dd($userHasCer);

    dd($notUpdatedUser);
}

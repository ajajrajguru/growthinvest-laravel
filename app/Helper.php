<?php
/**
generic method to fetch list of records from model
$modelName : 'App/User';
$filters: ['id'=>1]
$orderDataBy: ['id'=>'desc']
**/
function getModelList($modelName,$filters=[],$skip=0,$length=0,$orderDataBy=[]){

    $model    = new $modelName;

    if(empty($filters))
        $modelQuery = $model::all(); 
    else
        $modelQuery = $model::where($filters); 

     foreach ($orderDataBy as $columnName => $orderBy) {
        $modelQuery->orderBy($columnName,$orderBy);
    }

    if($length>1)
    {  
        $listCount = $modelQuery->get()->count(); 
        $list    = $modelQuery->skip($skip)->take($length)->get();   
    }
    else
    {
        $list    = (empty($filters))? $modelQuery :$modelQuery->get();  
        $listCount = $list->count();  
    }

    return ['listCount' =>$listCount,'list'=>$list ];

}

/**
check if provided permission has access to th user
*/ 
function hasAccess($uriPermission){
    $guard = $uriPermission['guard'];
    $permissions = $uriPermission['permissions'];
    $access = false; 
 
    if(!empty($permissions)){    //check for permission

        if(!hasPermission($permissions,$guard))
            $access = false;
        else
            $access = true;
 
    }
     
     
    return $access;
}

/***
checks if user has permission 
$uriPermission : array of permission
**/

function hasPermission($permissions,$guard){

    if(Auth::check() && Auth::user()->hasAnyPermission($permissions))
        return true;
    else
        return false;
}

 
function getCounty(){
    return ['Avon','Bedfordshire','Berkshire','Borders','Buckinghamshire','Cambridgeshire','Central','Cheshire','Cleveland','Clwyd','Cornwall','County Antrim','County Armagh','County Down','County Fermanagh','County Londonderry','County Tyrone','Cumbria','Derbyshire','Devon','Dorset','Dumfries and Galloway','Durham','Dyfed','East Sussex','Essex','Fife','Gloucestershire','Grampian','Greater Manchester','Gwent','Gwynedd County','Hampshire','Herefordshire','Hertfordshire','Highlands and Islands','Humberside','Isle of Wight','Kent','Lancashire','Leicestershire','Lincolnshire','London','Lothian','Merseyside','Mid Glamorgan','Norfolk','North Yorkshire','Northamptonshire','Northumberland','Nottinghamshire','Oxfordshire','Powys','Rutland','Shropshire','Somerset','South Glamorgan','South Yorkshire','Staffordshire','Strathclyde','Suffolk','Surrey','Tayside','Tyne and Wear','Warwickshire','West Glamorgan','West Midlands','West Sussex','West Yorkshire','Wiltshire','Worcestershire'];;
}

function getCountry(){
    return ["GB"=>"United Kingdom","AF"=>"Afghanistan","AX"=>"Aland Islands","AL"=>"Albania","DZ"=>"Algeria","AS"=>"American Samoa","AD"=>"Andorra","AO"=>"Angola","AI"=>"Anguilla","AQ"=>"Antarctica","AG"=>"Antigua And Barbuda","AR"=>"Argentina","AM"=>"Armenia","AW"=>"Aruba","AU"=>"Australia","AT"=>"Austria","AZ"=>"Azerbaijan","BS"=>"Bahamas","BH"=>"Bahrain","BD"=>"Bangladesh","BB"=>"Barbados","BY"=>"Belarus","BE"=>"Belgium","BZ"=>"Belize","BJ"=>"Benin","BM"=>"Bermuda","BT"=>"Bhutan","BO"=>"Bolivia","BA"=>"Bosnia And Herzegovina","BW"=>"Botswana","BV"=>"Bouvet Island","BR"=>"Brazil","IO"=>"British Indian Ocean Territory","BN"=>"Brunei Darussalam","BG"=>"Bulgaria","BF"=>"Burkina Faso","BI"=>"Burundi","KH"=>"Cambodia","CM"=>"Cameroon","CA"=>"Canada","CV"=>"Cape Verde","KY"=>"Cayman Islands","CF"=>"Central African Republic","TD"=>"Chad","CL"=>"Chile","CN"=>"China","CX"=>"Christmas Island","CC"=>"Cocos (Keeling) Islands","CO"=>"Colombia","KM"=>"Comoros","CG"=>"Congo","CD"=>"Congo,Democratic Republic","CK"=>"Cook Islands","CR"=>"Costa Rica","CI"=>"Cote D'Ivoire","HR"=>"Croatia","CU"=>"Cuba","CY"=>"Cyprus","CZ"=>"Czech Republic","DK"=>"Denmark","DJ"=>"Djibouti","DM"=>"Dominica","DO"=>"Dominican Republic","EC"=>"Ecuador","EG"=>"Egypt","SV"=>"El Salvador","GQ"=>"Equatorial Guinea","ER"=>"Eritrea","EE"=>"Estonia","ET"=>"Ethiopia","FK"=>"Falkland Islands (Malvinas)","FO"=>"Faroe Islands","FJ"=>"Fiji","FI"=>"Finland","FR"=>"France","GF"=>"French Guiana","PF"=>"French Polynesia","TF"=>"French Southern Territories","GA"=>"Gabon","GM"=>"Gambia","GE"=>"Georgia","DE"=>"Germany","GH"=>"Ghana","GI"=>"Gibraltar","GR"=>"Greece","GL"=>"Greenland","GD"=>"Grenada","GP"=>"Guadeloupe","GU"=>"Guam","GT"=>"Guatemala","GG"=>"Guernsey","GN"=>"Guinea","GW"=>"Guinea-Bissau","GY"=>"Guyana","HT"=>"Haiti","HM"=>"Heard Island & Mcdonald Islands","VA"=>"Holy See (Vatican City State)","HN"=>"Honduras","HK"=>"Hong Kong","HU"=>"Hungary","IS"=>"Iceland","IN"=>"India","ID"=>"Indonesia","IR"=>"Iran, Islamic Republic Of","IQ"=>"Iraq","IE"=>"Ireland","IM"=>"Isle Of Man","IL"=>"Israel","IT"=>"Italy","JM"=>"Jamaica","JP"=>"Japan","JE"=>"Jersey","JO"=>"Jordan","KZ"=>"Kazakhstan","KE"=>"Kenya","KI"=>"Kiribati","KR"=>"Korea","KW"=>"Kuwait","KG"=>"Kyrgyzstan","LA"=>"Lao People's Democratic Republic","LV"=>"Latvia","LB"=>"Lebanon","LS"=>"Lesotho","LR"=>"Liberia","LY"=>"Libyan Arab Jamahiriya","LI"=>"Liechtenstein","LT"=>"Lithuania","LU"=>"Luxembourg","MO"=>"Macao","MK"=>"Macedonia","MG"=>"Madagascar","MW"=>"Malawi","MY"=>"Malaysia","MV"=>"Maldives","ML"=>"Mali","MT"=>"Malta","MH"=>"Marshall Islands","MQ"=>"Martinique","MR"=>"Mauritania","MU"=>"Mauritius","YT"=>"Mayotte","MX"=>"Mexico","FM"=>"Micronesia, Federated States Of","MD"=>"Moldova","MC"=>"Monaco","MN"=>"Mongolia","ME"=>"Montenegro","MS"=>"Montserrat","MA"=>"Morocco","MZ"=>"Mozambique","MM"=>"Myanmar","NA"=>"Namibia","NR"=>"Nauru","NP"=>"Nepal","NL"=>"Netherlands","AN"=>"Netherlands Antilles","NC"=>"New Caledonia","NZ"=>"New Zealand","NI"=>"Nicaragua","NE"=>"Niger","NG"=>"Nigeria","NU"=>"Niue","NF"=>"Norfolk Island","MP"=>"Northern Mariana Islands","NO"=>"Norway","OM"=>"Oman","PK"=>"Pakistan","PW"=>"Palau","PS"=>"Palestinian Territory, Occupied","PA"=>"Panama","PG"=>"Papua New Guinea","PY"=>"Paraguay","PE"=>"Peru","PH"=>"Philippines","PN"=>"Pitcairn","PL"=>"Poland","PT"=>"Portugal","PR"=>"Puerto Rico","QA"=>"Qatar","RE"=>"Reunion","RO"=>"Romania","RU"=>"Russian Federation","RW"=>"Rwanda","BL"=>"Saint Barthelemy","SH"=>"Saint Helena","KN"=>"Saint Kitts And Nevis","LC"=>"Saint Lucia","MF"=>"Saint Martin","PM"=>"Saint Pierre And Miquelon","VC"=>"Saint Vincent And Grenadines","WS"=>"Samoa","SM"=>"San Marino","ST"=>"Sao Tome And Principe","SA"=>"Saudi Arabia","SN"=>"Senegal","RS"=>"Serbia","SC"=>"Seychelles","SL"=>"Sierra Leone","SG"=>"Singapore","SK"=>"Slovakia","SI"=>"Slovenia","SB"=>"Solomon Islands","SO"=>"Somalia","ZA"=>"South Africa","GS"=>"South Georgia And Sandwich Isl.","ES"=>"Spain","LK"=>"Sri Lanka","SD"=>"Sudan","SR"=>"Suriname","SJ"=>"Svalbard And Jan Mayen","SZ"=>"Swaziland","SE"=>"Sweden","CH"=>"Switzerland","SY"=>"Syrian Arab Republic","TW"=>"Taiwan","TJ"=>"Tajikistan","TZ"=>"Tanzania","TH"=>"Thailand","TL"=>"Timor-Leste","TG"=>"Togo","TK"=>"Tokelau","TO"=>"Tonga","TT"=>"Trinidad And Tobago","TN"=>"Tunisia","TR"=>"Turkey","TM"=>"Turkmenistan","TC"=>"Turks And Caicos Islands","TV"=>"Tuvalu","UG"=>"Uganda","UA"=>"Ukraine","AE"=>"United Arab Emirates","US"=>"United States","UM"=>"United States Outlying Islands","UY"=>"Uruguay","UZ"=>"Uzbekistan","VU"=>"Vanuatu","VE"=>"Venezuela","VN"=>"Viet Nam","VG"=>"Virgin Islands, British","VI"=>"Virgin Islands, U.S.","WF"=>"Wallis And Futuna","EH"=>"Western Sahara","YE"=>"Yemen","ZM"=>"Zambia","ZW"=>"Zimbabwe"];
}

function getCompanyDescription(){
    return [ "Wealth Manager","Accountant","Solicitor","Business Advisor","Investment Network","Financial Advisor"];
}


/***
generates unique GI code for the modal
***/

function generateGICode(\Illuminate\Database\Eloquent\Model $model, $refernceKey, $args)
{
   $randomNo  = rand($args['min'],$args['max']);
   $formattedGI=$args['prefix'].$randomNo;

   $record = $model->where([$refernceKey=> $formattedGI])->first();

   if(empty($record)){
      $result = $formattedGI;
   }else{
      $result = $this->generateRefernceId($model, $refernceKey,$args);
   }

   return $result;

}

function getRegulationTypes(){
    return ['da'=>'Directly Authorised','ar'=>'Appointed Representative','uo'=>'Unregulated/Other'];
}

function getRegisteredIndRange(){
    return ['1'=>'1','2'=>'2 - 5','3'=>'6 - 10','4'=>'11 - 25','5'=>'25 - 100','6'=>'100+'];
}

function getSource(){
     return ['internet'=>'Internet','personal'=>'Referral','recommendation'=>'Recommendation','email'=>'Email','event'=>'Event','LGBR Capital'=>'LGBR Capital'];
}
 
/** Generate Firm Invite Key
***/
function generate_firm_invite_key(\Illuminate\Database\Eloquent\Model $model,$firm_id){

    //  if($firm_id=="")
    //    return '';
    $firn_invite_key = uniqid().$firm_id;
    // $firn_invite_key = time()+rand();

    $record = $model->where(['invite_key'=> $firn_invite_key])->first();

   if(empty($record)){
      $result = $firn_invite_key;
   }else{
      $result = generate_firm_invite_key($model, $firm_id);
   }

   return $result;

    
}
 

<?php

function investorCertificationExpiry()
{
    if (env('APP_ENV') == 'local') {
        $date = date('Y-m-d', strtotime('-1 day'));
    } else {
        $date = date('Y-m-d', strtotime('-1 year'));
    }

    $userCertifications = App\UserHasCertification::where('created_at', '<=', $date)->where('active', '1')->get();
    $mailSent = false;
    foreach ($userCertifications as $key => $userCertification) {
        $investor          = $userCertification->user;
        $firmName          = (!empty($investor->firm)) ? $investor->firm->name : 'N/A';
        $firmId            = $investor->firm_id;
        $certification     = $userCertification->certification()->name;
        $certificationDate = $userCertification->created_at;

        if (env('APP_ENV') == 'local') {
            $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 day'));
        } else {
            $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 year'));
        }

        $userCertification->active = 0;
        $userCertification->save();

        if ($investor->hasRole('investor')) {
            $investor->removeRole('investor');
            $investor->assignRole('yet_to_be_approved_investor');
        }


        if(!$mailSent){
            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = [$investor->email];
            $data['cc']            = [];
            $data['subject']       = $certification . " Certification has expired";
            $data['template_data'] = ['name' => $investor->displayName(), 'firmName' => $firmName, 'certification' => $certification, 'investorGiCode' => $investor->gi_code, 'expiryDate' => $expiryDate];
            sendEmail('investor-certification-expiry', $data);

            $recipients = getRecipientsByCapability([], array('view_all_investors'));
            $recipients = getRecipientsByCapability($recipients, array('view_firm_investors', 'is_wealth_manager'), $firmId);

            foreach ($recipients as $recipientEmail => $recipientName) {
                $data['to']            = [$recipientEmail];
                $data['subject']       = "Investor's Certification has expired.";
                $data['template_data'] = ['name' => $recipientName, 'investorName' => $investor->displayName(), 'firmName' => $firmName, 'certification' => $certification, 'investorGiCode' => $investor->gi_code, 'expiryDate' => $expiryDate];

                sendEmail('investor-certification-expiry-backoffice-users', $data);
            }

            //if local send to only once user
            if (env('APP_ENV') == 'local') {
                $mailSent = true;
            }


        }

    }

}

/**
investor expiry reminder
7 days befor expiry
 */

function investorCertificationExpiryReminder()
{
    $date               = date('Y-m-d');
    $userCertifications = App\UserHasCertification::where(DB::raw('DATE_FORMAT(DATE_ADD(DATE_ADD(created_at, INTERVAL 1 YEAR), INTERVAL -7 DAY), "%Y-%m-%d")'), $date)->where('active', '1')->get();

    $mailSent = false;
    foreach ($userCertifications as $key => $userCertification) {
        $investor          = $userCertification->user;
        $firmName          = (!empty($investor->firm)) ? $investor->firm->name : 'N/A';
        $firmId            = $investor->firm_id;
        $certification     = $userCertification->certification()->name;
        $certificationDate = $userCertification->created_at;

        if (env('APP_ENV') == 'local') {
            $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 day'));
        } else {
            $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 year'));
        }

        if(!$mailSent){
            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = [$investor->email];
            $data['cc']            = [];
            $data['subject']       = "Reminder for Renewal of your " . $certification . " Certification";
            $data['template_data'] = ['name' => $investor->displayName(), 'firmName' => $firmName, 'certification' => $certification, 'investorGiCode' => $investor->gi_code, 'expiryDate' => $expiryDate];
            sendEmail('certification-expiry-in-week-investor', $data);

            $recipients = getRecipientsByCapability([], array('view_all_investors'));
            $recipients = getRecipientsByCapability($recipients, array('view_firm_investors', 'is_wealth_manager'), $firmId);

            foreach ($recipients as $recipientEmail => $recipientName) {
                $data['to']            = [$recipientEmail];
                $data['subject']       = "Reminder for Renewal of Investor's Certification";
                $data['template_data'] = ['name' => $recipientName, 'investorName' => $investor->displayName(), 'firmName' => $firmName, 'certification' => $certification, 'investorGiCode' => $investor->gi_code, 'expiryDate' => $expiryDate];

                sendEmail('certification-expiry-in-week', $data);
            }

            //if local send to only once user
            if (env('APP_ENV') == 'local') {
                $mailSent = true;
            }


        }

    }

}

function getHeaderPageMarkup($args)
{

    $backtop    = isset($args['backtop']) ? $args['backtop'] : "28mm";
    $backbottom = isset($args['backbottom']) ? $args['backbottom'] : "14mm";
    $backleft   = isset($args['backleft']) ? $args['backleft'] : "14mm";
    $backright  = isset($args['backright']) ? $args['backright'] : "14mm";

    $header_footer_start_html = '<page  ';
    if (isset($args['hideheader'])) {
        $header_footer_start_html .= '  hideheader="' . $args['hideheader'] . '" ';
    }

    if (isset($args['hidefooter'])) {
        $header_footer_start_html .= '  hidefooter="' . $args['hidefooter'] . '" ';
    }

    $header_footer_start_html .= ' backtop="' . $backtop . '" backbottom="' . $backbottom . '" backleft="' . $backleft . '"  backright="' . $backleft . '" style="font-size: 12pt">
<page_header>
    <table style="border: none; background-color:#FFF; margin:0;"  class="w100per"  >
        <tr>
            <td style="text-align: left;"  class="w100per">
              <img src="' . public_path("img/pdf/header-edge-main-cert.png") . '" class="w100per"   />
            </td>
        </tr>
    </table>
</page_header>
<page_footer>
    <table style="border: none; background-color:#FFF; width: 100%;  "  >
        <tr>
            <td style="text-align:center;"  class="w100per" >
              <img src="' . public_path("img/pdf/footer_ta_pdf-min.png") . '" class="w70per"  style="width: 90%;"/>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;    width: 100%">page [[page_cu]]/[[page_nb]]</td>
        </tr>
    </table>
</page_footer>';

    return $header_footer_start_html;

}

function get_checkbox_html($checboxes_data)
{

    $checkbox_html = "<table style='margin-bottom:0; padding-bottom: 0;' class='no-spacing'><tr class=''>";

    $checked_image = '<img src="' . public_path('img/pdf/check_mark.png') . '" width="10" height="10"/>';

    foreach ($checboxes_data as $key => $value) {

        $checked_unchecked_image = '<td style="width: 30px;" valign="top"><div class="inputcss checkbox">';

        if ($value['checked'] == true) {
            $checked_unchecked_image .= $checked_image;
        }

        $checked_unchecked_image .= '</div></td>';

        if ($value['label_first'] == true) {
            // $checkbox_html.="<td style='
            //   vertical-align: middle;
            //   '>".$value['label']."  &nbsp; ".$checked_unchecked_image."</td>";

            $checkbox_html .= "<td style='
        vertical-align: middle; width: 80%;
        ' valign='top'>" . $value['label'] . '</td>   ' . $checked_unchecked_image;

        } else {
            $checkbox_html .= $checked_unchecked_image . " <td style='display: inline-block;  vertical-align: middle; width: 80%;'>" . $value['label'] . "</td>";
        }

    }

    $checkbox_html .= "</tr></table>";

    return $checkbox_html;
}

function get_input_lable_box_style($input_element_value, $type_input = "text", $cols = 0, $rows = 0, $prefix = "", $postfix = "")
{

    $input_box_style = "";
    switch ($type_input) {
        case 'textarea':
            $rows_br = "";
            for ($i = 0; $i < $rows; $i++) {
                $rows_br .= "<br/>";
            }
            $input_box_style = '<table    cellpadding="0" cellspacing="0" style="border:1px solid #666;background-color:#C0C0C0">
                      <tr>
                        <td > &nbsp;' . $input_element_value . $rows_br . ' </td>
                        </tr>
                    </table>';
            break;

        case 'text':
            /* $input_box_style='<table cellpadding="0" cellspacing="0" style="border:2px solid #666; background-color:#C0C0C0">
            <tr>
            <td > &nbsp;'.$prefix.$input_element_value.$postfix.' </td>
            </tr>
            </table>'; */
            $input_box_style = '<b>' . $prefix . $input_element_value . $postfix . ' </b>';

            break;

    }

    return $input_box_style;

}

function nl2br_preg_rnnr($string, $replace_char = '<br/>')
{
    //return preg_replace('/(\r\n|\n|\r)/', $replace_char, $string);
    $new_comma_seperated_string = preg_replace('/(\r\n|\n|\r)/', $replace_char, $string);

    $new_string_array     = explode(',', $new_comma_seperated_string);
    $formated_new_string2 = "";

    $count = count($new_string_array);
    for ($i = 0; $i < $count; $i++) {

        if (trim($new_string_array[$i]) != "") {
            if ($i > 0) {
                $formated_new_string2 .= ", ";
            }

            $formated_new_string2 .= $new_string_array[$i];
        }

    }

    return $formated_new_string2;

}

function transferAssetsSubheaders($label, $sublabel = '', $args = array())
{

    $header_class = 'blue_heading_div';
    $table_html   = '';

    if (isset($args['header_pagetop'])) {
        if ($args['header_pagetop'] == true) {
            $header_class = 'blue_heading_div_top';
        }

    }

    $table_html .= '<table cellpadding="0" cellspacing="0" border="0"  class="w100per"  style="margin-top: 6px; padding-top: 0; padding-bottom: 0;" >';

    if ($sublabel != '') {
        $table_html .= '  <tr bgcolor="#0E2D41"><th class="w50per"></th><th class="w50per"  style="padding: 5px;"><h2 style="font-weight: bolder;color:#A9A9A9;">' . $sublabel . '</h2></th>   </tr>';
    }
    $colspan = ($sublabel != '') ? ' colspan="2" ' : '';
    $table_html .= '<tr>
    <td  style="padding: 5px;" class="' . $header_class . ' w100per"' . $colspan . '  >' . $label . '</td>
                                  </tr>
                                  </table>';

    return $table_html;
}

/**
 * [update_onfido_report_status description]
 * @param  [type] $cur_report_details [onfido individual report object data ]
 * @param  array  $args               ['identity_report_status','aml_report_status']   -> newstatus to be added
 * @return [type]                     [updated report data object]
 */
function update_onfido_report_status($cur_report_details, $args = array())
{

    if (isset($args['identity_report_status'])) {
        $new_identity_report_status = $args['identity_report_status'];
    }

    if (isset($args['aml_report_status'])) {
        $new_aml_report_status = $args['aml_report_status'];
    }

    switch ($cur_report_details->name) {
        case 'identity':if (isset($new_identity_report_status)) {

                $new_status_cur_report                   = $new_identity_report_status;
                $cur_report_details->status_growthinvest = $new_status_cur_report;
                //$cur_report_details->status       = $cur_report_details->status_onfido;
            }
            break;
        case 'anti_money_laundering':if (isset($new_aml_report_status)) {

                $new_status_cur_report                   = $new_aml_report_status;
                $cur_report_details->status_growthinvest = $new_status_cur_report;
                //$cur_report_details->status       = $cur_report_details->status_onfido;
            }
            break;
    }

    return $cur_report_details;

}

function createOnfidoApplicant($investor)
{
    $nomineeData            = $investor->getInvestorNomineeData();
    $nomineeapplicationInfo = $nomineeData['nomineeapplication_info']; //dd($nomineeapplicationInfo);
    $additionalInfo         = $nomineeData['additional_info'];

    $objectData['first_name']                      = $investor->first_name;
    $objectData['middle_name']                     = null;
    $objectData['last_name']                       = $investor->last_name;
    $objectData['email']                           = $investor->email;
    $objectData['dob']                             = date('Y-m-d H:i:s', strtotime($nomineeapplicationInfo['dateofbirth']));
    $objectData['telephone']                       = $investor->telephone_no;
    $objectData['mobile']                          = $investor->telephone_no;
    $objectData['country']                         = $investor->country;
    $objectData['addresses'][0]['country']         = $investor->country;
    $objectData['addresses'][0]['postcode']        = $investor->postcode;
    $objectData['addresses'][0]['building_number'] = $investor->address_1;
    $objectData['addresses'][0]['street']          = ($investor->address_2 != "") ? $investor->address_2 : 'na';
    $objectData['addresses'][0]['town']            = ($investor->city != "") ? $investor->city : 'na';
    $objectData['addresses'][0]['start_date']      = null;
    $objectData['addresses'][0]['end_date']        = null;

    // $objectData['addresses'] =  (object) $objectData['addresses'];
    // $objectData =  (object) $objectData;

    $reports[] = array('name' => 'identity');
    $reports[] = array('name' => 'anti_money_laundering');
    // commented on 26april2016 $reports[] = array('name'=>'anti_money_laundering');
    /*There was a validation error on this request","The following reports have not been enabled for your account: anti_money_laundering. You can see the list of enabled reports using the /report_type_groups API endpoint. Please contact client-support@onfido.com if you have questions regarding your account setup.*/

    $result_create_applicant = onfidoApplicantionApi($objectData, $reports);

    $result = $result_create_applicant['create_applicant_result'];

    $applicant_id = '';
    $error        = (isset($result->error)) ? $result->error : '';
    $error_html   = '';

    /* Check for applicant creation error*/
    if ($error) {

        $error_html .= 'Onfido create applicant error: ' . $error->message;

        $cont_error_fields = 1;
        foreach ($error->fields as $key => $value) {
            $error_html .= "<br/>" . $cont_error_fields . ". " . $key;

            if (is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $error_html .= "<br/>"; //.$key2;

                    /*var_dump($value2);

                    var_dump(get_object_vars($value2) );*/

                    if (is_array($value2)) {
                        foreach ($value2 as $key3 => $value3) {
                            //echo "*** \n\n\n".$key3;

                            foreach ($value3 as $key4 => $value4) {
                                $error_html .= $value4;
                            }
                        }
                    } else if (is_object($value2)) {

                        $v2 = get_object_vars($value2);

                        foreach ($v2 as $key3 => $value3) {
                            //$error_html.=$key3." ";
                            $error_html .= "<ol>";
                            foreach ($value3 as $key4 => $value4) {
                                $error_html .= '<li>' . $value4 . '</li>';
                            }
                            $error_html .= "</ol>";
                        }

                    }

                }
            } else {
                $error_html .= $value;
            }

            $cont_error_fields++;

        }

    } else {

        $applicant_id = $result->id;
    }
    /* Check for applicant creation error*/

    /* Check for applicant report creation error*/
    $check_report_error = '';

    $result_check_report = $result_create_applicant['create_checkreports_result'];
    $check_report_error  = (isset($result_check_report->error)) ? $result_check_report->error : '';
    if ($check_report_error) {

        $error_html .= 'Onfido report creation error: <br/>' . $check_report_error->message;

        if (!isset($cont_error_fields)) {
            $cont_error_fields = 1;
        }

        foreach ($check_report_error->fields as $key => $value) {
            //$error_html.= "<br/>".$cont_error_fields.". ".$key ;

            if (is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    //$error_html.= "<br/>".$key2;

                    /*var_dump($value2);
                    echo "<br/><br/> \n\n ";*/

                    if (is_array($value2)) {
                        //echo "<br/><br/> \n\n **********************";

                        foreach ($value2 as $key3 => $value3) {
                            /* echo "*** \n\n\n key3: ".$key3;

                            var_dump($value3);

                            echo "<br/><br/> \n\n ";*/

                            foreach ($value3 as $key4 => $value4) {

                                /*echo "key 4 ";
                                var_dump($value4);*/

                                $error_html .= $value4;
                            }
                        }
                    } else if (is_object($value2)) {
                        /*echo "<br/><br/> \n\n =====================";
                        echo "else if ";

                        echo "value2";
                        print_r($value2);*/

                        $v2 = get_object_vars($value2);
                        /*echo "v2";
                        print_r($v2);*/

                        foreach ($v2 as $key3 => $value3) {

                            /*echo "\n\n <br/> key3:";
                            var_dump($key3);
                            print_r($value3);*/

                            $error_html .= $key3 . " ";
                            $error_html .= "<ol>";
                            foreach ($value3 as $key4 => $value4) {
                                /*echo"key4".$key4;
                                print_r($value4);*/

                                $error_html .= '<li>' . $value4 . '</li>';
                            }
                            $error_html .= "</ol>";
                        }

                    } else {
                        $error_html .= $value2;
                    }

                }
            } else {
                $error_html .= $value;
            }

            $cont_error_fields++;

        }
    }

    $error = (isset($result->error)) ? $result->error : '';

    /* End Check for applicant report creation error*/

    $onfido_error     = 'no';
    $status_error_msg = '';

    if ($error_html != "") {
        $status_error_msg = "Thank you for your submission to the Investment Account.
One of our client services team will be in touch shortly to confirm any additional information that we require. ";
        $onfido_error = "yes";

        $firmName      = (!empty($investor->firm)) ? $investor->firm->name : 'N/A';
        $investorEmail = $investor->email;
        $recipients    = getRecipientsByCapability([], array('manage_options'));
        foreach ($recipients as $recipientEmail => $recipientName) {
            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = [$recipientEmail];
            $data['cc']            = [];
            $data['subject']       = $investor->displayName() . " Onfido submission failed ";
            $data['template_data'] = ['name' => $recipientName, 'investorName' => $investor->displayName(), 'firmName' => $firmName, 'investorEmail' => $investorEmail, 'errorHtml' => $error_html];
            sendEmail('onfido-submission-failed', $data);
        }

        $onfidoSubmitted = 'fail';
    } else {
        $onfidoSubmitted = 'yes';
    }

    $investorOnfifoStatus = $investor->userOnfidoSubmissionStatus();

    if (empty($investorOnfifoStatus)) {
        $investorOnfifoStatus           = new \App\UserData;
        $investorOnfifoStatus->user_id  = $investor->id;
        $investorOnfifoStatus->data_key = 'onfido_submitted';
    }

    $investorOnfifoStatus->data_value = $onfidoSubmitted;
    $investorOnfifoStatus->save();

    //var_dump($result->error);

    return array('result' => $result_create_applicant, 'applicant_id' => $applicant_id, 'error' => $status_error_msg, 'onfido_error' => $onfido_error);
}

function onfidoApplicantionApi($applicantDetails = array(), $reports = array())
{

    $token = env('ONFIDO_ACCESS_TOKEN');

    if (strlen($applicantDetails['country']) <= 2 && strlen($applicantDetails['country']) > 0) {
        $applicantDetails['country'] = convertCountrycodeAlpha2Alpha3($applicantDetails['country']);
    }

    if (strlen($applicantDetails['addresses'][0]['country']) <= 2 && strlen($applicantDetails['addresses'][0]['country']) > 0) {
        $applicantDetails['addresses'][0]['country'] = convertCountrycodeAlpha2Alpha3($applicantDetails['addresses'][0]['country']);
    }

    $applicant_details_json = json_encode($applicantDetails);

    //$auth = base64_encode( 'token='.$token );
    $ch          = curl_init();
    $curlopt_url = "https://api.onfido.com/v2/applicants/";
    curl_setopt($ch, CURLOPT_URL, $curlopt_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Token token=' . $token));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/3.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $applicant_details_json);

    $result                  = curl_exec($ch);
    $create_applicant_result = json_decode($result);

    $create_check_report_result = [];
    if (!isset($create_applicant_result->error)) {

        if (count($reports) > 0) {

            //This will create identity and AML Report Checks
            $result_check_reports       = createOnfidoApplicantCheck($create_applicant_result->id, $reports);
            $create_check_report_result = json_decode($result_check_reports);
        }

    }

    $return_result = array('create_applicant_result' => $create_applicant_result, 'create_checkreports_result' => $create_check_report_result);

    return $return_result;
}

function createOnfidoApplicantCheck($applicantId, $reports = array())
{

    if ($applicantId == '') {
        return false;
    }

    $token = env('ONFIDO_ACCESS_TOKEN');

    $checkobj['type']   = 'standard';
    $checkobj['status'] = 'in_progress';
    //$checkobj->type = 'awaiting_applicant';

    /* build report types array of report objects based on reports data passed */
    if (count($reports) > 0) {

        foreach ($reports as $key_report => $value_report) {

            $new_object_name          = str_replace(' ', '_', $value_report['name']) . '_obj';
            $$new_object_name['name'] = $value_report['name'];
            //$$new_object_name->status = 'awaiting_data';
            $check_reports[] = $$new_object_name;
        }

        $checkobj['reports'] = $check_reports;

    }

    $applicant_details_json = json_encode($checkobj);

    $ch          = curl_init();
    $curlopt_url = "https://api.onfido.com/v2/applicants/" . $applicantId . "/checks";
    curl_setopt($ch, CURLOPT_URL, $curlopt_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Token token=' . $token));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/3.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $applicant_details_json); // Commented not to include reports for check

    $result = curl_exec($ch);

    return $result;

}

function add_update_onfido_reports_meta($applicant_id = '', $investor = [], $check_report_result)
{

    if ($applicant_id != '' && empty($investor)) {

        $reports = array();

        $check_id           = $check_report_result->id;
        $check_status       = $check_report_result->status;
        $check_type         = $check_report_result->type;
        $check_results_uri  = $check_report_result->results_uri;
        $check_download_uri = $check_report_result->download_uri;
        $check_form_uri     = $check_report_result->form_uri;
        $check_paused       = $check_report_result->paused;

        $reports_ar = $check_report_result->reports;

        if ($check_report_result->reports == false || is_null($check_report_result->reports)) {
            //If report/check creation failed, add/update custom onfido report,

            $onfido_report_meta = $investor->userOnfidoApplicationReports();

            if (empty($onfido_report_meta)) {

                $args['identity_report_status'] = "requested";
                $args['aml_report_status']      = "requested";
                $args['set_report_meta']        = false;
                $report_data                    = add_new_onfido_report_onplatform($investor, $args);

            } else {

                $reports = array();

                //echo "four ";

                $report_data = (!empty($onfido_report_meta)) ? $onfido_report_meta->data_value : [];
                // var_dump($report_data);

                $onfido_check   = $report_data['check'];
                $onfido_reports = $onfido_check['reports'];

                foreach ($onfido_reports as $key => $value) {
                    $reports[] = update_onfido_report_status($value, $args);

                }

                $onfido_check['reports'] = $reports;
                $report_data['check']    = $onfido_check;

            }

        } else {
            foreach ($reports_ar as $key => $value) {

                $value->status_onfido       = $value->status;
                $value->status              = 'requested';
                $value->status_growthinvest = 'requested';
                $reports[]                  = $value;
            }

            $report_data = array('applicant_id' => $applicant_id,
                'check'                             => array('id' => $check_id,
                    'check_status'                                    => $check_status,
                    'check_type'                                      => $check_type,
                    'check_result_url'                                => $check_results_uri,
                    'check_download_url'                              => $check_download_uri,
                    'check_form_url'                                  => $check_form_uri,
                    'check_paused'                                    => $check_paused,
                    'reports'                                         => $reports,
                ),
            );

        }
        //update_user_meta($userid,'on_reports',maybe_serialize($report_data) );

        $onfido_report_meta = $investor->userOnfidoApplicationReports();

        if (empty($onfido_report_meta)) {
            $onfido_report_meta           = new \App\UserData;
            $onfido_report_meta->user_id  = $investor->id;
            $onfido_report_meta->data_key = 'onfido_reports';
        }

        $onfido_report_meta->data_value = $report_data;
        $onfido_report_meta->save();

    }

}

function add_new_onfido_report_onplatform($investor, $args)
{

    $identity_report_status = $args['identity_report_status'];
    $aml_report_status      = $args['aml_report_status'];
    $reports                = array();

    $identity_report_obj                      = new stdClass;
    $identity_report_obj->name                = 'identity';
    $identity_report_obj->id                  = '';
    $identity_report_obj->status_growthinvest = $identity_report_status;

    $aml_report_obj                      = new stdClass;
    $aml_report_obj->name                = 'anti_money_laundering';
    $aml_report_obj->id                  = '';
    $aml_report_obj->status_growthinvest = $aml_report_status;

    $reports[] = $identity_report_obj;
    $reports[] = $aml_report_obj;

    $report_data = array('applicant_id' => '',
        'check'                             => array('id' => '',
            'check_status'                                    => '',
            'check_type'                                      => '',
            'check_result_url'                                => '',
            'check_download_url'                              => '',
            'check_form_url'                                  => '',
            'check_paused'                                    => '',
            'reports'                                         => $reports,
        ),
    );
    if ($args['set_report_meta'] == false) {
        return $report_data;
    } else {
        $onfido_report_meta = $investor->userOnfidoApplicationReports();

        if (empty($onfido_report_meta)) {
            $onfido_report_meta           = new \App\UserData;
            $onfido_report_meta->user_id  = $investor->id;
            $onfido_report_meta->data_key = 'onfido_reports';
        }

        $onfido_report_meta->data_value = $report_data;
        $onfido_report_meta->save();

    }
}

function update_onfido_reports_status($investor, $args)
{

    $identity_report_status = $args['identity_report_status'];
    $aml_report_status      = $args['aml_report_status'];
    $reports                = array();

    $args['set_report_meta'] = false;

    $onfido_report_meta = $investor->userOnfidoApplicationReports();

    /*$args = array('identity_report_status'=> $identity_report_status,
    'aml_report_status'     => $aml_report_status
    ); */

    if (empty($onfido_report_meta)) {

        //echo "one ";

        $investor_onfido_applicant_id = $investor->userOnfidoApplicationId();

        if (!empty($investor_onfido_applicant_id)) {
            // If there is associated applicant id, retrieve check and reports and update the meta
            //echo "two ";
            $investor_onfido_applicant_id = $investor_onfido_applicant_id->data_value;
            $report_data                  = get_onfido_reports_meta_by_applicant_id($investor_onfido_applicant_id, $args);

        } else {

            add_new_onfido_report_onplatform($investor_id, $args);

        }

    } // END if($onfido_report_meta==false){
    else {

        $reports = array();

        //echo "four ";

        $report_data = (!empty($onfido_report_meta)) ? $onfido_report_meta->data_value : [];
        // var_dump($report_data);

        $onfido_check   = $report_data['check'];
        $onfido_reports = $onfido_check['reports'];

        foreach ($onfido_reports as $key => $value) {
            $reports[] = update_onfido_report_status($value, $args);

        }

        $onfido_check['reports'] = $reports;
        $report_data['check']    = $onfido_check;

    }

    $onfido_report_meta = $investor->userOnfidoApplicationReports();

    if (empty($onfido_report_meta)) {
        $onfido_report_meta           = new \App\UserData;
        $onfido_report_meta->user_id  = $investor->id;
        $onfido_report_meta->data_key = 'onfido_reports';
    }

    $onfido_report_meta->data_value = $report_data;
    $onfido_report_meta->save();

}

/*Function to  get onfido reports data for given applicant id and if new statuses are given for report update the report status in report data */
function get_onfido_reports_meta_by_applicant_id($applicant_id = '', $args = array())
{

    if ($applicant_id == '') {
        return false;
    }

    if (isset($args['identity_report_status'])) {
        $new_identity_report_status = $args['identity_report_status'];
    }

    if (isset($args['aml_report_status'])) {
        $new_aml_report_status = $args['aml_report_status'];
    }

    $reports = array();

    //$applicant_id = 'de331d9e-5276-4337-999b-dbcc7b47904d';
    $applicant_list_checks = json_decode(list_applicant_checks($applicant_id));

    $list_checks = $applicant_list_checks->checks;

    foreach ($list_checks as $key => $value) {
        //looping thru all checks of applicant

        $check_id           = $value->id;
        $check_status       = $value->status;
        $check_type         = $value->type;
        $check_results_uri  = $value->results_uri;
        $check_download_uri = $value->download_uri;
        $check_form_uri     = $value->form_uri;
        $check_paused       = $value->paused;

        $reports_ar = $value->reports;

        foreach ($reports_ar as $report_key => $report_value) {
            //looping thru all reports of check

            $cur_report_id = $report_value;

            $args_report_check = array('reportid' => $cur_report_id, 'checkid' => $check_id);
            $cur_report_data   = retrieve_report_details($args_report_check);

            $cur_report_details = update_onfido_report_status($cur_report_data, $args); //update report status with new statuses if provided

            $reports[] = $cur_report_details;

        }
    }
    $report_data = array('applicant_id' => $applicant_id,
        'check'                             => array('id' => $check_id,
            'check_status'                                    => $check_status,
            'check_type'                                      => $check_type,
            'check_result_url'                                => $check_results_uri,
            'check_download_url'                              => $check_download_uri,
            'check_form_url'                                  => $check_form_uri,
            'check_paused'                                    => $check_paused,
            'reports'                                         => $reports,
        ),
    );

    return $report_data;

}

function list_applicant_checks($applicant_id)
{

    $token = env('ONFIDO_ACCESS_TOKEN');

    //$auth = base64_encode( 'token='.$token );
    $ch          = curl_init();
    $curlopt_url = "https://api.onfido.com/v1/applicants/" . $applicant_id . "/checks";
    curl_setopt($ch, CURLOPT_URL, $curlopt_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Token token=' . $token));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/3.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);

    /* echo "<pre>";
    print_r($result);
    echo "</pre>"; */
    return $result;
    /* Example response

{"checks":[{"id":"eec6a785-9aa2-4d6e-9b14-e622b2198628","created_at":"2017-03-29T10:36:58Z","status":"complete","redirect_uri":null,"type":"express","result":"clear","sandbox":true,"report_type_groups":["2004"],"tags":[],"results_uri":"https://onfido.com/dashboard/information_requests/3106711","download_uri":"https://onfido.com/dashboard/pdf/information_requests/3106711","form_uri":null,"href":"/v1/applicants/d6783af5-b4d9-45b8-a5e8-fa49827340cb/checks/eec6a785-9aa2-4d6e-9b14-e622b2198628","reports":["71c794af-df1a-4ae6-ac94-84d5cbe05ede","ac71e083-fa98-49a9-8a24-a890369253d8"],"paused":false}]}

 */
}

function retrieve_report_details($args = array())
{

    $token = env('ONFIDO_ACCESS_TOKEN');

    if (isset($args['url']) && $args['url'] != '') {
        $retrieve_url = $args['url'];
    } else if (isset($args['reportid']) && isset($args['checkid'])) {
        $retrieve_url = "https://api.onfido.com/v2/checks/" . $args['checkid'] . "/reports/" . $args['reportid'];
    } else {
        return false;
    }

    //$auth = base64_encode( 'token='.$token );
    $ch          = curl_init();
    $curlopt_url = $retrieve_url;
    curl_setopt($ch, CURLOPT_URL, $curlopt_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Token token=' . $token));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/3.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result              = curl_exec($ch);
    $result_json_decoded = json_decode($result);

    /*echo "<pre>";
    print_r($result);
    echo "</pre>";*/

    return $result_json_decoded;
    /* Example response

 */
}

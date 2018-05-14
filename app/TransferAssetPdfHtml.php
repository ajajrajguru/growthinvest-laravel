<?php
namespace App;

use App\NumbersToWords;

class TransferAssetPdfHtml
{

/* Function to get HTML for nominee application form PDF*/
    public function getHtmlForTransferAssetPdf($transferasset, $additional_args)
    {
        $header_footer_end_html = "</page>";
        $html                   = '';
        $current_date           = date("d/m/Y");

        $investor             = $transferasset->investor;
        $companyDetails       = $transferasset->company;
        $transferassetDetails = $transferasset->details;
        $typeOfAssets         = typeOfAssets();
        $default_logo_url     = public_path("img/pdf/pdfheader - nomination-firstpg.jpg");

        $nomineeApplication = $investor->investorNomineeApplication(); 
        if (!empty($nomineeApplication)) {
            $nominee_details = $nomineeApplication->details;
        } else {
            $address = $investor->address_1;
            $address .= ($investor->address_2!='')? '<br>'.$investor->address_2 :'';
            $address .= ($investor->city!='')? '<br>'.$investor->city :'';
            $address .= ($investor->county!='')? '<br>'.$investor->county :'';

            $nominee_details['title']               = $investor->title;
            $nominee_details['surname']             = $investor->last_name;
            $nominee_details['forename']            = $investor->first_name;
            $nominee_details['dateofbirth']         = '';
            $nominee_details['nationalinsuranceno'] = '';
            $nominee_details['address']             =  $address;
            $nominee_details['postcode']            = $investor->postcode;
            $nominee_details['email']               = $investor->email;
            $nominee_details['telephone']           = $investor->telephone_no;

        }
        $checkbox_nonationalinsuranceno[] = array('label_first' => false, 'label' => 'If your client does not have a National Insurance number, please tick here', 'checked' => false);
        if (isset($nominee_details['nonationalinsuranceno'])) {
            if ($nominee_details['nonationalinsuranceno'] == 1) {
                $checkbox_nonationalinsuranceno   = array();
                $checkbox_nonationalinsuranceno[] = array('label_first' => false, 'label' => 'If you do not have a National Insurance number, please tick here', 'checked' => true);
            }
        }

        if (isset($transferassetDetails['typeoftransfer']) && $transferassetDetails['typeoftransfer'] == 'part') {
            $partarr   = array();
            $partarr[] = array('label_first' => true, 'label' => 'In Part', 'checked' => true);
            $fullarr   = array();
            $fullarr[] = array('label_first' => true, 'label' => 'In Full', 'checked' => false);
        } else {
            $partarr   = array();
            $partarr[] = array('label_first' => true, 'label' => 'In Part', 'checked' => false);
            $fullarr   = array();
            $fullarr[] = array('label_first' => true, 'label' => 'In Full', 'checked' => true);
        }
        $style_html = '<style type="text/css">
              .bordertable {border:1px solid #000;}
                th {border:none;
                  font-size:12px;
                  font-weight:normal;
                }
                td {
                  font-size:12px;
                  font-weight:normal;
                  border:none;
                }
               table {
                 background-color:#E0E0E0;
                 margin-bottom:1px;
                 /*margin-top:10px;*/
               }
                div {
                  border:1px solid #A9A9A9;
                  background-color:#FFF;
                  line-height: 15px;

                }
                div.sectionhead{
                  background-color:#0066ff;
                 color:#FFF";
                }
                div.subsectionhead{
                  background-color:#E0E0E0;
                  position:absolute;
                  bottom:0px;
                }
                .blue_heading_div{
                      color:#fff;
                      background-color:#0A3250;
                      font-size:10px;
                      display:block;


                      text-align: left;
                      /* border-left:1px solid #000;
                      border-top:1px solid #000;
                      border-right:1px solid #000;
                      border-bottom:1px solid #000; */
                      border-radius: 1mm;
                      padding-top:3px;
                      padding-bottom:6px;

                    }
                    .w100per{
                      width:100%;
                    }
                    .w98per{
                      width:98%;
                    }
                    .w90per{
                      width:90%;
                    }
                    .w50per{
                      width:50%;
                    }

                    .w30per{
                      width:30%;
                    }
                    .w25per{
                      width:25%;
                    }
                    .w20per{
                      width:20%;
                    }
                    .round_radius{
                      border-radius: 1mm;
                    }
                    .inputcss{
                      /* border: solid 1px #ccc;
                      border-radius: 50%;
                      display:block;
                      padding: 50px;
                      width:100px;
                      inline-height:200px; */
                     border-radius: 1mm;
                      /* padding-top:2px;
                      padding-bottom:4px;
                      border: none;
                      text-align: center;
                      border:1px solid #D9DBDD; */
                      padding-left:5px;
                    }
                    table.no-spacing {
                      border-spacing:0;
                      border-collapse: collapse;
                    }
                    .signature_style{
                         display:block;
                        width:300px;
                        font-size:45px;
                        padding-top:5px;
                      }
                      .dob{
                        padding: 6px;
                         display:inline;
                        width:12px;
                      }


                </style>';

        //Page 1 Start
        $table_html = '
            <table cellpadding="0" cellspacing="0" border="0"  width="100%" bgcolor="#FFF" style="margin-top: 15px;">

                <tr>
                <th width="100%">'; /*SEED EIS PLATFORM*/
        $table_html .= 'This form is used to transfer existing assets into your '; /*Seed EIS Platform*/
        $table_html .= 'Growth<font color="#51bce6">Invest</font> account, if you are transferring more than one product please complete
                a new Asset Transfer Form for each product you wish to transfer. Additional copies can be downloaded at www.growth<font color="#51bce6">invest</font>.com or
                requested via enquiries@growth<font color="#51bce6">invest</font>.com.<br><br></th>
                </tr>

            </table>';

        $label = 'GROWTHINVEST INVESTMENT ACCOUNT';
        $table_html .= $this->transfer_assets_subheaders($label);

        $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">
              <tr>
                <td style="width: 100%;">
                The GrowthInvest nominee and custody service enables you to make investments directly through the platform and monitor all of your tax efficient investments in one place. In providing this service we have partnered with <b>Platform One Limited</b>, an FCA regulated custodian and Investment account. Please complete the Asset Transfer form as accurately as possible and post the signed version to: GrowthInvest, Candlewick House, 120 Cannon Street, London, EC4N 6AS.
                </td>
              </tr>
              </table>';

 
        $table_html .= '<br>';
        $label = 'APPLICANT DETAILS';
        $table_html .= $this->transfer_assets_subheaders($label);

        // test starts
        $assets_noofshares = (isset($transferassetDetails['assets_noofshares'])) ? $transferassetDetails['assets_noofshares'] :'';
         $assets_typeofshare = (isset($transferassetDetails['assets_typeofshare'])) ?$transferassetDetails['assets_typeofshare']:'';
         $assets_nameonsharecertificate = (isset($transferassetDetails['assets_nameonsharecertificate'])) ?$transferassetDetails['assets_nameonsharecertificate']:'';
         $assets_transferamount = (isset($transferassetDetails['assets_transferamount'])) ?$transferassetDetails['assets_transferamount']:'';

        if ($transferasset->typeofasset != 'single_company') {

            $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 50%;">
                          <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                         <tr>
                         <td  style="width: 100%;"><b>Personal Details</b></td>
                         </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Title :</td>
                         <td style="Width: 70%;">
                         <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['title'] . '</div></td>
                         </tr>
                         </table><br>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Surname :</td>
                         <td style="Width: 70%;">
                         <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['surname'] . '</div></td>
                         </tr>
                         </table><br>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Forename(s) :</td>
                         <td style="Width: 70%;">
                         <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['forename'] . '</div></td>
                         </tr>
                         </table><br>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Date of Birth :</td>
                         <td style="Width: 70%;">
                         <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['dateofbirth'] . '</div></td>
                         </tr>
                         </table><br>

                         <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 100%;">National Insurance Number :</td>

                         </tr>
                         </table>

                         <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 100%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['nationalinsuranceno'] . '</div></td>

                         </tr>
                         </table>
                         <br>

                         <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 100%;">' . $this->get_checkbox_html($checkbox_nonationalinsuranceno) . '<br><span style="font-size: 10px;">* If you have a National Insurance number you must provide it.</span></td>
                         </tr>
                         </table>

                     </td>
                     <td style="width: 50%; vertical-align: top;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                         <tr>
                         <td  style="width: 100%;"><b>Contact Details</b></td>
                         </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Address :</td>
                         <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">' . $nominee_details['address'] . '<br><br><br></div></td>
                         </tr>

                         </table><br>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Postcode :</td>
                         <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['postcode'] . '</div></td>
                         </tr>

                         </table><br>

                         <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Email Address :</td>
                         <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['email'] . '</div></td>
                         </tr>
                         </table><br>

                         <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Telephone (Home) :</td>
                         <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;</div></td>
                         </tr>
                         </table><br>

                         <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Telephone (Work) :</td>
                         <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;</div></td>
                         </tr>
                         </table><br>

                         <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 30%;">Telephone (Mobile) :</td>
                         <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['telephone'] . '</div></td>
                         </tr>
                         </table>

                     </td>
                  </tr>






                 </table>';
        } else {

/* ###############################  */
            $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 50%;">
                      <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                     <tr>
                     <td  style="width: 100%;"><b>Personal Details</b></td>
                     </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Title :</td>
                     <td style="Width: 70%;">
                     <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['title'] . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Surname :</td>
                     <td style="Width: 70%;">
                     <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['surname'] . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Forename(s) :</td>
                     <td style="Width: 70%;">
                     <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['forename'] . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Date of Birth :</td>
                     <td style="Width: 70%;">
                     <div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['dateofbirth'] . '</div></td>
                     </tr>
                     </table>


                 </td>

                 <td style="width: 50%; vertical-align: top;">


                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                     <tr>
                     <td  style="width: 100%;"><b>&nbsp;</b></td>
                     </tr>
                     </table>

                     <table style="width: 100%; margin-top: 15px; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">National Insurance Number :</td>

                     </tr>
                     </table>


                  <table style="width: 100%;  margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['nationalinsuranceno'] . '</div></td>

                     </tr>
                     </table>
                     <br>

                  <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">' . $this->get_checkbox_html($checkbox_nonationalinsuranceno) . '<br><span style="font-size: 10px;">* If you have a National Insurance number you must provide it.</span></td>
                     </tr>
                     </table>
                 </td>

              </tr>

              <tr>
                <td style="width: 50%; vertical-align: top;">
                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                     <tr>
                     <td  style="width: 100%;"><b>Contact Details</b></td>
                     </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Address :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">' . $nominee_details['address'] . '<br><br><br></div></td>
                     </tr>

                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Postcode :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['postcode'] . '</div></td>
                     </tr>

                     </table>


                 </td>

                 <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 15px;" class="no-spacing" >
                     <tr>
                     <td  style="width: 100%;"><b>&nbsp;</b></td>
                     </tr>
                     </table>
                    <table style="width: 100%; margin-top: 15px; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Email Address :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px; word-break: break-all; word-break: break-word;">&nbsp;' . $nominee_details['email'] . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Telephone (Home) :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp; </div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Telephone (Work) :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp; </div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Telephone (Mobile) :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $nominee_details['telephone'] . '</div></td>
                     </tr>
                     </table>
                 </td>

              </tr>






             </table>';

        }

        // $table_html.='<br>'.$footer_img;
        if ($transferasset->typeofasset == 'single_company') {
            // $table_html .= $header;
            $label  = 'DETAILS OF ASSETS TO BE TRANSFERRED';
            $label1 = 'Asset Transfer Form - Single Company';
            $table_html .= '<br>' . $this->transfer_assets_subheaders($label);

            $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

            <tr>
              <td class="w50per"><b>Type of Assets : ' . $typeOfAssets[$transferasset->typeofasset] . '</b></td>
              <td class="w50per" ><b></b></td>
            </tr>

            <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" > 
                     <tr>
                     <td style="Width: 30%;">Company Name :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->name . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Company Number :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->company_no . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Email Address :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->email . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Phone Number :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->phone . '</div></td>
                     </tr>
                     </table>
                 </td>

                 <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Registered Name on :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->name . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">No. Shares to be:</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $assets_noofshares . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Type of Share :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $assets_typeofshare . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Name of Certificate :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $assets_nameonsharecertificate . '</div></td>
                     </tr>
                     </table>
                 </td>
              </tr>
              </table><br>';

        }
        if ($transferasset->typeofasset == 'seis_eis_portfolio' || $transferasset->typeofasset == 'iht_service') {
            // $table_html .= $header;
            if ($transferasset->typeofasset == 'seis_eis_portfolio') {
                $label1 = "Asset Transfer Form - Portfolio";
            } else {
                $label1 = "Asset Transfer Form - IHT";
            }

            $label = 'DETAILS OF PROVIDER';
            $table_html .= '<br>' . $this->transfer_assets_subheaders($label);

            $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">
            <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 100%;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Provider:</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->name . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Name of Product:</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->product . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Client Account Number:</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp; </div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Address of Provider:</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->address . '</div></td>
                     </tr>
                     </table>
                 </td>

              </tr>
            </table>';

        }
//           echo "<pre>";
        // print_r($firm_stats);
        // echo "</pre>";
        if ($transferasset->typeofasset == 'vct') {
            $label  = 'DETAILS OF PROVIDER';
            $label1 = 'Asset Transfer Form - VCT';

            $table_html .= '<br>' . $this->transfer_assets_subheaders($label);

            $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Provider :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->name . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Provider :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->product . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Email Id :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->email . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Phone Number:</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->phone . '</div></td>
                     </tr>
                     </table>

                 </td>
                 <td style="width: 50%; vertical-align: top;">
                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Address of Provider :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->address . '<br><br></div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Country :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->county . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Postcode :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->postcode . '</div></td>
                     </tr>
                     </table>
                 </td>
              </tr>

               <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Client Account Number :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">ISIN No. :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->isin_no . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">SEDOL Code :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->sedol_code . '</div></td>
                     </tr>
                     </table>

                 </td>
                 <td style="width: 50%; vertical-align: top;">

                    <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Please Transfer :</td>
                     <td style="Width: 70%;">
                      ' . $this->get_checkbox_html($partarr) . '<br>
                      ' . $this->get_checkbox_html($fullarr) . '
                      </td>
                     </tr>
                     </table><br>


                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Amount to  Transfer :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;&pound;&nbsp;' . $assets_transferamount . '</div></td>
                     </tr>
                     </table>
                 </td>
              </tr>
              </table>';

        }

        $table_html .= '<div style="page-break-after:always;border:none; "></div>';

        $table_html .= '<table cellpadding="0" cellspacing="0" border="0"  width="100%" bgcolor="#FFF" style="margin-top: 15px;">
                     <tr>
                     <td style="Width: 100%;">
                     Help filling out the form.<br>If you require assistance or have any questions please do not hesitate to contact our GrowthInvest Team on: 020 7071 3945.
                     </td>
                     </tr>
                     </table><br>';
        // $table_html .= $header;
        $label = 'TRANSFER INSTRUCTION';
        $table_html .= $this->transfer_assets_subheaders($label);

        $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

          <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">
                      Please transfer my holding once instructions have been received from Platform One to do so. After transfer, all dividends and tax credits due should be made payable to P1 growthinvest. Payments should be sent with client name as a reference.<br><br><b>Electronic Payments should be sent to: </b><br><br><b>Sort Code: 40 -05 - 30</b><br><br><b>Account Number: 0369 2051</b><br><br><b>Account Name: P1 growthinvest</b><br><br>
                     </td>
                     </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">
                      <div class="inputcss" style="padding: 6px; background: #ccc;"><b>APPLICANT NAME:</b></div>
                     </td>
                     </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">
                      <div class="inputcss" style="padding: 6px;">&nbsp;</div>
                     </td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;"><div class="inputcss" style="padding: 6px; background: #ccc;"><b>Date :</b></div></td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">';

        if ($additional_args['pdfaction'] == "esign") {
            $table_html .= '<input type="text"   style=" background:#FFF;  font-size:12px;   border: dashed 1mm white;    " name="Dte_es_:signer1:date:format(date,\'dd/mm/yyyy\')" /> ';
        } else {
            $table_html .= ' &nbsp;&nbsp;';
        }

        $table_html .= ' </div></td>
                     </tr>
                     </table>

                 </td>

                 <td style="width: 50%; vertical-align: top;">
                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">
                     <b>Instruction</b><br><br>I hereby instruct you to transfer my holding immediately, including the cash proceeds, together with any interest, dividends, rights and any other cash within my account (less the amount you are contractually entitled to keep) to Platform One Limited, Cedar House, 3 Cedar Park, Cobham Rd, Wimborne BH21 7SF .<br><br>
                     </td>
                     </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-top: 65px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">
                      <div class="inputcss" style="padding: 6px; background: #ccc;"><b>APPLICANT SIGNATURE:</b></div>
                     </td>
                     </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 100%;">
                      ';
        if ($additional_args['pdfaction'] == "esign") {
            //$table_html.='{{Sig_es_:signer1:signature}}';
            $table_html .= '<div class="inputcss" style="margin-left:5px;padding:14px 8px;margin-top:5px;"><input type="text" class="signature_style" name="Sig_es_:signer1:signature" /></div> ';

        } else {
            $table_html .= '<div class="inputcss" style="height: 70px;"></div>';
        }
        $table_html .= '
                     </td>
                     </tr>
                     </table>

                 </td>
              </tr>

          </table>';

        $table_html .= '<br>';
        $label = 'MAILING INSTRUCTION';
        $table_html .= $this->transfer_assets_subheaders($label);

        $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">
          <tr>
          <td style="width: 100%;">
          The GrowthInvest nominee and custody service enables you to make investments directly through the platform and monitor all of your tax efficient investments in one place. In providing this service we have partnered with <b>Platform One Limited</b>, an FCA regulated custodian and Investment account. Please complete the Asset Transfer form as accurately as possible and post the signed version to: <br><b>GrowthInvest, Candlewick House, 120 Cannon Street, London, EC4N 6AS.</b>
          </td>
          </tr>
          </table>';

        $head_foot_args['backtop']   = "35mm";
        $head_foot_args['headertxt'] = $label1;
        $header_footer_start_html    = get_header_page_markup($head_foot_args);

        $html = $style_html . $header_footer_start_html . $table_html . $header_footer_end_html;
// echo ($html);exit;
        return $html;

    }

    public function getHtmlForStockTransferPdf($transferasset, $additional_args)
    {
        $header_footer_end_html = "</page>";
        $html                   = '';
        $current_date           = date("d/m/Y");

        $investor             = $transferasset->investor;
        $companyDetails       = $transferasset->company;
        $transferassetDetails = $transferasset->details;

        $style_html = '<style type="text/css">
              .bordertable {border:1px solid #000;}
                th {border:none;
                  font-size:12px;
                  font-weight:normal;
                }
                td {
                  font-size:12px;
                  font-weight:normal;
                  border:none;
                }
               table {
                 background-color:#E0E0E0;
                 margin-bottom:1px;
                 /*margin-top:10px;*/
               }
                div {
                  border:1px solid #A9A9A9;
                  background-color:#FFF;
                  line-height: 15px;

                }
                div.sectionhead{
                  background-color:#0066ff;
                 color:#FFF";
                }
                div.subsectionhead{
                  background-color:#E0E0E0;
                  position:absolute;
                  bottom:0px;
                }
                .blue_heading_div{
                      color:#fff;
                      background-color:#0A3250;
                      font-size:10px;
                      display:block;


                      text-align: left;
                      /* border-left:1px solid #000;
                      border-top:1px solid #000;
                      border-right:1px solid #000;
                      border-bottom:1px solid #000; */
                      border-radius: 1mm;
                      padding-top:3px;
                      padding-bottom:6px;

                    }
                    .w100per{
                      width:100%;
                    }
                    .w98per{
                      width:98%;
                    }
                    .w90per{
                      width:90%;
                    }
                    .w50per{
                      width:50%;
                    }

                    .w30per{
                      width:30%;
                    }
                    .w25per{
                      width:25%;
                    }
                    .w20per{
                      width:20%;
                    }
                    .round_radius{
                      border-radius: 1mm;
                    }
                    .inputcss{
                      /* border: solid 1px #ccc;
                      border-radius: 50%;
                      display:block;
                      padding: 50px;
                      width:100px;
                      inline-height:200px; */
                     border-radius: 1mm;
                      /* padding-top:2px;
                      padding-bottom:4px;
                      border: none;
                      text-align: center;
                      border:1px solid #D9DBDD; */
                      padding-left:5px;
                    }
                    table.no-spacing {
                      border-spacing:0;
                      border-collapse: collapse;
                    }

                    .signature_style{
                         display:block;
                        width:300px;
                        font-size:35px;
                        padding-top:5px;
                      }

                      .signature_style2{
                         display:block;
                        width:265px;
                        font-size:35px;
                        padding-top:5px;
                      }

                </style>';

        
        // echo "<pre>";
        // print_r($usermeta);
        $address               = isset($investor->address_1) ? ", " . $investor->address_1 : "";
        $address2              = isset($investor->address_2) ? ", " . $investor->address_2 : "";
        $city                  = isset($investor->city) ? ", " . $investor->city : "";
        $postcode              = isset($investor->postcode) ? ", " . $investor->postcode : "";
        $assets_transferamount = (isset($transferassetDetails['assets_transferamount']) && $transferassetDetails['assets_transferamount'] != "") ? $transferassetDetails['assets_transferamount'] : "Nil";

        $assets_typeofshare = (isset($transferassetDetails['assets_typeofshare'])) ? $transferassetDetails['assets_typeofshare'] :'';
        $assets_noofshares = (isset($transferassetDetails['assets_noofshares'])) ? $transferassetDetails['assets_noofshares'] :'';
         
        $words = NumbersToWords::convert($assets_noofshares);
        
        $signimage_url         = public_path("img/pdf/sign-here.png");
        $table_html            = '
         <table style="width: 100%; background: #fff; margin-bottom: 0;" cellpadding="8" cellspacing="0">
          <tr>
            <td style="width: 20%;  vertical-align: top;">
            <h3 style="text-align: right;">STOCK<br>TRANSFER<br>FORM</h3>
            </td>

            <td style="width: 80%; ">
            <table style="width: 100%; background: #fff; " cellpadding="8" cellspacing="0">
                <tr>
                  <td colspan="2" style="width: 100%; text-align: center; border-left: 1px dotted #000; padding: 6px;">
                    Above this line for Registrar’s use
                  </td>
                </tr>
                <tr>
                  <td style="width: 60%; border: 1px dotted #000; padding: 6px;">
                  Write the amount of money or consideration involved. If it is more than £1,000 stamp duty must be paid to HMRC. If there is no money/consideration involved, e.g. it is a gift, write ‘Nil’ and do not complete the certificate on the reverse form.<br><br><br>Consideration Money £ ' . $assets_transferamount . '………………………………………………(1)
                  </td>
                  <td style="width: 40%; border: 1px dotted #000; padding: 6px;">
                    Certificate(s) Lodged with Registrar <br><br><br><br><br><br>(For completion by the Registrar)
                  </td>
                </tr>

              </table>
              <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                <tr>
                  <td style="width: 40%; border: 1px dotted #000; padding: 6px;">
                  Full Name of Undertaking (i.e.name of the company)
                  </td>
                  <td style="width: 60%; border: 1px dotted #000; padding: 6px;">
                    ' . $companyDetails->name . '
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%; border: 1px dotted #000; padding: 6px;">
                  Full Description of Security
                  </td>
                  <td style="width: 60%; border: 1px dotted #000; padding: 6px;">
                    ' . $assets_typeofshare . '
                  </td>
                </tr>
              </table>
              <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                <tr>
                    <td style="width: 40%; border: 1px dotted #000; padding: 6px;">
                    Number of shares/amount of stock being transfered in ‘Words’ or ‘Figures’
                    </td>
                    <td style="width: 40%; border: 1px dotted #000; padding: 6px;">
                      ' . $words . '
                    </td>
                    <td style="width: 20%; border: 1px dotted #000; padding: 6px;">
                      ' . $assets_noofshares . '
                    </td>
                  </tr>
              </table>
              <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                <tr>
                    <td style="width: 40%; border: 1px dotted #000; padding: 6px;">
                    Name(s) of registered holder(s) should be given in full; the address should be given where there is only one holder. If the transfer is not made by the registered holders(s), insert also name(s) and capacity (e.g. Executor(s)) of the person(s) making the transfer.
                    </td>
                    <td style="width: 60%; border: 1px dotted #000; vertical-align: top; padding: 6px;">
                      In the name(s) of ' . $investor->displayName() . $address . $address2 . $postcode . $city . '
                    </td>
                  </tr>
              </table>
            </td>
          </tr>
          </table>

          <table style="width: 100%; background: #fff; margin-top: 0;" cellpadding="8" cellspacing="0">
            <tr>
              <td style="width: 10%; vertical-align: top;">
              <img src="' . $signimage_url . '" style="max-width: 100%; height: auto;">
              </td>
              <td style="width: 90%; vertical-align: top;">
                <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                  <tr>
                      <td style="width: 60%; border: 1px dotted #000; padding: 6px; border-bottom: none;">
                      I/We hereby transfer the above security out of the name(s) of the
        aforesaid to the person(s) named:<br>
        Signature(s) of transferor(s)<br>';
        if ($additional_args['pdfaction'] == "esign") {
            //$table_html.='{{Sig_es_:signer1:signature}}';
            $table_html .= '<div class="inputcss" style="margin-left:5px;padding:14px 8px;margin-top:5px;"><input type="text" class="signature_style" name="Sig_es_:signer1:signature" /></div> ';
        } else {
            $table_html .= '1)…………………………………………………………….<br>
        2)…………………………………………………………….<br>
        3)…………………………………………………………….<br>
        4)…………………………………………………………….<br>';
        }
        $table_html .= '</td>
                      <td style="width: 40%; border: 1px dotted #000; vertical-align: top; padding: 6px; background: #ccc; border-bottom: none;">
                        Stamp of selling broker(s) or agent(s), if any, acting for the transferor(s)
                      </td>
                    </tr>
                </table>
                <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                  <tr>
                      <td style="width: 60%; border: 1px dotted #000; padding: 6px; border-top: none;">
                      Bodies corporate may execute under their common seal or otherwise in accordance with applicable statutory requirements.
                      </td>
                      <td style="width: 40%; border: 1px dotted #000; vertical-align: bottom; padding: 6px; border-top: none;">Date';

        if ($additional_args['pdfaction'] == "esign") {
            $table_html .= '<input type="text"   style="margin-top:2px; background:#FFF;  font-size:12px;   border: dashed 1mm white; width:120px;    " name="Dte_es_:signer1:date:format(date,\'dd/mm/yyyy\')" /> ';
        } else {
            $table_html .= '……………………….';
        }

        $table_html .= '(See note 7)
                      </td>
                    </tr>
                </table>
                <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                  <tr>
                      <td style="width: 40%; border: 1px dotted #000; padding: 6px; ">
                      <b>Full name(s) and full postal address(es)</b> (including County or, if applicable, postcode) of the person (s) to whom the security is transferred. Please state title, if any, or whether Mr, Mrs, Ms or Miss.( See note 8)
                      </td>
                      <td style="width: 60%; border: 1px dotted #000; ; padding: 6px; ">
                        <table style="width: 100%; background: #fff; border: 1px solid #000;">
                            <tr>
                              <td style="padding: 6px;">
                                PLATFORM ONE NOMINEE LIMITED<BR>3 CEDAR PARK<BR>COBHAM ROAD<BR>WIMBORNE DORSET<BR>BH21 7SB
                              </td>
                            </tr>
                        </table>
                      </td>
                    </tr>
                </table>
                <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                  <tr>
                      <td style="width: 100%; border: 1px dotted #000; padding: 6px; ">
                      I/We request that such entries be made in the Register of Shareholders as are necessary to give effect to this transfer.
                      </td>

                    </tr>
                </table>
                <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
                  <tr>
                      <td style="width: 50%; border: 1px dotted #000; padding: 6px; ">
                      Please provide the information requested below in case we need to contact you.<br><br>Day time telephone number :- <u>' . $investor->telephone_no . '</u><br><br>Email :- <u>' . $investor->email . '</u>……………………………………………(9)
                      </td>
                      <td style="width: 50%; border: 1px dotted #000; ; padding: 6px; vertical-align: top; background-color: #ccc;">

                                Stamp of buying broker or other person lodging this form.

                      </td>
                    </tr>
                </table>
              </td>
            </tr>
          </table>';

        // echo $table_html;
        // exit();

        $table_html .= '<div style="page-break-after:always;border:none; "></div>';
        $table_html .= '<table style="width: 100%; background: #fff; position: relative;" cellpadding="8" cellspacing="0">
                   <tr>
                   <td style="width: 100%;  padding: 6px; ">
                      Please see below for detailed information of how to complete the Stock Transfer Form with each required part specifically explained. If you require assistance or have any questions please do not hesitate to contact our team on: 020 7071 3945 or send an email to support@growthinvest.com
                    </td>
                    </tr>
              </table>';

        $label = 'COMPLETING THE FORM';
        $table_html .= $this->transfer_assets_subheaders($label);

        $processimage_url = public_path("img/pdf/stock-transfer-exp2.png");
        $table_html .= '


              <table style="width: 100%; background: #fff; position: relative;" cellpadding="8" cellspacing="0">
                   <tr>
                   <td style="width: 100%;  padding: 6px; ">
                      <img src="' . $processimage_url . '" style="max-width: 100%; height: auto;">
                    </td>
                    </tr>

              </table>';
        $table_html .= '
              <table style="width: 100%; background: #fff; " cellpadding="8" cellspacing="0">
              <tr>
                  <td style="width: 100%;  padding: 6px; ">

                    <b>Complete Certificate 1 if:</b>
                    <ul >
                      <li >the consideration you give for the shares is £1,000 or less and the transfer is not part of a larger transaction or series of transactions (as referred to in Certificate 1).</li>
                    </ul>

                    <br>
                    <b>Complete Certificate 2 if:</b>
                    <ul>
                      <li >the transfer is otherwise Exempt from Stamp Duty and you are not claiming a relief , or</li>
                      <li >the consideration given is not chargeable consideration.</li>
                    </ul>
                  </td>
                </tr>
              </table>';

        $label = 'Certificate 1';
        $table_html .= $this->transfer_assets_subheaders($label);
        // $table_html.=$footer_img;
        //Page 3 Start

        //  $table_html.=$common_table_html;
        $table_html .= '
            <table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
              <tr>
                  <td style="width: 40%;  border: 1px solid #000; padding: 6px; vertical-align: top;">
                    <p style="color: #9e9e9e; margin-top: 0;">*Please delete as appropriate</p>
                  </td>
                  <td style="width: 60%;  border: 1px solid #000; padding: 6px; ">
                    I/We* certify that the transaction effected by this instrument does not form part of a larger transaction or series of transactions in respect of which the amount or value, or aggregate amount or value, of the consideration exceeds £1,000. (See note 11)
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border: 1px solid #000; padding: 6px; vertical-align: top;">
                    <p style="color: #9e9e9e; margin-top: 0;">**Delete second sentence</p>
                  </td>
                  <td style="width: 60%;  border: 1px solid #000; padding: 6px; ">
                    I/We* confirm that I/we* have been authorised by the transferor to sign this certificate and that I/we* am/are* aware of all the facts of the transaction.** (See note 12)
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border: 1px solid #000; padding: 6px; ">
                   <b>Signature(s) (See note 12) </b>
                  </td>
                  <td style="width: 60%;  border: 1px solid #000; padding: 6px; ">
                    <b>Description (Transferor, solicitor, etc)</b>
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; ">
                   &nbsp;
                  </td>
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; ">
                   &nbsp;
                  </td>
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; ">
                   &nbsp;
                  </td>
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; ">
                   &nbsp;
                  </td>
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px;">
                   Date
                  </td>
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
              </table>';

        $bgcolor = '#fff';

        $table_html .= '<br pagebreak="true"/>';
        $label = 'Certificate 2';
        $table_html .= $this->transfer_assets_subheaders($label);
// $table_html.=$footer_img;
        //Page 3 Start
        //  $table_html.=$common_table_html;
        $table_html .= '
<table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
              <tr>
                  <td style="width: 40%;  border: 1px solid #000; padding: 6px; vertical-align: top;">
                    <p style="color: #9e9e9e; margin-top: 0;">*Please delete as appropriate</p>
                  </td>
                  <td style="width: 60%;  border: 1px solid #000; padding: 6px; ">
                    I/We* certify that this instrument is otherwise exempt from ad valorem Stamp Duty without a claim for relief being made or that no chargeable consideration is given for the transfer for the purposes of Stamp Duty.
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border: 1px solid #000; padding: 6px; vertical-align: top;">
                    <p style="color: #9e9e9e; margin-top: 0;">**Delete this sentence if certificate is given by transferor</p>
                  </td>
                  <td style="width: 60%;  border: 1px solid #000; padding: 6px; ">
                    I/We* confirm that I/we* have been authorised by the transferor to sign this certificate and that I/we* am/are* aware of all the facts of the transaction.**
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border: 1px solid #000; padding: 6px; ">
                   <b>Signature(s) (See note 12) </b>
                  </td>
                  <td style="width: 60%;  border: 1px solid #000; padding: 6px; ">
                    <b>Description (Transferor, solicitor, etc)</b>
                  </td>
                </tr>
                <tr>';

        $additional_signcell_downloadpdf = "";

        if ($additional_args['pdfaction'] == "esign") {
            //$table_html.='{{Sig_es_:signer1:signature}}';
            $table_html .= '<td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; " rowspan="4"> <input type="text" class="signature_style2" name="Sig_es_:signer1:signature" /> </td>';
        } else {
            $additional_signcell_downloadpdf .= '<td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; ">
                   &nbsp;</td>
                      ';
        }

        $table_html .= $additional_signcell_downloadpdf . '
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  ' . $additional_signcell_downloadpdf . '
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  ' . $additional_signcell_downloadpdf . '
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                   ' . $additional_signcell_downloadpdf . '
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="width: 40%;  border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 6px; ">
                   Date : ';

        if ($additional_args['pdfaction'] == "esign") {
            $table_html .= '<input type="text"   style="margin-top:2px; background:#FFF;  font-size:12px;   border: dashed 1mm white; width:120px;    " name="Dte_es_:signer1:date:format(date,\'dd/mm/yyyy\')" /> ';
        }

        $table_html .= '</td>
                  <td style="width: 60%;  border-bottom: 1px solid #000; padding: 6px; ">
                    &nbsp;
                  </td>
                </tr>
              </table>';
        $table_html .= '<div style="page-break-after:always;border:none; "></div>';
        $table_html .= '
<table style="width: 100%; background: #fff; margin-top: 0px;" cellpadding="8" cellspacing="0">
              <tr>
                  <td style="width: 100%;  border: 1px solid #000; padding: 6px; vertical-align: top;">
                    <b>Notes</b><br>
<b>.</b>    You do not need to send this form to HM Revenue & Customs (HMRC) if you have completed either Certificate 1 or 2, or the consideration for the transfer is nil (in which case you must write ‘nil’ in the ‘Consideration Money’ box on the front of the form). In these situations send the form straight to us.<br>
<b>..</b>   In all other cases - including where relief from Stamp Duty is claimed-send the transfer form to HMRC to be stamped before sending it to us.<br>
<b>...</b>   Information on Stamp Duty reliefs and exemptions and how to claim them can be found on the HMRC website at www.hmrc.gov.uk/sd.
                  </td>
                </tr>
                </table><br>';

        $table_html .= '<table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
              <tr>
                  <td style="width: 100%; padding: 6px; vertical-align: top;">
                  Please see below for detailed information for when Stamp Duty applies. If you require assistance or have any questions please do not hesitate to contact our team on:
020 7071 3945 or send an email to support@growthinvest.com.
                  </td>
                  </tr>
                  </table>';

        $label = 'REFERENCE TO STAMP DUTY';
        $table_html .= $this->transfer_assets_subheaders($label);
        $table_html .= '
<table style="width: 100%; background: #fff;" cellpadding="8" cellspacing="0">
              <tr>
                  <td style="width: 100%;  border: 1px solid #000; padding: 6px; vertical-align: top;">
                    <b><u>Note 1</u></b><br>If payment of more than £1,000 is involved in transferring these shares you should enter the amount re-ceived (the Consideration Money) in this box. Stamp Duty will need to be paid for the shares transferred and you should telephone the Stamp Office helpline on: 0300 200 3510 or, if calling from overseas, +44 1726 209 042. They will advise you of the amount of duty payable. Alternatively, visit the website at: www.hmrc.gov.uk/sd.<br>
<br>
A cheque or postal order, made payable to “HMRC”, should be sent with the completed Stock Transfer form to: Birmingham Stamp Office, 9th Floor, City Centre House, 30 Union Street, Birmingham, B2 4AR. The form will be returned to you after stamping.<br>
<br>
If the payment involved in transferring the shares is £1,000 or less than £1,000, you will need to complete <b>Certificate 1</b> on the second side of the form. If Consideration is over £1,000 but Stamp Duty exemptions apply (see note 15), <b>Certificate 2</b> on the second side of the form will need to be completed.If no payment (Consideration) is given for the shares, you must enter <b>‘Nil’</b> as the <b>Consideration Money</b> and you do not need to complete either certificate.
<br><br>
<b><u>Note 2</u></b><br><b>Where Stamp Duty is Not Chargeable or Exempt (and Certificate 1 does not apply)</b><br>
If you acquire any of the following, in the following ways, they will <b>not be chargeable</b> with Stamp Duty. <b>Certificate 2</b>, on the second side of the Stock Transfer form, should therefore be completed for:<br>
<ul style="margin: 0; padding: 0;">
  <li>Shares that you receive as a gift and that you don’t pay anything for (either money or some other - consideration)</li>
  <li>Shares that are received from your spouse or civil partner when you marry or enter into a civil - partnership</li>
  <li>Shares held in trust that are transferred from one trustee to another;</li>
  <li>Transfers that a liquidator makes as settlement to shareholders when a business is wound up;</li>
  <li>Shares that are transferred to you as a security for a loan;</li>
  <li>Shares that were held as security for a loan that are transferred back to you when you repay the - loan</li>
  <li>Transfers to the beneficiary of a trust when the trust is wound up.</li>
</ul>
 <br>
If any of the above applies, you should complete <b>Certificate 2</b> on the second side of the Stock Transfer form.The only exception is if any of the above applies <b>and</b> the Consideration is Nil. If this is the case, neither certificate need to be completed, and the Stock Transfer form does not need to be stamped by HMRC. No documents will need to be seen by HMRC as there will be no Stamp Duty to pay. However, please ensure that <b>‘Nil’</b> is written as the <b>‘Consideration Money’</b> (see Note 1).
                  </td>
                </tr>
                </table>';

        $head_foot_args['backtop']   = "46mm";
        $head_foot_args['headertxt'] = 'Stock Transfer Form';
        $header_footer_start_html    = get_header_page_markup($head_foot_args);

        $html = $style_html . $header_footer_start_html . $table_html . $header_footer_end_html;
// echo ($html);exit;
        return $html;

    }

    public function getHtmlForLetterOfAuthorityPdf($transferasset, $additional_args)
    {
        $header_footer_end_html = "</page>";
        $html                   = '';
        $current_date           = date("d/m/Y");

        $investor             = $transferasset->investor;
        $companyDetails       = $transferasset->company;
        $transferassetDetails = $transferasset->details;
        $typeOfAssets         = typeOfAssets();
        $default_logo_url     = public_path("img/pdf/pdfheader - nomination-firstpg.jpg");

        $nomineeApplication = $investor->userAdditionalInfo();

        $style_html = '<style type="text/css">
              .bordertable {border:1px solid #000;}
                th {border:none;
                  font-size:12px;
                  font-weight:normal;
                }
                td {
                  font-size:12px;
                  font-weight:normal;
                  border:none;
                }
               table {
                 background-color:#E0E0E0;
                 margin-bottom:1px;
                 /*margin-top:10px;*/
               }
                div {
                  border:1px solid #A9A9A9;
                  background-color:#FFF;
                  line-height: 15px;

                }
                div.sectionhead{
                  background-color:#0066ff;
                 color:#FFF";
                }
                div.subsectionhead{
                  background-color:#E0E0E0;
                  position:absolute;
                  bottom:0px;
                }
                .blue_heading_div{
                      color:#fff;
                      background-color:#0A3250;
                      font-size:10px;
                      display:block;


                      text-align: left;
                      /* border-left:1px solid #000;
                      border-top:1px solid #000;
                      border-right:1px solid #000;
                      border-bottom:1px solid #000; */
                      border-radius: 1mm;
                      padding-top:3px;
                      padding-bottom:6px;

                    }
                    .w100per{
                      width:100%;
                    }
                    .w98per{
                      width:98%;
                    }
                    .w90per{
                      width:90%;
                    }
                    .w50per{
                      width:50%;
                    }

                    .w30per{
                      width:30%;
                    }
                    .w25per{
                      width:25%;
                    }
                    .w20per{
                      width:20%;
                    }
                    .round_radius{
                      border-radius: 1mm;
                    }
                    .inputcss{
                      /* border: solid 1px #ccc;
                      border-radius: 50%;
                      display:block;
                      padding: 50px;
                      width:100px;
                      inline-height:200px; */
                     border-radius: 1mm;
                      /* padding-top:2px;
                      padding-bottom:4px;
                      border: none;
                      text-align: center;
                      border:1px solid #D9DBDD; */
                      padding-left:5px;
                    }
                    table.no-spacing {
                      border-spacing:0;
                      border-collapse: collapse;
                    }

                    .signature_style{
                      display:block;
                      width:300px;
                      font-size:22px;
                      padding-top:5px;
                    }




                </style>';

        $address  = isset($investor->address_1) ? ", " . $investor->address_1 : "";
        $address2 = isset($investor->address_2) ? ", " . $investor->address_2 : "";
        $city     = isset($investor->city) ? ", " . $investor->city : "";
        $postcode = isset($investor->postcode) ? ", " . $investor->postcode : "";

        $assets_noofshares = isset($transferassetDetails['assets_noofshares']) ? $transferassetDetails['assets_noofshares'] : "";
        if ($transferasset->typeofasset == 'iht_service') {
            $company_name      = $companyDetails->name;

            $assets_noofshares = ' / ' . $assets_noofshares;

        } else {
            $company_name      = $companyDetails->name;
            $assets_noofshares = '';
        }

        //Page 1 Start
        $table_html = '

            <table cellpadding="0" cellspacing="0" border="0"  style="width:92%; background:#FFF;" >

                <tr>
                <td style="width:100%">
                <h3 style="font-weight: 500; color: grey;">Letter of Authority</h3>
                Dear Client,<br>This letter is addressed to the undertaking company for the requested asset transfer to your Platform One Limited nominee account. In order for us to complete the transfer we require your permission to access your information and order the transfer from the company/fund where you hold stock.
                </td>
                </tr>

            </table><br>';

        $label = 'AUTHORITY LETTER FOR ASSET TRANSFER';
        $table_html .= $this->transfer_assets_subheaders($label);

        // test starts
        $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">
              <tr>
              <td class="w50per"><b>Registered Holder’s Name</b></td>
              <td class="w50per" ><b>Undertaking Manager/Company</b></td>
              </tr>
              <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Name of Account Holder :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $investor->displayName() . '</div></td>
                     </tr>
                     </table>
                 </td>
                 <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Name of the Undertaking :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->name . '</div></td>
                     </tr>
                     </table>
                 </td>
              </tr>
              <tr style="vertical-align: top; margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 50%;">
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing">
                     <tr>
                     <td style="Width: 30%;">Joint Owner (if applicable) :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;</div></td>
                     </tr>
                     </table>
                     <table style="width: 100%;" class="no-spacing">
                     <tr>
                     <td style="Width: 30%;">Address :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px; height: 50px;">&nbsp;' . $address . ' ' . $address2 . '</div></td>
                     </tr>
                     </table>
                 </td>
                 <td style="width: 50%;">
                     <table style="width: 100%;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%; vertical-align: top;">Address :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px; height: 50px;">&nbsp;' . $companyDetails->address . '</div></td>
                     </tr>
                     </table>
                     <table style="width: 100%;" class="no-spacing">
                     <tr>
                     <td style="Width: 30%; vertical-align: middle;">Postcode :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $companyDetails->postcode . '</div></td>
                     </tr>
                     </table>
                 </td>
              </tr>
              <tr style="vertical-align: top;">

                 <td style="width: 50%;">
                     <table style="width: 100%;" >
                     <tr>
                     <td style="Width: 30%; vertical-align: middle;">Postcode :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $postcode . '</div></td>
                     </tr>
                     </table>
                 </td>
                 <td style="width: 50%;">
                     <table style="width: 100%;" >
                     <tr>
                     <td style="Width: 30%; vertical-align: top;">Client Account No :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;</div></td>
                     </tr>
                     </table>
                     <table style="width: 100%;" >
                     <tr>
                     <td style="Width: 30%; vertical-align: middle;">Type of Asset :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $typeOfAssets[$transferasset->typeofasset] . '</div></td>
                     </tr>
                     </table>
                 </td>
              </tr>


             </table>';

        $table_html .= '<table cellpadding="0" cellspacing="10" border="1"  class="w100per round_radius" >
                <tr>
                <th class="w100per"> I/We the undersigned, hereby authorise my/our agent; GrowthInvest (Trading name for EIS Platforms Ltd. located at: Candlewick House, 120 Cannon Street, EC4N 6AS, London) to access and complete the asset re-registration.<br><br>
                Any and all acts carried out by GrowthInvest on my/our behalf as regards the asset transfer, shall have the same effect as my/our own. I/We confirm that by virtue of paragraph 6 of schedule 19 of the Finance Act 1999 this transaction is exempt from Stamp Duty Reserve Tax.<br><br>
                I/We authorise Platform One to submit this re-registration authority to the Manager/Director detailed below and for the Manager/Director to execute the re-registration with immediate effect.<br><br>
                I/We confirm that the re-registration of the asset(s) listed below will not affect any change of beneficial owners from or among the existing holders and is not for consideration in money or moneys worth.<br><br>
                This authorisation is valid until further written notice.</th>
                          </tr>
                          </table>';
        $table_html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius">



              <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; margin-bottom: 0;" >
                         <tr>

                         <td style="Width: 100%;"><div class="inputcss" style="padding: 6px; background: #ccc;"><b>REGISTERED HOLDER’S NAME</b></div></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-top: 0;" >
                     <tr>

                     <td style="Width: 100%;"><div class="inputcss" style="padding: 6px; height:15px;">' . $investor->displayName() . '</div></td>
                     </tr>
                     </table>
                     <table style="width: 100%;" >
                     <tr>
                     <td style="Width: 20%; vertical-align: middle;"><b>Date:</b> </td>
                     <td style="Width: 80%;"><div class="inputcss" style="padding: 6px;">';

        if ($additional_args['pdfaction'] == "esign") {
            $table_html .= '<input type="text" style=" background:#FFF;  font-size:12px;   border: dashed 1mm white;    "name="Dte_es_:signer1:date:format(date,\'dd/mm/yyyy\')" /> ';
        } else {
            $table_html .= ' &nbsp;';
        }

        $table_html .= '</div></td>';
        //      <td style="Width: 80%;"><div class="inputcss" style="padding: 6px;">'.$firm_stats['created_date'].'</div></td>

        $table_html .= '
                     </tr>
                     </table>
                 </td>
                 <td style="width: 50%; vertical-align: top;" >
                 <table style="width: 100%;" >
                         <tr>

                         <td style="Width: 100%;"><div class="inputcss" style="padding: 6px; background: #ccc;"><b>REGISTERED HOLDER’S SIGNATURE</b></div></td>
                         </tr>
                     </table>
                     <table style="width: 100%;" >
                     <tr style="vertical-align: top;">

                     <td style="Width: 100%; vertical-align: top;">';
        if ($additional_args['pdfaction'] == "esign") {
            //$table_html.='{{Sig_es_:signer1:signature}}';
            $table_html .= '<div class="inputcss" style="margin-left:5px;padding:14px 8px;margin-top:5px;"><input type="text" class="signature_style" name="Sig_es_:signer1:signature" /></div> ';
        } else {
            $table_html .= '<div class="inputcss" style="height: 60px;"></div>';
        }
        $table_html .= '</td>
                     </tr>
                     </table>
                 </td>
              </tr>


            </table><br pagebreak="true"/>';
        $label = 'ASSETS TO BE TRANSFERRED/RE-REGISTERED';
        $table_html .= $this->transfer_assets_subheaders($label);
        $table_html .= '
             <table style="border: solid 1px #000; border-collapse: collapse; width:100%;" align="center">
               <tr style="background:#ccc; color:#000;">
                  <td class="w50per" style="padding:8px;border: solid 1px #CCC;">Full name of assets to be transferred or re-registered:</td>
                  <td class="w50per" style="padding:8px;border: solid 1px #CCC;">Inc/Acc:</td>
                </tr>
             </table>
             <table style=" border-collapse: collapse; width:100%;" align="center">

             <tr style="margin-bottom: 0; padding: 0; ">
                <td style="width: 50%; border: solid 1px #0A3250; padding:8px; background:#FFF;">
                                    ' . $company_name . $assets_noofshares . '

                 </td>
                 <td style="width: 50%; border: solid 1px #0A3250; padding:8px;background:#FFF;">

                 </td>
              </tr>
              <tr style="margin-bottom: 0;">
                <td style="width: 50%; border: solid 1px #0A3250; padding:8px;background:#FFF;">
                    &nbsp;
                 </td>
                 <td style="width: 50%; border: solid 1px #0A3250; padding:8px;background:#FFF;">
                     &nbsp;
                 </td>
              </tr>
              <tr style="margin-bottom: 0;">
                <td style="width: 50%; border: solid 1px #0A3250; padding:8px;background:#FFF;">
                    &nbsp;
                 </td>
                 <td style="width: 50%; border: solid 1px #0A3250; padding:8px;background:#FFF;">
                     &nbsp;
                 </td>
              </tr>



            </table>
            ';

        $head_foot_args['headertxt'] = "14mm";
        $header_footer_start_html    = get_header_page_markup($head_foot_args);

        $html = $style_html . $header_footer_start_html . $table_html . $header_footer_end_html;

        return $html;

    }

    public function transfer_assets_subheaders($label, $sublabel = '')
    {

        $table_html = '<table cellpadding="5" cellspacing="0" border="0"  width="100%"   >';

        if ($sublabel != '') {
            $table_html .= '  <tr bgcolor="#FFF">            <th width="100%></th><th width="50%><h2 style="font-weight: 500;">' . $sublabel . '</h2></th>   </tr>';
        }
        $table_html .= '<tr><td  class="blue_heading_div"  >' . $label . '</td>
                                      </tr>
                                      </table>';

        return $table_html;
    }

    public function get_checkbox_html($checboxes_data)
    {
        $html = '';

        foreach ($checboxes_data as $key => $value) {

            $checkbox_html = '<div class="inputcss dob" style="padding:6px; text-align: center; height: 12px;">';
            if ($value['checked'] == true) {
                $checkbox_html .= '<img src="' . public_path("img/pdf/check_mark.png") . '" width="10" height="10"  style="margin: 0 auto;" />';
            }
            $checkbox_html .= "</div>";

            if ($value['label_first'] == true) {
                $html = $value['label'] . '  &nbsp; ' . $checkbox_html;
            } else {
                $html = $checkbox_html . " &nbsp; " . $value['label'];
            }

        }

        return $html;
    }

}

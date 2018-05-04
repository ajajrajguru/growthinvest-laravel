<?php
namespace App;

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
        $nominee_details    = $nomineeApplication->details; 

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

        // $table_html.='<table cellpadding="0" cellspacing="10" border="1"  width="100%" >
        //               <tr>
        //                <th width="100%">The GrowthInvest nominee and custody service enables you to make investments directly through the platform and monitor all of your tax efficient investments in one place. In providing this service we have partnered with <b>Platform One Limited</b>, an FCA regulated custodian and nominee service. Please complete the Asset Transfer form as accurately as possible and post the signed version to: GrowthInvest, Candlewick House, 120 Cannon Street, London, EC4N 6AS.</th>
        //               </tr>
        //               </table>';
        $table_html .= '<br>';
        $label = 'APPLICANT DETAILS';
        $table_html .= $this->transfer_assets_subheaders($label);

        // test starts

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
                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" > $transferassetDetails
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
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $transferassetDetails['assets_noofshares'] . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Type of Share :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $transferassetDetails['assets_typeofshare'] . '</div></td>
                     </tr>
                     </table><br>

                     <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                     <tr>
                     <td style="Width: 30%;">Name of Certificate :</td>
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $transferassetDetails['assets_nameonsharecertificate'] . '</div></td>
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
        if ($transferasset->typeofasset == 'VCT') {
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
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;' . $transferassetDetails['assets_clientaccno'] . '</div></td>
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
                     <td style="Width: 70%;"><div class="inputcss" style="padding: 6px;">&nbsp;&pound;&nbsp;' . $transferassetDetails['assets_transferamount'] . '</div></td>
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
                      Please transfer my holding once instructions have been received from Platform One to do so. After transfer, all dividends and tax credits due should be made payable to P1 growthinvest. Payments should be sent with client name as a reference.<br><br><b>Electronic Payments should be sent to: </b><br><br><b>Sort Code: 40 -13 - 07</b><br><br><b>Account Number: 9367 1402</b><br><br><b>Account Name: P1 growthinvest</b><br><br>
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

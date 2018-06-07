<?php
namespace App;

class BusinessPdfHtml
{

    public function getBusinessProposalHtml($businessListing)
    {
        $businessIdeasData           = (!empty($businessListing->getBusinessIdeas())) ? unserialize($businessListing->getBusinessIdeas()->data_value): [];
        $businessProposalDetails = (!empty($businessListing->getBusinessProposalDetails())) ? unserialize($businessListing->getBusinessProposalDetails()->data_value) : [];
        $fundingRequirement      = (!empty($businessListing->getFundingRequirement())) ? unserialize($businessListing->getFundingRequirement()->data_value) : [];
        $businessHmrcStatus      = (!empty($businessListing->getBusinessHmrcStatus())) ? $businessListing->getBusinessHmrcStatus()->data_value : '';
        $financials              = (!empty($businessListing->getFinancials())) ? unserialize($businessListing->getFinancials()->data_value) : [];
        $teamMemberDetails       = (!empty($businessListing->getTeamMemberDetails())) ? unserialize($businessListing->getTeamMemberDetails()->data_value) : [];
        $companyDetails          = (!empty($businessListing->getCompanyDetails())) ? unserialize($businessListing->getCompanyDetails()->data_value) : [];
        // $businessFiles           = $businessListing->getAllBusinessFile();
        // $documentUploads         = $businessListing->getDocumentUpload();
        // $dueDeligence            = $businessListing->getDueDeligence();
        // $publicAdditionalDocs    = $businessListing->getBusinessMultipleFile('public_additional_documents');
        // $privateAdditionalDocs   = $businessListing->getBusinessMultipleFile('private_additional_documents');
        // $defaultIds              = $businessListing->businessDefaults()->pluck('default_id')->toArray();
        // $profilePic      = $businessListing->getBusinessLogo('medium_1x1');
        // $backgroundImage = $businessListing->getBusinessBackgroundImage('medium_2_58x1');
        // $videos = $businessListing->businessVideos()->get();

        $html         = '';
        $table_border = "0";

        $default_logo_url   = public_path("img/pdf/pdfheader.jpg");
        $default_footer_url = public_path("img/pdf/pdf_footer3.png");

        $default_header1_bg_url = public_path("img/pdf/pdfheader1.png");
        $default_box_url        = public_path("img/pdf/box.png");
        $box_img                = '<img src="' . $default_box_url . '"><br>';
        // $nomination_first_page = K_PATH_IMAGES."PDF-Header-new-d-compressor.jpg";
        $nomination_first_page = public_path("img/pdf/general_pdf_header.png");
        $html .= '

                                                            <style>

                                h4{
                                color:#000;
                                font-size:12px;
                                font-weight:normal;
                                }

                                .section_holder  {
                                  background-color:#EAEAEA /* #666 */;
                                  border:1px solid #000;
                                  margin-bottom:5px;
                                }
                                .content_font_size1 td{
                                  font-size:7px !important;
                                }

                                .textbold
                                {
                                  font-weight: bold;
                                  font-size:10px;
                                }
                                .blue_heading_div{
                                  color:#fff;
                                  background-color:#0070C0;
                                  font-size:10px;
                                  display:block;
                                  width:100%;

                                  text-align: left;
                                  border-left:1px solid #000;
                                  border-top:1px solid #000;
                                  border-right:1px solid #000;
                                  border-bottom:1px solid #000;




                                }

                                th {

                                padding-top: 4px;
                                font-weight:normal;
                                font-size:9px;


                                }


                                td{
                                color: #666;

                                padding-top:5px;
                                padding-left:0px !important;
                                font-size:9px;
                                vertical-align: middle;

                                }





                                 </style>';

        if ($businessListing->type != 'fund') {

            $html .= '<table cellpadding="0" cellspacing="0" border="' . $table_border . '"  width="100%">
                                     <tr>
                                         <td   valign="top" height="90"> <img class="bg-background " src="' . $nomination_first_page . '"  style="max-width:100%; height:auto; " /> </td>
                                     </tr>

                                     <tr>
                                     <td valign="top"><h4>'; /*SEED EIS PLATFORM*/$html .= 'GROWTHINVEST BUSINESS PROPOSAL</h4>
                                         NOTE: Business Summary Questionnaire provides a snapshot of your business for consideration of our investment committee. Creates a short investment memorandum for everyone to download.<br/>
                                     </td>

                                     </tr>

                                </table>';
            $aboutbusiness   = (!empty($businessIdeasData) && isset($businessIdeasData['aboutbusiness'])) ? $businessIdeasData['aboutbusiness'] : '';
            $businessstage   = (!empty($businessIdeasData) && isset($businessIdeasData['businessstage'])) ? $businessIdeasData['businessstage'] : '';
            $businessfunded  = (!empty($businessIdeasData) && isset($businessIdeasData['businessfunded'])) ? $businessIdeasData['businessfunded'] : '';
            $incomegenerated = (!empty($businessIdeasData) && isset($businessIdeasData['incomegenerated'])) ? $businessIdeasData['incomegenerated'] : '';
            $aboutteam       = (!empty($businessIdeasData) && isset($businessIdeasData['aboutteam'])) ? $businessIdeasData['aboutteam'] : '';
            $marketscope     = (!empty($businessIdeasData) && isset($businessIdeasData['marketscope'])) ? $businessIdeasData['marketscope'] : '';
            $exit_strategy   = (!empty($businessIdeasData) && isset($businessIdeasData['exit_strategy'])) ? $businessIdeasData['exit_strategy'] : '';

            $html .= get_section_header_content_seperator() . ' <table cellpadding="5" cellspacing="0"  width="100%"   >
                                     <tr>
                                         <td  class="blue_heading_div" >Business Idea</td>
                                    </tr>
                                </table><table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%"   class="section_holder">
                                  <tr>


                                      <td  width="100%">

                                       <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%" class="content_font_size1" >

                                            <tr>
                                                <td class="textbold">Please describe your business</td>

                                                <td>' . get_input_box_style($aboutbusiness, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                              <tr>
                                                <td class="textbold">What stage is the business at?</td>
                                                <td>' . get_input_box_style($businessstage, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">Funding to this point</td>
                                                <td>' . get_input_box_style($businessfunded, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">Has the business generated any income/turnover so far? If so, how much?</td>
                                                <td>' . get_input_box_style($incomegenerated, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Please summarize the team</td>
                                                <td>' . get_input_box_style($aboutteam, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Please summarize the market/industry</td>
                                                <td>' . get_input_box_style($marketscope, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Please describe your exit strategy</td>
                                                <td>' . get_input_box_style($exit_strategy, 'textarea', 0, 3) . ' </td>
                                            </tr>

                                         </table> </td></tr></table>';

            //section 2
            $expected_status_html = '';
            foreach ($businessListing->tax_status as $key => $taxStatus) {
                $expected_status_html .= get_checkbox_html2($taxStatus, true);
            }

            $business_sector      = $businessListing->getBusinessSectors();
            $business_sector_html = '';
            foreach ($business_sector as $key => $sector) {
                $business_sector_html .= get_checkbox_html2($sector->name, true);
            }

            $milestones     = $businessListing->getBusinessMilestone();
            $milestone_html = '';
            foreach ($milestones as $key => $milestone) {
                $milestone_html .= get_checkbox_html2($milestone->name, true);
            }
            $stageofbusiness = (!empty($businessListing->getBusinessStage())) ? $businessListing->getBusinessStage()->name : '';
            $proposalRounds  = businessRounds();
            $proposal_round  = (isset($proposalRounds[$businessListing->round])) ? $proposalRounds[$businessListing->round] : '';

            $business_proposal_details = (!empty($businessProposalDetails) && isset($businessProposalDetails['business_proposal_details'])) ? $businessProposalDetails['business_proposal_details'] : '';
            $tradingname               = (!empty($businessProposalDetails) && isset($businessProposalDetails['tradingname'])) ? $businessProposalDetails['tradingname'] : '';
            $address                   = (!empty($businessProposalDetails) && isset($businessProposalDetails['address'])) ? $businessProposalDetails['address'] : '';
            $postcode                  = (!empty($businessProposalDetails) && isset($businessProposalDetails['postcode'])) ? $businessProposalDetails['postcode'] : '';
            $website                   = (!empty($businessProposalDetails) && isset($businessProposalDetails['website'])) ? $businessProposalDetails['website'] : '';
            $social_facebook           = (!empty($businessProposalDetails) && isset($businessProposalDetails['social-facebook'])) ? $businessProposalDetails['social-facebook'] : '';
            $social_linkedin           = (!empty($businessProposalDetails) && isset($businessProposalDetails['social-linkedin'])) ? $businessProposalDetails['social-linkedin'] : '';
            $social_twitter            = (!empty($businessProposalDetails) && isset($businessProposalDetails['social-twitter'])) ? $businessProposalDetails['social-twitter'] : '';
            $social_google             = (!empty($businessProposalDetails) && isset($businessProposalDetails['social-google'])) ? $businessProposalDetails['social-google'] : '';
            $started_trading           = (!empty($businessProposalDetails) && isset($businessProposalDetails['started-trading'])) ? $businessProposalDetails['started-trading'] : '';

            $html .= '<br pagebreak="true"/>';
            $html .= get_section_header_content_seperator() . '<table cellpadding="5" cellspacing="0"  width="100%"   >
                                     <tr>
                                         <td  class="blue_heading_div" >Business Proposal Details</td>
                                    </tr>
                                </table><table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%"   class="section_holder">
                                  <tr>


                                      <td  width="100%">

                                       <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%" class="content_font_size1" >

                                            <tr>
                                                <td width="30%" class="textbold">Trading Name</td>
                                                <td width="70%">' . get_input_box_style($businessListing->title) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                              <tr>
                                                <td class="textbold">Business Proposal Round</td>
                                                <td>' . get_input_box_style($proposal_round) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">Elevator pitch</td>
                                                <td>' . get_input_box_style($business_proposal_details, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">Company Name</td>
                                                <td>' . get_input_box_style($tradingname) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Registered Address</td>
                                                <td>' . get_input_box_style($address, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Postcode</td>
                                                <td>' . get_input_box_style($postcode) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Website</td>
                                                <td>' . get_input_box_style($website) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Facebook</td>
                                                <td>' . get_input_box_style($social_facebook) . ' </td>
                                            </tr>
                                           <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Linkedin</td>
                                                <td>' . get_input_box_style($social_linkedin) . ' </td>
                                            </tr>
                                           <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Twitter</td>
                                                <td>' . get_input_box_style($social_twitter) . ' </td>
                                            </tr>
                                           <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Google +</td>
                                                <td>' . get_input_box_style($social_google) . ' </td>
                                            </tr>
                                           <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Started Trading</td>
                                                <td>' . get_input_box_style($started_trading) . ' </td>
                                            </tr>
                                           <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Expected Tax Status</td>
                                                <td>' . $expected_status_html . ' </td>
                                            </tr>
                                           <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">HMRC Approval Status</td>
                                                <td>' . get_input_box_style($businessHmrcStatus) . ' </td>
                                            </tr>
                                             <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Business Sector</td>
                                                <td>' . $business_sector_html . ' </td>
                                            </tr>
                                             <tr>
                                              <td></td>
                                            </tr>
                                         <tr>
                                                <td class="textbold">Stage of Business</td>
                                                <td>' . get_input_box_style($stageofbusiness) . ' </td>
                                            </tr>
                                           <tr>
                                              <td></td>
                                            </tr>
                                         <tr>
                                                <td class="textbold">Milestones achieved</td>
                                                <td>' . $milestone_html . ' </td>
                                            </tr>

                                         </table> </td></tr>
                                </table>';

            //section 3
 
 
            $kh = 1;
            $useoffundshtml = '';
            if(!empty($fundingRequirement['use_of_funds'])){
                foreach ($fundingRequirement['use_of_funds'] as $useoffundsvalue) {
                    $useoffundshtml .= '<tr>
                                            <td  class="textbold"> ' . $kh . '</td>
                                            <td class="textbold">Amount/Percentage</td>
                                            </tr>
                                            <tr>
                                            <td>' . get_input_box_style($useoffundsvalue['value']) . '</td>
                                            <td>' . get_input_box_style($useoffundsvalue['amount']) . '</td>
                                            </tr>';
                    $kh++;
                }
            }

            $no_of_shares_issue   = (!empty($fundingRequirement) && isset($fundingRequirement['no-of-shares-issue'])) ? $fundingRequirement['no-of-shares-issue'] : '';
            $no_of_new_shares_issue   = (!empty($fundingRequirement) && isset($fundingRequirement['no-of-new-shares-issue'])) ? $fundingRequirement['no-of-new-shares-issue'] : '';
            $share_price_curr_inv_round   = (!empty($fundingRequirement) && isset($fundingRequirement['share-price-curr-inv-round'])) ? $fundingRequirement['share-price-curr-inv-round'] : '';
            $share_class_issued   = (!empty($fundingRequirement) && isset($fundingRequirement['share-class-issued'])) ? $fundingRequirement['share-class-issued'] : '';
            $nominal_value_share   = (!empty($fundingRequirement) && isset($fundingRequirement['nominal-value-share'])) ? $fundingRequirement['nominal-value-share'] : '';
            $investment_sought   = (!empty($fundingRequirement) && isset($fundingRequirement['investment-sought'])) ? $fundingRequirement['investment-sought'] : '0';
            $bi_minimum_investment   = (!empty($fundingRequirement) && isset($fundingRequirement['bi_minimum_investment'])) ? $fundingRequirement['bi_minimum_investment'] : '0';
            $minimum_raise   = (!empty($fundingRequirement) && isset($fundingRequirement['minimum-raise'])) ? $fundingRequirement['minimum-raise'] : '0';
            $post_money_valuation   = (!empty($fundingRequirement) && isset($fundingRequirement['post-money-valuation'])) ? $fundingRequirement['post-money-valuation'] : '0';
            $pre_money_valuation   = (!empty($fundingRequirement) && isset($fundingRequirement['pre-money-valuation'])) ? $fundingRequirement['pre-money-valuation'] : '0';
            $percentage_giveaway   = (!empty($fundingRequirement) && isset($fundingRequirement['percentage-giveaway'])) ? $fundingRequirement['percentage-giveaway'] : '';

            
            $notcalculatedcheck = (!empty($fundingRequirement) && isset($fundingRequirement['not-calculated-share'])) ? $fundingRequirement['not-calculated-share'] : '0';
            if ($notcalculatedcheck == '1') {
                $html .= get_section_header_content_seperator() . '<table cellpadding="5" cellspacing="0"  width="100%"   >
                                     <tr>
                                         <td  class="blue_heading_div" >Funding Requirements</td>
                                    </tr>
                                </table><table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%"   class="section_holder">
                                  <tr>


                                      <td  width="100%">

                                       <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%" class="content_font_size1" >

                                            <tr>
                                                <td class="textbold">Targeted Raise</td>
                                                <td>' . get_input_box_style('&pound; ' . $investment_sought) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                              <tr>
                                                <td class="textbold">Minimum Investment</td>
                                                <td>' . get_input_box_style('&pound; ' . $bi_minimum_investment) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">Minimum Raise</td>
                                                <td>' . get_input_box_style('&pound; ' . $minimum_raise) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">Post-money Valuation</td>
                                                <td>' . get_input_box_style('&pound; ' .  $post_money_valuation) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Pre-money Valuation</td>
                                                <td>' . get_input_box_style('&pound; ' . $pre_money_valuation) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td  class="textbold">Post-investment % shareholding to be issued</td>
                                                <td>' . get_input_box_style($percentage_giveaway) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Use of Funds</td>
                                                <td> </td>
                                            </tr>
                                            ' . $useoffundshtml . '

                                         </table> </td></tr>
                                </table>';
            } else {

       

                $html .= get_section_header_content_seperator() . '
                                 <table cellpadding="5" cellspacing="0"  width="100%"   >
                                     <tr>
                                         <td  class="blue_heading_div" >Funding Requirements</td>
                                    </tr>
                                </table><table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%"   class="section_holder">
                                  <tr>


                                      <td  width="100%">

                                       <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%" class="content_font_size1" >

                                            <tr>
                                                <td class="textbold">Number of Shares in Issue</td>
                                                <td>' . get_input_box_style($no_of_shares_issue) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr> <tr>
                                                <td class="textbold">Number of New Shares to be Issued</td>
                                                <td>' . get_input_box_style($no_of_new_shares_issue) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr> <tr>
                                                <td class="textbold">Share Price for Current Investment Round</td>
                                                <td>' . get_input_box_style('&pound; ' . $share_price_curr_inv_round) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr> <tr>
                                                <td class="textbold">Share Class of Shares to be Issued</td>
                                                <td>' . get_input_box_style($share_class_issued ) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr> <tr>
                                                <td class="textbold">Nominal Value of Shares</td>
                                                <td>' . get_input_box_style('&pound; ' . $nominal_value_share) . '</td>





                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Raise Amount</td>
                                                <td>' . get_input_box_style('&pound; ' . $investment_sought) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                              <tr>
                                                <td class="textbold">Minimum Investment</td>
                                                <td>' . get_input_box_style('&pound; ' . $bi_minimum_investment) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>

                                             <tr>
                                                <td class="textbold">Post-money Valuation</td>
                                                <td>' . get_input_box_style('&pound; ' . $post_money_valuation) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Pre-money Valuation</td>
                                                <td>' . get_input_box_style('&pound; ' .$pre_money_valuation) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Post-Investment % Equity Offer</td>
                                                <td>' . get_input_box_style($percentage_giveaway) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Use of Funds</td>
                                                <td> </td>
                                            </tr>
                                             ' . $useoffundshtml . '

                                         </table> </td></tr>
                                </table>';
            }

            //section 4

            $revenue_year1   = (!empty($fundingRequirement) && isset($fundingRequirement['revenue_year1'])) ? $fundingRequirement['revenue_year1'] : '';
            $revenue_year2   = (!empty($fundingRequirement) && isset($fundingRequirement['revenue_year2'])) ? $fundingRequirement['revenue_year2'] : '';
            $revenue_year3   = (!empty($fundingRequirement) && isset($fundingRequirement['revenue_year3'])) ? $fundingRequirement['revenue_year3'] : '';
            $sale_year1   = (!empty($fundingRequirement) && isset($fundingRequirement['sale_year1'])) ? $fundingRequirement['sale_year1'] : '';
            $sale_year2   = (!empty($fundingRequirement) && isset($fundingRequirement['sale_year2'])) ? $fundingRequirement['sale_year2'] : '';
            $sale_year3   = (!empty($fundingRequirement) && isset($fundingRequirement['sale_year3'])) ? $fundingRequirement['sale_year3'] : '';
            $expences_year1   = (!empty($fundingRequirement) && isset($fundingRequirement['expences_year1'])) ? $fundingRequirement['expences_year1'] : '';
            $expences_year2   = (!empty($fundingRequirement) && isset($fundingRequirement['expences_year2'])) ? $fundingRequirement['expences_year2'] : '';
            $expences_year3   = (!empty($fundingRequirement) && isset($fundingRequirement['expences_year3'])) ? $fundingRequirement['expences_year3'] : '';
            $ebitda_year_1   = (!empty($fundingRequirement) && isset($fundingRequirement['ebitda_year_1'])) ? $fundingRequirement['ebitda_year_1'] : '';
            $ebitda_year_2   = (!empty($fundingRequirement) && isset($fundingRequirement['ebitda_year_2'])) ? $fundingRequirement['ebitda_year_2'] : '';
            $ebitda_year_3   = (!empty($fundingRequirement) && isset($fundingRequirement['ebitda_year_3'])) ? $fundingRequirement['ebitda_year_3'] : '';

            $html .= get_section_header_content_seperator() . '
                                  <table cellpadding="5" cellspacing="0"  width="100%"   >
                                     <tr>
                                         <td  class="blue_heading_div" >Financials</td>
                                    </tr>
                                </table><table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%"   class="section_holder">
                                  <tr>


                                      <td  width="100%">

                                       <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%" class="content_font_size1" >

                                            <tr>
                                                <td></td>
                                                <td class="textbold">Year 1(&pound;)</td>
                                                <td class="textbold">Year 2(&pound;)</td>
                                                <td class="textbold">Year 3(&pound;)</td>
                                            </tr> <tr>
                                                <td class="textbold">SALES</td>
                                                <td>' . get_input_box_style(' &pound;' . $revenue_year1) . '</td>
                                                <td>' . get_input_box_style(' &pound;' . $revenue_year2) . '</td>
                                                <td>' . get_input_box_style(' &pound;' . $revenue_year3) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                              <tr>
                                                <td class="textbold">COST OF SALES </td>
                                                <td>' . get_input_box_style(' &pound;' . $sale_year1) . ' </td>
                                                <td>' . get_input_box_style(' &pound;' . $sale_year2) . ' </td>
                                                <td>' . get_input_box_style(' &pound;' . $sale_year3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">EXPENSES</td>
                                                <td>' . get_input_box_style(' &pound;' . $expences_year1) . ' </td>
                                                <td>' . get_input_box_style(' &pound;' . $expences_year2) . ' </td>
                                                <td>' . get_input_box_style(' &pound;' . $expences_year3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">NET INCOME</td>
                                                <td>' . get_input_box_style(' &pound;' . $ebitda_year_1) . ' </td>
                                                <td>' . get_input_box_style(' &pound;' . $ebitda_year_2) . ' </td>
                                                <td>' . get_input_box_style(' &pound;' . $ebitda_year_3) . ' </td>
                                            </tr>


                                         </table> </td></tr>
                                </table>';

            //section 5

             
            $nodata = '';
            if ((isset($teamMemberDetails['team-members'])) && count($teamMemberDetails['team-members']) == 0) {
                $nodata = "(No Data)";
            } else {
                $html .= '<br pagebreak="true"/>';
            }

            $html .= '
                               <table cellpadding="5" cellspacing="0"  width="100%"   >
                                     <tr>
                                         <td  class="blue_heading_div" >Management Team ' . $nodata . '</td>
                                    </tr>
                                </table>';
            $i = 1;
            if ((isset($teamMemberDetails['team-members'])) && count($teamMemberDetails['team-members']) > 0) {
                foreach ($teamMemberDetails['team-members'] as $teamMemberDetail) {

                    /*echo "<pre>";
                    print_r($management_team_value);
                    echo "</pre>";*/
                    $html .= ' <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%"   class="section_holder">
                                    <tr>


                                        <td  width="100%">

                                         <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%" class="content_font_size1" >
                                           <tr>
                                           <td> <h3>Member ' . $i . '</h3> </td>
                                            <td></td>
                                            </tr>
                                            ';
             
                    $html .= '<tr>
                                      <td></td>
                                    </tr>
                                    <tr>
                                    <td class="textbold">Member Name</td>
                                     <td>' . $teamMemberDetail['name'] . '</td>
                                </tr>
                                <tr>
                                      <td></td>
                                    </tr>
                                    <tr>
                                    <td class="textbold">Position within The Company</td>
                                     <td>' .$teamMemberDetail['position'] . '</td>

                                </tr>
                                <tr>
                                      <td></td>
                                    </tr>
                                    <tr>
                                    <td class="textbold">Short Bio</td>
                                     <td>' . $teamMemberDetail['bio'] . '</td>
                                </tr>
                                <tr>
                                      <td></td>
                                    </tr>
                                    <tr>
                                    <td class="textbold">Employment Status Pre-investment</td>
                                     <td>' . $teamMemberDetail['preinvestment'] . '</td>
                                </tr>
                                <tr>
                                      <td></td>
                                    </tr>
                                    <tr>
                                    <td class="textbold">Employment Status Post-investment</td>
                                     <td>' . $teamMemberDetail['postinvestment'] . '</td>
                                </tr>
                                <tr>
                                      <td></td>
                                    </tr>
                                    <tr>
                                    <td class="textbold">Equity holding % (pre-investment)</td>
                                     <td>' . $teamMemberDetail['equitypreinvestment'] . '</td>
                                </tr>

                                ';
                        
                    $html .= '<tr>
                                              <td></td>
                                            </tr>';

                    $mediaLinks = (isset($teamMemberDetail['socialmedia-link'])) ? $teamMemberDetail['socialmedia-link'] : [];

                    foreach($mediaLinks as $k=> $mediaLink) {
                        $html .= '<tr>
                                                    <td class="textbold">Social Media Link ' . ($k+1) . '</td>
                                                    <td class="textbold">Link Type</td>
                                                    </tr>
                                                    <tr>
                                                    <td>' . get_input_box_style($mediaLink['social_link'] ) . '</td>
                                                    <td>' . get_input_box_style($mediaLink['link_type']) . '</td>
                                                    </tr>';
                    }

                    $html .= '</table>
                                            </td>

                                          </tr>
                                    </table>
                                  ';
                    if ($i % 4 == 0) {
                        $html .= '<br pagebreak="true"/>';
                    }

                    $i++;
                }

            }

            //section 6
            
            $number   = (!empty($companyDetails) && isset($companyDetails['number'])) ? $companyDetails['number'] : '';
            $type   = (!empty($companyDetails) && isset($companyDetails['type'])) ? $companyDetails['type'] : '';
            $telephone   = (!empty($companyDetails) && isset($companyDetails['telephone'])) ? $companyDetails['telephone'] : '';
            $sic2003   = (!empty($companyDetails) && isset($companyDetails['sic2003'])) ? $companyDetails['sic2003'] : '';
            $typeofaccount   = (!empty($companyDetails) && isset($companyDetails['typeofaccount'])) ? $companyDetails['typeofaccount'] : '';
            $latestannualreturns   = (!empty($companyDetails) && isset($companyDetails['latestannualreturns'])) ? $companyDetails['latestannualreturns'] : '';
            $nextannualreturnsdue   = (!empty($companyDetails) && isset($companyDetails['nextannualreturnsdue'])) ? $companyDetails['nextannualreturnsdue'] : '';
            $latestannualaccounts   = (!empty($companyDetails) && isset($companyDetails['latestannualaccounts'])) ? $companyDetails['latestannualaccounts'] : '';
            $nextannualaccountsdue   = (!empty($companyDetails) && isset($companyDetails['nextannualaccountsdue'])) ? $companyDetails['nextannualaccountsdue'] : '';
            $sic2007   = (!empty($companyDetails) && isset($companyDetails['sic2007'])) ? $companyDetails['sic2007'] : '';
            $tradingaddress   = (!empty($companyDetails) && isset($companyDetails['tradingaddress'])) ? $companyDetails['tradingaddress'] : '';
            $incorporationdate   = (!empty($companyDetails) && isset($companyDetails['incorporationdate'])) ? $companyDetails['incorporationdate'] : '';









            $html .= '<br pagebreak="true"/>';
            $html .= get_section_header_content_seperator() . '
                               <table cellpadding="5" cellspacing="0"  width="100%"   >
                                     <tr>
                                         <td  class="blue_heading_div" >Company Details</td>
                                    </tr>
                                </table><table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%"   class="section_holder">
                                  <tr>


                                      <td  width="100%">

                                       <table cellpadding="0" cellspacing="5" border="' . $table_border . '"  width="100%" class="content_font_size1" >

                                            <tr>
                                                <td class="textbold">Company Number</td>
                                                <td>' . get_input_box_style($number) . '</td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                              <tr>
                                                <td class="textbold">Company Type</td>
                                                <td>' . get_input_box_style($type) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">Telephone No.</td>
                                                <td>' . get_input_box_style($telephone) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                             <tr>
                                                <td class="textbold">SIC 2003</td>
                                                <td>' . get_input_box_style($sic2003) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Types of Accounts</td>
                                                <td>' . get_input_box_style($typeofaccount) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Latest Annual Returns</td>
                                                <td>' . get_input_box_style($latestannualreturns) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Next Annual Returns Due</td>
                                                <td>' . get_input_box_style($nextannualreturnsdue) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Latest Annual Accounts</td>
                                                <td>' . get_input_box_style($latestannualaccounts) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Next Annual Accounts Due</td>
                                                <td>' . get_input_box_style($nextannualaccountsdue) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">SIC 2007</td>
                                                <td>' . get_input_box_style($sic2007) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Trading Address</td>
                                                <td>' . get_input_box_style($tradingaddress, 'textarea', 0, 3) . ' </td>
                                            </tr>
                                            <tr>
                                              <td></td>
                                            </tr>
                                            <tr>
                                                <td class="textbold">Incorporation Date</td>
                                                <td>' . get_input_box_style($incorporationdate, 0, 3) . ' </td>
                                            </tr>


                                         </table> </td></tr>
                                </table>';

            

        }

        /******************************************************************/
        /*********************** funds sections ***************************/
        /******************************************************************/

        else {
           

        }

        return $html;
    }

}

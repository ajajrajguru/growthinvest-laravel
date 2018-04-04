<?php
namespace App;

use Auth;

class InvestorPdfHtml
{

    public function sophisticatedCertificationHtml($sophisticatedData, $investor)
    {

        $html = '';

        $sophisticated_option0_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_0', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        $sophisticated_option1_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_1', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        $sophisticated_option2_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_2', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        $sophisticated_option3_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_3', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


              <tr style="margin-bottom: 0; padding-bottom: 0;">
              <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Sophisticated Investor </p></td>
              </tr>
              </table>';
        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                            <img class="bg-background" src="' . public_path("img/pdf/05-kaka.png") . '"  style="max-width:100%; height:auto; width: 60px;" /><br>

                                SOPHISTICATED INVESTOR


                     </td>
                     <td style="width: 70%; border:none;">
                        <h4>Sophisticated Investor</h4>
                        <p style="font-size: 15px; margin-bottom: 5px;">You can be considered a Sophisticated Investor if any of the following applies;</p>


                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have been a member of a network or syndicate of business angel for at least six months</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have made more than one investment in an unlisted company in the last two years</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have worked in the private equity SME finance sector in the last two years</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have been a director of a company with annual turnover in excess of £1m in the last two years</p></td>
                             </tr>
                         </table>

                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 100%;">

                            &nbsp;


                     </td>

                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="0" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                  <td style="width: 100%;">


                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >

                        <tr>
                             <td colspan="2" style="width: 100%; font-size: 15px;">
                             I qualify as a Sophisticated investor and thus exempt under article 50(A) of the Financial Services and Markets Act 2000 after signing this prescribed template with relevant risk warnings and I meet at least one of the following criteria.
                             </td>
                         </tr>




                         <tr>
                         <td style="Width: 5%;">' . $sophisticated_option0_checked . '</td>
                         <td style="Width: 95%; font-size: 14px; margin-bottom: 20px;">I have been a member of a network or syndicate of business angels for at least the six months preceding the date of the certificate</td>
                         </tr>



                        <tr>
                         <td style="Width: 5%;">' . $sophisticated_option1_checked . '</td>
                         <td style="Width: 95%; font-size: 14px;">I have made more than one investment in an unlisted company in the two years preceding that date</td>
                         </tr>



                         <tr>
                         <td style="Width: 5%;">' . $sophisticated_option2_checked . '</td>
                         <td style="Width: 95%; font-size: 14px;">I have worked, in the two years preceding that date, in a professional capacity in the private equity sector, or in the provision of finance for small and medium enterprises</td>
                         </tr>



                         <tr>
                         <td style="Width: 5%;">' . $sophisticated_option3_checked . '</td>
                         <td style="Width: 95%; font-size: 14px;">I have been, in the two years preceding that date, a director of a company with an annual turnover of at least £1 million</td>
                         </tr>

                         </table>


                  </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="0" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                  <td style="width: 100%;">


                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >

                        <tr>
                             <td style="width: 100%;">
                             <p style="font-size: 15px; margin-bottom: 5px;">The financial products that are covered in the exemptions (articles 48 and 50A) only apply to certain types of investment:</p>

                            <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                                 <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Shares or stock in unlisted companies</p></td>
                                 </tr>
                             </table>

                            <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                                 <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px; margin-top: 0; padding-top:0;">Collective investment schemes, where the underlying investment is in unlisted company shares or stock</p></td>
                                 </tr>
                             </table>

                             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10px; padding-top:0;">.</p></td>
                                 <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px; margin-top: 0; padding-top:0;">Options, futures and contracts for differences that relate to unlisted shares or stock.</p></td>
                                 </tr>
                             </table>

                             </td>
                         </tr>

                    </table>


                  </td>
                  </tr></table><br>';

        $html .= '<table cellpadding="0" cellspacing="1" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">



        <tr>
             <td style="width: 100%;">
             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                 <tr>
                 <td style="Width: 5%; vertical-align: top;">';

        if (isset($sophisticatedData['conditions']) && in_array('si_check_0', $sophisticatedData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '     </td>
                 <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px; font-weight: bold; margin-top: 0; padding-top:0;">I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                 </tr>
             </table>

             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                 <tr>
                 <td style="Width: 5%; vertical-align: top;">';

        if (isset($sophisticatedData['conditions']) && in_array('si_check_1', $sophisticatedData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '    </td>
                 <td style="Width: 95%;  vertical-align: top;"><p style="font-size: 14px; font-weight: bold; margin-top: 0; padding-top:0;">I wish to be treated as a sophisticated investor and have a certificate that can be made available for presentation by my accountant or Financial Adviser or lawyer (on request).</p></td>
                 </tr>
             </table>

             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                 <tr>
                 <td style="Width: 5%; vertical-align: top;">';

        if (isset($sophisticatedData['conditions']) && in_array('si_check_2', $sophisticatedData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '     </td>
                 <td style="Width: 95%;  vertical-align: top;"><p style="font-size: 14px; margin-top: 0; padding-top:0; font-weight: bold;">I have read and understand the risk warning.</p></td>
                 </tr>
             </table>


             </td>
         </tr>

    </table>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function retailInvestorsHtml($retailData, $investor, $addData)
    {
        $clientCategory   = Defaults::find($addData['client_category_id']);
        $getQuestionnaire = $clientCategory->getCertificationQuesionnaire();

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


              <tr style="margin-bottom: 0; padding-bottom: 0;">
              <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Retail (Restricted) Investor </p></td>
              </tr>
              </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                        <img class="bg-background" src="' . public_path("img/pdf/03-money-hand.png") . '" style="max-width:100%; height:auto; width: 60px;"><br>

                            RETAIL (RESTRICTED) INVESTOR


                 </td>
                 <td style="width: 70%; border:none;">
                    <h4>Retail (Restricted) Investor Statement</h4>
                    <p style="font-size: 15px; margin-bottom: 5px;">Retail (restricted) investors must declare that they are not investing more than 10% of their net assets (including savings, stocks, ISAs, bonds and property; excluding your primary residence) into unquoted companies as a result of using GrowthInvest.</p>




                 </td>
              </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; ">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
               <td style="width: 100%; border:none;">

               <p style="font-size: 15px; margin-bottom: 5px;">I make this statement so that I can receive promotional communications relating to non-readily realisable securities as a retail (restricted) investor. I declare that I qualify as a retail (restricted) investor because:</p>
               <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">In the preceding twelve months, I have not invested more than 10% of my net assets in non-readily realisable securities; and </p></td>
                     </tr>
                 </table>

                <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I undertake that in the next twelve months I will not invest more than 10% of my net assets in non-readily realisable securities.</p></td>
                     </tr>
                 </table>



                 <p style="font-size: 15px; margin-bottom: 5px;">Net assets for these purposes do not include:</p>




                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">The property which is my primary residence or any money raised through a loan secured on that property;&nbsp;</p></td>
                     </tr>
                 </table>

                <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any rights of mine under a qualifying contract of insurance; OR </p></td>
                     </tr>
                 </table>

                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any benefits (in the form of pensions or otherwise) which are payable on the termination of my service or on my death or retirement and to which I am (or my dependants are), or may be entitled.</p></td>
                     </tr>
                 </table>

               </td>
              </tr>
              </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; ">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
               <td style="width: 100%; border:none;">



               </td>
               </tr>
               </table>';

        $html .= '<table cellpadding="0" cellspacing="5" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; font-size: 14px;">';
        $quest_count = 1;

        foreach ($getQuestionnaire as $getQuestion) {

            if ($quest_count == 4) {
                $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td colspan="4"> <br/><br><br><br> </td>

                </tr> ';
            }

            $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
            <td width="3%">' . $quest_count . '</td>
            <td colspan="3">' . $getQuestion->questions . '
            </td>
        </tr>';

            foreach ($getQuestion->options as $option) {

                $quiz_option_selected = '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
                if ($option->correct) {
                    $quiz_option_selected = ' <img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
                }
                $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
            <td width="3%"></td>
            <td width="3%">
                ' . $quiz_option_selected . '
            </td>
            <td width="2%">
            </td>
            <td width="92%">' . $option->label . '</td>


        </tr> ';

            }
            $html .= '<tr>
                <td>&nbsp;</td>
            </tr>';

            $quest_count++;

        }
        $html .= '</table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
                 <td style="width: 100%; border:none;">



                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($retailData['conditions']) && in_array('ri_check_1', $retailData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                         </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I  accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($retailData['conditions']) && in_array('ri_check_2', $retailData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                         </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I wish to be treated as a Retail (Restricted) Investor.</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($retailData['conditions']) && in_array('ri_check_3', $retailData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                         </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I have read and understand the risk warning.</p></td>
                         </tr>
                     </table>



                 </td>
              </tr></table><br><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function highNetWorthHtml($highNetData, $investor)
    {

        $highnetworth_option0_checked = (isset($highNetData['terms']) && in_array('sic_option_0', $highNetData['terms'])) ? '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        $highnetworth_option1_checked = (isset($highNetData['terms']) && in_array('sic_option_1', $highNetData['terms'])) ? '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


              <tr style="margin-bottom: 0; padding-bottom: 0;">
              <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified High Net Worth Individual</p></td>
              </tr>
              </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                            <img class="bg-background" src="' . public_path("img/pdf/01-piggybank.png") . '"  style="max-width:100%; height:auto; width: 60px;" /><br>

                                HIGH NET WORTH INDIVIDUALS


                     </td>
                     <td style="width: 70%; border:none;">
                        <h4>High Net Worth Individuals</h4>
                        <p style="font-size: 15px; margin-bottom: 5px;">High Net-Worth Individuals ("HNWI") are exempt under article 48 of the FSMA 2000 if they have signed a prescribed template with relevant risk warnings that they have over £100 000 p.a income and net assets excluding primary residence of over £250,000</p>




                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 100%;">
                            &nbsp;
                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; ">

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                     <td style="width: 100%; border:none;">
                     <p style="margin-bottom: 5px; font-size: 15px;">
                        I am a certified high net worth individual because at least one of the following applies:
                        </p>
                     </td>
                  </tr>

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                     <td style="width: 100%; border:none;">
                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                                <td style="Width: 5%;">' . $highnetworth_option0_checked . '</td>
                                <td style="Width: 95%; font-size: 14px; margin-bottom: 20px;"> I had, during the financial year immediately preceding the date below, an annual income to the value of £100,000 or more;</td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%;">' . $highnetworth_option1_checked . '</td>
                            <td style="Width: 95%; font-size: 14px;">I held, throughout the financial year immediately preceding the date below, net assets to the value of £250,000 or more. Net assets for these purposes do not include:</td>
                             </tr>
                         </table>


                     </td>
                  </tr>



                <tr style="margin-bottom: 0; padding-bottom: 0;">
                     <td style="width: 100%; border:none;">
                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">(i)</td>
                             <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">The property which is my client\'s primary residence or any loan secured on that residence;</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">(ii)</td>
                             <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any rights of my client\'s are under a qualifying contract of insurance within the meaning of the Financial Services and Markets Act 2000 (Regulated Activities) Order 2001; or</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">(iii)</td>
                             <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any benefits (in the form of pensions or otherwise) which are payable on the termination of my client service or on his/her death or retirement and to which he/she (or dependants are), or may be entitled.</p></td>
                             </tr>
                         </table>
                     </td>
                  </tr>

                  <tr style="margin-bottom: 0; padding-bottom: 0;">

                     <td style="width: 100%; border:none;">

                        <p style="font-size: 15px; margin-bottom: 5px;">By agreeing to be categorised as a HNWI, you agree to be communicated financial promotions of certain types of investments, principally;</p>


                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Shares or stock in unlisted companies</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Collective investment schemes, where the underlying investment is in unlisted company shares or stock</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Options, futures and contracts for differences that relate to unlisted shares or stock</p></td>
                             </tr>
                         </table>
                     </td>
                  </tr>

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                     <td style="width: 100%; border:none;">
                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($highNetData['conditions']) && in_array('hi_check_0', $highNetData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                        </td>
                        <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0; font-weight: bold;">I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($highNetData['conditions']) && in_array('hi_check_1', $highNetData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '</td>
                         <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0; font-weight: bold;">I wish to be treated as a HNWI and have a certificate that can be made available for presentation by my accountant or lawyer (on request).</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($highNetData['conditions']) && in_array('hi_check_2', $highNetData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= ' </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I have read and understand the risk warning.</p></td>
                         </tr>
                     </table>
                 </td>
              </tr>
              </table><br><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function professionInvHtml($professionInvData, $investor)
    {

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


      <tr style="margin-bottom: 0; padding-bottom: 0;">
      <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Professional Investor </p></td>
      </tr>
      </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                            <img class="bg-background" src="' . public_path("img/pdf/02-people.png") . '"  style="max-width:100%; height:auto; width: 60px; "  /><br>

                                PROFESSIONAL INVESTOR


                     </td>
                     <td style="width: 70%; border:none;">
                        <h4>Professional Investor</h4>
                        <p style="font-size: 15px; margin-bottom: 5px;">A Professional Investor is an investor whom is not designated as a Retail (Restricted) Investor as per the FCA Conduct of Business Handbook https://fshandbook.info/FS/print/FCA/COBS/3 .  If you fall into one of the below categories then you will qualify as a professional investor. As a professional investor GrowthInvest is able to communicate with you directly in relation to investment business.</p>




                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

    <tr style="margin-bottom: 0; padding-bottom: 0;">

     <td style="width: 100%; border:none;">
        <p>Investment professionals are exempt under Article 14 of the of the Financial Services and Markets Act 2000 (Promotion of Collective Investment Scheme) (Exemptions) Order 2001:</p>
        <ol  style="list-style-type: lower-alpha; font-size: 14px;">
            <li style="line-height: 16px;">  an authorised person;</li>
            <li style="line-height: 16px;">  an exempt person where the communication relates to a controlled activity which is a regulated activity in relation to which the person is exempt;</li>
            <li style="line-height: 16px;">  any other person—
                <ol   style="list-style-type: lower-roman; font-size: 14px;">
                    <li style="line-height: 16px;"> whose ordinary activities involve him in carrying on the controlled activity to which the communication relates for the purpose of a business carried on by him; or </li>
                    <li style="line-height: 16px;"> who it is reasonable to expect will carry on such activity for the purposes of a business carried on by him; </li>
                </ol>
            </li>
            <li style="line-height: 16px;">  a government, local authority (whether in the United Kingdom or elsewhere) or an international organisation;</li>
            <li style="line-height: 16px;">  a person ("A") who is a director, officer or employee of a person ("B") falling within any of subparagraphs (a) to (d) where the communication is made to A in that capacity and where A’s responsibilities when acting in that capacity involve him in the carrying on by B of controlled activities.</li>
        </ol>




     </td>
    </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                     <td style="width: 100%; border:none;">



                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($professionInvData['conditions']) && in_array('pi_check_1', $professionInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                            </td>
                            <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($professionInvData['conditions']) && in_array('pi_check_1', $professionInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                             </td>
                             <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I wish to be treated as an professional investor.</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($professionInvData['conditions']) && in_array('pi_check_2', $professionInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                             </td>
                             <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I have read and understand the risk warning.</p></td>
                             </tr>
                         </table>



                     </td>
                  </tr></table><br><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function adviceInvestorsHtml($adviceInvData, $investor)
    {

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


      <tr style="margin-bottom: 0; padding-bottom: 0;">
      <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Advised Investor</p></td>
      </tr>
      </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                      <tr style="margin-bottom: 0; padding-bottom: 0;">
                        <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                                <img class="bg-background " src="' . public_path("img/pdf/06-ppl-circle.png") . '"  style="max-width:100%; height:auto; width: 60px; " /><br>

                                    ADVISED INVESTOR


                         </td>
                         <td style="width: 70%; border:none;">
                            <h4>Advised Investor</h4>
                            <p style="font-size: 15px; margin-bottom: 5px;">An advised investor is one that has been assessed and categorised by an FCA regulated company
                    and deemed suitable under COBS9 to receive financial promotions. As an advised investor you are aware
                    that you can seek advice from an authorised person who specialises in advising on unlisted shares and
                    unlisted debt securities.</p>

                         </td>
                      </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

        <tr style="margin-bottom: 0; padding-bottom: 0;">

         <td style="width: 100%; border:none;">
            <p style="font-size: 14px; margin-bottom: 5px;">Please provide details of the FCA regulated company through which you have been assessed and categorised. GrowthInvest will treat you as a Retail (Restricted) Investor until such time as the company is registered as a client and has provided categorisation documentation on your behalf. Please complete the below statement and questionnaire.</p>

            <p style="font-size: 14px; margin-bottom: 5px;">I am a client of a firm that has assessed me as suitable to receive financial promotions. I accept that the investments to which the promotions relate may expose me to a significant risk of losing all of the money or other property invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.</p>

         </td>
        </tr></table>';

        $financial_advisor_details = $adviceInvData['financial_advisor_info'];

        if (!empty($financial_advisor_details)) {

            $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                 <td style="width: 100%; border:none;">

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 100%; vertical-align: top;">
                         <h4 style="border-bottom: 1px solid #000; margin-bottom:0; padding-bottom: 0;">Financial Advisor details</h4><hr style="margin-top: 5px; margin-bottom: 5px;"></td>
                         </tr>
                     </table>

                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Do you have a Financial Advisor or Wealth Manager (Authorised Person)</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . ucfirst($financial_advisor_details['havefinancialadvisor']) . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Are you receiving advice from an Authorised Person in relation to unlisted shares and unlisted debt securities?</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . ucfirst($financial_advisor_details['advicefromauthorised']) . '</td>
                         </tr>
                     </table>';

            if (isset($financial_advisor_details['havefinancialadvisor'])) {

                $address  = !isset($financial_advisor_details['address']) || is_null($financial_advisor_details['address']) ? "" : "<table style='width: 100%; margin-bottom: 0; padding-bottom: 0;' class='no-spacing' ><tr><td style='width: 100%;'>" . $financial_advisor_details['address'] . "</td></tr></table>";
                $address2 = !isset($financial_advisor_details['address2']) || is_null($financial_advisor_details['address2']) ? "" : "<table style='width: 100%; margin-bottom: 0; padding-bottom: 0;' class='no-spacing' ><tr><td style='width: 100%;'>" . $financial_advisor_details['address2'] . "</td></tr></table>";
                $city     = !isset($financial_advisor_details['city']) || is_null($financial_advisor_details['city']) ? "" : $financial_advisor_details['city'] . ",";
                $location = !isset($financial_advisor_details['county']) || is_null($financial_advisor_details['county']) ? "" : "&nbsp;" . $financial_advisor_details['county'] . ",";
                $postcode = !isset($financial_advisor_details['postcode']) || is_null($financial_advisor_details['postcode']) ? "" : "&nbsp;" . $financial_advisor_details['postcode'] . "";

                $addressall = "<div>" . $address . $address2 . $city . $location . $postcode . "</div><br>";

                if ($financial_advisor_details['havefinancialadvisor'] == 'yes') {
                    $html .= '
                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Company Name</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['companyname'] . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Address</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $addressall . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Telephone Number</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['telephone'] . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Principle contact</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['principlecontact'] . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Email</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['email'] . '</td>
                         </tr>
                     </table>



                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">FCA Number</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['fcanumber'] . '</td>
                         </tr>
                     </table>';

                }
            }

            $html .= '  </td>
                </tr></table>';

        }

        $html .= '<div style="page-break-after:always;border:none;"></div>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                 <td style="width: 100%; border:none;">
                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($adviceInvData['conditions']) && in_array('ai_check_0', $adviceInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                         </td>

                         <td style="Width: 95%; vertical-align: top; font-weight: bold; font-size: 14px;">I am a client of a firm that has assessed me as suitable to receive financial promotions.</td>
                         </tr>
                         <tr>
                         <td style="Width: 5%; vertical-align: top;"> ';

        if (isset($adviceInvData['conditions']) && in_array('ai_check_1', $adviceInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '        </td>

                         <td style="Width: 95%; vertical-align: top; font-weight: bold; font-size: 14px;">I accept that the investments to which the promotions relate may expose me to a significant risk of losing all of the money or other property invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.</td>
                         </tr>
                         <tr>
                         <td style="Width: 5%; vertical-align: top;"> ';

        if (isset($adviceInvData['conditions']) && in_array('ai_check_2', $adviceInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                         </td>

                         <td style="Width: 95%; vertical-align: top; font-weight: bold; font-size: 14px;">I have read and understand the risk warning.</td>
                         </tr>
                     </table>
                 </td>
                 </tr>
                 </table><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function getElectiveProfHtml($retailData, $investor, $addData)
    {

        $clientCategory   = Defaults::find($addData['client_category_id']);
        $getQuestionnaire = $clientCategory->getCertificationQuesionnaire();

        $electiveProfInvestorQuizStatementDeclaration = getElectiveProfInvestorQuizStatementDeclaration(true);

        $electiveProfessionalStatement   = $electiveProfInvestorQuizStatementDeclaration['statement'];
        $electiveProfessionalDeclaration = $electiveProfInvestorQuizStatementDeclaration['declaration'];

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


        <tr style="margin-bottom: 0; padding-bottom: 0;">
        <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Elective Professional Investor </p></td>
        </tr>
        </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

          <tr style="margin-bottom: 0; padding-bottom: 0;">
            <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                    <img class="bg-background" src="' . public_path("img/pdf/04-money-bag.png") . '"  style="max-width:100%; height:auto; width: 60px; " /><br>

                        ELECTIVE PROFESSIONAL INVESTOR


             </td>
             <td style="width: 70%; border:none;">
                <h4>Elective Professional Investor</h4>
                <p style="font-size: 15px; margin-bottom: 5px;">
                    If categorised as a Retail (Restricted) Investor, Sophisticated Investor or High Net Worth Individual
                    we are unable to conduct business with you via telephone or in person in relation to our investments.
                    However, if you chose to become an Elective Professional client and we deem you suitable then
                    you can engage directly with us in respect of investment business.
                </p>

                <p>An Elective Professional (Opt Up) Client is someone ordinarily a “Retail” client who wishes to be treated as a "Professional" category client as per the FCA handbook COBs <a href="https://fshandbook.info/FS/print/FCA/COBS/3" target ="_blank">https://fshandbook.info/FS/print/FCA/COBS/3</a>
                    </p>




             </td>
          </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

          <tr style="margin-bottom: 0; padding-bottom: 0;">
             <td style="width: 100%; border:none;">


                <p>To enable us to categorise you as an Elective Professional Opt Up you must complete the following questionnaire. After this has been completed you must follow the instructions in the statement below.
                    </p>




             </td>
          </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="5" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; font-size: 14px;">';
        $quest_count = 1;

        foreach ($getQuestionnaire as $getQuestion) {

            if ($quest_count == 5) {
                $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td colspan="4"> <br/><br><br><br><br><br> </td>

                        </tr> ';
            }

            $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
            <td width="3%">' . $quest_count . '</td>
            <td colspan="3">' . $getQuestion->questions . '
            </td>
        </tr>';

            foreach ($getQuestion->options as $option) {
                $quiz_option_selected = '<img class="bg-background" src="' . public_path("img/pdf/cert-untick.jpg") . '"/>';
                if ($option->correct) {
                    $quiz_option_selected = ' <img class="bg-background" src="' . public_path("img/pdf/cert-tick.jpg") . '"/>';
                }
                $html .= '<tr>
            <td width="3%"></td>
            <td width="3%" >
                ' . $quiz_option_selected . '
            </td>
            <td width="2%">
            </td>
            <td width="92%">' . $option->label . '
            </td>
        </tr>';

            }

            $html .= '<tr>
                    <td coslpan="4">&nbsp;</td>
                </tr>';

            $quest_count++;

        }
        $html .= '</table>';

        $html .= $electiveProfessionalStatement;

        $html .= $electiveProfessionalDeclaration;

        $html .= ' <div style="margin-bottom: 5px;"><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name . '</div>';

        $html .= ' <div style="margin-bottom: 5px;"><b>Email ID: </b>' . $investor->email . '</div>';

        $html .= ' <div style="margin-bottom: 5px;"><b>Date: </b>' . date('d/m/Y') . '</div>';

        return $html;
    }

    // offline pdf

/* Function to get HTML for nominee application form PDF*/
    public function getHtmlForNominationApplicationformPdf($firmStats, $statsPage, $firmId = 0, $additionalArgs)
    {

        $header_footer_end_html = "</page>";

        $nomineeapplication_info       = $firmStats['nomineeapplication_info'];
        $chargesfinancial_advisor_info = $firmStats['chargesfinancial_advisor_info'];
        $financial_advisor_info        = $firmStats['financial_advisor_info'];
        $taxfinancial_advisor_info     = $firmStats['taxfinancial_advisor_info'];
        $organization_info             = $firmStats['organization_info'];
        $additional_info               = $firmStats['additional_info'];

        if ($nomineeapplication_info == "") {
            $invuser_data = fetch_user_data($firmStats['ID']);
        }

        $html         = '';
        $table_border = "0";

        if ($firmId == 0) {
            $firm_name = "All";
        } else {
            $firm_name = get_the_title($firmId);
        }

        $current_date = date("d/m/Y");

        $pg_header_args               = array();
        $pg_header_args['hideheader'] = "1";
        $pg_header_args['hidefooter'] = "1";
        $header_footer_start_html     = getHeaderPageMarkup($pg_header_args);

        $default_logo_url   = public_path("img/pdf/pdfheader.jpg");
        $default_footer_url = public_path("img/pdf/pdf_footer3.png");

        $default_header1_bg_url = public_path("img/pdf/pdfheader1.png");
        $default_box_url        = public_path("img/pdf/box.png");
        $box_img                = '<img src="' . $default_box_url . '"><br>';
        $nomination_first_page  = public_path("img/pdf/general_pdf_header.png");
        $subheaders_topbgimg    = public_path("img/pdf/new_pdf_headerbg.png");

        $lastpage_image = public_path('img/pdf/nominee_needhelp.jpg');

        //$page1_image = K_PATH_IMAGES.'offline-app-form.jpg';
        if ($additionalArgs['pdfaction'] == "esign") { /*Image for online pdf */$page1_image = public_path('img/pdf/online-nom-pdf.jpg');} else { $page1_image = public_path('img/pdf/offline-nom-pdf.jpg');}

        //Start Page 1 SEction 1

        $nonationalinsuranceno            = false;
        $checkbox_nonationalinsuranceno[] = array('label_first' => false, 'label' => ' If your client does not have a National Insurance number, please tick here', 'checked' => false);
        if (isset($nomineeapplication_info['nonationalinsuranceno'])) {
            if ($nomineeapplication_info['nonationalinsuranceno'] == 1) {
                $checkbox_nonationalinsuranceno   = array();
                $checkbox_nonationalinsuranceno[] = array('label_first' => false, 'label' => ' If you do not have a National Insurance number, please tick here', 'checked' => true);
                $nonationalinsuranceno            = true;
            }
        }
        // echo "<pre>";
        // print_r($firmStats);

        $titlearr = array(
            "mr"   => "Mr",
            "mrs"  => "Mrs",
            "miss" => "Miss",
            "ms"   => "Ms",
        );
        $usertitle    = (isset($nomineeapplication_info['title']) ? $titlearr[$nomineeapplication_info['title']] : $titlearr[$invuser_data['title']]);
        $nominee_comb = public_path("img/pdf/nominee-hcomb-800.jpg");
        $html .= '<style type="text/css">
        .bordertable {border:5px solid #000;}
          th {border:none;
            font-size:10px;
            font-weight:normal;
          }
          td {
            font-size:10px;
            font-weight:normal;
            border:none;
            vertical-align:middle;
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
                font-size:12px;
                display:block;
               text-transform:uppercase;
                text-align: left;
                /* border-left:1px solid #000;
                border-top:1px solid #000;
                border-right:1px solid #000;
                border-bottom:1px solid #000; */
                border-radius: 1mm;
                padding-top:3px;
                padding-bottom:6px;
                font-weight:500;
              }

              .blue_heading_div_top{
                color:#fff;
                background-color:#0E2D41;
                font-size:12px;
                display:block;
               text-transform:uppercase;
                text-align: left;
                border:none;

                padding-top:3px;
                padding-bottom:6px;
                font-weight:500;
                background:#0E2D41 url(' . $subheaders_topbgimg . ') no-repeat top left;
                background-position: 0 0 ;
              }



              .blue_heading_div_top2{

                    position:    relative;
                    overflow:    hidden;
                    width:       800px;
                    height:      400px;
                    padding:     25px 0 0 65px;

                    font-size:   12px;
                    text-align:  left;
                    font-weight: normal;
                    background-image: url(' . $nominee_comb . ');
                    line-height:18px;
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
               height:7px;
               border:1px solid #152838;
                /* padding-top:2px;
                padding-bottom:4px;
                border: none;
                text-align: center;
                border:1px solid #D9DBDD; */
                padding-left:5px;

              }

              .dob{
                padding: 5px;
                 display:inline;
                width:12px;
              }

              .dob-padding{
                padding:8px 5px;
              }

              table.no-spacing {
                border-spacing:0;
                border-collapse: collapse;
              }
              .register{
                 margin:-10px 0px -10px 0px;
                font-weight:bold;
              }
              .subtitle{
                margin:-5px 0px 0px 0px;
                text-transform:uppercase;
                font-weight:200;
                color:#A9A9A9;
                letter-spacing:2;
                display:inline-block;
              }
              .subtitle span{
                text-transform:capitalize;
                font-size:13px;
              }
              .para{
                font-weight:100;
                font-size:13px;
                color:#666666;
                margin-top:-5px;
              }
              .font9{
                font-size:9px;
              }
              .font13{
                font-size:13px;
              }
              .listStyle{
                margin-left:15px;
                margin-top:-2px;
                text-align:justify;
              }
              .agreement{
                margin:0px -5px 3px -5px;
                font-weight:400;
                font-size:11.3px;
              }
              .textArea{
                overflow:hidden;
                height:100px;
                border-radius:15px;
                background-repeat:no-repeat;
                background-position: center;
                line-height:36px;
                padding:15px 15px 0px 15px;
              }
              .detail_title{
                text-align:center;
                text-transform:uppercase;
                text-decoration:underline;
                margin-top:18px;
                padding:40px;
               font-weight:300;
              }
              .detail_subtitle{
                font-size:15px;
                font-weight:100;
                color:#666666;
              }
              .m-l-30{
                margin-left:30px;
              }
              .m-l-n-60{
                margin-left:-60px;
              }
              .m-t-n-7{
                margin-top:-7px;
              }
              .m-l-50{
                margin-left:50px;
              }
              .m-l-37{
                margin-left:37px;
              }
              .table_display{
                  border:1px solid black;
                  padding:5px;
                  width:142px;
                  background-color:white;
                  text-align:left;
              }
              .title-box{
                text-transform:uppercase;
                font-weight:100;
                font-size:13px;
                margin-left:0px;
              }
              .font23{
                font-size:23px;
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

            .table_white{
              background-color:#FFF;
            }

            ul.dashed {
                list-style-type: none;
              }
              ul.dashed > li {
                text-indent: -5px;
              }
              ul.dashed > li:before {
                content: "-";
                text-indent: -5px;
              }

              .checkbox{
                padding: 5px;
                 display:inline;
                width:10px;
                height:10px;
              }


              .signature_style{
                 display:block;
                width:300px;
                font-size:30px;

              }


              ul,ol{
                padding:0;
                margin-left:-20px;
              }

              .cust-textarea{
                height:45px;
              }
          </style>' . $header_footer_start_html;

        if ($nomineeapplication_info == "") {

            $address    = !isset($additional_info['address']) || is_null($additional_info['address']) ? "" : $additional_info['address'];
            $address2   = !isset($additional_info['address2']) || is_null($additional_info['address2']) ? "" : "<br/>&nbsp; " . $additional_info['address2'];
            $city       = !isset($additional_info['city']) || is_null($additional_info['city']) ? "" : "<br/>&nbsp; " . $additional_info['city'];
            $location   = !isset($invuser_data['location']) || is_null($invuser_data['location']) ? "" : "<br/>&nbsp; " . $invuser_data['location'];
            $addressall = $address . $address2 . $city . $location;

        } else {
            /* $address = !isset($additional_info['address']) || is_null($additional_info['address'])?"":$additional_info['address'];
            $address2= !isset($additional_info['address2']) || is_null($additional_info['address2'])?"":"<br/>&nbsp; ".$additional_info['address2'];
            $city =!isset($additional_info['city']) || is_null($additional_info['city'])?"":"<br/>&nbsp; ".$additional_info['city'];
            $location= !isset($invuser_data['location']) || is_null($invuser_data['location'])?"":"<br/>&nbsp; ".$invuser_data['location'];
            $addressall=$address.$address2.$city.$location;
            $addressall = !isset($nomineeapplication_info['address'])?$addressall:str_replace("&#13;","<br/>&nbsp; ",$nomineeapplication_info['address']);
            $addressall = nl2br($addressall);*/

            $addressall = nl2br($nomineeapplication_info['address']);
        }

        $html .= '<img src="' . $page1_image . '" style="width:755px; margin-left:-35px; margin-top:-80px;  " />
                       <div style="page-break-after:always;border:none; "></div>';

        $html .= '<table style="width: 100%; border: solid 0px black; background:#fff;  line-height:18px;" cellspacing="0" cellpadding="0">

                                    <tr>
                                        <td style="text-align: center;    width: 100%"><h4 style="text-align: center; margin-top:-10px; margin-bottom:0; padding-bottom:0;">INVESTMENT ACCOUNT  APPLICATION FORM</h4></td>
                                    </tr>
                                    <tr>
                                      <td align="left">
                                      Dear investor,<br/>
                                      The Growthinvest Nominee and custody investment account service enables you to make investments directly through the platform and monitor all of your tax efficient investments in one place. In providing  this service we have partnered with Platform One Limited, an DVA regulated custodian and nominee service. We will then notify you as soon as your account is open and you are ready to begin investing.<br/>

                                      This application form should be read in conjunction with our platform Terms and Conditions.<br/><br/>

                                      Please ensure you complete all necessary sections:

                                        <table style="width: 100%; border: solid 0px black; background:#fff;  line-height:18px;" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td style="width:50%">
                                                  <ul  >';

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= '            <li><div style="height:15px; border:none; ">Section 1 - Investor Account Details</div></li>
                                                    <li><div style="height:15px; border:none;">Section 2 - Tax Certificates</div></li>
                                                    <li><div style="height:15px; border:none;">Section 3 - Client Bank Account Details<br/></div></li>
                                                    <li><div style="height:15px; border:none;">Section 4 - Fees & Charges</div></li>
                                                    <li><div style="height:15px; border:none;">Section 5 - Client Declaration & Data Protection</div></li>
                                                    <li><div style="height:15px; border:none;">Section 6 - Confirmation of Verification of Identity</div></li>
                                                    <li><div style="height:15px; border:none;">Section 7 - Transfer Details</div></li>
                                                    <li><div style="height:15px; border:none;">Section 8 - Signature</div></li>
                                                    <li><div style="height:15px; border:none;">Section 9 - Appendix</div></li>';
        } else {

            $html .= '            <li><div style="height:15px; border:none; ">Section 1 - Investor Account Details</div></li>
                                                    <li><div style="height:15px; border:none;">Section 2 - Eligibility Declaration</div></li>
                                                    <li><div style="height:15px; border:none;">Section 3 - Tax Certificates</div></li>
                                                    <li><div style="height:15px; border:none;">Section 4 - Client Bank Account Details<br/></div></li>
                                                    <li><div style="height:15px; border:none;">Section 5 - Fees & Charges</div></li>
                                                    <li><div style="height:15px; border:none;">Section 6 - Client Declaration & Data Protection</div></li>
                                                    <li><div style="height:15px; border:none;">Section 7 - Confirmation of Verification of Identity</div></li>
                                                    <li><div style="height:15px; border:none;">Section 8 - Transfer Details</div></li>
                                                    <li><div style="height:15px; border:none;">Section 9 - Signature</div></li>
                                                    <li><div style="height:15px; border:none;">Section 10 - Appendix</div></li>';

        }

        $html .= '            </ul>
                                              </td>
                                              <td style="width:50%; text-align:left;" valign="top">
                                                <div style="border:1px solid #000; padding:8px;  ">
                                                  <b>Completing this form online:</b><br/><br/>

                                                  If you are completing this form online there is no
                                                  need to send a hard copy of the signed application
                                                  form to our office. Please fill out the missing
                                                  information, if any, and sign at the end of this form via the Adobe Sign Application.<br/><br/>

                                                  <b>Completing this form offline.</b><br/>
                                                  Please complete all relevant sections of the
                                                  application form and send to:
                                                  Client Service Dept, Growthinvest, Candlewick
                                                  House, 120 Cannon Street, EC4N6AS London.
                                                </div>

                                              </td>
                                            </tr>
                                        </table>


                                      </td>
                                    </tr>
                                </table>




                                  <table cellpadding="0" cellspacing="0" border="0" style="margin-left: -58px;" >
                                    <tr>
                                      <td   class="blue_heading_div_top2  "  valign="top" >  If you require assistance filling out this form please do not <br/>hesitate to contact the Growth<span style="color:#0CADDC;">Invest</span> Client Service<br/> Department on 020 70713945<br/><br/></td>
                                    </tr>
                                  </table>







                                <div style="page-break-after:always;border:none; "></div>'; //echo $html;exit();

        $html .= '
                        <table style="width: 100%; border: solid 0px black; background:#fff" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="text-align: center;    width: 100%"><h4 style="text-align: center; margin-top:-10px; margin-bottom:0; padding-bottom:0;">INVESTMENT ACCOUNT  APPLICATION FORM</h4></td>
                            </tr>

                        </table> ';

        if ($nomineeapplication_info != "") {
            $checkbox_are_u_us_person[]  = array('label_first' => false, 'label' => 'Yes', 'checked' => ($nomineeapplication_info['areuspersonal'] == "yes") ? true : false);
            $checkbox_are_u_us_person1[] = array('label_first' => false, 'label' => 'No', 'checked' => ($nomineeapplication_info['areuspersonal'] == "no") ? true : false);
        } else {
            $checkbox_are_u_us_person[]  = array('label_first' => false, 'label' => 'Yes', 'checked' => false);
            $checkbox_are_u_us_person1[] = array('label_first' => false, 'label' => 'No', 'checked' => false);
        }

        $checkbox_tax_residencyval = false;
        if (isset($nomineeapplication_info['taxresidency'])) {
            if ($nomineeapplication_info['taxresidency'] == 1) {
                $checkbox_tax_residencyval = true;
            }
        }
        $checkbox_tax_residency[] = array('label_first' => false, 'label' => 'UK', 'checked' => $checkbox_tax_residencyval);

        /* $potentiallyexposed = 'no';
        if(isset($nomineeapplication_info['potentiallyexposed'])){

        $potentiallyexposed = $nomineeapplication_info['potentiallyexposed'];
        }

        $politically_exposed[] = array('label_first'=>false,'label'=>'Yes','checked'=> ($potentiallyexposed=="yes")?true:false);

        $politically_exposed2[] = array('label_first'=>false,'label'=>'No','checked'=>($potentiallyexposed=="no")?true:false);*/
        $politically_exposed[] = array('label_first' => false, 'label' => 'Yes', 'checked' => false);

        $politically_exposed2[] = array('label_first' => false, 'label' => 'No', 'checked' => false);

        $newscoinvestment = false;
        if (isset($nomineeapplication_info['newscoinvestment'])) {
            if ($nomineeapplication_info['newscoinvestment'] == 1) {
                $newscoinvestment = true;
            }
        }
        $co_investment_opportunities[] = array('label_first' => false, 'label' => 'Yes', 'checked' => $newscoinvestment);

        /* CR260 changes $html.='<table cellpadding="0" cellspacing="0" border="'.$table_border.'"  width="100%" class="table_white">

        <tr>
        <td valign="top">The GrowthInvest nominee and custody service enables you to make investments directly through the platform and monitor all of your tax efficient investments in one place. In providing this service we have partnered with Platform One Limited, an FCA regulated custodian and nominee service. Please complete the application form as accurately as possible and click the Submit Application button at the bottom or post the signed version to:<br> <b>GrowthInvest, Candlewick House, 120 Cannon Street, EC4N6AS London</b><br> We will then notify you as soon as your account is open and you are ready to begin investing. This application form should be read in conjunction with our platform charges document, terms and conditions and investor agreement.<br/>
        </td>

        </tr>

        </table>'.*/

        $html .= transferAssetsSubheaders('SECTION 1 INVESTOR ACCOUNT DETAILS') . '
                        <table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                         <tr>
                          <td class="w50per"><b>Personal Details</b></td>
                          <td class="w50per" ><b>Contact Details</b></td>
                          </tr>

                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td style="width: 50%; vertical-align: top;">
                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Title </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">&nbsp;' . $usertitle . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Surname </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">&nbsp;' . (isset($nomineeapplication_info['surname']) ? $nomineeapplication_info['surname'] : $invuser_data['last_name']) . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Forename(s) </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['forename']) ? $nomineeapplication_info['forename'] : $invuser_data['first_name']) . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Date of Birth </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['dateofbirth']) ? $nomineeapplication_info['dateofbirth'] : "") . '</div></td>
                                 </tr>
                                 </table><br>


                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">National Insurance Number </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['nationalinsuranceno']) ? $nomineeapplication_info['nationalinsuranceno'] : "") . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;"><b>If you do have a National Insurance number you must provide it.</b></td>

                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td valign="middle" style="Width: 100%; vertical-align: middle;">' . get_checkbox_html($checkbox_nonationalinsuranceno) . '</td>

                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Town of Birth </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['townofbirth']) ? $nomineeapplication_info['townofbirth'] : "&nbsp;") . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Country of Birth </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['countryofbirth']) ? $nomineeapplication_info['countryofbirth'] : "&nbsp;") . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Nationality </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['nationality']) ? $nomineeapplication_info['nationality'] : "") . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Domiciled </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['domiciled']) ? $nomineeapplication_info['domiciled'] : "") . '</div></td>
                                 </tr>
                                 </table><br>








                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>

                                 <td style="Width: 100%;">
                                  A US person is an individual to whom one or more of the following applies:<br>
                                          <ul>
                                            <li>Dual citizens of the US and another country</li>
                                            <li>US citizen even if residing outside the United States</li>
                                            <li>US passport holder</li>
                                            <li>Born in the US, unless citizenship has been renounced</li>
                                            <li>Lawful permanent resident of the US</li>
                                            <li>A ‘substantially present’ person as declared by the US tax regulator</li>
                                          </ul></td>
                                 </tr>
                                 </table><br>


                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 40%; vertical-align: top;">Are you a US Citizen? </td>
                                 <td style="Width: 20%; vertical-align: middle;">
                                    <table cellpadding="0" cellspacing="" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                                              <td style="width: 50%;">' . get_checkbox_html($checkbox_are_u_us_person) . '</td>
                                              <td style="width: 50%;">' . get_checkbox_html($checkbox_are_u_us_person1) . '</td>

                                            </tr>
                                          </table>
                                 </td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Tax District: </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['taxdistrict']) ? $nomineeapplication_info['taxdistrict'] : "&nbsp;") . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;"><!--Tax Reference Number-->Tax Identification Number: </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['taxrefno']) ? $nomineeapplication_info['taxrefno'] : "&nbsp;") . '</div></td>
                                 </tr>
                                 </table><br>



                                  <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Tax Residency: </td>
                                 <td style="Width: 70%;">
                                      <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                      <tr>
                                      <td valign="middle" style="Width: 15%;">' . get_checkbox_html($checkbox_tax_residency) . '</td>



                                      <td style="Width: 20%;">others:</td>
                                      <td style="Width: 50%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['taxresidencyother']) ? $nomineeapplication_info['taxresidencyother'] : "&nbsp;") . '</div></td>

                                      </tr>
                                      </table>

                                 </td>
                                 </tr>
                                 </table><br>



                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 40%; vertical-align: top;">Are you a Politically Exposed Person (PEP): </td>
                                 <td style="Width: 20%;">

                                       <table cellpadding="0" cellspacing="" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                    <tr style="margin-bottom: 0; padding-bottom: 0;">
                                      <td style="width: 50%;">' . get_checkbox_html($politically_exposed) . '</td>
                                      <td style="width: 50%;">' . get_checkbox_html($politically_exposed2) . '</td>

                                    </tr>
                                  </table>

                                 </td>
                                 </tr>
                                 </table><br>


                             </td>';

        $html .= '<td style="width: 50%; vertical-align: top;">
                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Telephone (Home) </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['telhome']) ? $nomineeapplication_info['telhome'] : '') . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Telephone (Work) </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['telwork']) ? $nomineeapplication_info['telwork'] : '') . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Telephone (Mobile) </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['telephone']) ? $nomineeapplication_info['telephone'] : $additional_info['telephonenumber']) . '</div></td>
                                 </tr>
                                 </table><br>

                                 <!-- <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%; vertical-align: top;">Address </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . $addressall . '<br><br><br></div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Postcode </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['postcode']) ? $nomineeapplication_info['postcode'] : $additional_info['postcode']) . '</div></td>
                                 </tr>
                                 </table><br> -->

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Email Address </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['email']) ? $nomineeapplication_info['email'] : $invuser_data['user_email']) . '</div></td>
                                 </tr>
                                 </table><br>





                                 <!-- MOVED CR280 MARK-AB-START -->

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%; vertical-align: top;">Permanent Address </td>
                                 <td style="Width: 70%;"><div class="inputcss cust-textarea" style="padding: 5px;">' . $addressall . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Postcode </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['postcode']) ? $nomineeapplication_info['postcode'] : $additional_info['postcode']) . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;">Length of occupation at the current address: </td>

                                 </tr>
                                 </table>



                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;"> </td>
                                 <td style="Width: 70%;">
                                    <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                     <tr>
                                     <td style="Width: 15%; vertical-align: middle;">Years:</td>
                                     <td style="Width: 30%;" valign="top"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['occupationlengthyears']) ? $nomineeapplication_info['occupationlengthyears'] : "&nbsp;") . '</div></td>

                                     <td style="Width: 5%;">&nbsp;</td>

                                     <td style="Width: 20%; vertical-align: middle;">months:</td>
                                     <td style="Width: 30%;"  valign="top"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['occupationlengthmonths']) ? $nomineeapplication_info['occupationlengthmonths'] : "&nbsp;") . '</div></td>
                                     </tr>
                                     </table>
                                 </td>
                                 </tr>
                                 </table><br><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%; vertical-align: top;">Previous Address if less than three years: </td>
                                 <td style="Width: 70%;"><div class="inputcss cust-textarea" style="padding: 5px;">' . (isset($nomineeapplication_info['prevaddresslessthan3yrs']) ? $nomineeapplication_info['prevaddresslessthan3yrs'] : "&nbsp;") . '</div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Postcode </td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['prevpostcodelessthan3yrs']) ? $nomineeapplication_info['prevpostcodelessthan3yrs'] : "&nbsp;") . '</div></td>
                                 </tr>
                                 </table><br>


                                <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                     <td style="Width: 100%;">Length of occupation at the previous address: </td>

                                   </tr>
                                 </table>



                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                     <td style="Width: 30%;"></td>
                                     <td style="Width: 70%;">
                                        <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                         <tr>
                                         <td style="Width: 15%; vertical-align: middle; padding: 5px;">Years:</td>
                                         <td style="Width: 30%;"  valign="middle"><div class="inputcss" style="padding: 5px;"> &nbsp; </div></td>

                                         <td style="Width: 5%;">&nbsp;</td>

                                         <td style="Width: 20%; vertical-align: middle;">months:</td>
                                         <td style="Width: 30%;"  valign="middle"><div class="inputcss" style="padding: 5px;"> &nbsp; </div></td>
                                         </tr>
                                         </table>
                                     </td>
                                   </tr>
                                 </table><br><br>

                                <!-- CR280 MARK-AB-END -->




                                 ';

        $html .= '</td>
                          </tr>
                          </table>
                            <div style="page-break-after:always;border:none; "></div>';

        $checkbox_data211[] = array('label_first' => false, 'label' => 'Based on this statement, I confirm I am a sophisticated investor', 'checked' => '');
        $checkbox_data212[] = array('label_first' => false, 'label' => 'Based on this statement, I confirm I am a High NET-Worth individual', 'checked' => '');
        //End  Page 1 SEction 1

        //Addtional section 2 for offline pdf
        if ($additionalArgs['pdfaction'] != "esign") {
            /* <!-- new section -->*/
            $html .= transferAssetsSubheaders('SECTION 2: ELIGIBILITY DECLARATION') . '
                          <table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; font-size: 14px;">

                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                          <td style="width: 100%;" colspan="2">
                                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                     <tr>

                                     <td style="Width: 100%;">';

            $checkbox_data_iconfirm0[] = array('label_first' => true, 'label' => 'If you already have a valid certificate on Growth<span style="color: #0CADDC;">Invest</span> Platform please tick here', 'checked' => false);
            $html .= get_checkbox_html($checkbox_data_iconfirm0) . '
                                      </td>
                                     </tr>
                                     </table>


                                 </td>
                          </tr>

                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                          <td style="width: 100%;" colspan="2">
                                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                     <tr>

                                     <td style="Width: 100%;">';

            $checkbox_data_iconfirm1[] = array('label_first' => true, 'label' => 'If you are categorised through your wealth manager please tick here and,  if applying offline, submit your certificate along with this application form.', 'checked' => false);
            $html .= get_checkbox_html($checkbox_data_iconfirm1) . '
                                      </td>
                                     </tr>
                                     </table>


                                 </td>
                          </tr>






                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 100%;" colspan="2">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;">
                                   <p style="text-align: center;" font-weight: bold;><b>If none of the above, please confirm which of the statements below is the best suitable to your profile</b></p>

                                   <div style="margin-top: 5px; margin-bottom: 5px; background-color: rgb(224, 224, 224); border-color: rgb(224, 224, 224);">I confirm that by certifying as a high net-worth individual or a sophisticated investor for the purposes of the Financial Service and Markets Act 2000 (financial promotion) Order 2005, I understand that this means:</div>

                                   <div style="margin-top: 5px; margin-bottom: 5px; background-color: rgb(224, 224, 224); border-color: rgb(224, 224, 224);"><ul type="i" style="list-style: lower-roman;">
                                    <li>I can receive financial promotions that may not have been approved by a person authorised by the Financial Services Authority, the content of such financial promotions may not confirm to rules issued by the Financial Services Authority;</li>
                                    <li>by signing/making this statement I may lose significant rights;</li>
                                    <li>I may have no right to complain to either of the following:
                                    <ul type="a" style="list-style: lower-alpha;">
                                    <li>the Financial Services Authority, or</li>
                                    <li>the Financial Ombudsman; and</li>
                                    </ul>
                                    </li>
                                    <li>I may have no right to seek compensation from the Financial Services Compensation Scheme</li>
                                   </ul></div>
                                   </td>

                                   </tr>
                                   </table>
                               </td>

                            </tr>

                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; " class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><p>STATEMENT FOR SELF-CERTIFIED SOPHISTICATED INVESTOR</p>

                                   I am self-certified sophisticated investor because at least one of the following applies:
                                   <ul type="a" style="list-style: lower-alpha;">
                                   <li>I am a member of a network or syndicate of business angels and have been so far at least the last six months prior to the date of this declaration</li>
                                   <li>I have made more than one investment in an unlisted company in the two years prior to the date of this declaration, in a professional capacity in the private equity sector, or in the provision of finance for small and medium enterprises;</li>
                                   <li>I am currently, or have been in the two years prior to the date of this declaration, a director of a company with an annual turnover of at least &pound; 1 million</li>
                                   </ul>
                                   <p>I accept that I can lose my property and other assets from making investment decisions based on financial promotions.<br>I am aware that it is open to me to seek advice from someone who specialises in advising on investments.</p>

                                   </td>

                                   </tr>
                                   </table>

                               </td>
                               <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                  <td style="Width: 100%;"><p>STATEMENT FOR HIGH NET-WORTH INDIVIDUAL</p>
                                  I am certified high net-worth individual because at least one of the following applies:
                                  <ul type="a" style="list-style: lower-alpha;">
                                  <li>I had, during the financial year immediately preceding the date of this declaration, an annual income to the value of &pound;10,000 or more; or</li>
                                  <li>I held, throughout the financial year immediately preceding the date of this declaration, net assets to the value of &pound;250,000 or more. "net assets" for these purposes don not include:
                                  <ul type="i" style="list-style: lower-roman;">
                                  <li>the property which is my primary residence or any loan secured on that residence;</li>
                                  <li>any rights of mine under a qualifying contract of insurance within the meaning of the Financial Services and Markets Act 2000 (Regulated Activities) Order 2001; or</li>
                                  <li>any benefits (in the form of pensions or otherwise) which are payable on the termination of my service or on my death or retirement and to which I am (or my dependents are), or may be, entitled.</li>
                                  </ul>

                                  <p>I accept that I can lose my property and other assets from making investment decisions based on financial promotions.<br>I am aware that it is open to me to seek advice from someone who specialises in advising on investments.</p>
                                  </li>
                                  </ul>
                                  </td>
                                   </tr>
                                   </table>
                               </td>

                            </tr>

                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 50%; vertical-align: top;">
                               <table cellpadding="0" cellspacing="" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                <tr style="margin-bottom: 0; padding-bottom: 0;">
                                  <td style="width: 100%;">' . get_checkbox_html($checkbox_data211) . '</td>


                                </tr>
                              </table>
                              </td>

                              <td style="width: 50%; vertical-align: top;">
                               <table cellpadding="0" cellspacing="" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                <tr style="margin-bottom: 0; padding-bottom: 0;">
                                  <td style="width: 100%;">' . get_checkbox_html($checkbox_data212) . '</td>


                                </tr>
                              </table>
                              </td>
                            </tr>

                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 100%; vertical-align: top;" colspan="2">
                               <table cellpadding="0" cellspacing="" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                <tr style="margin-bottom: 0; padding-bottom: 0;">
                                  <td style="width: 100%;">
                                  <p>I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily  realisable securities.</p>
                                  - I wish to be treated as a the confirmed profile from the statement above<br>- I have read and understand the risk warning                                          </td>


                                </tr>
                              </table>
                              </td>


                            </tr>


                           </table><div style="page-break-after:always;border:none;"></div>';
            /* <!-- /new section -->*/

        } //End Addtional section 2 for offline pdf

        //Start Page 2 SEction 2

        //$html.=get_nomination_form_nextpage_header().get_section_header_content_seperator(50).

        $sendtaxcertificateto = isset($nomineeapplication_info['sendtaxcertificateto']) ? $nomineeapplication_info['sendtaxcertificateto'] : '';
        $checkbox_data11[]    = array('label_first' => false, 'label' => 'Yourself*', 'checked' => ($sendtaxcertificateto == "yourself") ? true : false);
        $checkbox_data12[]    = array('label_first' => false, 'label' => 'Adviser**', 'checked' => ($sendtaxcertificateto == "adviser") ? true : false);
        $checkbox_data13[]    = array('label_first' => false, 'label' => 'Accountant**', 'checked' => ($sendtaxcertificateto == "accountant") ? true : false);

        if (Auth::user()->hasPermissionTo('is_wealth_manager')) {
            if ($taxfinancial_advisor_info != "") {
                $tax_companyname = isset($taxfinancial_advisor_info['companyname']) ? $taxfinancial_advisor_info['companyname'] : '';
                $tax_address     = isset($taxfinancial_advisor_info['address']) ? $taxfinancial_advisor_info['address'] : '';
                $tax_telephone   = isset($taxfinancial_advisor_info['telephone']) ? $taxfinancial_advisor_info['telephone'] : '';
                $tax_website     = isset($taxfinancial_advisor_info['website']) ? $taxfinancial_advisor_info['website'] : '';
                $tax_email       = isset($taxfinancial_advisor_info['email']) ? $taxfinancial_advisor_info['email'] : '';
                $tax_compaanyfca = isset($taxfinancial_advisor_info['fcanumber']) ? $taxfinancial_advisor_info['fcanumber'] : '';

                $tax_principlecontact  = isset($taxfinancial_advisor_info['principlecontact']) ? $taxfinancial_advisor_info['principlecontact'] : '';
                $tax_primarycontactfca = isset($taxfinancial_advisor_info['primarycontactfca']) ? $taxfinancial_advisor_info['primarycontactfca'] : '';
            } else {
                $tax_companyname = !isset($financial_advisor_info['companyname']) ? $organization_info['companyname'] : $financial_advisor_info['companyname'];
                $tax_address     = !isset($financial_advisor_info['address']) ? $organization_info['address'] : $financial_advisor_info['address'];
                $tax_telephone   = !isset($financial_advisor_info['telephone']) ? $organization_info['telephone'] : $financial_advisor_info['telephone'];
                $tax_website     = !isset($financial_advisor_info['website']) ? $organization_info['website'] : $financial_advisor_info['website'];
                $tax_email       = !isset($financial_advisor_info['email']) ? $organization_info['email'] : $financial_advisor_info['email'];
                $tax_compaanyfca = !isset($financial_advisor_info['fcanumber']) ? $organization_info['fcanumber'] : $financial_advisor_info['fcanumber'];

                $tax_principlecontact  = isset($financial_advisor_info['principlecontact']) ? $financial_advisor_info['principlecontact'] : '';
                $tax_primarycontactfca = isset($financial_advisor_info['primarycontactfca']) ? $financial_advisor_info['primarycontactfca'] : '';
            }
        } else {
            if ($taxfinancial_advisor_info == "") {
                $tax_companyname = isset($financial_advisor_info['companyname']) ? $financial_advisor_info['companyname'] : '';
                $tax_address     = isset($financial_advisor_info['address']) ? $financial_advisor_info['address'] : '';
                $tax_telephone   = isset($financial_advisor_info['telephone']) ? $financial_advisor_info['telephone'] : '';
                $tax_website     = isset($financial_advisor_info['website']) ? $financial_advisor_info['website'] : '';
                $tax_email       = isset($financial_advisor_info['email']) ? $financial_advisor_info['email'] : '';
                $tax_compaanyfca = isset($financial_advisor_info['fcanumber']) ? $financial_advisor_info['fcanumber'] : '';

                $tax_principlecontact  = isset($financial_advisor_info['principlecontact']) ? $financial_advisor_info['principlecontact'] : '';
                $tax_primarycontactfca = isset($financial_advisor_info['primarycontactfca']) ? $financial_advisor_info['primarycontactfca'] : '';
            } else {
                $tax_companyname = isset($taxfinancial_advisor_info['companyname']) ? $taxfinancial_advisor_info['companyname'] : '';
                $tax_address     = isset($taxfinancial_advisor_info['address']) ? $taxfinancial_advisor_info['address'] : '';
                $tax_telephone   = isset($taxfinancial_advisor_info['telephone']) ? $taxfinancial_advisor_info['telephone'] : '';
                $tax_website     = isset($taxfinancial_advisor_info['website']) ? $taxfinancial_advisor_info['website'] : '';
                $tax_email       = isset($taxfinancial_advisor_info['email']) ? $taxfinancial_advisor_info['email'] : '';
                $tax_compaanyfca = isset($taxfinancial_advisor_info['fcanumber']) ? $taxfinancial_advisor_info['fcanumber'] : '';

                $tax_principlecontact  = isset($taxfinancial_advisor_info['principlecontact']) ? $taxfinancial_advisor_info['principlecontact'] : '';
                $tax_primarycontactfca = isset($taxfinancial_advisor_info['primarycontactfca']) ? $taxfinancial_advisor_info['primarycontactfca'] : '';
            }

        }

        if ($taxfinancial_advisor_info == "") {
            $tax_address2           = isset($financial_advisor_info['address2']) ? $financial_advisor_info['address2'] : '';
            $tax_county             = isset($financial_advisor_info['county']) ? $financial_advisor_info['county'] : '';
            $tax_postcode           = isset($financial_advisor_info['postcode']) ? $financial_advisor_info['postcode'] : '';
            $tax_country            = isset($financial_advisor_info['country']) ? $financial_advisor_info['country'] : '';
            $tax_primarycontactname = isset($financial_advisor_info['principlecontact']) ? $financial_advisor_info['principlecontact'] : '';
            $tax_city               = isset($financial_advisor_info['city']) ? $financial_advisor_info['city'] : '';
        } else {

            $tax_address2           = isset($taxfinancial_advisor_info['address2']) ? $taxfinancial_advisor_info['address2'] : '';
            $tax_county             = isset($taxfinancial_advisor_info['county']) ? $taxfinancial_advisor_info['county'] : '';
            $tax_postcode           = isset($taxfinancial_advisor_info['postcode']) ? $taxfinancial_advisor_info['postcode'] : '';
            $tax_country            = isset($taxfinancial_advisor_info['country']) ? $taxfinancial_advisor_info['country'] : '';
            $tax_primarycontactname = isset($taxfinancial_advisor_info['principlecontact']) ? $taxfinancial_advisor_info['principlecontact'] : '';
            $tax_city               = isset($taxfinancial_advisor_info['city']) ? $taxfinancial_advisor_info['city'] : '';
        }

        $tax_complete_address = $tax_address . ($tax_address2 != '' ? ", " . $tax_address2 : "");
        $tax_complete_address .= ($tax_city != '' ? ", " . $tax_city : "");
        $tax_complete_address .= ($tax_county != '' ? ", " . $tax_county : "");
        $tax_complete_address .= ($tax_country != '' ? ", " . get_country_name_by_code($tax_country) : "");
        $tax_complete_address .= ($tax_postcode != '' ? ", " . $tax_postcode : "");

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 2: TAX CERTIFICATES');
        } else {
            $html .= transferAssetsSubheaders('SECTION 3: TAX CERTIFICATES');
        }
        $html .= '
                         <table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 100%;" ' . ($sendtaxcertificateto != "yourself" ? ' colspan="2" ' : ' ') . '>
                                  <p style="font-size: 11px;">Please indicate where you would like the original tax certificate sent to:

                                  <table cellpadding="0" cellspacing="0" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                    <tr style="margin-bottom: 0; padding-bottom: 0;">
                                      <td style="width:33.33%;">' . get_checkbox_html($checkbox_data11) . '</td>
                                      <td style="width:33.33%;">' . get_checkbox_html($checkbox_data12) . '</td>
                                      <td style="width:33.33%;">' . get_checkbox_html($checkbox_data13) . '</td>
                                    </tr>
                                  </table>

                                  * Will be correspondence address if filled out<br>
                                  ** If you have indicated that you would like your Accountant or Financial Adviser to receive your Tax Certificates please provide their details below:</p>
                              </td>
                          </tr>';
        // echo $html;
        // exit();
        //

        if ($sendtaxcertificateto != "yourself") {

            $user_has_backoffice_access = Auth::user()->hasPermissionTo('is_wealth_manager');

            if ($nomineeapplication_info == "" && $invuser_data['firm'] != DEFAULT_firmId) {

                //if($user_has_backoffice_access){
                $txcertificatefirmname  = !isset($financial_advisor_info['companyname']) ? $organization_info['companyname'] : $financial_advisor_info['companyname'];
                $txcertificatetelephone = !isset($financial_advisor_info['telephone']) ? $organization_info['telephone'] : $financial_advisor_info['telephone'];
                $txcertificateemail     = !isset($financial_advisor_info['email']) ? $organization_info['email'] : $financial_advisor_info['email'];
                $txcertificateaddress1  = !isset($financial_advisor_info['address']) ? $organization_info['address'] : $financial_advisor_info['address'];
                /* }
                else{
                $txcertificatefirmname = !isset($financial_advisor_info['companyname'])?'':$financial_advisor_info['companyname'];
                $txcertificatetelephone = !isset($financial_advisor_info['telephone'])?"":$financial_advisor_info['telephone'];
                $txcertificateemail = !isset($financial_advisor_info['email'])?"":$financial_advisor_info['email'];
                $txcertificateaddress1 = !isset($financial_advisor_info['address'])?"":$financial_advisor_info['address'];
                }*/

                $txcertificatecontact = isset($financial_advisor_info['principlecontact']) ? $financial_advisor_info['principlecontact'] : '';

                $txcertificateaddress2 = !isset($financial_advisor_info['address2']) ? "" : $financial_advisor_info['address2'];

                $txcertificatecity     = !isset($financial_advisor_info['city']) ? "" : $financial_advisor_info['city'];
                $txcertificatecounty   = !isset($financial_advisor_info['county']) ? "" : $financial_advisor_info['county'];
                $txcertificatecountry  = !isset($financial_advisor_info['country']) ? "" : $financial_advisor_info['country'];
                $txcertificatepostcode = !isset($financial_advisor_info['postcode']) ? "" : $financial_advisor_info['postcode'];
                $txcertificateaddress  = $txcertificateaddress1 . "<br/>"+$txcertificateaddress2 . " <br/>" . $txcertificatecity
                    . " <br/> " . $txcertificatecounty . "<br/>" . $txcertificatepostcode;

            } else {

                if ($sendtaxcertificateto == "accountant") {
                    $txcertificatefirmname  = isset($nomineeapplication_info['txcertificateaccfirmname']) ? $nomineeapplication_info['txcertificateaccfirmname'] : "";
                    $txcertificatecontact   = isset($nomineeapplication_info['txcertificateacccontact']) ? $nomineeapplication_info['txcertificateacccontact'] : "";
                    $txcertificatetelephone = isset($nomineeapplication_info['txcertificateacctelephone']) ? $nomineeapplication_info['txcertificateacctelephone'] : "";
                    $txcertificateemail     = isset($nomineeapplication_info['txcertificateaccemail']) ? $nomineeapplication_info['txcertificateaccemail'] : "";
                    $txcertificateaddress   = isset($nomineeapplication_info['txcertificateaccaddress']) ? nl2br_preg_rnnr($nomineeapplication_info['txcertificateaccaddress'], ", ") : "";
                } else {

                    $txcertificatefirmname  = isset($nomineeapplication_info['txcertificatefirmname']) ? $nomineeapplication_info['txcertificatefirmname'] : "";
                    $txcertificatecontact   = isset($nomineeapplication_info['txcertificatecontact']) ? $nomineeapplication_info['txcertificatecontact'] : "";
                    $txcertificatetelephone = isset($nomineeapplication_info['txcertificatetelephone']) ? $nomineeapplication_info['txcertificatetelephone'] : "";
                    $txcertificateemail     = isset($nomineeapplication_info['txcertificateemail']) ? $nomineeapplication_info['txcertificateemail'] : "";
                    $txcertificateaddress   = isset($nomineeapplication_info['txcertificateaddress']) ? nl2br_preg_rnnr($nomineeapplication_info['txcertificateaddress'], ", ") : "";
                }

            }

            $html .= '  <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 50%;">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 30%;">' . get_input_lable_box_style('Firm Name') . '</td>
                                   <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . $txcertificatefirmname . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 30%;">' . get_input_lable_box_style('Contact') . '</td>
                                   <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . $txcertificatecontact . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 30%;">' . get_input_lable_box_style('Telephone') . '</td>
                                   <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . $txcertificatetelephone . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 30%;">' . get_input_lable_box_style('Email address') . ' </td>
                                   <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . $txcertificateemail . '</div></td>
                                   </tr>
                                   </table>



                               </td>
                               <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 30%; vertical-align: top;">Address :</td>
                                   <td style="Width: 70%;"><div class="inputcss cust-textarea" style="padding: 5px;">' . $txcertificateaddress . '</div></td>
                                   </tr>
                                   </table>
                               </td>
                            </tr>
                            ';

            // echo $html;
            // exit();
        }

        $html .= '</table>';

        //End  Page 2 SEction 2

        //Start Page 2 SEction 3

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 3: CLIENT BANK ACCOUNT DETAILS');
        } else {
            $html .= transferAssetsSubheaders('SECTION 4: CLIENT BANK ACCOUNT DETAILS');
        }

        $html .= '
                        <table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                        <tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td colspan="2">
                                 Please provide details of the bank account to which you would like any proceeds credited.
                             </td>
                        </tr>

                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td style="width: 50%;">
                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;">Name of Account Holder(s) :</td>

                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['bankaccntholder1']) ? $nomineeapplication_info['bankaccntholder1'] : "") . '</div></td>

                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['bankaccntholder2']) ? $nomineeapplication_info['bankaccntholder2'] : "") . '</div></td>

                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Account Number :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['bankaccntnumber']) ? $nomineeapplication_info['bankaccntnumber'] : "") . '</div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Sort Code :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['bankaccntsortcode']) ? $nomineeapplication_info['bankaccntsortcode'] : "") . '</div></td>
                                 </tr>
                                 </table>
                             </td>
                             <td style="width: 50%;">
                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Bank Name :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['bankname']) ? $nomineeapplication_info['bankname'] : "") . '</div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%; vertical-align: top;">Bank Address :</td>
                                 <td style="Width: 70%;"><div class="inputcss cust-textarea" style="padding: 5px;">' . (isset($nomineeapplication_info['bankaddress']) ? $nomineeapplication_info['bankaddress'] : "") . '<br><br></div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Post Code :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['clientbankpostcode']) ? $nomineeapplication_info['clientbankpostcode'] : "") . '</div></td>
                                 </tr>
                                 </table>
                             </td>
                          </tr>

                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td colspan="2">
                                   Please note: If the account is in the name of a third party it will be necessary to complete a full identity check on the third party.
                               </td>
                          </tr>

                          </table>   ';

        $html .= '
                        <table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #fff; margin-left: -65px;">

                        <tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td style="width: 100%; vertical-align: top; background: #fff;">
                                 <img src="' . public_path("img/pdf/nominee-hcomb.jpg") . '" style=" width: 110%; ">
                             </td>
                        </tr>



                          </table>   ';

        //Start Page 3 Section 5
        if ($nomineeapplication_info != "") {
            if (isset($nomineeapplication_info['signatureimgid'])) {
                $img_signature_url = get_attached_file($nomineeapplication_info['signatureimgid'], 'thumbnail');
            }

        }

        $adviservattobeapplied = "";
        if (isset($nomineeapplication_info['adviservattobeapplied'])) {
            $adviservattobeapplied = $nomineeapplication_info['adviservattobeapplied'];
        }
        $checkbox_data31[] = array('label_first' => false, 'label' => 'Yes', 'checked' => ($adviservattobeapplied == "yes") ? true : false);
        $checkbox_data32[] = array('label_first' => false, 'label' => 'No', 'checked' => ($adviservattobeapplied == "no") ? true : false);

        $ongoingadvattobeapplied = "";
        if (isset($nomineeapplication_info['ongoingadvchargesvatyettobeapplied'])) {
            $ongoingadvattobeapplied = $nomineeapplication_info['ongoingadvchargesvatyettobeapplied'];
        }
        $checkbox_ongoingadv_vat_applied1[] = array('label_first' => false, 'label' => 'Yes', 'checked' => ($ongoingadvattobeapplied == "yes") ? true : false);
        $checkbox_ongoingadv_vat_applied2[] = array('label_first' => false, 'label' => 'No', 'checked' => ($ongoingadvattobeapplied == "no") ? true : false);

        $intermediaryvattobeapplied = "";
        if (isset($nomineeapplication_info['intermediaryvattobeapplied'])) {
            $intermediaryvattobeapplied = $nomineeapplication_info['intermediaryvattobeapplied'];
        }
        $checkbox_intermediary_vat_applied1[] = array('label_first' => false, 'label' => 'Yes', 'checked' => ($intermediaryvattobeapplied == "yes") ? true : false);
        $checkbox_intermediary_vat_applied2[] = array('label_first' => false, 'label' => 'No', 'checked' => ($intermediaryvattobeapplied == "no") ? true : false);

        $verified_via_seed = false;
        if (isset($nomineeapplication_info['adviseridentityverify1'])) {

            if ($nomineeapplication_info['adviseridentityverify1'] == "verified_via_seedeis_partner") {
                $verified_via_seed = true;

            }

        }

        $nomineeapplication_verified_02 = false;
        if ($nomineeapplication_info != "") {
            $nomineeapplication_verified_02 = ($nomineeapplication_info['verified'] == "complete_pending_evidence") ? true : false;
        }
        $JMLSG[] = array('label_first' => false, 'label' => 'I have enclosed evidence I/We have obtained evidence that meets the standard requirements which are defined within the guidance for the UK financial Sector issued by the JMLSG.', 'checked' => $nomineeapplication_verified_02);

        $no_valid_kyc_aml[] = array('label_first' => false, 'label' => 'Tick here if you do not have a valid KYC and AML certificate for your client.', 'checked' => false);

        /* $verified_via_seed_checkbox[] = array('label_first'=>false,'label'=>'Please tick this box if your clients identity was verified via Seed EIS Platform partner, Onfido.com KYC/AML.','checked'=>$verified_via_seed); */

        $verified_via_seed_checkbox[] = array('label_first' => false, 'label' => 'Please tick this box if your client\'s identity was verified via GrowthInvest partner, Onfido.com KYC/AML.', 'checked' => $verified_via_seed);

        $verified_via_without_face = false;
        if (isset($nomineeapplication_info['nomverificationwithoutface'])) {

            if ($nomineeapplication_info['nomverificationwithoutface'] == "yes") {
                $verified_via_without_face = true;

            }

        }

        $verified_via_without_face_checkbox[] = array('label_first' => false, 'label' => 'Please tick this box if your client\'s identity was verified without face to face contact.', 'checked' => $verified_via_without_face);

        /*--------------------------------------------------------------------------------*/

        if (Auth::user()->hasPermissionTo('is_wealth_manager')) {
            if ($chargesfinancial_advisor_info != "") {
                $advchrges_companyname       = isset($chargesfinancial_advisor_info['companyname']) ? $chargesfinancial_advisor_info['companyname'] : '';
                $advchrges_address           = isset($chargesfinancial_advisor_info['address']) ? $chargesfinancial_advisor_info['address'] : '';
                $advchrges_telephone         = isset($chargesfinancial_advisor_info['telephone']) ? $chargesfinancial_advisor_info['telephone'] : '';
                $advchrges_website           = isset($chargesfinancial_advisor_info['website']) ? $chargesfinancial_advisor_info['website'] : '';
                $advchrges_email             = isset($chargesfinancial_advisor_info['email']) ? $chargesfinancial_advisor_info['email'] : '';
                $advchrges_compaanyfca       = isset($chargesfinancial_advisor_info['fcanumber']) ? $chargesfinancial_advisor_info['fcanumber'] : '';
                $advchrges_principlecontact  = isset($chargesfinancial_advisor_info['principlecontact']) ? $chargesfinancial_advisor_info['principlecontact'] : '';
                $advchrges_primarycontactfca = isset($chargesfinancial_advisor_info['primarycontactfca']) ? $chargesfinancial_advisor_info['primarycontactfca'] : '';

            } else {
                $advchrges_companyname       = !isset($financial_advisor_info['companyname']) ? $organization_info['companyname'] : $financial_advisor_info['companyname'];
                $advchrges_address           = !isset($financial_advisor_info['address']) ? $organization_info['address'] : $financial_advisor_info['address'];
                $advchrges_telephone         = !isset($financial_advisor_info['telephone']) ? $organization_info['telephone'] : $financial_advisor_info['telephone'];
                $advchrges_website           = !isset($financial_advisor_info['website']) ? $organization_info['website'] : $financial_advisor_info['website'];
                $advchrges_email             = !isset($financial_advisor_info['email']) ? $organization_info['email'] : $financial_advisor_info['email'];
                $advchrges_compaanyfca       = !isset($financial_advisor_info['fcanumber']) ? $organization_info['fcanumber'] : $financial_advisor_info['fcanumber'];
                $advchrges_principlecontact  = isset($financial_advisor_info['principlecontact']) ? $financial_advisor_info['principlecontact'] : '';
                $advchrges_primarycontactfca = isset($financial_advisor_info['primarycontactfca']) ? $financial_advisor_info['primarycontactfca'] : '';
            }
        } else {
            if ($chargesfinancial_advisor_info == "") {
                $advchrges_companyname       = isset($financial_advisor_info['companyname']) ? $financial_advisor_info['companyname'] : '';
                $advchrges_address           = isset($financial_advisor_info['address']) ? $financial_advisor_info['address'] : '';
                $advchrges_telephone         = isset($financial_advisor_info['telephone']) ? $financial_advisor_info['telephone'] : '';
                $advchrges_website           = isset($financial_advisor_info['website']) ? $financial_advisor_info['website'] : '';
                $advchrges_email             = isset($financial_advisor_info['email']) ? $financial_advisor_info['email'] : '';
                $advchrges_compaanyfca       = isset($financial_advisor_info['fcanumber']) ? $financial_advisor_info['fcanumber'] : '';
                $advchrges_principlecontact  = isset($financial_advisor_info['principlecontact']) ? $financial_advisor_info['principlecontact'] : '';
                $advchrges_primarycontactfca = isset($financial_advisor_info['primarycontactfca']) ? $financial_advisor_info['primarycontactfca'] : '';
            } else {
                $advchrges_companyname       = isset($chargesfinancial_advisor_info['companyname']) ? $chargesfinancial_advisor_info['companyname'] : '';
                $advchrges_address           = isset($chargesfinancial_advisor_info['address']) ? $chargesfinancial_advisor_info['address'] : '';
                $advchrges_telephone         = isset($chargesfinancial_advisor_info['telephone']) ? $chargesfinancial_advisor_info['telephone'] : '';
                $advchrges_website           = isset($chargesfinancial_advisor_info['website']) ? $chargesfinancial_advisor_info['website'] : '';
                $advchrges_email             = isset($chargesfinancial_advisor_info['email']) ? $chargesfinancial_advisor_info['email'] : '';
                $advchrges_compaanyfca       = isset($chargesfinancial_advisor_info['fcanumber']) ? $chargesfinancial_advisor_info['fcanumber'] : '';
                $advchrges_principlecontact  = isset($chargesfinancial_advisor_info['principlecontact']) ? $chargesfinancial_advisor_info['principlecontact'] : '';
                $advchrges_primarycontactfca = isset($chargesfinancial_advisor_info['primarycontactfca']) ? $chargesfinancial_advisor_info['primarycontactfca'] : '';
            }

        }

        if ($chargesfinancial_advisor_info == "") {
            $advchrges_address2           = isset($financial_advisor_info['address2']) ? $financial_advisor_info['address2'] : '';
            $advchrges_county             = isset($financial_advisor_info['county']) ? $financial_advisor_info['county'] : '';
            $advchrges_postcode           = isset($financial_advisor_info['postcode']) ? $financial_advisor_info['postcode'] : '';
            $advchrges_country            = isset($financial_advisor_info['country']) ? $financial_advisor_info['country'] : '';
            $advchrges_primarycontactname = isset($financial_advisor_info['principlecontact']) ? $financial_advisor_info['principlecontact'] : '';
            $advchrges_city               = isset($financial_advisor_info['city']) ? $financial_advisor_info['city'] : '';
        } else {

            $advchrges_address2           = isset($chargesfinancial_advisor_info['address2']) ? $chargesfinancial_advisor_info['address2'] : '';
            $advchrges_county             = isset($chargesfinancial_advisor_info['county']) ? $chargesfinancial_advisor_info['county'] : '';
            $advchrges_postcode           = isset($chargesfinancial_advisor_info['postcode']) ? $chargesfinancial_advisor_info['postcode'] : '';
            $advchrges_country            = isset($chargesfinancial_advisor_info['country']) ? $chargesfinancial_advisor_info['country'] : '';
            $advchrges_primarycontactname = isset($chargesfinancial_advisor_info['principlecontact']) ? $chargesfinancial_advisor_info['principlecontact'] : '';
            $advchrges_city               = isset($chargesfinancial_advisor_info['city']) ? $chargesfinancial_advisor_info['city'] : '';
        }
        /*--------------------------------------------------------------------------------*/

        $html .= '<div style="page-break-after:always;border:none;"></div>';
        if ($additionalArgs['pdfaction'] == "esign") {
            $current_section = "4";
            $html .= transferAssetsSubheaders('SECTION 4: FEES AND CHARGES');
        } else {
            $current_section = "5";
            $html .= transferAssetsSubheaders('SECTION 5: FEES AND CHARGES');
        }

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">
                              <tr style="margin-bottom: 0; padding-bottom: 0;">
                                <td  style="width: 100%;">
                                     Please review all fees and charges below in both sections ' . $current_section . '.1 and ' . $current_section . '.2. All the latest account charges are listed in the GrowthInvest Fees and Charges document
                                 </td>
                              </tr>
                            </table>';
        //$html.='<div style="page-break-after:always;border:none;"></div>';

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION ' . $current_section . '.1: GROWTHINVEST ANNUAL CHARGE');
        } else {
            $html .= transferAssetsSubheaders('SECTION ' . $current_section . '.1: GROWTHINVEST ANNUAL CHARGE');
        }

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                                <tr style="margin-bottom: 0; padding-bottom: 0;">
                                  <td  style="width: 100%;">
                                     There is an annual fee applied as a percentage of your overall portfolio value. This is applied on a tiered basis, starting at 0.5% on portfolios up to £100,000, with a minimum annual charge of £150. Any agreed variation to the current standard terms will be detailed below:
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                       <tr>
                                         <td style="Width: 30%;">1. GROWTHINVEST ANNUAL CHARGE</td>
                                         <td style="Width: 16%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">% of investment:</div></td>
                                         <td style="Width: 5%; text-align: center;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;" >&nbsp;</div></td>
                                         <td style="Width: 16%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">Fixed amount</div></td>
                                          <td style="Width: 2%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">&nbsp;</div></td>
                                         <td style="Width: 18%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">Is VAT to be applied?</div></td>
                                        </tr>



                                     </table>

                                     <table style="width: 100%; margin-top: 0; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                     <tr>
                                     <td style="Width: 30%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">&nbsp;</div></td>
                                     <td style="Width: 16%;"><div class="inputcss" style="padding: 5px; ">' . (isset($nomineeapplication_info['adviserinitialinvestpercent']) ? $nomineeapplication_info['adviserinitialinvestpercent'] : "") . '%</div></td>
                                     <td style="Width: 5%; text-align: center;">or</td>
                                     <td style="Width: 16%;"><div class="inputcss" style="padding: 5px; ">&pound;' . (isset($nomineeapplication_info['adviserinitialinvestfixedamnt']) ? $nomineeapplication_info['adviserinitialinvestfixedamnt'] : "") . '</div></td>
                                    <td style="Width: 2%;">&nbsp;</td>
                                     <td style="Width: 18%;">

                                    <table cellpadding="0" cellspacing="0" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                        <tr style="margin-bottom: 0; padding-bottom: 0;">
                                          <td style="width:33.33%;">' . get_checkbox_html($checkbox_data31) . '</td>
                                          <td style="width:33.33%;">' . get_checkbox_html($checkbox_data32) . '</td>

                                        </tr>
                                      </table>
                                     </td>
                                     </tr>
                                     </table>
                                  </td>
                                </tr>

                              </table>';

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION ' . $current_section . '.2: ADVISER DETAILS AND CHARGES (IF APPLICABLE)');
        } else {
            $html .= transferAssetsSubheaders('SECTION ' . $current_section . '.2: ADVISER DETAILS AND CHARGES (IF APPLICABLE)');
        }

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                            <!--
                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td colspan="2" style="width: 100%;">
                                   <i>To be completed by your adviser/investment institution/intermediary. If you are completing your application as an unadvised direct investor, please proceed to section 6.</i>
                               </td>
                            </tr> -->

                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <!-- <td style="width: 50%;">

                                   I confirm that: <br/><br>
    I have obtained evidence to verify the identity of my client(s), which meets the standard evidence criteria set out within the guidance for the UK Financial Sector issued by the Joint Money Laundering Steering Group. I understand and agree that '; /*Seed EIS Platform*/
        $html .= 'GrowthInvest and Platform One



                       are reliant on me having completed this money laundering check. I also agree to provide you with copies of the ID relied upon should that be required for legal and compliance audit purposes and agree that '; /*Seed EIS Platform*/
        $html .= 'Growthinvest and Platform One may need to carry out a further risk assessment should my client not be physically present for identification purposes and that Platform One will apply enhanced due diligence checks for politically checks against the HMRC sanctions list.<br/><br>
                                ' . get_checkbox_html($verified_via_without_face_checkbox) . '<br/><br>
                                ' . get_checkbox_html($verified_via_seed_checkbox) . '<br/><br/><br>

                                I confirm that the investor is a customer of our firm and we have assessed the suitability of this investment for the Applicant.<br/>
                                <br>I have enclosed evidence to support the details given in Section 1.
                                <br>
                               </td> -->
                               <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>

                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">FIRM NAME</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>

                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . $advchrges_companyname . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">FCA FIRM REFERENCE NUMBER</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . $advchrges_compaanyfca . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">FIRM ADDRESS</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; height: 40px; ">' . $advchrges_address . ($advchrges_address != '' ? ', ' : '') . $advchrges_address2 . ($advchrges_address2 != '' ? ', ' : '') . $advchrges_city . ($advchrges_city != '' ? ', ' : '') . $advchrges_county . ($advchrges_county != '' ? ', ' : '') . getCountryNameByCode($advchrges_country) . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">POST CODE</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . $advchrges_postcode . '</div></td>
                                   </tr>
                                   </table>


                                   <!-- <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%; "><div class="inputcss" style="padding: 5px; background: #ccc;">REGISTERED INDIVIDUAL (RI) NAME</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . (isset($nomineeapplication_info['advisorconfirmriname']) ? $nomineeapplication_info['advisorconfirmriname'] : "") . '</div></td>
                                   </tr>
                                   </table><br> -->



                               </td>

                               <td style="width: 50%; vertical-align: top;">
                               <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">ADVISER NAME</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . $advchrges_principlecontact . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">FCA ADVISOR NO.</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . $advchrges_primarycontactfca . '</div></td>
                                   </tr>
                                   </table>



                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">ADVISER EMAIL ADDRESS</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . $advchrges_email . '</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">BEST CONTACT TELEPHONE NUMBER</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; ">' . $advchrges_telephone . '</div></td>
                                   </tr>
                                   </table>
                               </td>
                            </tr>






                          <tr style="margin-bottom: 0; padding-bottom: 0; ">
                            <td colspan="2" style="width: 100%;">
                            <div style="background: rgb(224, 224, 224); border-color: rgb(224, 224, 224);"><b>Client Agreed Adviser Remuneration</b><br/>

                              GrowthInvest can facilitate the payment of fees to your adviser. Please specify the agreed adviser remuneration below:
                            </div><br/>
                             </td>
                          </tr>





                          <tr style="margin-bottom: 0; padding-bottom: 0; ">
                            <td colspan="2" style="width: 100%;">

                            <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 33%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">2. ONGOING ADVISER CHARGE*</div></td>
                                 <td style="Width: 17%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">% of investment:</div></td>
                                 <td style="Width: 5%; text-align: center;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;" >&nbsp;</div></td>
                                 <td style="Width: 17%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">Fixed amount</div></td>
                                  <td style="Width: 2%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">&nbsp;</div></td>
                                 <td style="Width: 18%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">Is VAT to be applied?</div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; " class="no-spacing" >
                                 <tr>
                                 <td style="Width: 33%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">&nbsp;</div></td>
                                 <td style="Width: 17%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['ongoingadvinitialinvestpercent']) ? $nomineeapplication_info['ongoingadvinitialinvestpercent'] : "") . '%</div></td>
                                 <td style="Width: 5%; text-align: center;">or</td>
                                 <td style="Width: 17%;"><div class="inputcss" style="padding: 5px;">&pound;' . (isset($nomineeapplication_info['ongoingadvinitialinvestfixedamnt']) ? $nomineeapplication_info['ongoingadvinitialinvestfixedamnt'] : "") . '</div></td>
                                <td style="Width: 2%;">&nbsp;</td>
                                 <td style="Width: 18%;">

                                <table cellpadding="0" cellspacing="0" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                    <tr style="margin-bottom: 0; padding-bottom: 0;">
                                      <td style="width:33.33%;">' . get_checkbox_html($checkbox_ongoingadv_vat_applied1) . '</td>
                                      <td style="width:33.33;">' . get_checkbox_html($checkbox_ongoingadv_vat_applied2) . '</td>

                                    </tr>
                                  </table>

                                 </td>
                                 </tr>
                                 </table>


                             </td>
                          </tr>

                           <tr style="margin-bottom: 0; padding-bottom: 0; ">
                            <td colspan="2" style="width: 100%;">

                            <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 33%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">3. AGREED INITIAL CHARGES**</div></td>
                                 <td style="Width: 17%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">% of investment:</div></td>
                                 <td style="Width: 5%; text-align: center;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;" >&nbsp;</div></td>
                                 <td style="Width: 17%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">Fixed amount</div></td>
                                  <td style="Width: 2%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">&nbsp;</div></td>
                                 <td style="Width: 18%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">Is VAT to be applied?</div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; " class="no-spacing" >
                                 <tr>
                                 <td style="Width: 33%;"><div style="padding: 2px; background: rgb(224, 224, 224); border-color: transparent;">&nbsp;</div></td>
                                 <td style="Width: 17%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['intermediaryinitialinvestpercent']) ? $nomineeapplication_info['intermediaryinitialinvestpercent'] : "") . '%</div></td>
                                 <td style="Width: 5%; text-align: center;">or</td>
                                 <td style="Width: 17%;"><div class="inputcss" style="padding: 5px;">&pound;' . (isset($nomineeapplication_info['intermediaryinitialinvestfixedamnt']) ? $nomineeapplication_info['intermediaryinitialinvestfixedamnt'] : "") . '</div></td>
                                <td style="Width: 2%;">&nbsp;</td>
                                 <td style="Width: 18%;">

                                <table cellpadding="0" cellspacing="0" border=""   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%;>

                                    <tr style="margin-bottom: 0; padding-bottom: 0;">
                                      <td style="width:33.33%;">' . get_checkbox_html($checkbox_intermediary_vat_applied1) . '</td>
                                      <td style="width:33.33;">' . get_checkbox_html($checkbox_intermediary_vat_applied2) . '</td>

                                    </tr>
                                  </table>

                                 </td>
                                 </tr>
                                 </table>


                             </td>
                          </tr>
                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td colspan="2" style="width: 100%;">
                              <div style="background: rgb(224, 224, 224); border-color: rgb(224, 224, 224); margin-bottom: 0;">
                              *The on-going adviser charge will be applied monthly in arrears on the overall portfolio value<br/>

                              ** Any agreed initial charges on investments should be entered here and will be applied automatically to new investments. Ad hoc fees and charges can also be facilitated on each individual investment on instructions the specific investment application form.
                              </div>
                            </td>
                          </tr>

                            <!-- <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td colspan="2">
                                   <b>Please see the below notes for further information for adviser charge requests:</b>
                               </td>
                            </tr> -->

                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td colspan="2" style="width: 100%;">
                              <b style="margin-top: -10px;">Please see the below notes for further information for adviser charge requests :</b>
                                <ol style="margin-bottom: 5px; margin-top: -10px;">
                                <li>All charges entered on this form will be stored on our system and will be used to validate all charge requests made by you or set up on your behalf</li>
                                <li>Ad hoc charges must be requested by completing an ad hoc adviser charge form, or via written request signed by the client.</li>
                                <li>Where VAT has been selected, it will be applied on top of the charge calculations.</li>
                                <li>In signing this form, you confirm that the stated adviser is an authorised third party. GrowthInvest will send copies of relevant information, and accept reasonable instruction from your authorised adviser unless instructed otherwise in writing.</li>
                                </ol>

                                <!-- CR280 change
                                <div style="background: rgb(224, 224, 224); border-color: rgb(224, 224, 224);">I confirm that I agree that my financial adviser is authorised to deduct the charges detailed above</div> -->
                              </td>

                            <!-- <td style="width: 50%;">
                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;">1. All charges entered on this form will be stored on our system and will be used to validate all charge requests made by you or set up on your behalf.</td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;">2. Ad hoc charges must be requested by completing an ad hoc adviser charge form, or via written request signed by the client.</td>
                                 </tr>
                                 </table>
                             </td>
                             <td style="width: 50%; vertical-align: middle;">
                                 <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%;">3. Where VAT has been selected, it will be applied on top of the charge calculations.</td>

                                 </tr>
                                 </table>
                             </td> -->
                          </tr>


                        </table>

                            <div style="page-break-after:always;border:none;"></div>'; /*if($additionalArgs['pdfaction']=="")*/

        //End Page 3 Section 5

        //Start Page 5

        //Start Page 6 SEction 6 Client declaration
        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 5.1: CLIENT DECLARATION');
        } else {
            $html .= transferAssetsSubheaders('SECTION 6.1: CLIENT DECLARATION');
        }

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 5px; padding-top: 0; padding-bottom: 0; width: 100%; table-layout: fixed;">

                                      <tr>
                                        <td colspan="2" style="width: 100%;">Before signing this declaration you should read the GrowthInvest Terms & Conditions, the GrowthInvest Charges document and Investment Agreement carefully. These documents give you important information about your GrowthInvest Account and form the basis of the contract between you and GrowthInvest. If there is anything that you do not understand, you should contact your Financial Adviser or any member of the GrowthInvest Team*. As part of this document you will automatically open a Platform One account for asset custody purposes.
                                         </td>
                                      </tr>



                                      <tr>

                                          <td  style="width: 50%;  vertical-align:top;" valign="top">
                                            <ol style="width: 100%; margin-bottom:0px; margin-top:-8px;"  >
                                              <li >I/we wish to open an Account with GrowthInvest in accordance with the published Terms and Conditions, Investor agreement and the GrowthInvest Platform Charges, which I/we acknowledge having received and to which I/we agree to be bound and any subsequent amendments which Platform One and GrowthInvest may inform me/us of from time to time.</li>

                                              <li>I/we acknowledge that neither GrowthInvest nor Platform One are providing investment, legal, financial, tax or other advice and that any tax information provided is in the context of an investment into the Platform.</li>

                                              <li>I/we confirm the my/our Financial Adviser has authorisation to deduct their charges as detailed in ' . ($additionalArgs['pdfaction'] == "esign" ? 'section 4' : 'section 5') . '. I/we understand that on cancellation or closure of the account, Platform One will not refund these Adviser Charges. I/we will need to negotiate with my/our Financial Adviser about refunding any of these Adviser Charges.</li>

                                              <li>I/We confirm that the bank account details given in ' . ($additionalArgs['pdfaction'] == "esign" ? 'Section 3' : 'Section 4') . ' are those of my/our bank account and that I/we have given my/our Financial Adviser instruction to use this account for cash withdrawals.</li>

                                              <li>I/We declare that this application has been completed to the best of my knowledge and belief.</li>

                                              <li>I/We confirm that the information contained within this application form is true and correct. I/We agree to notify you immediately in the event that the information I/we have provided changes.</li>

                                              <li>I/we have read and understood the GrowthInvest Platform Charges.</li>
                                            </ol>
                                          </td>

                                          <td  style="width: 50%;" valign="top">
                                            <ul   style="width: 100%;  margin-bottom:0px; margin-top:-8px; list-style: none;">
                                              <li><table cellpadding="0" cellspacing="0" border="0"   class="w100per" style="margin-top: 0; padding-top: 0; padding-bottom: 0; width: 100%; table-layout: fixed;"> <tr><td style="width:5%; vertical-align:top;  text-align:right;" > 8. </td><td style="width:95%; vertical-align:top;" >I/we confirm that I/we have categorised myself/ourselves on GrowthInvest, or have done so with my/our Financial Adviser and selected ‘advised Client’. I/We understand therefore that:</td></tr></table>

                                                <ol style="list-style-type: upper-alpha; margin-left:0%;">                  <li> I/we can receive financial promotions that may not have been approved by a person authorised by the Financial Conduct Authority.</li>                  <li>The content of such financial promotions may not conform to rules issued by the financial Conduct Authority. </li>                  <li>I/we may have no right to seek compensation from the Financial Services Compensation Scheme.</li>                  <li>I/we may have no right to complain to either the Financial Conduct Authority or the Financial Ombudsman Scheme.</li>                </ol>

                                              </li>
                                              <li  ><table cellpadding="0" cellspacing="0" border="0"   class="w100per" style="margin-top: 0; padding-top: 0; padding-bottom: 0; width: 100%; table-layout: fixed;"> <tr><td style="width:5%; vertical-align:top; text-align:right;" > 9. </td><td style="width:95%; vertical-align:top;" >I am/We are aware that it is open to me/us to seek advice from someone who specialises in advising on investments.</td></tr></table></li>
                                              <li  ><table cellpadding="0" cellspacing="0" border="0"   class="w100per" style="margin-top: 0; padding-top: 0; padding-bottom: 0; width: 100%; table-layout: fixed;"> <tr><td style="width:5%; vertical-align:top;  text-align:right;" >10. </td><td style="width:95%; vertical-align:top;" >I/We understand that I/we have the right to re-register the SEIS/EIS shares into my own name at any time after the shares have been issued. However they will no longer appear in my Platform One portfolio.</td></tr></table></li>
                                              <li  ><table cellpadding="0" cellspacing="0" border="0"   class="w100per" style="margin-top: 0; padding-top: 0; padding-bottom: 0; width: 100%; table-layout: fixed;"> <tr><td style="width:5%; vertical-align:top;  text-align:right;" >11. </td><td style="width:95%; vertical-align:top;" >I am/We are over age 18 and a UK resident. If I/we cease to be a UK resident I/we will advise GrowthInvest in writing within 30 days.</td></tr></table></li>
                                            </ul>
                                          </td>


                                        </tr>

                                        <tr>
                                        <td colspan="2" style="width: 100%; vertical-align:top;">*GrowthInvest is unable to provide advice, unless you register as a Professional Client</td>
                                      </tr>

                                    </table>'; /*.get_section_header_content_seperator(700).get_nomination_form_footer()*/;

        //End Page 6 SEction 6 Client declaration

        // section6.1 starts  SECTION 6.1: DATA PROTECTION ACT
        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 5.2: DATA PROTECTION');
        } else {
            $html .= transferAssetsSubheaders('SECTION 6.2: DATA PROTECTION');
        }

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

      <tr style="margin-bottom: 0; padding-bottom: 0;">
        <td style="width: 50%; vertical-align: top;">
             <p style="margin-bottom:3px; margin-top:-5px;" >Platform One and GrowthInvest will treat the information supplied on this form, along with information we obtain from other sources, as confidential and solely for administering your investments. In doing so Platform One may use external agents, custodians and outsourced administrators to provide some of the services necessary to run your portfolios and shall ensure that such external agents, custodians and outsourced administrators are also obliged to treat this information as confidential.</p>

                <p style="margin-bottom:3px;">This information may also be passed to our regulator, auditors, legal and financial advisers, other financial institutions connected with the provision of your investments (e.g. fund managers), authorised agents, third party service providers, authorised law enforcement agencies and local authorities. However, your personal information will not be passed to any other external parties unless we have your permission to do so or we are under a legal obligation or have a duty to do so.</p>

                <p style="margin-bottom:3px;">In order to ensure the efficient running of your investments, we may share the information provided by you with other data processors acting on our behalf and who may be outside the European Economic Area. In this event we are bound by our obligations under the Data Protection Act to ensure your information is adequately protected.</p>
         </td>
         <td style="width: 50%;">
             <p style="margin-bottom:3px;  margin-top:-5px;">If you provide us with information about other investors, you confirm that they have appointed you to act for them to consent to the processing of their personal data and that you have informed them of our identity and the purposes (as set out above) for which their personal data will be processed.</p>

            <p style="margin-bottom:3px; ">We will carry out an identity authentication check to verify your identity. This may involve checking the details you supply against those held on databases that may be accessed by the reputable third party company that carries out checks on our behalf. This includes information from the Electoral Register and fraud prevention agencies. We will use scoring methods to verify your identity. A record of this search will be kept and may be used to help other companies to verify your identity. We may also pass information to other organisations involved in the prevention of fraud and money laundering, to protect ourselves and our customers from fraud and theft. If false or inaccurate information is provided or fraud is suspected, this will be recorded and may be shared with other organisations.</p>

            <p style="margin-bottom:3px;  ">Under the terms of the Data Protection Act 2003, you are entitled to ask for a copy of the information we hold on you. A fee may be charged for this service. In addition, if any of the information we hold on you is inaccurate or incorrect, please let us know and we will correct it. Requests should be made in writing to: GrowthInvest, Candlewick House, 120 Cannon St, London EC4N 6AS.</p>
         </td>
      </tr>







      </table>
        <div style="page-break-after:always;border:none;"></div>
      ';

        //testing page7-B starts

        $adviser_confirm_chkbx1_checkedval = false;
        if (isset($nomineeapplication_info['advisorconfirmstandardreq'])) {
            if ($nomineeapplication_info['advisorconfirmstandardreq'] == "yes") {
                $adviser_confirm_chkbx1_checkedval = true;
            }
        }
        $adviser_confirm_chkbx1[] = array('label_first' => false, 'label' => 'The evidence I/we have obtained meets the standard requirements which are defined within the guidance for the UK Financial Sector issued by Joint Money Laundering Steering Group (JMLSG); or ', 'checked' => $adviser_confirm_chkbx1_checkedval);

        $adviser_confirm_chkbx2_checkedval = false;
        if (isset($nomineeapplication_info['advisorconfirmexceedstandardreq'])) {
            if ($nomineeapplication_info['advisorconfirmexceedstandardreq'] == "yes") {
                $adviser_confirm_chkbx2_checkedval = true;
            }
        }
        $adviser_confirm_chkbx2[] = array('label_first' => false, 'label' => 'The evidence I/we have obtained exceeds the standard requirements and I/we have attached the further evidence I/we used to verify the identity of my/our client to this
    form.', 'checked' => $adviser_confirm_chkbx2_checkedval);

        // / testing page7-A ends

        $nomineeapplication_verified_01 = false;
        if ($nomineeapplication_info != "") {
            $nomineeapplication_verified_01 = ($nomineeapplication_info['verified'] == "completed") ? true : false;
        }
        $verification_checkbox_data_01[] = array('label_first' => false, 'label' => '', 'checked' => $nomineeapplication_verified_01);

        $nomineeapplication_verified_02 = false;
        if ($nomineeapplication_info != "") {
            $nomineeapplication_verified_02 = ($nomineeapplication_info['verified'] == "complete_pending_evidence") ? true : false;
        }
        $verification_checkbox_data_02[] = array('label_first' => false, 'label' => '', 'checked' => $nomineeapplication_verified_02);

        $nomineeapplication_verified_03 = false;
        if ($nomineeapplication_info != "") {
            $nomineeapplication_verified_03 = ($nomineeapplication_info['verified'] == "requested") ? true : false;
        }
        $verification_checkbox_data_03[] = array('label_first' => false, 'label' => '', 'checked' => $nomineeapplication_verified_03);

        $nomineeapplication_verified_04 = false;
        if ($nomineeapplication_info != "") {
            $nomineeapplication_verified_04 = ($nomineeapplication_info['verified'] == "manual_kyc") ? true : false;
        }
        $verification_checkbox_data_04[] = array('label_first' => false, 'label' => 'I would like to do manual KYC process.', 'checked' => $nomineeapplication_verified_04);

        $verification_checkbox_data_05_offline[] = array('label_first' => false, 'label' => '', 'checked' => false);

        //testing page7-A starts
        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 6: CONFIRMATION OF VERIFICATION OF IDENTITY CERTIFICATE');
        } else {
            $html .= transferAssetsSubheaders('SECTION 7: CONFIRMATION OF VERIFICATION OF IDENTITY CERTIFICATE');
        }

        $app_sec7f = (isset($nomineeapplication_info['forename']) ? $nomineeapplication_info['forename'] : $invuser_data['first_name']);
        $app_sec7l = (isset($nomineeapplication_info['surname']) ? $nomineeapplication_info['surname'] : $invuser_data['last_name']);

        $html .= ' <table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">
                <tr style="margin-bottom: 0; padding-bottom: 0;">
                  <td   style="width: 100%;">
                    <p style="font-style: italic; margin-bottom: 5px;">Please complete this page to confirm that your identity has been verified for anti-money laundering purposes. We do not require a full credit check on any investor.</p>
                    <i>Please select from the below options by ticking the boxes:</i>
                  </td>
                </tr>
                <tr>
                  <td>

                      <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                      <tr>
                      <td style="Width: 80%; vertical-align: midddle;">1. I have completed the Growth<span style="color: #0CADDC;">Invest</span> online KYC and AML process via Onfido*.</td>
                      <td style="Width: 10%; vertical-align: middle;">' . get_checkbox_html($verification_checkbox_data_01) . '  &nbsp;  &nbsp; </td>
                      </tr>
                      </table>

                      <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                      <tr>
                      <td style="Width: 80%; vertical-align: midddle;">2. I have completed the KYC and AML through my wealth Manager/Advisor and will provide a copy of this if requested.</td>
                      <td style="Width: 10%; vertical-align: middle;">' . get_checkbox_html($verification_checkbox_data_02) . '  &nbsp;  &nbsp; </td>
                      </tr>
                      </table>

                      <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                        <tr>
                          <td style="Width: 80%; vertical-align: midddle;">3. I would like for Growth<span style="color: #0CADDC;">Invest</span> to commence the checks necessary to verify me/my client\'s identity online through Onfido*</td>
                          <td style="Width: 10%; vertical-align: middle;">' . get_checkbox_html($verification_checkbox_data_03) . '  &nbsp;  &nbsp; </td>
                        </tr>
                      </table>

                      <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                        <tr>
                          <td style="Width: 80%; vertical-align: midddle;">4. I would rather complete the identification and anti money laundering checks offline and will provide documentation in line with requirements laid out in Appendix I.</td>
                          <td style="Width: 10%; vertical-align: middle;">' . get_checkbox_html($verification_checkbox_data_05_offline) . '  &nbsp;  &nbsp; </td>
                        </tr>
                      </table>

                  </td>
                </tr>
              </table>
      ';

        $html .= transferAssetsSubheaders('Verification of Identity by Wealth Manager');

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                        <tr >
                        <td style="width: 100%;" colspan="2">


                            <p style="font-style: italic;"><b>Important Information</b><br>
                            A separate certificate must be completed for each investor (e.g. joint holders, trustee cases and joint life cases.) If the payments for the investor are being made by a third party, the identity of that person must also be verified and confirmation provided in a separate certificate.<br>
                            This certificate cannot be used to verify the identity of any investor that falls into one of the following categories:
                            <ul style="font-style: italic;">
                            <li>those who are exempt from verification as being an existing client of the introducing firm prior to the introduction of the requirement for such verification;</li>
                            <li>those who have been subject to Simplified Due Diligence under the Money Laundering Regulations; or</li>
                            <li>those whose identity has been verified using the source of funds as evidence.</li>
                            </ul>
                            </p>
                            <p style="font-style: italic;">This certificate must carry an original signature.</p>
                            <p style="font-style: italic;">We reserve the right to request a copy of the evidence you use to verify the identity of your client.</p>


                         </td>
                         </tr>

                             <tr style="margin-bottom: 0; padding-bottom: 0;">
                               <td colspan="2" style="width: 100%;">
                               <!-- <div style="background: rgb(224, 224, 224); border-color: rgb(224, 224, 224); margin-bottom: 0;"><u>Verification of Identity</u></div> -->
                               I confirm that:
    &nbsp; '; /*Seed EIS Platform*/
        $html .= 'I have obtained evidence to verify the identity of my client(s), which meets the standard evidence criteria set out within the guidance for the UK Financial Sector issued by the Joint Money Laundering Steering Group(JMLSG)
                                 I understand and agree that GrowthInvest and Platform One are reliant on me having completed this money laundering check. I also agree to provide you with copies of the ID relied upon should that be required for legal and compliance audit purposes and agree that Growthinvest and Platform One may need to carry out a further risk assessment should my client not be physically present for identification purposes and that Platform One will apply enhanced due diligence checks for politically checks against the HMRC sanctions list.<br/><br/>
                                 <b>I confirm that the investor is a customer of our firm and we have assessed the  suitability of this investment for the Applicant.</b><br/><br>';

        $html .= '<!-- Please tick one of the boxes below to indicate Know Your Customer & Anti-Money Laundering preferences -->
                                   ' . get_checkbox_html($JMLSG) . '
                                   <div style="margin-left: 0; background: #e0e0e0; border-color: #e0e0e0;">' . get_checkbox_html($verified_via_without_face_checkbox) . '</div>';
        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= '<div style="text-align:center;width:100%; background: rgb(224, 224, 224); border-color: rgb(224, 224, 224);">OR: </div>' . get_checkbox_html($no_valid_kyc_aml);
        }

        // CR280 '.get_checkbox_html($verified_via_seed_checkbox).'
        $html .= '</td>
                             </tr>






                             <tr style="margin-bottom: 0; padding-bottom: 0;">
                             <td style="width: 50%;">
                                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                  <tr>
                                  <td style="Width: 100%; "><div class="inputcss" style="padding: 5px; background: #ccc;">Adviser Name</div></td>
                                  </tr>
                                  </table>

                                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                  <tr>
                                  <td style="Width: 100%; background: #ccc;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['advisorapplicantname']) ? $nomineeapplication_info['advisorapplicantname'] : "") . '</div></td>
                                  </tr>
                                  </table><br>

                                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                  <tr>
                                  <td style="Width: 30%;"><div class="inputcss" style="padding: 5px; background: #ccc;">Date :</div></td>
                <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">&nbsp;';

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= '<input type="text"   style="   font-size:10px; border: dashed 1mm white    " name="Dte_es_:signer1:date:format(date,\'dd/mm/yyyy\')"  disabled="disabled"/>';
        } else {
            $html .= ' &nbsp;';
        }

        $html .= '  </div>
                             </td>
                                  </tr>
                                  </table>
                              </td>
                              <td style="width: 50%; vertical-align: top;">
                                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                  <tr>
                                  <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background: #ccc;">Adviser Signature</div></td>
                                  </tr>
                                  </table>

                                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                  <tr>
                                  <td style="Width: 100%; background: #ccc;">';

        if ($additionalArgs['pdfaction'] == "esign") {

            $html .= '<div class="inputcss" style="height:60px;"><input style="margin-top:5px;" type="text" class="signature_style" name="Sig_es_:signer1:signature" /></div> ';
        } else {
            $html .= '<div class="inputcss" style="padding: 5px;"><BR><BR><br></div>';
        }

        $html .= '</td>
                                  </tr>
                                  </table>
                              </td>
                           </tr>
                            <tr>
                              <td colspan="2" style="width: 100%;">
                                &copy; Onfido&trade; ,' . date('Y') . '. All rights reserved. Data Protection Registration Number:Z2709206. Company Registration Number: 07479524. Onfido is registered with the Information Commissioner\'s Office in compliance with the Data Protection Act 1998. Onfido uses 256-bit SSL encryption 100% of the time on every device.
                              </td>
                            </tr>

                        </table>';

        $html .= '<!-- <table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                              <tr style="margin-bottom: 0; padding-bottom: 0;">
                                <td style="width: 100%;">
                                  <p style="text-align: center; font-weight: bold; font-style: italic; margin-bottom: 5px;">If you have not previously completed KYC and AML please select one of the below:</p>
                                </td>
                              </tr>


                            </table>--><div style="page-break-after:always;border:none; "></div>';

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 7: TRANSFER DETAILS');
        } else {
            $html .= transferAssetsSubheaders('SECTION 8: TRANSFER DETAILS');
        }

        $app_sec7f = (isset($nomineeapplication_info['forename']) ? $nomineeapplication_info['forename'] : $invuser_data['first_name']);
        $app_sec7l = (isset($nomineeapplication_info['surname']) ? $nomineeapplication_info['surname'] : $invuser_data['last_name']);

        $nomineeapplication_transfer_at_later_stage          = false;
        $nomineeapplication_transfer_immediately_and_provide = false;
        if ($nomineeapplication_info != "") {
            $nomineeapplication_transfer_at_later_stage          = ($nomineeapplication_info['transfer_at_later_stage'] == "yes") ? true : false;
            $nomineeapplication_transfer_immediately_and_provide = ($nomineeapplication_info['transfer_at_later_stage'] == "no") ? true : false;
        }
        $nomineeapplication_transfer_at_later_stage_chkbox[] = array('label_first' => false, 'label' => 'I will transfer funds at a later stage', 'checked' => $nomineeapplication_transfer_at_later_stage);

        $nomineeapplication_transfer_immediately_and_provide_chkbox[] = array('label_first' => false, 'label' => 'I will transfer funds immediately and provide details below', 'checked' => $nomineeapplication_transfer_immediately_and_provide);

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                        <tr style="margin-bottom: 0; padding-bottom: 0;">
                        <td colspan="2" style="width: 100%;">
                        <p style="font-weight: bold; font-style: italic; margin-bottom: 5px;">Please provide details below of the amount you will be transferring to your Investment Account.
                            </p>


                         </td>
                         </tr>


                          <tr>
                          <td colspan="2" style="width: 100%;">
                                  ' . get_checkbox_html($nomineeapplication_transfer_immediately_and_provide_chkbox) . '
                                 ' . get_checkbox_html($nomineeapplication_transfer_at_later_stage_chkbox) . '
                             </td>
                          </tr>

                          <tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td colspan="2" style="width: 100%;">
                              <b>Transfer :</b>
                            </td>
                          </tr>


                         <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">&nbsp;</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px; background: #ccc; text-align: center;">INVESTMENT AMOUNT</div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Bank Transfer</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['subscriptioninvamntbank']) ? "&pound;" . $nomineeapplication_info['subscriptioninvamntbank'] : "") . ' &nbsp;  &nbsp;  </div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Cheque</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;"> &pound; ' . (isset($nomineeapplication_info['subscriptioninvamntcheq']) ? $nomineeapplication_info['subscriptioninvamntcheq'] : "") . '  &nbsp;  &nbsp; </div></td>
                                 </tr>
                                 </table>




                               </td>

                                <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>

                                 <td style="Width: 100%; vertical-align: top;"><div class="inputcss" style="padding: 5px; background: #ccc; text-align: center;">EXPECTED DATE OF BANK TRANSFER</div></td>
                                 </tr>
                                 </table>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 100%; vertical-align: top;"><div class="inputcss" style="padding: 5px; ">' . (isset($nomineeapplication_info['subscriptiontransferdate']) ? $nomineeapplication_info['subscriptiontransferdate'] : "") . '</div></td>

                                 </tr>
                                 </table>


                               </td>

                            </tr>

                         <tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td colspan="2" style="width: 100%;">
                                 <b>P1 GrowthInvest Bank Account Details:</b>
                             </td>
                          </tr>

                           <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Bank Name :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;"> HSBC </div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Account Name :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;"> P1 GROWTHINVEST </div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Reference: - Initials and Last Name</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">' . (isset($nomineeapplication_info['subscriptionreffnamelname']) ? $nomineeapplication_info['subscriptionreffnamelname'] : "") . '</div></td>
                                 </tr>
                                 </table>




                               </td>

                                <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Sort Code :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;"> 401307 </div></td>
                                 </tr>
                                 </table><br>

                                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 30%;">Account Number :</td>
                                 <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;"> 93671402 </div></td>
                                 </tr>
                                 </table>


                               </td>

                            </tr>

                            </table>';

        //testing page7-A starts
        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 8: SIGNATURE');
        } else {
            $html .= transferAssetsSubheaders('SECTION 9: SIGNATURE');
        }

        $app_sec7f = (isset($nomineeapplication_info['forename']) ? $nomineeapplication_info['forename'] : $invuser_data['first_name']);
        $app_sec7l = (isset($nomineeapplication_info['surname']) ? $nomineeapplication_info['surname'] : $invuser_data['last_name']);

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                        <tr style="margin-bottom: 0; padding-bottom: 0;">
                        <td colspan="2" style="width: 100%;">
                             <p style="margin-bottom: 5px;">I hereby confirm that I have read and agree with all the information provided with this form and that I have read and agree to the Growth<span style="color:#2EB6DD;">Invest</span> and Platform One Terms and Conditions.</p>
                             <p style="margin-bottom: 5px;">I confirm that the bank account details in ' . ($additionalArgs['pdfaction'] == "esign" ? 'Section 3' : 'Section 4') . ' are those of my account and (if applicable) I have given my financial adviser instruction to use this account for cash payments.</p>
                             <p>I declare that this application has been completed to the best of my knowledge and belief.</p>
                         </td>
                         </tr>

                            <tr style="margin-bottom: 0; padding-bottom: 0;">
                              <td style="width: 50%;">
                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background : #ccc;">Applicant Name</div></td>
                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px;">&nbsp;' . $app_sec7f . ' ' . $app_sec7l . '</div></td>

                                   </tr>
                                   </table><br>

                                    <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 30%;"><div class="inputcss" style="padding: 5px; background : #ccc;">DATE</div></td>
                                   <td style="Width: 70%;"><div class="inputcss" style="padding: 5px;">&nbsp;';

        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= '<input type="text"   style="    font-size:10px;   border: dashed 1mm white  " name="Dte_es_:signer1:date:format(date,\'dd/mm/yyyy\')"  disabled="disabled"/>';
        } else {
            $html .= ' &nbsp;';
        }

        $html .= '</div></td>
                                   </tr>
                                   </table>
                               </td>
                               <td style="width: 50%; vertical-align: top;">
                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>
                                   <td style="Width: 100%;"><div class="inputcss" style="padding: 5px; background : #ccc;">APPLICANT SIGNATURE</div></td>

                                   </tr>
                                   </table>

                                   <table style="width: 100%; margin-bottom:0; padding-bottom: 0;" class="no-spacing" >
                                   <tr>

                                   <td style="Width: 100%;">';

        if ($additionalArgs['pdfaction'] == "esign") {

            $html .= '<div class="inputcss" style="height:60px;"><input style="margin-top:5px;" type="text" class="signature_style" name="Sig_es_:signer1:signature" /></div> ';
        } else {
            $html .= '<div class="inputcss" style="padding: 5px;"><BR><BR><br></div>';
        }

        $html .= ' </td>
                                   </tr>
                                   </table>
                               </td>
                            </tr></table>';

        $html .= '<div style="page-break-after:always;border:none;"></div>';

        //testing page7-A starts
        if ($additionalArgs['pdfaction'] == "esign") {
            $html .= transferAssetsSubheaders('SECTION 9: APPENDIX');
        } else {
            $html .= transferAssetsSubheaders('SECTION 10: APPENDIX');
        }

        $html .= transferAssetsSubheaders('I. VERIFICATION OF IDENTITY');

        $html .= '
                            <table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">
                                <tr style="margin-bottom: 0; padding-bottom: 0;">
                                  <td colspan="2" style="width: 100%;">
                                    <p>If you selected to provide your details for the verification of identity in ' . ($additionalArgs['pdfaction'] == "esign" ? 'section 6' : 'section 7') . ' please follow instructions below:</p>
                                    <p>You must provide one document from List A and one Document from List B below with your Application Form and remittance amount. These copies must be verified by an approved person and certified to be a true original.</p>

                                    <p>The Company reserves the right to request further documentation or conduct further searches as necessary in respect of any applicant in order to satisfy their obligations to ensure adherence to Anti Money Laundering regulation and/or legislation. Each item must be less than three months old and should show your name and permanent residential address, Original documents will be returned by post at your risk</p>
                                  </td>
                                </tr>
                                <tr style="margin-bottom: 0; padding-bottom: 0;">
                                  <td style="width: 50%; vertical-align: top;">
                                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                     <tr>
                                     <td style="Width: 100%;">
                                     <b>List A (Verification of Identity)</b><br>
                                     <ul>
                                     <li>Photo ID (e.g. Passport, Driving License or certified copies of either)</li>
                                     </ul>
                                     </td>
                                     </tr>
                                     </table>
                                  </td>
                                  <td style="width: 50%; vertical-align: top;">
                                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                     <tr>
                                     <td style="Width: 100%;">
                                     <b>List B (Verification of Address)</b><br>
                                     <ul>
                                     <li>Driving License (or certified copy)</li>
                                     <li>Utility bill (but not a mobile telephone bill)</li>
                                     <li>Council Tax bill (for the current year)</li>
                                     <li>Original tax notification from HM Revenue & Customs</li>
                                     <li>Bank statement/Building Society statement</li>
                                     </ul>
                                     </td>
                                     </tr>
                                     </table>
                                 </td>

                                </tr>
                              </table>';

        $html .= transferAssetsSubheaders('II. MAILING INSTRUCTIONS FOR HARD COPIES');
        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">





                             <tr style="margin-bottom: 0; padding-bottom: 0;">
                               <td style="width: 100%;">
                                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                    <tr>
                                    <td style="Width: 100%;">If you are sending in any hard copies please make sure you make a copy of your signed forms and certificates for your records. To prevent delay or loss and to ensure that your certificates are deposited correctly, mail this form and your certificates or other required documentation (if applicable) by overnight delivery or by registered or certified mail (with return receipt requested) to:</td>
                                    </tr>
                                    </table><br>

                                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                    <tr>
                                    <td style="Width: 100%; text-align: center;"><b>GrowthInvest, Candlewick House, 120 Cannon Street, London, EC4N 6AS</b></td>

                                    </tr>
                                    </table><br>


                                </td>

                             </tr></table>';

        //$html.='<img src="'.$lastpage_image.'" style="width:755px; margin-left:-88px; margin-top:-129px;  " />';

        $html = $html . $header_footer_end_html;

        $html .= '<page backimg="' . $lastpage_image . '"> </page>';

        return $html;

    }

    public function getInvestorsActivityHtml($activityListings)
    {
        $html = '

                                                <style>
                     h3 {

                    margin-top: 4px;
                    font-size:18px;
                    font-weight:600;
                    line-height: 20px;
                    margin-top:10px;

                    }
                       

                    
                    th{
                        vertical-align:top;
                        color: #000
                    }
                    th,td {
                        padding : 10px 15px;
                        font-size:12px;
                    }

                    td{
                        color: #A2A0A0
                    }

                    

                     </style>
 
 

                     <h3>Activity Log Data</h3>
                    <table cellpadding="0" cellspacing="0"  style="width: 100%;"  >
                         
                         <tr>
                              <td align="left" valign="bottom" style="width: 50%;"  >Date - ' . date('d/m/Y') . ' </td>
                              <td align="right" valign="bottom" style="width: 50%;color:#A2A0A0" >&nbsp;</td>
                         </tr>
                         <tr height="8" style="height:4px;padding:0px;">
                            <td colspan="2" valign="top" height="4" style="width: 100%;height:8px;padding:0px;"><hr style="border:1px solid #ccc;width: 100%;"></td>
                         </tr>
                    </table>';
        $table_html = '<table  cellpadding="0" cellspacing="0" style="width:100%;" border="1" cellpadding="8px" cellspacing="0px">';

        $table_html .= '<tr    class="title-bg" style=" ">
                            <th style="width: 10%;">&nbsp;</th>
                            <th style="width: 15%;">Company</th>
                            <th style="width: 10%;">First Name</th>
                            <th style="width: 10%;">Last Name</th>
                            <th style="width: 10%;">Type of User</th>
                            <th style="width: 15%;">Activity Name</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Description</th>

                          </tr>';
        $bgcolor          = '#fff';
        $activityData     = [];
        $activityTypeList = activityTypeList();
        $row_cnt = 0;
        $userObj          = [];

        if (!empty($activityListings)) {

            foreach ($activityListings as $key => $activityListing) {

                if ($row_cnt % 2 == 0) {
                    $bgcolor = '#fff';
                } else {
                    $bgcolor = '#f9fafb';
                }

                
                if (isset($userObj[$activityListing->user_id])) {
                    $user = $userObj[$activityListing->user_id];
                } else {
                    $user                               = User::find($activityListing->user_id);
                    $userObj[$activityListing->user_id] = $user;
                }

                $firstName = '';
                $lastName = '';

                $userName                   = $activityListing->username;
                if(trim($userName)!=""){
                    $splitUserName                   = explode(' ', $userName);
                    if(count($splitUserName)>=2)
                        list($firstName, $lastName) = $splitUserName;
                    else
                        $firstName  = $userName;

                }

                $activityId[$activityListing->id] = $activityListing->id;
                $userActivity                     = Activity::find($activityListing->id);
                 
                // $certificationName                = (!empty($investor) && !empty($investor->userCertification()) && !empty($investor->getLastActiveCertification())) ? $investor->getLastActiveCertification()->certification()->name : '';
                $userType = (!empty($user) && !empty($user->roles())) ? title_case($user->roles()->pluck('display_name')->implode(' ')) : '';
                $activityMeta                     = (!empty($userActivity->meta()->first())) ? $userActivity->meta()->first()->meta_value : '';
                $firstname                        = title_case($firstName);
                $lastname                         = title_case($lastName);
                $activityName                     = (isset($activityTypeList[$activityListing->type])) ? $activityTypeList[$activityListing->type] : '';
                $date                             = (!empty($activityListing->date_recorded)) ? date('d/m/Y H:i:s', strtotime($activityListing->date_recorded)) : '';
                $description                      = (isset($activityMeta['amount invested'])) ? $activityMeta['amount invested'] : '';

                $box_img = '';

                $table_html .= "<tr style='background-color:$bgcolor;'>
                            <td style='width: 10%;'>" . $box_img . "</td>
                            <td  style='width: 15%;' align='center' ></td>
                            <td style='width: 10%;'>" . $firstname . "</td>
                            <td style='width: 10%;''>" . $lastname . "</td>
                            <td style='width: 10%;'>" . $userType . "</td>
                            <td style='width: 15%;'>" . $activityName . "</td>
                            <td style='width: 15%;'>" . $date . "</td>
                            <td style='width: 15%;' align='center' >". $description ."</td>";
                $table_html .= " 


                          </tr>";

                $row_cnt++;

            }
        } else {
            $table_html .= '<tr style="background-color:' . $bgcolor . '">
                            <td colspan="5" >No Activity Data</td>
                      </tr>';
        }

        $table_html .= '</table>';

        $html = $html . $table_html;

        return $html;
    }

}

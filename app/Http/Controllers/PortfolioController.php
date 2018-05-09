<?php

namespace App\Http\Controllers;

use App\BusinessHasDefault;
use App\BusinessInvestment;
use App\BusinessListing;
use App\User;
use DB;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {

        $requestFilters = $request->all();
        $breadcrumbs    = [];
        $breadcrumbs[]  = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[]  = ['url' => '', 'name' => 'Portfolio'];

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $user      = new User;
        $investors = $user->getInvestorUsers();

        $businessListing          = BusinessListing::where('status', 'publish')->where('business_status', 'listed')->get();
        $data['businessListings'] = $businessListing;
        $data['durationType']     = durationType();
        $data['financialYears']   = getFinancialYears();
        $data['breadcrumbs']      = $breadcrumbs;
        $data['requestFilters']   = $requestFilters;
        $data['investors']        = $investors;
        $data['firms']            = $firms;
        $data['breadcrumbs']      = $breadcrumbs;
        $data['pageTitle']        = 'Portfolio';
        $data['activeMenu']       = 'portfolio';

        return view('backoffice.portfolio.portfolio-summary')->with($data);
    }

    public function getPortfolioData(Request $request)
    {
        $filters = $request->all();

        $investmentTypeData    = $this->getInvestmentType($filters);
        $sectorAnalysis        = $this->getSectorAnalysis($filters);
        $businessStageAnalysis = $this->getBusinessStageAnalysis($filters);
        $investmentRoute       = $this->getInvestmentRoute($filters);
        $investmentTaxByYear   = $this->getInvestmentTaxByYear($filters);
        $portfolioSummary      = $this->portfolioSummary($filters);
        $topInvestments        = $this->getTopInvestments($filters);
        $investmentHtml        = $this->getInvestmentDetails($filters);

        $portfolioSummary['investmentTypeData'] = $investmentTypeData['investmentTypeData'];

        $json_data = array(
            "investmentTypeData"    => $investmentTypeData['investmentTypeAmount'],
            "sectorAnalysis"        => $sectorAnalysis,
            "businessStageAnalysis" => $businessStageAnalysis['stageData'],
            "investmentRoute"       => $investmentRoute,
            "investmentByYear"      => $investmentTaxByYear['investmentByYear'],
            "investmentTypeByYear"  => $investmentTaxByYear['investmentTypeByYear'],
            "graph"                 => $investmentTaxByYear['graph'],
            "portfolioSummary"      => $portfolioSummary,
            "topInvestmentData"     => $topInvestments,
            "investmentHtml"        => $investmentHtml['investmentHtml'],

        );

        return response()->json($json_data);

    }

    public function applyFilters($queryObj, $filters)
    {

        if (isset($filters['duration']) && $filters['duration'] != "") {
            $durationDates = getDateByPeriod($filters['duration']);
            $queryObj->where(DB::raw('DATE_FORMAT(business_investments.created_at, "%Y-%m-%d")'), '>=', $durationDates['fromDate']);
            $queryObj->where(DB::raw('DATE_FORMAT(business_investments.created_at, "%Y-%m-%d")'), '<=', $durationDates['toDate']);
        }

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
            $queryObj->where(DB::raw('DATE_FORMAT(business_investments.created_at, "%Y-%m-%d")'), '>=', $fromDate);
            $queryObj->where(DB::raw('DATE_FORMAT(business_investments.created_at, "%Y-%m-%d")'), '<=', $toDate);
        }

        if (isset($filters['tax_year']) && $filters['tax_year'] != "") {
            $arg['year']   = $filters['tax_year'];
            $durationDates = getDateByPeriod('financialyr', $arg);
            $queryObj->where(DB::raw('DATE_FORMAT(business_investments.created_at, "%Y-%m-%d")'), '>=', $durationDates['fromDate']);
            $queryObj->where(DB::raw('DATE_FORMAT(business_investments.created_at, "%Y-%m-%d")'), '<=', $durationDates['toDate']);
        }

        if (isset($filters['firmid']) && $filters['firmid'] != "") {
            $queryObj->leftjoin('users', function ($join) {
                $join->on('business_listings.owner_id', 'users.id');
            })->where('users.firm_id', $filters['firmid']);
        }

        if (isset($filters['investor']) && $filters['investor'] != "") {
            $queryObj->where('business_investments.investor_id', $filters['investor']);
        }

        if (isset($filters['company']) && $filters['company'] != "") {
            $queryObj->where('business_listings.id', $filters['company']);
        }

        if (isset($filters['asset_status']) && $filters['asset_status'] != "") {
            $queryObj->where('business_investments.aic_gi', $filters['asset_status']);
        }

        return $queryObj;
    }

    public function getInvestmentType($filters)
    {
        $businessListingQry = BusinessListing::select(\DB::raw('business_listings.*, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        });

        $businessListings = $this->applyFilters($businessListingQry, $filters)->groupBy('business_listings.id')->get();

        $totalSeis       = 0;
        $totalEis        = 0;
        $totalVct        = 0;
        $totalIht        = 0;
        $totalSeisAmount = 0;
        $totalEisAmount  = 0;
        $totalVctAmount  = 0;
        $totalIhtAmount  = 0;

        foreach ($businessListings as $key => $businessListing) {

            if (!empty($businessListing->tax_status) && in_array('SEIS', $businessListing->tax_status)) {
                $totalSeisAmount += $businessListing->amount_raised;
                $totalSeis += 1;
            }

            if (!empty($businessListing->tax_status) && in_array('EIS', $businessListing->tax_status)) {
                $totalEis += 1;
                $totalEisAmount += $businessListing->amount_raised;
            }

            if (!empty($businessListing->tax_status) && in_array('VCT', $businessListing->tax_status)) {
                $totalVct += 1;
                $totalVctAmount += $businessListing->amount_raised;
            }

            if (!empty($businessListing->tax_status) && in_array('IHT', $businessListing->tax_status)) {
                $totalIht += 1;
                $totalIhtAmount += $businessListing->amount_raised;
            }
        }

        $investmentTypeAmount = [
            ['Investmenttype' => 'seis', 'amount' => $totalSeisAmount],
            ['Investmenttype' => 'eis', 'amount' => $totalEisAmount],
            ['Investmenttype' => 'vct', 'amount' => $totalVctAmount],
            ['Investmenttype' => 'iht', 'amount' => $totalIhtAmount],
        ];

        $investmentTypeData = ['seis_count' => $totalSeis, 'seis_amount' => format_amount($totalSeisAmount, 0, true), 'eis_count' => $totalEis, 'eis_amount' => format_amount($totalEisAmount, 0, true), 'vct_count' => $totalVct, 'vct_amount' => format_amount($totalVctAmount, 0, true), 'iht_count' => $totalIhtAmount, 'iht_amount' => format_amount($totalIhtAmount, 0, true)];

        return ['investmentTypeAmount' => $investmentTypeAmount, 'investmentTypeData' => $investmentTypeData];
    }

    public function getSectorAnalysis($filters)
    {
        $sectorData      = [];
        $businessSectors = getBusinessSectors();
        $sectorNames     = [];
        foreach ($businessSectors as $key => $businessSector) {
            $sectorNames[$businessSector->id] = $businessSector->name;
        }

        $sectorIds          = array_keys($sectorNames);
        $businessListingQry = BusinessHasDefault::select(\DB::raw('business_has_defaults.default_id as defaultid, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_listings', function ($join) {
            $join->on('business_has_defaults.business_id', 'business_listings.id')->where('business_listings.status', 'publish');
        })->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->whereIn('business_has_defaults.default_id', $sectorIds);

        $businessListings = $this->applyFilters($businessListingQry, $filters)->groupBy('business_has_defaults.default_id')->orderBy('amount_raised', 'desc')->get();

        $data      = [];
        $sectorAmt = [];
        $allOthers = 0;
        foreach ($businessListings as $key => $businessListing) {
            $defaultId  = $businessListing->defaultid;
            $sectorName = $sectorNames[$defaultId];

            $amount = (!empty($businessListing->amount_raised)) ? $businessListing->amount_raised : 0;
            if ($key < 10) {
                $data[] = ['sectortype' => $sectorName, 'amount' => $amount];
            } else {
                $allOthers += $amount;
            }

        }

        if ($allOthers > 0) {
            $data[] = ['sectortype' => 'All Others', 'amount' => $allOthers];
        }
        return $data;

    }

    public function getBusinessStageAnalysis($filters)
    {
        $stageData       = [];
        $stageOfBusiness = getStageOfBusiness();
        $stageNames      = [];
        foreach ($stageOfBusiness as $key => $stageOfBusines) {
            $stageNames[$stageOfBusines->id] = $stageOfBusines->name;
        }

        $stageIds           = array_keys($stageNames);
        $businessListingQry = BusinessHasDefault::select(\DB::raw('business_has_defaults.default_id as defaultid, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_listings', function ($join) {
            $join->on('business_has_defaults.business_id', 'business_listings.id')->where('business_listings.status', 'publish');
        })->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->whereIn('business_has_defaults.default_id', $stageIds);

        $businessListings = $this->applyFilters($businessListingQry, $filters)->groupBy('business_has_defaults.default_id')->orderBy('amount_raised', 'desc')->get();

        $data      = [];
        $sectorAmt = [];

        $totalAmount = 0;
        foreach ($businessListings as $key => $businessListing) {
            $defaultId = $businessListing->defaultid;
            $stageName = $stageNames[$defaultId];

            $amount = (!empty($businessListing->amount_raised)) ? $businessListing->amount_raised : 0;
            $totalAmount += $amount;

            $data[] = ['stage' => $stageName, 'amount' => $amount];

        }

        return ['stageData' => $data, 'total_amount' => $totalAmount];

    }

    public function getInvestmentRoute($filters)
    {
        $businessListingQry = BusinessListing::select(\DB::raw('business_listings.type, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        });

        $businessListings = $this->applyFilters($businessListingQry, $filters)->groupBy('business_listings.type')->get();

        $data = [];

        foreach ($businessListings as $key => $businessListing) {
            $investmenttype = title_case($businessListing->type);
            $amount         = (!empty($businessListing->amount_raised)) ? $businessListing->amount_raised : 0;

            $data[] = ['investmenttype' => $investmenttype, 'amount' => $amount];

        }

        return $data;

    }

    public function getInvestmentTaxByYear($filters)
    {
        $businessListingQry = BusinessListing::select(\DB::raw('business_listings.*, business_investments.created_at as invested_date, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        });

        $businessListings = $this->applyFilters($businessListingQry, $filters)->groupBy('business_listings.id')->orderBy('business_investments.created_at', 'desc')->get();

        $data                 = [];
        $investmentByYear     = [];
        $investmentTypeByYear = [];
        foreach ($businessListings as $key => $businessListing) {

            $investedDate   = date("m/d/y", strtotime($businessListing->invested_date));
            $investedAmount = $businessListing->amount_raised;
            $fyear          = calculateFiscalYearForDate($investedDate, "4/6", "4/5"); //
            if (!isset($sub_arr[$fyear])) {
                $investmentByYear[$fyear] = 0;
            }

            $investmentByYear[$fyear] += $investedAmount;

            if (!empty($businessListing->tax_status) && in_array('SEIS', $businessListing->tax_status)) {
                if (!isset($sub_arr[$fyear])) {
                    $investmentTypeByYear[$fyear]['SEIS'] = 0;
                }

                $investmentTypeByYear[$fyear]['SEIS'] += $businessListing->amount_raised;
            }

            if (!empty($businessListing->tax_status) && in_array('EIS', $businessListing->tax_status)) {
                if (!isset($sub_arr[$fyear])) {
                    $investmentTypeByYear[$fyear]['EIS'] = 0;
                }

                $investmentTypeByYear[$fyear]['EIS'] += $businessListing->amount_raised;
            }

            if (!empty($businessListing->tax_status) && in_array('EIS', $businessListing->tax_status)) {
                if (!isset($sub_arr[$fyear])) {
                    $investmentTypeByYear[$fyear]['VCT'] = 0;
                }

                $investmentTypeByYear[$fyear]['VCT'] += $businessListing->amount_raised;
            }

            if (!empty($businessListing->tax_status) && in_array('IHT', $businessListing->tax_status)) {
                if (!isset($sub_arr[$fyear])) {
                    $investmentTypeByYear[$fyear]['IHT'] = 0;
                }

                $investmentTypeByYear[$fyear]['IHT'] += $businessListing->amount_raised;
            }
        }

        $investmentByYearData = [];
        foreach ($investmentByYear as $year => $amount) {
            $investmentByYearData[] = ['year' => $year, 'amount' => $amount];
        }

        $investmentTypeByYearData = [];
        foreach ($investmentTypeByYear as $year => $investmentAmount) {
            $investmentAmount['year']   = $year;
            $investmentTypeByYearData[] = $investmentAmount;
        }

        $graph = [
            ["balloonText" => "SEIS:[[value]]",
                "fillAlphas"   => 0.8,
                "id"           => "AmGraph-SEIS",
                "lineAlpha"    => 0.2,
                "title"        => "SEIS",
                "type"         => "column",
                "valueField"   => "SEIS"],

            ["balloonText" => "EIS:[[value]]",
                "fillAlphas"   => 0.8,
                "id"           => "AmGraph-EIS",
                "lineAlpha"    => 0.2,
                "title"        => "EIS",
                "type"         => "column",
                "valueField"   => "EIS"],

            ["balloonText" => "VCT:[[value]]",
                "fillAlphas"   => 0.8,
                "id"           => "AmGraph-VCT",
                "lineAlpha"    => 0.2,
                "title"        => "VCT",
                "type"         => "column",
                "valueField"   => "VCT"],

            ["balloonText" => "IHT:[[value]]",
                "fillAlphas"   => 0.8,
                "id"           => "AmGraph-IHT",
                "lineAlpha"    => 0.2,
                "title"        => "IHT",
                "type"         => "column",
                "valueField"   => "IHT"]];

        return ['investmentTypeByYear' => $investmentTypeByYearData, 'investmentByYear' => $investmentByYearData, 'graph' => $graph];

    }

    public function portfolioSummary($filters)
    {

        $businessListingQry = BusinessListing::select(\DB::raw('business_listings.*,
            SUM(CASE business_investments.status WHEN "funded" THEN 1 ELSE 0 END) as invested_count,
            SUM(CASE business_investments.status WHEN "watch_list" THEN 1 ELSE 0 END) as watchlist_count,
            SUM(CASE business_investments.status WHEN "funded" THEN business_investments.amount ELSE 0 END) as invested,
            SUM(CASE  WHEN business_investments.status="pledged" and business_investments.details like "%ready-to-invest%" THEN business_investments.amount ELSE 0 END) as pledged '))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->whereIn('business_investments.status', ['pledged', 'funded', 'watchlist_count']);
        });

        $businessListingQuery = $this->applyFilters($businessListingQry, $filters)->first();

        if (!empty($businessListingQuery)) {
            return ['cash_amount' => 0, 'invested_count' => $businessListingQuery->invested_count, 'watchlist_count' => $businessListingQuery->invested_count, 'invested' => format_amount($businessListingQuery->invested, 0, true), 'pledged' => format_amount($businessListingQuery->pledged, 0, true)];
        } else {
            return false;
        }

    }

    public function getTopInvestments($filters)
    {
        $businessListingQry = BusinessListing::select(\DB::raw('business_listings.id,business_listings.gi_code,business_listings.title, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        });

        $businessListings = $this->applyFilters($businessListingQry, $filters)->groupBy('business_listings.id')->orderBy('amount_raised', 'desc')->take('5')->get();

        $totalInvestmentQry = BusinessListing::select(\DB::raw('SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        });

        $totalInvestment = $this->applyFilters($totalInvestmentQry, $filters)->first();

        $topInvestments = [];
        foreach ($businessListings as $key => $businessListing) {

            $topInvestments[] = ['gi_code' => $businessListing->gi_code, 'title' => $businessListing->title, 'id' => $businessListing->id, 'formated_amount' => format_amount($businessListing->amount_raised, 0, true), 'amount' => $businessListing->amount_raised];

        }
        $data = ['topInvestments' => $topInvestments, 'totalInvestment' => $totalInvestment->amount_raised];

        return $data;

    }

    public function getInvestmentDetails($filters)
    {
        $businessInvestmentQry = BusinessInvestment::select(\DB::raw('business_listings.title as investmentname,business_listings.gi_code as investmentgicode,business_investments.amount as investmentamount, business_investments.amount,business_investments.additional_details as investment_additional_details,CONCAT(investor.first_name," ",investor.last_name) as investorname,investor.gi_code as investorgicode'))->leftjoin('business_listings', function ($join) {
            $join->on('business_investments.business_id', 'business_listings.id');
        })->leftjoin('users as investor', function ($join) {
            $join->on('business_investments.investor_id', 'investor.id');
        });

        $businessInvestments = $this->applyFilters($businessInvestmentQry, $filters)->orderBy('business_investments.created_at', 'desc')->get();

        $tdHtml         = '';
        $grandTotal     = 0;
        $investmentList = [];
        foreach ($businessInvestments as $key => $businessInvestment) {
            $additionalDetails = $businessInvestment->investment_additional_details;
            $noofShares        = '-';
            $shareIssuePrice   = '-';
            $shareIssueDate    = '-';
            $revaluationDate   = '-';
            $currSharePrice    = 0;
            $totalCompanyValue = 0;
            $subTotal          = 0;

            if (!empty($additionalDetails)) {
                $additionalDetails = unserialize($additionalDetails);
                $noofShares        = (isset($additionalDetails['shares']) && $additionalDetails['shares'] != '') ? $additionalDetails['shares'] : '-';

                $shareIssuePrice = (isset($additionalDetails['share_issue_price'])) ? $additionalDetails['share_issue_price'] : '-';
                $shareIssueDate  = (isset($additionalDetails['share_issue_date']) && !empty($additionalDetails['share_issue_date'])) ? date('d/m/Y', strtotime($additionalDetails['share_issue_date'])) : '-';
                $revaluationDate = (isset($additionalDetails['revaluation_date']) && !empty($additionalDetails['revaluation_date'])) ? date('d/m/Y', strtotime($additionalDetails['revaluation_date'])) : '-';
            }

            $noofSharesVal = ($noofShares != '') ? intval($noofShares) : 0;
            $subTotal      = $noofSharesVal * $currSharePrice;

            $grandTotal = $grandTotal + $subTotal;

            $investmentList[] = [
                'investorgicode'    => $businessInvestment->investorgicode,
                'investorname'      => $businessInvestment->investorname,
                'investmentgicode'  => $businessInvestment->investmentgicode,
                'investmentname'    => $businessInvestment->investmentname,
                'investmentamount'  => $businessInvestment->investmentamount,
                'noofShares'        => $noofShares,
                'shareIssuePrice'   => $shareIssuePrice,
                'shareIssueDate'    => $shareIssueDate,
                'revaluationDate'   => $revaluationDate,
                'currSharePrice'    => $currSharePrice,
                'totalCompanyValue' => $totalCompanyValue,
                'subTotal'          => $subTotal,
            ];

            $tdHtml .= '<tr><td>' . $businessInvestment->investmentgicode . '</td>
                            <td>' . $businessInvestment->investorname . '</td>
                            <td>' . $businessInvestment->investmentname . '</td>
                            <td>' . format_amount($businessInvestment->investmentamount, 0, true) . '</td>
                            <td>' . $noofShares . '</td>
                            <td>' . $shareIssuePrice . '</td>
                            <td>' . $shareIssueDate . '</td>
                            <td>' . $revaluationDate . '</td>
                            <td>' . $currSharePrice . '</td>
                            <td>' . $totalCompanyValue . '</td>
                            <td>' . $subTotal . '</td>
                        </tr>';
        }

        $tdHtml .= '<tr><td  colspan="10"></td><td>' . $grandTotal . '</td></tr>';

        return ['investmentHtml' => $tdHtml, 'investmentList' => $investmentList, 'grandTotal' => $grandTotal];
    }

    public function exportPortfolioReportXlsx(Request $request)
    {

        $filters = $request->all();

        $investmentTypeData    = $this->getInvestmentType($filters);
        $sectorAnalysis        = $this->getSectorAnalysis($filters);
        $businessStageAnalysis = $this->getBusinessStageAnalysis($filters);
        $investmentTaxByYear   = $this->getInvestmentTaxByYear($filters);
        $topInvestments        = $this->getTopInvestments($filters);
        $investmentData        = $this->getInvestmentDetails($filters);

        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Prajay Verenkar')
            ->setTitle('Portfolio')
            ->setSubject('Portfolio')
            ->setDescription('Portfolio Report');

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('list_of_invested_proposals');
        // header
        $headers = ['User Platform GI Code', 'Investor Name', 'Proposal Platform GI Code', 'Trading Name ', 'Amount', 'No. of Shares', 'Share Issue Price', 'Share Issue Date', 'Revaluation Date', 'Current Share Price', 'Total Valuation', 'Total'];

        $col = 'A';
        foreach ($headers as $header) {
            $spreadsheet->getActiveSheet()->setCellValue($col . '1', $header);
            $col++;
        }

        $investmentList   = $investmentData['investmentList'];
        $grandTotal       = $investmentData['grandTotal'];
        $investmentList[] = ['', '', '', '', '', '', '', '', '', '', 'Grand Total', $grandTotal];

        $i = 2;
        foreach ($investmentList as $key => $investment) {
            $col = 'A';

            foreach ($investment as $key => $value) {
                $spreadsheet->getActiveSheet()->setCellValue($col . $i, $value);
                $col++;
            }
            $i++;
        }

        // business_stage_summ

        // Create a new worksheet, after the default sheet
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);

        $spreadsheet->getActiveSheet()->setTitle('business_stage_summ');
        $header2 = array('Business Sector Name', 'Percentage');

        $col = 'A';
        foreach ($header2 as $header) {
            $spreadsheet->getActiveSheet()->setCellValue($col . '1', $header);
            $col++;
        }
        $stageData   = $businessStageAnalysis['stageData'];
        $totalAmount = $businessStageAnalysis['total_amount'];

        $i = 2;
        foreach ($stageData as $key => $stage) {
            $perc = round($stage['amount'] / $totalAmount * 100);

            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $stage['stage']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $perc);
            $i++;
        }

        // portfolio_tax_allocation
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2);
        $spreadsheet->getActiveSheet()->setTitle('portfolio_tax_allocation');
        $header3 = array('Name', 'Value');
        $col     = 'A';
        foreach ($header3 as $header) {
            $spreadsheet->getActiveSheet()->setCellValue($col . '1', $header);
            $col++;
        }

        $investmentTypeAmount      = $investmentTypeData['investmentTypeAmount'];
        $investmentTypeAmountTotal = 0;
        foreach ($investmentTypeAmount as $key => $investmentTypeAmountVal) {
            $investmentTypeAmountTotal += $investmentTypeAmountVal['amount'];
        }

        $i = 2;
        foreach ($investmentTypeAmount as $key => $investmentType) {
            $perc = $investmentType['amount'] / $investmentTypeAmountTotal * 100;

            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $investmentType['Investmenttype']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $perc);
            $i++;
        }

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(3);
        $spreadsheet->getActiveSheet()->setTitle('busines_sector_summ');
        $header4 = array('Type of Sector', 'Percentage');
        $col     = 'A';
        foreach ($header4 as $header) {
            $spreadsheet->getActiveSheet()->setCellValue($col . '1', $header);
            $col++;
        }

        $sectorAnalysisTotal = 0;
        foreach ($sectorAnalysis as $key => $sector) {
            $sectorAnalysisTotal += $sector['amount'];
        }

        $i = 2;
        foreach ($sectorAnalysis as $key => $sector) {
            $perc = $sector['amount'] / $sectorAnalysisTotal * 100;

            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $sector['sectortype']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $perc);
            $i++;
        }

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(4);
        $spreadsheet->getActiveSheet()->setTitle('top_funding_summary');
        $header5 = array('Platform GI Code', 'Proposal Name', 'Percentage', 'Amount Invested');
        $col     = 'A';
        foreach ($header5 as $header) {
            $spreadsheet->getActiveSheet()->setCellValue($col . '1', $header);
            $col++;
        }

        $topInvestmentList = $topInvestments['topInvestments'];
        $totalInvestments  = $topInvestments['totalInvestment'];

        $i = 2;
        foreach ($topInvestmentList as $key => $topInvestment) {
            $perc = $topInvestment['amount'] / $totalInvestments * 100;

            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $topInvestment['gi_code']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $topInvestment['title']);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $perc);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $i, $topInvestment['amount']);
            $i++;
        }

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(5);
        $spreadsheet->getActiveSheet()->setTitle('tax_year_breakdown');
        $header6 = array('Financial Year', 'Amount');
        $col     = 'A';

        foreach ($header6 as $header) {
            $spreadsheet->getActiveSheet()->setCellValue($col . '1', $header);
            $col++;
        }
        $investmentByYear = $investmentTaxByYear['investmentByYear'];

        $i = 2;
        foreach ($investmentByYear as $key => $investment) {

            $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $investment['year']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $investment['amount']);
            $i++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="portfolio-dashboard-data.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}

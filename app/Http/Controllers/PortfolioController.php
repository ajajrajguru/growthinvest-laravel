<?php

namespace App\Http\Controllers;

use App\BusinessHasDefault;
use App\BusinessInvestment;
use App\BusinessListing;
use App\User;
use Illuminate\Http\Request;

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

        $user           = new User;
        $backofficeUser = $user->backofficeUsers();

        $businessListing          = BusinessListing::where('status', 'publish')->where('business_status', 'listed')->get();
        $data['businessListings'] = $businessListing;
        $data['durationType']     = durationType();
        $data['breadcrumbs']      = $breadcrumbs;
        $data['requestFilters']   = $requestFilters;
        $data['backofficeUsers']  = $backofficeUser;
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
            "businessStageAnalysis" => $businessStageAnalysis,
            "investmentRoute"       => $investmentRoute,
            "investmentByYear"      => $investmentTaxByYear['investmentByYear'],
            "investmentTypeByYear"  => $investmentTaxByYear['investmentTypeByYear'],
            "graph"                 => $investmentTaxByYear['graph'],
            "portfolioSummary"      => $portfolioSummary,
            "topInvestmentData"     => $topInvestments,
            "investmentHtml"        => $investmentHtml,

        );

        return response()->json($json_data);

    }

    public function getInvestmentType($filters)
    {
        $businessListings = BusinessListing::select(\DB::raw('business_listings.*, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->groupBy('business_listings.id')->get();

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
            ['Investmenttype' => 'seis',
                'amount'          => $totalSeisAmount],
            ['Investmenttype' => 'eis',
                'amount'          => $totalEisAmount],
            ['Investmenttype' => 'vct',
                'amount'          => $totalVctAmount],
            ['Investmenttype' => 'iht',
                'amount'          => $totalIhtAmount],
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

        $sectorIds        = array_keys($sectorNames);
        $businessListings = BusinessHasDefault::select(\DB::raw('business_has_defaults.default_id as defaultid, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_listings', function ($join) {
            $join->on('business_has_defaults.business_id', 'business_listings.id')->where('business_listings.status', 'publish');
        })->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->whereIn('business_has_defaults.default_id', $sectorIds)->groupBy('business_has_defaults.default_id')->orderBy('amount_raised', 'desc')->get();

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

        $stageIds         = array_keys($stageNames);
        $businessListings = BusinessHasDefault::select(\DB::raw('business_has_defaults.default_id as defaultid, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_listings', function ($join) {
            $join->on('business_has_defaults.business_id', 'business_listings.id')->where('business_listings.status', 'publish');
        })->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->whereIn('business_has_defaults.default_id', $stageIds)->groupBy('business_has_defaults.default_id')->orderBy('amount_raised', 'desc')->get();

        $data      = [];
        $sectorAmt = [];
        $allOthers = 0;
        foreach ($businessListings as $key => $businessListing) {
            $defaultId = $businessListing->defaultid;
            $stageName = $stageNames[$defaultId];

            $amount = (!empty($businessListing->amount_raised)) ? $businessListing->amount_raised : 0;

            $data[] = ['stage' => $stageName, 'amount' => $amount];

        }

        return $data;

    }

    public function getInvestmentRoute($filters)
    {
        $businessListings = BusinessListing::select(\DB::raw('business_listings.type, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->groupBy('business_listings.type')->get();

        foreach ($businessListings as $key => $businessListing) {
            $investmenttype = title_case($businessListing->type);
            $amount         = (!empty($businessListing->amount_raised)) ? $businessListing->amount_raised : 0;

            $data[] = ['investmenttype' => $investmenttype, 'amount' => $amount];

        }

        return $data;

    }

    public function getInvestmentTaxByYear($filters)
    {
        $businessListings = BusinessListing::select(\DB::raw('business_listings.*, business_investments.created_at as invested_date, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->groupBy('business_listings.id')->orderBy('business_investments.created_at', 'desc')->get();

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

        $businessListingQuery = BusinessListing::select(\DB::raw('business_listings.*,
    		SUM(CASE business_investments.status WHEN "funded" THEN 1 ELSE 0 END) as invested_count,
    		SUM(CASE business_investments.status WHEN "watch_list" THEN 1 ELSE 0 END) as watchlist_count,
    		SUM(CASE business_investments.status WHEN "funded" THEN business_investments.amount ELSE 0 END) as invested,
    		SUM(CASE  WHEN business_investments.status="pledged" and business_investments.details like "%ready-to-invest%" THEN business_investments.amount ELSE 0 END) as pledged '))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->whereIn('business_investments.status', ['pledged', 'funded', 'watchlist_count']);
        })->first();

        if (!empty($businessListingQuery)) {
            return ['cash_amount' => 0, 'invested_count' => $businessListingQuery->invested_count, 'watchlist_count' => $businessListingQuery->invested_count, 'invested' => format_amount($businessListingQuery->invested, 0, true), 'pledged' => format_amount($businessListingQuery->pledged, 0, true)];
        } else {
            return false;
        }

    }

    public function getTopInvestments($filters)
    {
        $businessListings = BusinessListing::select(\DB::raw('business_listings.id,business_listings.gi_code,business_listings.title, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->groupBy('business_listings.id')->orderBy('amount_raised', 'desc')->take('5')->get();

        $totalInvestment = BusinessListing::select(\DB::raw('SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->where('business_investments.status', 'funded');
        })->first();

        $topInvestments = [];
        foreach ($businessListings as $key => $businessListing) {

            $topInvestments[] = ['gi_code' => $businessListing->gi_code, 'title' => $businessListing->title, 'id' => $businessListing->id, 'formated_amount' => format_amount($businessListing->amount_raised, 0, true), 'amount' => $businessListing->amount_raised];

        }
        $data = ['topInvestments' => $topInvestments, 'totalInvestment' => $totalInvestment->amount_raised];

        return $data;

    }

    public function getInvestmentDetails($filters)
    {
        $businessInvestments = BusinessInvestment::select(\DB::raw('business_listings.title as investmentname,business_listings.gi_code as investmentgicode,business_investments.amount as investmentamount, business_investments.amount,business_investments.additional_details as investment_additional_details,CONCAT(investor.first_name," ",investor.last_name) as investorname'))->leftjoin('business_listings', function ($join) {
            $join->on('business_investments.business_id', 'business_listings.id');
        })->leftjoin('users as investor', function ($join) {
            $join->on('business_investments.investor_id', 'investor.id');
        })->orderBy('business_investments.created_at', 'desc')->get();

        $tdHtml = '';
        $grandTotal  = 0;

        foreach ($businessInvestments as $key => $businessInvestment) {
        	$additionalDetails =  $businessInvestment->investment_additional_details;
        	$noofShares = '-';
        	$shareIssuePrice = '-';
        	$shareIssueDate = '-';
        	$revaluationDate = '-';
        	$currSharePrice = 0;
        	$totalCompanyValue = 0;
        	$subTotal = 0;
        	 
        	if(!empty($additionalDetails)){
        		$additionalDetails = unserialize($additionalDetails);
        		$noofShares = (isset($additionalDetails['shares']) && $additionalDetails['shares']!='') ? $additionalDetails['shares']:'-';
        		
        		$shareIssuePrice = (isset($additionalDetails['share_issue_price'])) ? $additionalDetails['share_issue_price']:'-';
        		$shareIssueDate = (isset($additionalDetails['share_issue_date']) && !empty($additionalDetails['share_issue_date'])) ? date('d/m/Y',strtotime($additionalDetails['share_issue_date'])):'-';
        		$revaluationDate = (isset($additionalDetails['revaluation_date']) && !empty($additionalDetails['revaluation_date'])) ? date('d/m/Y',strtotime($additionalDetails['revaluation_date'])):'-';
        	}

        	$noofSharesVal = ($noofShares!='') ? intval($noofShares):0;
        	$subTotal = $noofSharesVal * $currSharePrice;

        	$grandTotal  = $grandTotal + $subTotal;

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

        return $tdHtml;
    }
}

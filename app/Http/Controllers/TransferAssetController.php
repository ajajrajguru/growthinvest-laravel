<?php

namespace App\Http\Controllers;

use App\AdobeSignature;
use App\Company;
use App\TransferAsset;
use App\TransferAssetMeta;
use App\TransferAssetPdfHtml;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spipu\Html2Pdf\Html2Pdf;
use View;

class TransferAssetController extends Controller
{
    public function transferAsset()
    {

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Transfer Asset'];

        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Transfer Asset';
        $data['activeMenu']  = 'transferassets';

        return view('backoffice.transfer-asset.transfer-asset')->with($data);
    }

    public function offlineTransferAsset()
    {

        $investor = new User;

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Transfer Asset'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Offline Transfer Asset'];

        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Offline Transfer Asset';
        $data['activeMenu']  = 'transferassets';

        return view('backoffice.transfer-asset.offline-transfer-asset')->with($data);
    }

    public function onlineTransferAsset()
    {

        $investor     = new User;
        $investors    = $investor->getInvestorUsers();
        $typeOfAssets = typeOfAssets();
        $companies    = Company::where('deleted', 0)->get();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Transfer Asset'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Online Transfer Asset'];

        $data['single_companies'] = $companies->where("type", "single_company");
        $data['other_companies']  = $companies->where("type", '!=', "single_company");
        $data['investors']        = $investors;
        $data['typeOfAssets']     = $typeOfAssets;
        $data['transferType']     = ['full' => 'In Full', 'part' => 'In Part'];
        $data['breadcrumbs']      = $breadcrumbs;
        $data['pageTitle']        = 'Online Transfer Asset';
        $data['activeMenu']       = 'transferassets';

        return view('backoffice.transfer-asset.online-transfer-asset')->with($data);
    }

    public function getInvestorAssets(Request $request)
    {
        $requestData = $request->all();
        $investor    = $requestData['investor_id'];

        $transferassets = TransferAsset::where('investor_id', $investor)->where('deleted', 0)->get();

        $businesslistingHtml = View::make('backoffice.transfer-asset.investor-assets', compact('transferassets'))->render();

        $json_data = array(
            'status'               => true,
            'businesslisting_html' => $businesslistingHtml,

        );

        return response()->json($json_data);

    }

    public function saveAssetStatus(Request $request)
    {
        $requestData = $request->all();
        $assetid     = $requestData['assetid'];
        $status      = $requestData['status'];

        $transferasset  = TransferAsset::find($assetid);
        $responseStatus = false;

        if (!empty($transferasset)) {
            $transferasset->status = $status;
            $transferasset->save();
            $responseStatus = true;
        }

        $json_data = array(
            'status' => $responseStatus,

        );

        return response()->json($json_data);
    }

    public function deleteAsset(Request $request)
    {
        $requestData = $request->all();
        $assetid     = $requestData['assetid'];

        $transferasset  = TransferAsset::find($assetid);
        $responseStatus = false;

        if (!empty($transferasset)) {
            $transferasset->deleted = 1;
            $transferasset->save();
            $responseStatus = true;
        }

        $json_data = array(
            'status' => $responseStatus,

        );

        return response()->json($json_data);
    }

    public function saveOnlineTransferAsset(Request $request)
    {
        $requestData = $request->all();
        $investorId  = $requestData['investor'];
        $typeOfAsset = $requestData['type_of_asset'];

        if ($typeOfAsset == "single_company") {
            $companyId = $requestData['companies'];
            $details   = $requestData['company'];
        } else {
            $companyId = $requestData['providers'];
            $details   = $requestData['provider'];
        }

        $transferAsset              = new TransferAsset;
        $transferAsset->investor_id = $investorId;
        $transferAsset->typeofasset = $typeOfAsset;
        $transferAsset->companyid   = $companyId;
        $transferAsset->details     = $details;
        $transferAsset->status      = '';
        $transferAsset->save();

        if (isset($requestData['transferasset_file_path']) && !empty($requestData['transferasset_file_path'])) {

            $files = $requestData['transferasset_file_path'];
            foreach ($files as $key => $file) {

                $source   = pathinfo($file);
                $basename = $source['basename'];

                $currentPath  = public_path() . '/uploads/tmp/' . $basename;
                $uploadedFile = new UploadedFile($currentPath, $basename);

                $id = $transferAsset->uploadFile($uploadedFile, false, $basename);
                $transferAsset->remapFiles([$id], 'transferasset');

                //delete temp file
                if (File::exists($file)) {
                    File::delete($file);
                }
            }
        }

        return redirect(url('backoffice/transfer-asset/online/' . $transferAsset->id));

    }

    public function onlineTransferAssetSummary($id)
    {
        $transferasset = TransferAsset::find($id);

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Transfer Asset'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Online Transfer Asset'];

        $data['transferasset'] = $transferasset;
        $data['breadcrumbs']   = $breadcrumbs;
        $data['pageTitle']     = 'Online Transfer Asset';
        $data['activeMenu']    = 'transferassets';

        return view('backoffice.transfer-asset.online-transfer-asset-summary')->with($data);

    }

    public function downloadTransferAsset($id, $type)
    {

        $transferasset = TransferAsset::find($id);

        if (empty($transferasset)) {
            abort(404);
        }

        $transferAssetPdf            = new TransferAssetPdfHtml();
        $additionalArgs['pdfaction'] = '';
        $pdfTitle                    = '';

        if ($type == 'transfer_asset_pdf') {
            $html     = $transferAssetPdf->getHtmlForTransferAssetPdf($transferasset, $additionalArgs);
            $pdfTitle = 'Transfer Assets Form ';
        } elseif ($type == 'stock_transfer_form') {
            $html     = $transferAssetPdf->getHtmlForStockTransferPdf($transferasset, $additionalArgs);
            $pdfTitle = 'Stock Transfer Form';
        } elseif ($type == 'letter_of_authority_pdf') {
            $html     = $transferAssetPdf->getHtmlForLetterOfAuthorityPdf($transferasset, $additionalArgs);
            $pdfTitle = 'Letter Of Authority';
        }

        $now_date = date('d-m-Y', time());

        $file_name = $pdfTitle . '  - ' . $now_date . '.pdf';

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($html, isset($_GET['vuehtml']));

        $html2pdf->Output($file_name);

    }

    public function adobeSignataureTransferAsset(Request $request)
    {
        $id             = $request->input('assetid');
        $type           = $request->input('assettype');
        $transferasset  = TransferAsset::find($id);
        $investor       = $transferasset->investor;
        $responseStatus = false;
        if (empty($transferasset)) {
            abort(404);
        }

        $docKeys = ['transfer_asset_pdf' => 'transferasset_dockey', 'stock_transfer_form' => 'stocktransfer_dockey', 'letter_of_authority_pdf' => 'authletter_dockey'];
        $docKey  = $docKeys[$type];

        $transferassetData = $transferasset->transferAssetMeta()->where('meta_key', $docKey)->first();
        if (empty($transferassetData) || $transferassetData->meta_value == "") {

            $transferAssetPdf            = new TransferAssetPdfHtml();
            $additionalArgs['pdfaction'] = 'esign';
            $pdfTitle                    = '';
            $now_date                    = date('d-m-Y', time());

            $tmp_foldername  = "tmp_transferassets";
            $foldername      = uniqid("ab1234cde_folder1_a932_");
            $destination_dir = public_path() . '/userdocs/' . $tmp_foldername . '/' . $foldername;

            if (!file_exists(public_path() . '/userdocs/' . $tmp_foldername)) {

                mkdir(public_path() . '/userdocs/' . $tmp_foldername);

            }

            if ($type == 'transfer_asset_pdf') {
                $html = $transferAssetPdf->getHtmlForTransferAssetPdf($transferasset, $additionalArgs);

                $output_link       = $destination_dir . '/Transfer_Asset_pdf_' . $now_date . '.pdf';
                $callbackurl       = url('transferasset/adobe/signed-doc-callback') . '?type=transferasset&cat=transferasset';
                $adobesign_message = "Please sign the Transfer Asset document";
                $adobesign_name    = "Transfer Asset Form";

            } elseif ($type == 'stock_transfer_form') {
                $html              = $transferAssetPdf->getHtmlForStockTransferPdf($transferasset, $additionalArgs);
                $output_link       = $destination_dir . '/stock_transfer_pdf_' . $now_date . '.pdf';
                $callbackurl       = url('transferasset/adobe/signed-doc-callback') . '?type=transferasset&cat=stock_transfer_form';
                $adobesign_message = "Please sign Stock Transfer document";
                $adobesign_name    = "Stock Transfer Form";

            } elseif ($type == 'letter_of_authority_pdf') {
                $html              = $transferAssetPdf->getHtmlForLetterOfAuthorityPdf($transferasset, $additionalArgs);
                $output_link       = $destination_dir . '/letter_of_authority_pdf_' . $now_date . '.pdf';
                $callbackurl       = url('transferasset/adobe/signed-doc-callback') . '?type=transferasset&cat=letter_of_authority';
                $adobesign_message = "Please sign Letter Of Authority document";
                $adobesign_name    = "Letter Of Authority";
            }

            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($html, isset($_GET['vuehtml']));

            if (!file_exists($destination_dir)) {

                mkdir($destination_dir);
            }

            $html2pdf->Output($output_link, 'F');

            $adobe_sign_args = array(
                'pdf_url'         => $output_link,
                'name'            => $adobesign_name,
                'message'         => $adobesign_message,
                'recipient_email' => $investor->email,
                'ccs'             => 'cinthia@ajency.in',
                'callbackInfo'    => $callbackurl,
            );

            $adobe_echo_sign = new AdobeSignature();
            $dockeyvalue     = $adobe_echo_sign->sendPdfForSignature($adobe_sign_args);

            $transferassetData             = new TransferAssetMeta;
            $transferassetData->transfer_id   = $transferasset->id;
            $transferassetData->meta_key   = $docKey;
            $transferassetData->meta_value = $dockeyvalue;
            $transferassetData->save();

            // $action   = 'Start Adobe Sign';
            // $activity = saveActivityLog('User', Auth::user()->id, 'start_adobe_sign', $investor->id, $action, '', $investor->firm_id);

            //delete temp file
            if (File::exists($output_link)) {
                File::delete($output_link);
            }

            $responseStatus = true;

        }

        $json_data = array(
            'status' => $responseStatus,
        );
        return response()->json($json_data);
    }

    public function updateTransferAssetDockey(Request $request)
    {
        $eventType = $request->input("eventType");

        if ($eventType == "ESIGNED") {

            $dockey = $request->input("documentKey");

            $response_data   = '';
            $returnd_doc_key = '';

            
            $adobeechosign = new AdobeSignature();

            $transferassetData = TransferAssetMeta::where('meta_value', $dockey)->first();

            if (!empty($transferassetData)) {
                $metaKeys  = ['transferasset_dockey' => 'stocktransfer_signedurl', 'stocktransfer_dockey' => 'transferasset_signedurl', 'authletter_dockey' => 'authletter_signedurl'];
                $type = $transferassetData->meta_key;
                $metaKey   = $metaKeys[$type];
                $dockeyUrl = $adobeechosign->getAdobeDocUrlByDocKey($dockey);

                $transferassetData              = new TransferAssetMeta;
                $transferassetData->transfer_id = $transferassetData->transfer_id;
                $transferassetData->meta_key    = $metaKey;
                $transferassetData->meta_value  = $dockeyUrl;
                $transferassetData->save();
            }
        }

    }
}

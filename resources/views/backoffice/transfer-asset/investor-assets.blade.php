@if($transferassets->count())
  @php
    $typeOfAssets =  typeOfAssets();
    $custodyType = custodyType();
    $transferType = ['full'=>'In Full','part'=>'In Part'];
  @endphp
  @foreach($transferassets as $transferasset)
  @php
  
    $details = $transferasset->details;
    $files = $transferasset->getFiles('transferasset');
    $transferassetDocs = $transferasset->transferAssetMeta()->whereIn('meta_key',['transferasset_dockey','stocktransfer_dockey','authletter_dockey'])->pluck('meta_key')->toArray();
    
  @endphp
    <tr class="">
        <td width="10%">
          {{ (isset($typeOfAssets[$transferasset->typeofasset]))? $typeOfAssets[$transferasset->typeofasset] :'' }}
          
        </td>
        <td  width="10%">
            {{ (!empty($transferasset->company))? title_case($transferasset->company->name) :'' }}
        </td>
        <td class="subheader_cell-cust" width="10%">
             {{ (isset($details['assets_typeofshare']))? $details['assets_typeofshare'] :'' }}
        </td>
        <td class="subheader_cell-cust" width="9%">
           {{ (isset($details['assets_noofshares']))? $details['assets_noofshares'] :'' }}

        </td>
        <td class="subheader_cell-cust" width="9%">
            {{ (isset($details['assets_nameonsharecertificate']))? title_case($details['assets_nameonsharecertificate']) :'' }}
        </td>
        <td class="subheader_cell-cust" width="9%">
            {{ (isset($details['assets_productname']))? $details['assets_productname'] :'' }}
        </td>
        <td class="subheader_cell-cust" width="9%">
            {{ (isset($details['assets_clientaccno']))? $details['assets_clientaccno'] :'' }}
        </td>
        <td class="subheader_cell-cust" width="9%">
             {{ (isset($details['typeoftransfer']) && isset($transferType[$details['typeoftransfer']]))? $transferType[$details['typeoftransfer']] :'' }}
        </td>
        <td class="subheader_cell-cust" width="9%">
            {{ (isset($details['assets_aicustody']) && isset($custodyType[$details['assets_aicustody']]))? $custodyType[$details['assets_aicustody']] :'' }}
        </td>
        <td class="subheader_cell-cust" width="9%">
           {{ (isset($details['assets_transferamount']))? $details['assets_transferamount'] :'' }}
        </td>
        <td class="subheader_cell-cust" width="10%">
            <a href="javascipt:void(0)" class="toggle-download-uploaded-doc " assetid="{{ $transferasset->id }}">View</a>
        </td>
        <td class="subheader_cell-cust" width="6%">
           <a class="toggle-download-doc btn btn-link" href="javascipt:void(0)" assetid="{{ $transferasset->id }}" investorid="{{ $transferasset->investor_id }}" ><i class="fa fa-download"></i></a> | 
           <a href="javascipt:void(0)" class="delete_tranferasset btn btn-link" assetid="{{ $transferasset->id }}"><i class="fa fa-trash fa-lg"></i></a>
        </td>
        <td class="subheader_cell-cust" width="6%">
           <select class="transferasset_status form-control" style="width:115px; display: inline-block;">
              <option value="pending" selected="">pending</option>                      
              <option value="completed" @if($transferasset->status=="completed") selected @endif>completed</option>                    
           </select>

           <a class="btn btn-link savetransferasset_asset" href="javascipt:void(0);" assetid="{{ $transferasset->id }}"><i class="fa fa-save fa-lg "></i></a>

           <span class="transferasset-msg d-none"></span>
        </td>
        
    </tr>
    <tr class="download-doc-{{ $transferasset->id }} d-none" >
      <td colspan="13">
        Letter of Authority - Enables us to complete the transfer on your/your client’s behalf<br>
  <a href="{{ url('backoffice/transfer-asset/'.$transferasset->id.'/download/letter_of_authority_pdf')}}"  class="btn btn-primary mt-2 " target="_blank">Download </a>
 
  <button  class="btn btn-primary mt-3 esign_doc" assetid="{{ $transferasset->id }}" assettype ="letter_of_authority_pdf" asset-type-text="Letter of Authority" @if(in_array('authletter_dockey',$transferassetDocs)) disabled data-toggle="tooltip"  title="Letter of Authority already sent for signature" data-original-title="Letter of Authority already sent for signature"  @endif>Send for E-SIGN<div class="ld ld-ring ld-spin d-none btn-spinner"></div></button><span id="letter_of_authority_pdf_msg"></span><br><br>

  Stock Transfer Form - Please fill out and send to us as we required for our own records regardless of Stamp Duty status<br>
  <a href="{{ url('backoffice/transfer-asset/'.$transferasset->id.'/download/stock_transfer_form')}}"  class="btn btn-primary mt-2" target="_blank">Download </a>
  <button class="btn btn-primary mt-3 esign_doc" assetid="{{ $transferasset->id }}" assettype ="stock_transfer_form" asset-type-text="Stock Transfer Form" @if(in_array('stocktransfer_dockey',$transferassetDocs)) disabled data-toggle="tooltip"  title="Stock Transfer Form already sent for signature" data-original-title="Stock Transfer Form already sent for signature" @endif>Send for E-SIGN<div class="ld ld-ring ld-spin d-none btn-spinner"></div></button><span id="stock_transfer_form_msg"></span><br><br>

  Asset Transfer Form - Always save a copy for your own record and send for electronic signature<br>
  <a href="{{ url('backoffice/transfer-asset/'.$transferasset->id.'/download/transfer_asset_pdf')}}"    class="btn btn-primary mt-3 " target="_blank">Download </a>

  <button class="btn btn-primary mt-3 esign_doc" assetid="{{ $transferasset->id }}" assettype ="transfer_asset_pdf" asset-type-text="Asset Transfer Form" @if(in_array('transferasset_dockey',$transferassetDocs)) disabled data-toggle="tooltip"  title="Asset Transfer Form already sent for signature" data-original-title="Asset Transfer Form already sent for signature" @endif>Send for E-SIGN<div class="ld ld-ring ld-spin d-none btn-spinner"></div></button><span id="transfer_asset_pdf_msg"></span>
      </td>
    </tr>
    <tr class="download-uploaded-doc-{{ $transferasset->id }} d-none">
      <td colspan="13">
       @if(!empty($files))
        @foreach($files as $file)  
          {{ $file['name'] }}  <a class="download-file" href="{{ url('download-file/'.$file['id']) }}" target="_blank" fileid="{{ $file['id'] }}"  ><i class="fa fa-download"></i></a> <br>
        @endforeach
       @else
        No Share Docs Uploaded
       @endif
      </td>
    </tr>

  @endforeach
@else
<tr><td  colspan="13" class="text-center"> No Data Found</td></tr>  
@endif              
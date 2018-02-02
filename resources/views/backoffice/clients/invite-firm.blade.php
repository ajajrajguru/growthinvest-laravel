<div class="p-4" id="invite-clients"> 
    <h1 class="section-title font-weight-medium text-primary">Invite Entrepreneur</h1>
    <p class="">You are able to register a client on the platform directly yourself, and we will complete any additional details and follow up required. However, if you would like to invite a client onto the platform and would like them to register as part of your network, then you are able to do so in a number of ways:</p>
    <ol class="pl-3">
        <li>Ask them to register directly onto www.growthinvest.com and to ensure that they include your details as part of the registration process</li>
        <li>Copy and paste the link here into an email, or copy the raw link from the box below You can edit and amend the custom text that will be seen above the registration form, by Editing the text in the box below.</li>
        <li>Providing www.growthinvest.com with a list of client prospects whom you would like to invite, we will individually email each of your clients with an approved and signed off bespoke, branded email, and provide a full activity report and follow up as required.</li>
    </ol>
     
    <!-- <div class="p-3 bg-gray mb-3">
        <div class="row">
            <div class="col-md-8">
                <label for="">Firm Name</label>
                <select name="invite_firm_name" class="form-control entrepreneurSearchinput" id="invite_firm_name">
                    <option value="">All Firms</option>
                    @foreach($firms as $firm)
                    <option value="{{ $firm->id }}">{{ $firm->name }}</option>
                    @endforeach
                </select>
                <small><i>Select the firm whose invite you need to view</i></small>
            </div>
             <div class="col-md-4 text-right">
                 <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-view-invite">View Invite</a>
            </div> 
        </div>
    </div> --> 

    <div class="p-3 bg-gray mb-3">
        <div class="row">
            <div class="col-sm-10">
                <div class="row">
                    <label for="" class="col-sm-2 col-form-label">Firm Name</label>
                    <div class="col-sm-9">
                        <select name="invite_firm_name" class="form-control entrepreneurSearchinput" id="invite_firm_name">
                            <option value="">All Firms</option>
                            @foreach($firms as $firm)
                            <option value="{{ $firm->id }}">{{ $firm->name }}</option>
                            @endforeach
                        </select>
                        <small><i>Select the firm whose invite you need to view</i></small>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 mt-sm-0 mt-3">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-view-invite">View Invite</a>
            </div>
        </div>
    </div>

    <div class="form-group">
            <label>URL</label>
            <input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="invite_link" value="http://seedtwin.ajency.in/register/?{{$firm->invite_key}}#businessowner" disabled>
            <div class="viewmode @if($mode=='edit') d-none @endif">http://seedtwin.ajency.in/register/?invite_key#businessowner</div>
    </div>

    <div class="form-group">
        <label>Entrepreneur invite content</label>
        <textarea class="rich-editor editmode @if($mode=='view') d-none @endif"" name="invite_content" >{{ (isset($invite_content['ent_invite_content'])) ? $invite_content['ent_invite_content'] : ''}}</textarea>
        <span class="viewmode @if($mode=='edit') d-none @endif @if($mode!='edit') scrollable @endif">{!! (isset($invite_content['ent_invite_content'])) ? $invite_content['ent_invite_content'] : ''!!}</span>            
    </div>

    <div class="d-flex justify-content-between">
        <div>
            <button type="submit" class="btn btn-primary save-btn editmode @if($mode=='view') d-none @endif ld-ext-right">Save <div class="ld ld-ring ld-spin"></div></button>
            <button type="submit" class="btn  cancel-btn editmode @if($mode=='view') d-none @endif ld-ext-right">Cancel <div class="ld ld-ring ld-spin"></div></button>
        </div>
        <div>
            <button type="submit" class="btn btn-primary send-invite-btn editmode @if($mode=='view') d-none @endif ld-ext-right">Send Invite <div class="ld ld-ring ld-spin"></div></button>
        </div>
    </div>
</div>

<script type="text/javascript">

    <?php /*if($firm->id){

echo "var edit_mode = 'yes' ";
}
else{
echo "var edit_mode = 'no' ";
}*/
?>

     function loadCkeditor(){
        alert('asd')
        // CKEDITOR.replace( 'rich-editor' );
        // CKEDITOR.replaceClass('rich-editor');
        var elements = CKEDITOR.document.find( '.rich-editor' ),
            i = 0,
            element;

            console.log('RICHE TEXT BOXES ')
            console.log(element);

        while ( ( element = elements.getItem( i++ ) ) ) {

            var t = element.InnerText ;

            var inst = CKEDITOR.replace( element );
            inst.setData(t)

        }

        setTimeout(function(){


            /*if(edit_mode=="yes"){
                $('#cke_ent_invite_content').addClass('d-none')

            }*/


         }, 2000);


    }

</script>
<script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js" onload="loadCkeditor();"></script>
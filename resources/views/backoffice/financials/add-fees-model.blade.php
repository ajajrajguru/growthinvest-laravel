
 
 <!-- Modal -->
    <div class="modal fade" id="addFeesModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Fees</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body m-auto d-block">
            <div>
             <div class="form-group">
              <label>Amount : £</label>
              <input type="number" name="amount" class="form-control">
            </div>

            <div class="form-group">
              <label>Comment :</label>
             <textarea class="form-control" name="comments"  ></textarea>
            </div>

 
                 
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="business_id" >
            <input type="hidden" name="investor_id" >
            <input type="hidden" name="type" >
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary save-investment-fees">Save changes</button>
          </div>
        </div>
      </div>
    </div>

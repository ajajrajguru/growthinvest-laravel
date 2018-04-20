<div class="modal fade" id="crop-{{ $imageClass }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" minContainerWidth="{{ $minContainerWidth }}" minContainerHeight="{{ $minContainerHeight }}">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <form name="cropImage" id="cropImage" enctype="multipart/form-data" >  
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ $heading }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-auto d-block">
        
        <div>
             <img src="" style="">
             <input type="hidden" name="aspect_ratio" value="{{ $aspectRatio }}">
             <input type="hidden" name="original_image" value="">
             <input type="hidden" name="crop_data" value="">
             <input type="hidden" name="image_class" value="{{ $imageClass }}">
             <input type="hidden" name="object_type" value="{{ $objectType }}">
             <input type="hidden" name="object_id" value="{{ $objectId }}">
             <input type="hidden" name="display_size" value="{{ $displaySize }}">
             <input type="hidden" name="image_type" value="{{ $imageType }}">

        </div>
        
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary crop-image">Crop</button>
      </div>
      </form>
    </div>
  </div>
</div>
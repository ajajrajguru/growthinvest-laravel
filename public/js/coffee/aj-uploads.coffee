window.uploadFiles = (containerId,uploadPath,type) -> 
  $('#'+containerId).pluploadQueue
    runtimes: 'html5,flash,silverlight,html4'
    url: uploadPath
    chunk_size: '2mb'
    headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    rename: true
    dragdrop: true
    filters:
      max_file_size: '10mb'
      mime_types: [
        {
          title: 'Image files'
          extensions: 'jpg,gif,png,csv,doc,docx,xlsx,txt,zip,pdf'
        }
        {
          title: 'Zip files'
          extensions: 'zip'
        }
      ]
    resize:
      width: 200
      height: 200
      quality: 90
      crop: true
    flash_swf_url: '/plupload/js/Moxie.swf'
    silverlight_xap_url: '/plupload/js/Moxie.xap'
    init:
      FileUploaded: (up, files, xhr) ->
        fileResponse = JSON.parse(xhr.response)
        filetype = $('#'+containerId).attr('file-type')

        delete_html = '<p class="multi_file_name"> '+fileResponse.data.file_name+' <a href="javascript:void(0)" class="delete-uploaded-file" object-type="App\BusinessListing" object-id="" type="'+filetype+'"><i class="fa fa-close" style="color: red"></i></a></p>'
        delete_html += '<div><input type="hidden" name="'+type+'_file_id" class="file_id" value=""></div>'
        $('#'+containerId).closest('.upload-files-section').find('.uploaded-file-path').append('<input type="hidden" name="'+type+'_file_path[]" value="'+fileResponse.data.image_path+'">')
        $('#'+containerId).closest('.upload-files-section').find('.uploaded-files').append delete_html

                                                   
                                               

window.uploadCropImage = (containerId,selectFile,imageId,uploadPath) -> 
  uploader = new (plupload.Uploader)(
    runtimes: 'html5,flash,silverlight,html4'
    browse_button: selectFile
    container: document.getElementById(containerId)
    headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    url: uploadPath
    filters:
      max_file_size: '10mb'
      mime_types: [
        {
          title: 'Image files'
          extensions: 'jpg,gif,png'
        }
        
      ]
    flash_swf_url: '/plupload/js/Moxie.swf'
    silverlight_xap_url: '/plupload/js/Moxie.xap'
    init:
      FilesAdded: (up, files) ->
        uploader.start()
        false
        return
      FileUploaded: (up, files, xhr) ->
        fileResponse = JSON.parse(xhr.response)
        console.log fileResponse
        
        $('#crop-'+imageId).find('input[name="original_image"]').val fileResponse.data.image_path
        aspectRatioVal = $('#crop-'+imageId).find('input[name="aspect_ratio"]').val()
        minContainerWidthVal = $("#crop-"+imageId).attr('minContainerWidth')
        minContainerHeightVal = $("#crop-"+imageId).attr('minContainerHeight')

        $("#crop-"+imageId).modal('show')
        $image = $("#crop-"+imageId).find('img')
        $image.cropper('destroy') 
        $image.attr('src', fileResponse.data.image_path)
        $image.cropper
          aspectRatio: aspectRatioVal
          minContainerWidth : minContainerWidthVal
          minContainerHeight : minContainerHeightVal
          crop: (event) ->
            $("#crop-"+imageId).find('input[name="crop_data"]').val(JSON.stringify(event.detail))
            return
        
        cropper = $image.data('cropper')


        return
      Error: (up, err) ->
       
        return
  )
  uploader.init()

window.uploadSingleFile = (containerId,selectFile,uploadPath) -> 
  uploader = new (plupload.Uploader)(
    runtimes: 'html5,flash,silverlight,html4'
    browse_button: selectFile
    container: document.getElementById(containerId)
    headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    url: uploadPath
    filters:
      max_file_size: '10mb'
      mime_types: [
        {
          title: 'Image files'
          extensions: 'jpg,gif,png,csv,doc,docx,xlsx,txt,zip,pdf'
        }
        {
          title: 'Zip files'
          extensions: 'zip'
        }
      ]
    flash_swf_url: '/plupload/js/Moxie.swf'
    silverlight_xap_url: '/plupload/js/Moxie.xap'
    init:
      FilesAdded: (up, files) ->
        uploader.start()
        false
        return
      FileUploaded: (up, files, xhr) ->
        fileResponse = JSON.parse(xhr.response)
        objectType = $('#'+selectFile).attr('object-type')
        objectId = $('#'+selectFile).attr('object-id')
        type = $('#'+selectFile).attr('file-type')
        $('#'+selectFile).closest('.upload-files-section').find('.uploaded-file-path').val(fileResponse.data.image_path)
        if($('#'+selectFile).closest('.upload-files-section').find('.file_name').length)
          delete_html = '<a href="javascript:void(0)" class="delete-uploaded-file" object-type="'+objectType+'" object-id="'+objectId+'" type="'+type+'"><i class="fa fa-close" style="color: red"></i></a>'
          delete_html += '<input type="hidden" name="'+type+'_url" class="image_url" value="'+fileResponse.data.image_path+'">'
          
          $('#'+selectFile).closest('.upload-files-section').find('.file_name').html(fileResponse.data.file_name+' '+delete_html)

        return
      Error: (up, err) ->
       
        return
  )
  uploader.init()

$(document).ready ->
  $(document).on 'click', '.crop-image', ->
    $form = $(this).closest('form')
    $.ajax
      type: 'post'
      url: '/crop-image'
      headers:
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      data: $form.serialize()
         
      success: (data) ->
        imageClass = $form.find('input[name="image_class"]').val()
        $("#crop-"+imageClass).modal('hide')
        if(!data.mapped)
          $("."+imageClass).closest('div').find('.cropped_image_url').val data.image_path   

        $("."+imageClass).attr('src', data.image_path)
        $("."+imageClass).closest('div').find('.delete-image').removeClass('d-none') 

  $(document).on 'click', '.delete-image', ->
    if !confirm('Are you sure you want to delete this image?')
      return

    btnObj = $(this)
    objectType = $(this).attr('object-type') 
    objectId = $(this).attr('object-id')
    type = $(this).attr('type')
    imageClass = $(this).attr('image-class')
    $.ajax
      type: 'post'
      url: '/delete-image'
      headers:
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      data:
        'object_type': objectType 
        'object_id': objectId 
        'image_type': type 
         
      success: (data) ->
        if($("."+imageClass).closest('div').find('.cropped_image_url').length)
          $("."+imageClass).closest('div').find('.cropped_image_url').val '-1'
        $("."+imageClass).attr('src', data.image_path)
        btnObj.addClass('d-none')

  $(document).on 'click', '.delete-uploaded-file', ->
    if !confirm('Are you sure you want to delete this file?')
      return

    btnObj = $(this)
    objectType = $(this).attr('object-type') 
    objectId = $(this).attr('object-id')
    fileId = $(this).attr('file-id')
    type = $(this).attr('type')
    $.ajax
      type: 'post'
      url: '/delete-file'
      headers:
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      data:
        'object_type': objectType 
        'object_id': objectId 
        'file_type': type 
         
      success: (data) ->
        if(btnObj.closest('.upload-files-section').find('.deleted_files').length && fileId!="")
          btnObj.closest('.upload-files-section').find('.deleted_files').append('<input type="hidden" name="delete_file[]" value="'+fileId+'">')

        if(btnObj.closest('.multi_file_name').length)
          btnObj.closest('.multi_file_name').remove()

        if(btnObj.closest('.upload-files-section').find('.file_name').length)
          btnObj.closest('.upload-files-section').find('.file_name').html('')

         
        
    
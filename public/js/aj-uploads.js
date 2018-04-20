(function() {
  window.uploadCropImage = function(containerId, selectFile, imageId, uploadPath) {
    var uploader;
    uploader = new plupload.Uploader({
      runtimes: 'html5,flash,silverlight,html4',
      browse_button: selectFile,
      container: document.getElementById(containerId),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: uploadPath,
      filters: {
        max_file_size: '10mb',
        mime_types: [
          {
            title: 'Image files',
            extensions: 'jpg,gif,png'
          }, {
            title: 'Zip files',
            extensions: 'zip'
          }
        ]
      },
      flash_swf_url: '/plupload/js/Moxie.swf',
      silverlight_xap_url: '/plupload/js/Moxie.xap',
      init: {
        FilesAdded: function(up, files) {
          uploader.start();
          false;
        },
        FileUploaded: function(up, files, xhr) {
          var $image, aspectRatioVal, cropper, fileResponse, minContainerHeightVal, minContainerWidthVal;
          fileResponse = JSON.parse(xhr.response);
          console.log(fileResponse);
          $('#crop-' + imageId).find('input[name="original_image"]').val(fileResponse.data.image_path);
          aspectRatioVal = $('#crop-' + imageId).find('input[name="aspect_ratio"]').val();
          minContainerWidthVal = $("#crop-" + imageId).attr('minContainerWidth');
          minContainerHeightVal = $("#crop-" + imageId).attr('minContainerHeight');
          $("#crop-" + imageId).modal('show');
          $image = $("#crop-" + imageId).find('img');
          $image.cropper('destroy');
          $image.attr('src', fileResponse.data.image_path);
          $image.cropper({
            aspectRatio: aspectRatioVal,
            minContainerWidth: minContainerWidthVal,
            minContainerHeight: minContainerHeightVal,
            crop: function(event) {
              $("#crop-" + imageId).find('input[name="crop_data"]').val(JSON.stringify(event.detail));
            }
          });
          cropper = $image.data('cropper');
        },
        Error: function(up, err) {}
      }
    });
    return uploader.init();
  };

  $(document).ready(function() {
    $(document).on('click', '.crop-image', function() {
      var $form;
      $form = $(this).closest('form');
      return $.ajax({
        type: 'post',
        url: '/crop-image',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $form.serialize(),
        success: function(data) {
          var imageClass;
          imageClass = $form.find('input[name="image_class"]').val();
          $("#crop-" + imageClass).modal('hide');
          console.log(imageClass);
          $("." + imageClass).attr('src', data.image_path);
          return $("." + imageClass).closest('div').find('.delete-image').removeClass('d-none');
        }
      });
    });
    return $(document).on('click', '.delete-image', function() {
      var btnObj, imageClass, objectId, objectType, type;
      if (!confirm('Are you sure you want to delete this image?')) {
        return;
      }
      btnObj = $(this);
      objectType = $(this).attr('object-type');
      objectId = $(this).attr('object-id');
      type = $(this).attr('type');
      imageClass = $(this).attr('image-class');
      return $.ajax({
        type: 'post',
        url: '/delete-image',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          'object_type': objectType,
          'object_id': objectId,
          'image_type': type
        },
        success: function(data) {
          $("." + imageClass).attr('src', data.image_path);
          return btnObj.addClass('d-none');
        }
      });
    });
  });

}).call(this);

(function() {
  window.uploadCropImage = function(containerId, selectFile, imageId, uploadPath) {
    var uploader;
    console.log(121);
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
          var $image, aspectRatioVal, cropper, fileResponse;
          fileResponse = JSON.parse(xhr.response);
          console.log(fileResponse);
          $('#crop-image-container').find('input[name="original_image"]').val(fileResponse.data.image_path);
          aspectRatioVal = $('#crop-image-container').find('input[name="aspect_ratio"]').val();
          $("#crop-image-container").modal('show');
          $image = $("#crop-image-container").find('img');
          $image.attr('src', fileResponse.data.image_path);
          $image.cropper({
            aspectRatio: aspectRatioVal,
            minContainerWidth: 450,
            minContainerHeight: 200,
            crop: function(event) {
              $('#crop-image-container').find('input[name="crop_data"]').val(JSON.stringify(event.detail));
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
    return $(document).on('click', '.crop-image', function() {
      return $.ajax({
        type: 'post',
        url: '/crop-image',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('form[name="cropImage"]').serialize(),
        success: function(data) {
          $("#crop-image-container").modal('hide');
          return $("#upload-image").attr('src', data.image_path);
        }
      });
    });
  });

}).call(this);

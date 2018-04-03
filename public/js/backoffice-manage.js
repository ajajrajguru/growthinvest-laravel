(function() {
  $(document).ready(function() {
    $('.activity-group-type-map').on('change', 'select[name="activity_group"]', function() {
      var btnObj;
      btnObj = $(this);
      return $.ajax({
        type: 'post',
        url: '/backoffice/activity-group/get-activity-type',
        data: {
          'type_id': btnObj.val()
        },
        success: function(data) {
          if (data.html !== "") {
            $('.activity-list').removeClass('d-none');
            $('.activity-list').find('ul').html(data.html);
          } else {
            $('.activity-list').addClass('d-none');
            $('.activity-list').find('ul').html(data.html);
          }
        },
        error: function(request, status, error) {
          throwError();
        }
      });
    });
    return $(document).on('click', '.save-activity-group-types', function() {
      var activity_types, btnObj, group_id;
      btnObj = $(this);
      activity_types = '';
      group_id = $('select[name="activity_group"]').val();
      $('input[name="activity_types[]"]').each(function() {
        if ($(this).is(':checked')) {
          return activity_types += $(this).val() + ',';
        }
      });
      return $.ajax({
        type: 'post',
        url: '/backoffice/activity-group/save-activity-type',
        data: {
          'group_id': group_id,
          'activity_types': activity_types
        },
        success: function(data) {
          console.log(data);
          if (!data.success) {
            $('.gi-success').addClass('d-none');
            $('.gi-danger').removeClass('d-none');
            $('.gi-danger').find('#message').html("Failed to update");
          } else {
            $('.gi-success').removeClass('d-none');
            $('.gi-danger').addClass('d-none');
            $('.gi-success').find('#message').html("Updated Successfully");
          }
        },
        error: function(request, status, error) {
          throwError();
        }
      });
    });
  });

}).call(this);

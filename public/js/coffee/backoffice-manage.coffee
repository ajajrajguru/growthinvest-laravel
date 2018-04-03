$(document).ready ->

  $('.activity-group-type-map').on 'change', 'select[name="activity_group"]', ->
    btnObj = $(this)
    
    $.ajax
      type: 'post'
      url: '/backoffice/activity-group/get-activity-type'
      data:
        'type_id': btnObj.val()
      success: (data) ->
        if(data.html!="")
          $('.activity-list').removeClass('d-none')
          $('.activity-list').find('ul').html(data.html)
        else
          $('.activity-list').addClass('d-none')
          $('.activity-list').find('ul').html(data.html)
        
          
        return
      error: (request, status, error) ->
        throwError()
        return

  $(document).on 'click', '.save-activity-group-types', ->
    btnObj = $(this)
    activity_types = ''
    group_id = $('select[name="activity_group"]').val()
 
    $('input[name="activity_types[]"]').each ->
      if $(this).is(':checked')
        activity_types += $(this).val()+','

    $.ajax
      type: 'post'
      url: '/backoffice/activity-group/save-activity-type'
      data:
        'group_id': group_id
        'activity_types': activity_types
      success: (data) ->
        console.log data
        if !data.success
          $('.gi-success').addClass('d-none')
          $('.gi-danger').removeClass('d-none')
          $('.gi-danger').find('#message').html("Failed to update")
        else
          $('.gi-success').removeClass('d-none')
          $('.gi-danger').addClass('d-none')
          $('.gi-success').find('#message').html("Updated Successfully")
          
          
        return
      error: (request, status, error) ->
        throwError()
        return
 

  






      
 
  

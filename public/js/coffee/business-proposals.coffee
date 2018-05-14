$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
$(document).ready ->
  

  $('.save-section').click ->
    btnObj = $(this)
    title = $('input[name="title"]').val()
    submitType = btnObj.attr('submit-type')

    hrefId = $('input[name="title"]').closest('.parent-tabpanel').attr('id')
    titleInvalidTabHeadObj = $('a[href="#'+hrefId+'"]').closest('.card-header') 
    if(title=='')
      $('input[name="title"]').parsley().validate()   
      titleInvalidTabHeadObj.addClass('border border-danger')
      titleInvalidTabHeadObj.find('.has-invalid-data').removeClass('d-none')
    else
      titleInvalidTabHeadObj.removeClass('border border-danger')
      titleInvalidTabHeadObj.find('.has-invalid-data').addClass('d-none')


    hrefId = btnObj.closest('.parent-tabpanel').attr('id') 
    isValidTab = 0
    invalidTabHeadObj = $('a[href="#'+hrefId+'"]').closest('.card-header')  
    invalidTabHeadObj.removeClass('border border-danger')
    invalidTabHeadObj.find('.has-invalid-data').addClass('d-none')

    $(this).find('.completion_status').each ->
      if(!$(this).parsley().isValid())
        isValidTab++
        if(isValidTab>0)
          invalidTabHeadObj.addClass('border border-danger')
          invalidTabHeadObj.find('.has-invalid-data').removeClass('d-none')

    if(title!='' && isValidTab==0)
      form_data = btnObj.closest('form').serializeArray()
      $.ajax
        type: 'post'
        url: '/business-proposals/save'
        data:
          'submit_type': submitType
          'form_data': form_data  
          
        success: (data) ->
          if(data.redirect)
            window.open("/investment-opportunities/"+data.gi_code+"/edit");
          else
            console.log data.gi_code
        


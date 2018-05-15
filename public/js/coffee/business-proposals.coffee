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

    btnObj.closest('.parent-tabpanel').find('.completion_status').each ->
      if(!$(this).parsley().isValid())
        $(this).parsley().validate()   
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
            window.location.href="/investment-opportunities/"+data.gi_code+"/edit";
          else
            console.log data.gi_code


  $(document).on 'change', 'input[name="post-money-valuation"]', ->
    investment_sought = $('#investment-sought').val()
    if isNaN(investment_sought) or investment_sought == ''
      investment_sought = 0
    else
      investment_sought = parseFloat(investment_sought)
    post_money_valuation = $(this).val()
    if isNaN(post_money_valuation) or post_money_valuation == ''
      post_money_valuation = 0
    else
      post_money_valuation = parseFloat(post_money_valuation)
    pre_money_valuation = ''
    percentage_giveaway = ''
    if post_money_valuation != 0 and investment_sought != 0
      pre_money_valuation = post_money_valuation - investment_sought
      percentage_giveaway = investment_sought / post_money_valuation * 100
      percentage_giveaway = Math.round(percentage_giveaway * 100) / 100
    $('#percentage-giveaway').val percentage_giveaway
    $('#pre-money-valuation').val pre_money_valuation
    return

  $(document).on 'click', '.delete_funds_row', ->
    if confirm('Are you sure you want to delete this Fund from your List?')
      $(this).closest('.add-use-of-funds').remove()


  $(document).on 'click', '.add_funds_row', ->
    html = '<div class="row add-use-of-funds">
                <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode" name="use_of_funds" placeholder="" ></div></div>
                <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode" name="use_of_funds_amount" placeholder="" ></div></div>
                <div class="col-sm-2"><a class="delete_funds_row btn btn-primary text-right" ><i class="fa fa-trash"></i> &nbsp;</a></div>
            </div>'

    $('.add-use-of-funds-container').append(html)
  

        


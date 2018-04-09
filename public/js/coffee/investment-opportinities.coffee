$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->
  getInvestmentOpportunity = () -> 

    $('.investment-loader').removeClass('d-none')
    filters = {}
    filters.business_listing_type = $('input[name="business_listing_type"]').val();

    status = ''
    $('input[name="tax_status[]"]').each ->
      if $(this).is(':checked')
        status += $(this).val()+','

    filters.tax_status = status

    sectors = ''
    $('input[name="business_sector[]"]').each ->
      if $(this).is(':checked')
        sectors += $(this).val()+','

    filters.sectors = sectors

    due_deligence = ''
    $('input[name="due_deligence[]"]').each ->
      if $(this).is(':checked')
        due_deligence += $(this).val()+','

    filters.due_deligence = due_deligence

    business_stage = ''
    $('input[name="business_stage[]"]').each ->
      if $(this).is(':checked')
        business_stage += $(this).val()+','

    filters.business_stage = business_stage

    funded_per = ''
    $('input[name="funded_per[]"]').each ->
      if $(this).is(':checked')
        funded_per += $(this).val()+','

    filters.funded_per = funded_per

    investment_sought = ''
    $('input[name="investment_sought[]"]').each ->
      if $(this).is(':checked')
        investment_sought += $(this).val()+','

    filters.investment_sought = investment_sought

    
    $.ajax
      type: 'post'
      url: '/investment-opportunities/filter-listings'
      data:filters
      success: (reponse) ->
        $('.investment-loader').addClass('d-none')
        if($('.business-listing').length)
           $('.business-listing').html reponse.businesslistingHtml

          if reponse.businesslistingHtml !=""
            $('.platform-listing-section').removeClass('d-none')
          else
            $('.platform-listing-section').addClass('d-none')
          
          $('.platform-listing').html reponse.platformListingHtml

          $(".knob").knob();

        return
      error: (request, status, error) ->
        throwError()
        return 
  
  if($('.business-listing').length)    
    getInvestmentOpportunity()

    
  $(document).on 'change', '.filter-business-list', ->
    getInvestmentOpportunity()
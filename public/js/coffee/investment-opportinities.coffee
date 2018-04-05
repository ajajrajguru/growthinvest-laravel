$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->
  getInvestmentOpportunity = () -> 

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
    
    $.ajax
      type: 'post'
      url: '/investment-opportunities/filter-listings'
      data:filters
      success: (reponse) ->
        if($('.business-listing').length)
           $('.business-listing').html reponse.businesslistinghtml

        return
      error: (request, status, error) ->
        throwError()
        return 
  
  if($('.business-listing').length)    
    getInvestmentOpportunity()

    
  $(document).on 'change', '.filter-business-list', ->
    getInvestmentOpportunity()
(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var getInvestmentOpportunity;
    getInvestmentOpportunity = function() {
      var due_deligence, filters, sectors, status;
      filters = {};
      filters.business_listing_type = $('input[name="business_listing_type"]').val();
      status = '';
      $('input[name="tax_status[]"]').each(function() {
        if ($(this).is(':checked')) {
          return status += $(this).val() + ',';
        }
      });
      filters.tax_status = status;
      sectors = '';
      $('input[name="business_sector[]"]').each(function() {
        if ($(this).is(':checked')) {
          return sectors += $(this).val() + ',';
        }
      });
      filters.sectors = sectors;
      due_deligence = '';
      $('input[name="due_deligence[]"]').each(function() {
        if ($(this).is(':checked')) {
          return due_deligence += $(this).val() + ',';
        }
      });
      filters.due_deligence = due_deligence;
      return $.ajax({
        type: 'post',
        url: '/investment-opportunities/filter-listings',
        data: filters,
        success: function(reponse) {
          if (($('.business-listing').length)) {
            $('.business-listing').html(reponse.businesslistinghtml);
          }
        },
        error: function(request, status, error) {
          throwError();
        }
      });
    };
    if (($('.business-listing').length)) {
      getInvestmentOpportunity();
    }
    return $(document).on('change', '.filter-business-list', function() {
      return getInvestmentOpportunity();
    });
  });

}).call(this);

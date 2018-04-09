(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var getInvestmentOpportunity;
    getInvestmentOpportunity = function() {
      var business_stage, due_deligence, filters, funded_per, investment_sought, sectors, status;
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
      business_stage = '';
      $('input[name="business_stage[]"]').each(function() {
        if ($(this).is(':checked')) {
          return business_stage += $(this).val() + ',';
        }
      });
      filters.business_stage = business_stage;
      funded_per = '';
      $('input[name="funded_per[]"]').each(function() {
        if ($(this).is(':checked')) {
          return funded_per += $(this).val() + ',';
        }
      });
      filters.funded_per = funded_per;
      investment_sought = '';
      $('input[name="investment_sought[]"]').each(function() {
        if ($(this).is(':checked')) {
          return investment_sought += $(this).val() + ',';
        }
      });
      filters.investment_sought = investment_sought;
      return $.ajax({
        type: 'post',
        url: '/investment-opportunities/filter-listings',
        data: filters,
        success: function(reponse) {
          if (($('.business-listing').length)) {
            $('.business-listing').html(reponse.businesslistingHtml);
          }
          if (reponse.businesslistingHtml !== "") {
            $('.platform-listing-section').removeClass('d-none');
          } else {
            $('.platform-listing-section').addClass('d-none');
          }
          $('.platform-listing').html(reponse.platformListingHtml);
          $(".knob").knob();
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

(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var getInvestmentOpportunity;
    getInvestmentOpportunity = function() {
      var aic_sector, business_stage, due_deligence, filters, fund_investmentobjective, fund_status, fund_type, funded_per, investment_sought, sectors, status, vct_investmentstrategy, vct_offeringtype, vct_type;
      $('.investment-loader').addClass('d-flex').removeClass('d-none');
      $('.no-data-conatiner').removeClass('d-flex').addClass('d-none');
      filters = {};
      filters.business_listing_type = $('input[name="business_listing_type"]').val();
      filters.order_by = $('select[name="order_by"]').val();
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
      filters.search_title = $('input[name="search_title"]').val();
      fund_type = '';
      $('input[name="fund_type[]"]').each(function() {
        if ($(this).is(':checked')) {
          return fund_type += $(this).val() + ',';
        }
      });
      filters.fund_type = fund_type;
      fund_status = '';
      $('input[name="fund_status[]"]').each(function() {
        if ($(this).is(':checked')) {
          return fund_status += $(this).val() + ',';
        }
      });
      filters.fund_status = fund_status;
      fund_investmentobjective = '';
      $('input[name="fund_investmentobjective[]"]').each(function() {
        if ($(this).is(':checked')) {
          return fund_investmentobjective += $(this).val() + ',';
        }
      });
      filters.fund_investmentobjective = fund_investmentobjective;
      vct_type = '';
      $('input[name="vct_type[]"]').each(function() {
        if ($(this).is(':checked')) {
          return vct_type += $(this).val() + ',';
        }
      });
      filters.vct_type = vct_type;
      vct_investmentstrategy = '';
      $('input[name="vct_investmentstrategy[]"]').each(function() {
        if ($(this).is(':checked')) {
          return vct_investmentstrategy += $(this).val() + ',';
        }
      });
      filters.vct_investmentstrategy = vct_investmentstrategy;
      vct_offeringtype = '';
      $('input[name="vct_offeringtype[]"]').each(function() {
        if ($(this).is(':checked')) {
          return vct_offeringtype += $(this).val() + ',';
        }
      });
      filters.vct_offeringtype = vct_offeringtype;
      aic_sector = '';
      $('input[name="aic_sector[]"]').each(function() {
        if ($(this).is(':checked')) {
          return aic_sector += $(this).val() + ',';
        }
      });
      filters.aic_sector = aic_sector;
      return $.ajax({
        type: 'post',
        url: '/investment-opportunities/filter-listings',
        data: filters,
        success: function(reponse) {
          if (($('.business-listing').length)) {
            if (reponse.businesslistingHtml !== "") {
              $('.open-investment-offers').removeClass('d-none');
            } else {
              $('.open-investment-offers').addClass('d-none');
            }
            $('.business-listing').html(reponse.businesslistingHtml);
            if (reponse.platformListingHtml !== "") {
              $('.platform-listing-section').removeClass('d-none');
            } else {
              $('.platform-listing-section').addClass('d-none');
            }
            $('.platform-listing').html(reponse.platformListingHtml);
            $('.knob').each(function() {
              var $this;
              $this = $(this);
              $this.knob({
                'readOnly': true
              });
            });
            $('.investment-loader').removeClass('d-flex').addClass('d-none');
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover({
              trigger: 'hover',
              html: true,
              content: function() {
                return $('#popover-content').html();
              }
            });
            if (reponse.totalBusinessListings === 0) {
              $('.no-data-conatiner').addClass('d-flex').removeClass('d-none');
            }
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
    $(document).on('change', 'select[name="order_by"]', function() {
      return getInvestmentOpportunity();
    });
    $(document).on('change', '.filter-business-list', function() {
      return getInvestmentOpportunity();
    });
    $(document).on('click', '.search-by-title', function() {
      return getInvestmentOpportunity();
    });
    return $(document).on('click', '.reset-investment-opportunity', function() {
      $('input[name="tax_status[]"]').prop('checked', false);
      $('input[name="business_sector[]"]').prop('checked', false);
      $('input[name="due_deligence[]"]').prop('checked', false);
      $('input[name="business_stage[]"]').prop('checked', false);
      $('input[name="funded_per[]"]').prop('checked', false);
      $('input[name="investment_sought[]"]').prop('checked', false);
      $('input[name="search_title"]').val('');
      getInvestmentOpportunity();
    });
  });

}).call(this);

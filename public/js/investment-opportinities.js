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
      $('.business-listing').html('');
      $('.platform-listing').html('');
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
          var api;
          $('.business-listing').html('');
          $('.platform-listing').html('');
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
              var $this, myVal;
              $this = $(this);
              myVal = $this.attr('value');
              if (parseFloat(myVal) > 100) {
                $(this).attr('data-bgColor', '#74b9eb');
                $(this).attr('data-fgColor', '#E9D460');
              }
              $(this).knob({
                'min': 0,
                'max': 100,
                'readOnly': true,
                'dynamicDraw': true,
                'tickColorizeValues': true,
                'skin': 'tron',
                'draw': function() {
                  $(this.i).val(myVal + '%');
                }
              });
              return $({
                value: 0
              }).animate({
                value: myVal
              }, {
                duration: 1000,
                easing: 'swing',
                step: function() {
                  $this.val(Math.ceil(this.value)).trigger('change');
                }
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
            $('#giMenu').mmenu({
              navbar: {
                title: false
              },
              extensions: ['pagedim-black', 'theme-dark']
            }, {
              clone: true
            });
            api = $('#mm-giMenu').data('mmenu');
            api.bind('open:start', function() {
              return $('.mobile-menu-toggle').addClass('is-active');
            });
            api.bind('close:start', function() {
              return $('.mobile-menu-toggle').removeClass('is-active');
            });
            $(window).scroll(function() {
              var scroll;
              scroll = $(window).scrollTop();
              if (scroll >= 1) {
                $('header').addClass('sticky');
                return $('.navbar-menu').addClass('dark');
              } else {
                $('header').removeClass('sticky');
                return $('.navbar-menu').removeClass('dark');
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
    $(document).on('click', '.apply-investment-opportunity', function() {
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
      $('input[name="aic_sector[]"]').prop('checked', false);
      $('input[name="fund_type[]"]').prop('checked', false);
      $('input[name="fund_status[]"]').prop('checked', false);
      $('input[name="fund_investmentobjective[]"]').prop('checked', false);
      $('input[name="vct_investmentstrategy[]"]').prop('checked', false);
      $('input[name="vct_type[]"]').prop('checked', false);
      $('input[name="vct_investmentstrategy[]"]').prop('checked', false);
      $('input[name="vct_offeringtype[]"]').prop('checked', false);
      $('input[name="search_title"]').val('');
      $('select[name="order_by"]').val('');
      getInvestmentOpportunity();
    });
  });

}).call(this);

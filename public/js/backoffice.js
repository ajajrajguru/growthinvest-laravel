(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var addrolesTable, api, availablePermissionstable, businessClientTable, businesslistingsTable, clearInput, column, entrepreneurTable, firmsTable, fundmanagerTable, getUrlVars, initSerachForTable, intermediaryTable, investmentClientTable, updateSerachinput, userAdminTable, usersTable;
    getUrlVars = function() {
      var hash, hashes, i, vars;
      vars = [];
      hash = void 0;
      hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
      i = 0;
      while (i < hashes.length) {
        hash = hashes[i].split('=');
        vars[hash[0]] = hash[1];
        $('td[data-search="' + hash[0] + '"]').find('.datatable-search').val(hash[1]);
        i++;
      }
      return vars;
    };
    $('.dataFilterTable thead th.w-search').each(function() {
      var searchField, searchType, title;
      title = $(this).text();
      searchType = $(this).closest('table').find('tr.filters td').eq($(this).index()).attr('data-search');
      if (searchType === 'role') {
        searchField = '<select class="form-control datatable-search">';
        searchField += '<option value="">Search ' + title + '</option>';
        $(userRoles).each(function(id, value) {
          value = value.trim();
          return searchField += '<option value="' + value + '">' + value + '</option>';
        });
        searchField += '</select>';
      } else {
        searchField = '<div class="input-group"> <div class="input-group-prepend pt-2 pr-2"><i class="fa fa-search text-muted"></i></div> <input type="text" class="form-control datatable-search" placeholder="Search ' + title + '" />   <div class="input-group-append">    <button class="btn btn-sm btn-link clear-input" type="button"><i class="fa fa-times text-secondary"></i></button>  </div> </div>';
      }
      $(this).closest('table').find('tr.filters td').eq($(this).index()).html(searchField);
    });
    updateSerachinput = function(tableObj) {
      var urlParms;
      urlParms = getUrlVars();
      tableObj.columns().eq(0).each(function(colIdx) {
        var colVal;
        colVal = $('.datatable-search', $('.filters td')[colIdx]).val();
        tableObj.columns(colIdx).search(colVal).draw();
      });
    };
    initSerachForTable = function(tableObj) {
      var urlParms;
      urlParms = getUrlVars();
      tableObj.columns().eq(0).each(function(colIdx) {
        $('.datatable-search', $('.filters td')[colIdx]).on('keyup change', function() {
          tableObj.column(colIdx).search(this.value).draw();
        });
      });
    };
    clearInput = function(tableObj) {
      $('body').on('click', '.clear-input', function() {
        var column;
        $(this).closest('.input-group').find('input').val('');
        tableObj.columns().eq(0).each(function(colIdx) {
          var colVal;
          colVal = $('input', $('.filters td')[colIdx]).val();
          tableObj.columns(colIdx).search(colVal).draw();
        });
        if ($(window).width() < 767) {
          if ($('.toggle-btn input:checkbox:not(:checked)')) {
            column = 'table .' + $('.toggle-btn input').attr('name');
            $(column).hide();
          }
        }
      });
    };
    if ($('#datatable-firms').length) {
      firmsTable = $('#datatable-firms').DataTable({
        "paging": false,
        "info": true,
        "dom": '<"top"i>t<"bottom"i>',
        'aaSorting': [[1, 'asc']],
        'columns': [
          {
            'data': 'logo',
            "orderable": false
          }, {
            'data': 'name'
          }, {
            'data': 'firm_type'
          }, {
            'data': 'parent_firm'
          }, {
            'data': 'gi_code'
          }, {
            'data': 'action',
            "orderable": false
          }
        ]
      });
      initSerachForTable(firmsTable);
      updateSerachinput(firmsTable);
      clearInput(firmsTable);
    }
    $(document).on('keyup change', '.data-search-input .datatable-search', function() {
      var urlParams;
      urlParams = '';
      $('.data-search-input .datatable-search').each(function() {
        var dataType, textVal;
        textVal = $(this).val();
        dataType = $(this).closest('td').attr('data-search');
        if (textVal !== '') {
          if (urlParams !== "") {
            urlParams += '&';
          }
          return urlParams += dataType + '=' + textVal;
        }
      });
      return window.history.pushState("", "", "?" + urlParams);
    });
    if ($('#datatable-users').length) {
      usersTable = $('#datatable-users').DataTable({
        "paging": false,
        "info": true,
        "dom": '<"top"i>t<"bottom"i>',
        'aaSorting': [[0, 'asc']],
        'columns': [
          {
            'data': 'name'
          }, {
            'data': 'email'
          }, {
            'data': 'role'
          }, {
            'data': 'firm'
          }, {
            'data': 'action',
            "orderable": false
          }
        ]
      });
      initSerachForTable(usersTable);
      updateSerachinput(usersTable);
      clearInput(usersTable);
    }
    if ($('#userAdmin').length) {
      userAdminTable = $('#userAdmin').DataTable({
        "paging": true,
        "info": true,
        "searching": false,
        "ordering": false
      });
    }
    if ($('#availablePermissions').length) {
      availablePermissionstable = $('#availablePermissions').DataTable({
        "paging": true,
        "info": true,
        "searching": false,
        "ordering": false
      });
    }
    if ($('#rolesTable').length) {
      addrolesTable = $('#rolesTable').DataTable({
        "paging": true,
        "info": true,
        "searching": false,
        "ordering": false
      });
    }
    if ($('#datatable-Intermediary').length) {
      intermediaryTable = $('#datatable-Intermediary').DataTable({
        "paging": false,
        "info": true,
        "dom": '<"top"i>t<"bottom"i>',
        'aaSorting': [[1, 'asc']],
        'columns': [
          {
            'data': 'ckbox',
            "orderable": false
          }, {
            'data': 'intm_details'
          }, {
            'data': 'comp_name'
          }, {
            'data': 'comp_desc'
          }, {
            'data': 'submitted_on'
          }, {
            'data': 'lbgr'
          }, {
            'data': 'action',
            "orderable": false
          }
        ]
      });
      initSerachForTable(intermediaryTable);
      updateSerachinput(intermediaryTable);
      clearInput(intermediaryTable);
    }
    $(document).on('change', '.delete_intm_users', function() {
      if ($('input[name="intermediary_user_delete[]"]:checked').length > 0) {
        return $('.delete-all-user').removeClass('d-none');
      } else {
        return $('.delete-all-user').addClass('d-none');
      }
    });
    $(document).on('click', '.select-all-user', function() {
      $(this).addClass('d-none');
      $('.select-none-user').removeClass('d-none');
      $('.delete-all-user').removeClass('d-none');
      return $(".delete_intm_users").prop('checked', true);
    });
    $(document).on('click', '.select-none-user', function() {
      $(this).addClass('d-none');
      $('.select-all-user').removeClass('d-none');
      $('.delete-all-user').addClass('d-none');
      return $(".delete_intm_users").prop('checked', false);
    });
    $(document).on('click', '.delete-all-user', function() {
      var userIds;
      userIds = '';
      $('.delete_intm_users').each(function() {
        if ($(this).is(':checked')) {
          return userIds += $(this).val() + ',';
        }
      });
      return $.ajax({
        type: 'post',
        url: '/backoffice/user/delete-user',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          'user_id': userIds
        },
        success: function(data) {
          if (data.status) {
            $('.delete_intm_users').each(function() {
              if ($(this).is(':checked')) {
                return intermediaryTable.row($(this).closest('tr')).remove();
              }
            });
            $('.gi-success').removeClass('d-none');
            $('.gi-danger').addClass('d-none');
            $('.gi-success #message').html("Intermediaries Deleted Successfully.");
            return intermediaryTable.draw();
          } else {
            $('.gi-success').addClass('d-none');
            $('.gi-danger').removeClass('d-none');
            return $('.gi-danger #message').html("Failed to delete intermediaries.");
          }
        }
      });
    });
    $(document).on('click', '.editUserBtn', function() {
      $('.editmode').removeClass('d-none');
      $('.reqField').removeClass('d-none');
      $('.viewmode').addClass('d-none');
      $('.disabledInput').attr('disabled', false);
      $(this).addClass('d-none');
      return $('.cancelUpdateBtn').removeClass('d-none');
    });
    $(document).on('click', '.cancelUpdateBtn', function() {
      $('.editmode').addClass('d-none');
      $('.reqField').addClass('d-none');
      $('.viewmode').removeClass('d-none');
      $('.disabledInput').attr('disabled', true);
      $(this).addClass('d-none');
      return $('.editUserBtn').removeClass('d-none');
    });
    $(document).on('click', '.editFirmBtn', function() {
      $('.editmode').removeClass('d-none');
      $('.reqField').removeClass('d-none');
      $('.viewmode').addClass('d-none');
      $(this).addClass('d-none');
      $('#cke_ent_invite_content').removeClass('d-none');
      $('#cke_inv_invite_content').removeClass('d-none');
      $('#cke_fundmanager_invite_content').removeClass('d-none');
      $('.percentlbl').removeClass('d-none');
      return $('.cancelFirmUpdateBtn').removeClass('d-none');
    });
    $(document).on('click', '.cancelFirmUpdateBtn', function() {
      $('.editmode').addClass('d-none');
      $('.reqField').addClass('d-none');
      $('.viewmode').removeClass('d-none');
      $(this).addClass('d-none');
      $('#cke_ent_invite_content').addClass('d-none');
      $('#cke_inv_invite_content').addClass('d-none');
      $('#cke_fundmanager_invite_content').addClass('d-none');
      $('.percentlbl').addClass('d-none');
      return $('.editFirmBtn').removeClass('d-none');
    });
    $(document).on('click', '#change_pwd', function() {
      $(this).addClass('d-none');
      $('#cancel_pwd').removeClass('d-none');
      return $('.setpassword-cont').removeClass('d-none');
    });
    $(document).on('click', '#cancel_pwd', function() {
      $(this).addClass('d-none');
      $('#change_pwd').removeClass('d-none');
      return $('.setpassword-cont').addClass('d-none');
    });
    if ($('form').length && $('form').attr('data-parsley-validate') === true) {
      $('form').parsley().on('form:success', function() {
        $(this)[0].$element.find('.save-btn .fa-check').addClass('d-none');
        return $(this)[0].$element.find('.save-btn').addClass('running');
      });
    }
    $('[data-toggle="popover"]').popover();
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
    entrepreneurTable = $('#datatable-entrepreneurs').DataTable({
      'pageLength': 50,
      'processing': false,
      'serverSide': true,
      'bAutoWidth': false,
      'aaSorting': [[0, 'asc']],
      'ajax': {
        url: '/backoffice/entrepreneurs/get-entrepreneurs',
        type: 'post',
        data: function(data) {
          var filters;
          filters = {};
          filters.firm_name = $('select[name="firm_name"]').val();
          data.filters = filters;
          return data;
        },
        error: function() {}
      },
      'columns': [
        {
          'data': 'name'
        }, {
          'data': 'email'
        }, {
          'data': 'firm'
        }, {
          'data': 'business'
        }, {
          'data': 'registered_date'
        }, {
          'data': 'source',
          "orderable": false
        }, {
          'data': 'action',
          "orderable": false
        }
      ]
    });
    $('.entrepreneurSearchinput').change(function() {
      entrepreneurTable.ajax.reload();
    });
    $('.download-entrepreneur-csv').click(function() {
      var firm_name;
      firm_name = $('select[name="firm_name"]').val();
      return window.open("/backoffice/entrepreneur/export-entrepreneurs?firm_name=" + firm_name);
    });
    $('body').on('click', '.entrepreneurs-reset-filters', function() {
      $('select[name="firm_name"]').val('').trigger('change');
      entrepreneurTable.ajax.reload();
    });
    fundmanagerTable = $('#datatable-fundmanagers').DataTable({
      'pageLength': 50,
      'processing': false,
      'serverSide': true,
      'bAutoWidth': false,
      'aaSorting': [[0, 'asc']],
      'ajax': {
        url: '/backoffice/fundmanagers/get-fundmanagers',
        type: 'post',
        data: function(data) {
          var filters;
          filters = {};
          filters.firm_name = $('select[name="firm_name"]').val();
          data.filters = filters;
          return data;
        },
        error: function() {
          console.log("error");
        }
      },
      'columns': [
        {
          'data': 'name'
        }, {
          'data': 'email'
        }, {
          'data': 'firm'
        }, {
          'data': 'business'
        }, {
          'data': 'registered_date'
        }, {
          'data': 'source',
          "orderable": false
        }, {
          'data': 'action',
          "orderable": false
        }
      ]
    });
    $('.fundmanagerSearchinput').change(function() {
      fundmanagerTable.ajax.reload();
    });
    $('.download-fundmanager-csv').click(function() {
      var firm_name;
      firm_name = $('select[name="firm_name"]').val();
      return window.open("/backoffice/fundmanager/export-fundmanagers?firm_name=" + firm_name);
    });
    $('body').on('click', '.fundmanagers-reset-filters', function() {
      $('select[name="firm_name"]').val('').trigger('change');
      fundmanagerTable.ajax.reload();
    });
    businesslistingsTable = $('#datatable-businesslistings').DataTable({
      'pageLength': 50,
      'searching': false,
      'processing': false,
      'serverSide': true,
      'bAutoWidth': false,
      "dom": '<"top d-sm-flex justify-content-sm-between w-100"li>t<"bottom d-sm-flex justify-content-sm-between w-100"ip>',
      'aaSorting': [[1, 'asc']],
      'ajax': {
        url: '/backoffice/business-listings/get-businesslistings',
        type: 'post',
        data: function(data) {
          var business_invest_listings, filters;
          filters = {};
          filters.firm_name = $('select[name="firm_name"]').val();
          filters.business_listings_type = $('select[name="business_listings_type"]').val();
          business_invest_listings = 'yes';
          if (window.location.pathname.indexOf('invest-listings') === -1) {
            business_invest_listings = "no";
          }
          filters.invest_listings = business_invest_listings;
          data.filters = filters;
          return data;
        },
        error: function() {}
      },
      'columns': [
        {
          'data': 'logo',
          "orderable": false
        }, {
          'data': 'name'
        }, {
          'data': 'duediligence'
        }, {
          'data': 'created_date'
        }, {
          'data': 'modified_date'
        }, {
          'data': 'firmtoraise',
          "orderable": false
        }, {
          'data': 'activity_sitewide',
          "orderable": false
        }, {
          'data': 'activity_firmwide',
          "orderable": false
        }, {
          'data': 'action',
          "orderable": false
        }
      ]
    });
    $('.businesslistingsSearchinput').change(function() {
      businesslistingsTable.ajax.reload();
    });
    $(document).on('change', '#managebusiness_type', function() {
      return window.open("/backoffice/" + $(this).val(), "_self");
    });
    $('.download-business-listings-csv').click(function() {
      var business_listings_type, firm_name;
      firm_name = $('select[name="firm_name"]').val();
      business_listings_type = $('select[name="business_listings_type"]').val();
      return window.open("/backoffice/business-listing/export-business-listings?firm_name=" + firm_name + "&business_listings_type=" + business_listings_type);
    });
    $('body').on('click', '.business-listings-reset-filters', function() {
      $('select[name="firm_name"]').val('').trigger('change');
      $('select[name="business_listings_type"]').val('').trigger('change');
      businesslistingsTable.ajax.reload();
    });
    businesslistingsTable = $('#datatable-currentbusinessvaluations').DataTable({
      'pageLength': 50,
      'processing': false,
      'serverSide': true,
      'bAutoWidth': false,
      'aaSorting': [[1, 'asc']],
      'ajax': {
        url: '/backoffice/business-listings/get-current-valuation-listings',
        type: 'post',
        data: function(data) {
          return data;
        },
        error: function() {}
      },
      'columns': [
        {
          'data': 'name'
        }, {
          'data': 'created_date'
        }, {
          'data': 'total_valuation',
          "orderable": false
        }, {
          'data': 'share_price',
          "orderable": false
        }, {
          'data': 'action',
          "orderable": false
        }
      ]
    });
    $('.btn-view-invite').click(function() {
      var firmid, invite_type;
      invite_type = $(this).attr('invite-type');
      firmid = $('#invite_firm_name').val();
      if (firmid === "") {
        alert("Please select firm");
        return;
      }
      return $.ajax({
        type: 'get',
        url: '/backoffice/firm-invite/' + firmid + '/' + invite_type,
        success: function(data) {
          console.log(data);
          CKEDITOR.instances['invite_content'].setData(data.invite_content);
          return $('input[name="invite_link"]').val("http://seedtwin.ajency.in/register/?" + data.invite_key + "#" + invite_type);
        }
      });
    });
    $('body').on('click', '.squareline-tabs .nav-link.active', function(e) {
      e.preventDefault();
      return $('.squareline-tabs .nav-item .nav-link').toggleClass('d-none d-block');
    });
    if ($(window).width() < 767) {
      if ($('.toggle-btn input:checkbox:not(:checked)')) {
        column = 'table .' + $('.toggle-btn input').attr('name');
        $(column).hide();
      }
      $('body').on('click', '.toggle-btn', function() {
        column = 'table .' + $(this).find('input[type="checkbox"]').attr('name');
        $(column).toggle();
      });
      return;
    }
    $('select[name="invite_firm_name"]').change(function() {
      return $('#invite_display').addClass('d-none');
    });
    $('.cancel-invite-btn').click(function() {
      return $('#invite_display').addClass('d-none');
    });
    $('.save-invite-btn').click(function() {
      var firmid, invite_type;
      invite_type = $(this).attr('invite-type');
      firmid = $('#invite_firm_name').val();
      if (firmid === "") {
        alert("Please select firm");
        return;
      }
      return $('form[name="form-invite-firm"]').submit();
    });
    $('body').on('click', '.edit_valuation', function() {
      var business_id, share_price, total_valuation;
      business_id = $(this).attr('proposal-id');
      share_price = $(this).attr('share-price');
      total_valuation = $(this).attr('total-valuation');
      $('#editing_business_id').val(business_id);
      $('#inp_shareprice').val(share_price);
      $('#inp_totalvaluation').val(total_valuation);
      $('#currentValuationModal').modal('show');
    });
    $('body').on('click', '#current_valuation_save', function() {
      var business_id, share_price, total_valuation;
      total_valuation = $('#inp_totalvaluation').val();
      share_price = $('#inp_shareprice').val();
      business_id = $('#editing_business_id').val();
      return $.ajax({
        type: 'post',
        url: '/backoffice/save-current-business-valuation',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          'business_id': business_id,
          'share_price': share_price,
          'total_valuation': total_valuation
        },
        success: function(data) {
          $('.spn_totalvaluation_' + business_id).html(total_valuation);
          $('.spn_shareprice_' + business_id).html(share_price);
          if (data.status) {
            $('.gi-danger').addClass('d-none');
            $('.gi-danger').html("");
            $('.gi-success').html("Valuation Saved Successfully.");
            $('.spn_totalvaluation_' + business_id).html(total_valuation);
            return $('.spn_shareprice_' + business_id).html(share_price);
          } else {
            $('.gi-danger').html("Failed to Save Valuation.");
            return $('.gi-success').html("");
          }
        }
      });
    });
    $('.download-current-business-valuation-csv').click(function() {
      return window.open("/backoffice/current-valuations/export-current-valuations");
    });
    investmentClientTable = $('#datatable-investment-client').DataTable({
      'paging': false,
      'processing': false,
      'serverSide': true,
      'bAutoWidth': false,
      "dom": '<"top d-sm-flex justify-content-sm-between w-100"li>t<"bottom d-sm-flex justify-content-sm-between w-100"ip>',
      'aaSorting': [[1, 'asc']],
      'ajax': {
        url: '/backoffice/financials/get-investment-client',
        type: 'post',
        dataSrc: function(json) {
          console.log(json);
          $("#total_invested").html(json.totalInvested);
          $("#total_accrude").html(json.totalAccrude);
          $("#total_paid").html(json.totalPaid);
          $("#total_due").html(json.totalDue);
          return json.data;
        },
        data: function(data) {
          var filters;
          filters = {};
          filters.firm_ids = $('input[name="firm_ids"]').val();
          filters.firm_name = $('select[name="firm_name"]').val();
          filters.investor_name = $('select[name="investor_name"]').val();
          filters.client_category = $('select[name="client_category"]').val();
          filters.investment = $('select[name="investment"]').val();
          filters.duration_from = $('input[name="duration_from"]').val();
          filters.duration_to = $('input[name="duration_to"]').val();
          data.filters = filters;
          return data;
        },
        error: function() {}
      },
      'columns': [
        {
          'data': '#',
          "orderable": false
        }, {
          'data': 'invested_date',
          "orderable": false
        }, {
          'data': 'investment',
          "orderable": false
        }, {
          'data': 'investor',
          "orderable": false
        }, {
          'data': 'firm',
          "orderable": false
        }, {
          'data': 'invested_amount',
          "orderable": false
        }, {
          'data': 'accrude',
          "orderable": false
        }, {
          'data': 'paid',
          "orderable": false
        }, {
          'data': 'due',
          "orderable": false
        }, {
          'data': 'parent_firm',
          "orderable": false
        }, {
          'data': 'investment_gi_code',
          "orderable": false
        }, {
          'data': 'investor_gi_code',
          "orderable": false
        }, {
          'data': 'firm_gi_code',
          "orderable": false
        }, {
          'data': 'transaction_type',
          "orderable": false
        }, {
          'data': 'action',
          "orderable": false
        }
      ],
      'columnDefs': [
        {
          'targets': 'col-visble',
          'visible': false
        }
      ]
    });
    $('body').on('click', '.alter-investmentclient-table', function() {
      $('.inv-cli-cols').each(function() {
        var colIndex;
        colIndex = $(this).val();
        if ($(this).is(':checked')) {
          return investmentClientTable.column(colIndex).visible(true);
        } else {
          return investmentClientTable.column(colIndex).visible(false);
        }
      });
      $('#columnVisibility').modal('hide');
    });
    $('body').on('click', '.apply-investmentclient-filters', function() {
      var urlParams;
      urlParams = '';
      if ($('select[name="firm_name"]').val() !== "") {
        urlParams += 'firm=' + $('select[name="firm_name"]').val();
      }
      if ($('select[name="investor_name"]').val() !== "") {
        urlParams += '&investor=' + $('select[name="investor_name"]').val();
      }
      if ($('select[name="client_category"]').val() !== "") {
        urlParams += '&client-category=' + $('select[name="client_category"]').val();
      }
      if ($('select[name="investment"]').val() !== "") {
        urlParams += '&investment=' + $('select[name="investment"]').val();
      }
      if ($('input[name="duration_from"]').val() !== "") {
        urlParams += '&duration_from=' + $('input[name="duration_from"]').val();
      }
      if ($('input[name="duration_to"]').val() !== "") {
        urlParams += '&duration_to=' + $('input[name="duration_to"]').val();
      }
      window.history.pushState("", "", "?" + urlParams);
      investmentClientTable.ajax.reload();
    });
    $('body').on('click', '.reset-investmentclient-filters', function() {
      $('select[name="firm_name"]').val('').trigger('change');
      $('select[name="investor_name"]').val('').trigger('change');
      $('select[name="client_category"]').val('');
      $('select[name="investment"]').val('');
      $('input[name="duration_from"]').val('');
      $('input[name="duration_to"]').val('');
      window.history.pushState("", "", "?");
      investmentClientTable.ajax.reload();
    });
    $('.download-investmentclient-report').click(function() {
      var type, urlParams;
      type = $(this).attr('report-type');
      urlParams = '';
      if ($('input[name="firm_ids"]').val() !== "") {
        urlParams += 'firm_ids=' + $('input[name="firm_ids"]').val();
      }
      if ($('select[name="firm_name"]').val() !== "") {
        urlParams += '&firm=' + $('select[name="firm_name"]').val();
      }
      if ($('select[name="investor_name"]').val() !== "") {
        urlParams += '&investor_name=' + $('select[name="investor_name"]').val();
      }
      if ($('select[name="client_category"]').val() !== "") {
        urlParams += '&client_category=' + $('select[name="client_category"]').val();
      }
      if ($('select[name="investment"]').val() !== "") {
        urlParams += '&investment=' + $('select[name="investment"]').val();
      }
      if ($('input[name="duration_from"]').val() !== "") {
        urlParams += '&duration_from=' + $('input[name="duration_from"]').val();
      }
      if ($('input[name="duration_to"]').val() !== "") {
        urlParams += '&duration_to=' + $('input[name="duration_to"]').val();
      }
      if ($('input[name="business_ids"]').val() !== "") {
        urlParams += '&business_ids=' + $('input[name="business_ids"]').val();
      }
      if (type === 'csv') {
        return window.open("/backoffice/financials/export-investmentclient?" + urlParams);
      } else if (type === 'pdf') {
        return window.open("/backoffice/financials/investmentclient-pdf?" + urlParams);
      }
    });
    businessClientTable = $('#datatable-business-client').DataTable({
      'paging': false,
      'processing': false,
      'serverSide': true,
      'bAutoWidth': false,
      "dom": '<"top d-sm-flex justify-content-sm-between w-100"li>t<"bottom d-sm-flex justify-content-sm-between w-100"ip>',
      'aaSorting': [[1, 'asc']],
      'ajax': {
        url: '/backoffice/financials/get-business-client',
        type: 'post',
        dataSrc: function(json) {
          console.log(json);
          $("#total_invested").html(json.totalInvested);
          $("#total_accrude").html(json.totalAccrude);
          $("#total_paid").html(json.totalPaid);
          $("#total_due").html(json.totalDue);
          return json.data;
        },
        data: function(data) {
          var filters;
          filters = {};
          filters.firm_ids = $('input[name="firm_ids"]').val();
          filters.firm_name = $('select[name="firm_name"]').val();
          filters.investment = $('select[name="investment"]').val();
          filters.duration_from = $('input[name="duration_from"]').val();
          filters.duration_to = $('input[name="duration_to"]').val();
          data.filters = filters;
          return data;
        },
        error: function() {}
      },
      'columns': [
        {
          'data': '#',
          "orderable": false
        }, {
          'data': 'investment',
          "orderable": false
        }, {
          'data': 'invested_amount',
          "orderable": false
        }, {
          'data': 'accrude',
          "orderable": false
        }, {
          'data': 'paid',
          "orderable": false
        }, {
          'data': 'due',
          "orderable": false
        }, {
          'data': 'action',
          "orderable": false
        }
      ],
      'columnDefs': [
        {
          'targets': 'col-visble',
          'visible': false
        }
      ]
    });
    $('body').on('click', '.alter-businessclient-table', function() {
      $('.inv-cli-cols').each(function() {
        var colIndex;
        colIndex = $(this).val();
        if ($(this).is(':checked')) {
          return businessClientTable.column(colIndex).visible(true);
        } else {
          return businessClientTable.column(colIndex).visible(false);
        }
      });
      $('#columnVisibility').modal('hide');
    });
    $('body').on('click', '.apply-businessclient-filters', function() {
      var urlParams;
      urlParams = '';
      if ($('select[name="firm_name"]').val() !== "") {
        urlParams += 'firm=' + $('select[name="firm_name"]').val();
      }
      if ($('select[name="investment"]').val() !== "") {
        urlParams += '&investment=' + $('select[name="investment"]').val();
      }
      if ($('input[name="duration_from"]').val() !== "") {
        urlParams += '&duration_from=' + $('input[name="duration_from"]').val();
      }
      if ($('input[name="duration_to"]').val() !== "") {
        urlParams += '&duration_to=' + $('input[name="duration_to"]').val();
      }
      window.history.pushState("", "", "?" + urlParams);
      businessClientTable.ajax.reload();
    });
    $('body').on('click', '.reset-businessclient-filters', function() {
      $('select[name="firm_name"]').val('').trigger('change');
      $('select[name="investment"]').val('');
      $('input[name="duration_from"]').val('');
      $('input[name="duration_to"]').val('');
      window.history.pushState("", "", "?");
      businessClientTable.ajax.reload();
    });
    $('.download-businessclient-report').click(function() {
      var type, urlParams;
      type = $(this).attr('report-type');
      urlParams = '';
      if ($('input[name="firm_ids"]').val() !== "") {
        urlParams += 'firm_ids=' + $('input[name="firm_ids"]').val();
      }
      if ($('input[name="business_ids"]').val() !== "") {
        urlParams += '&business_ids=' + $('input[name="business_ids"]').val();
      }
      if ($('select[name="firm_name"]').val() !== "") {
        urlParams += '&firm=' + $('select[name="firm_name"]').val();
      }
      if ($('select[name="investment"]').val() !== "") {
        urlParams += '&investment=' + $('select[name="investment"]').val();
      }
      if ($('input[name="duration_from"]').val() !== "") {
        urlParams += '&duration_from=' + $('input[name="duration_from"]').val();
      }
      if ($('input[name="duration_to"]').val() !== "") {
        urlParams += '&duration_to=' + $('input[name="duration_to"]').val();
      }
      if (type === 'csv') {
        return window.open("/backoffice/financials/export-businessclient?" + urlParams);
      } else if (type === 'pdf') {
        return window.open("/backoffice/financials/businessclient-pdf?" + urlParams);
      }
    });
    $('body').on('click', 'input[name="ck_business"]', function() {
      var textVal;
      textVal = '';
      $('input[name="ck_business"]:checked').each(function() {
        return textVal += ',' + $(this).val();
      });
      return $('input[name="business_ids"]').val(textVal);
    });
    $('body').on('click', '.add-fees', function() {
      var businessId, investorId, type;
      investorId = $(this).attr('investor');
      businessId = $(this).attr('business');
      type = $(this).attr('type');
      $("#addFeesModel").find('input[name="investor_id"]').val(investorId);
      $("#addFeesModel").find('input[name="type"]').val(type);
      $("#addFeesModel").find('input[name="business_id"]').val(businessId);
      return $("#addFeesModel").modal('show');
    });
    return $('body').on('click', '.save-investment-fees', function() {
      var amount, businessId, comment, investorId, type;
      investorId = $('input[name="investor_id"]').val();
      businessId = $('input[name="business_id"]').val();
      type = $('input[name="type"]').val();
      amount = $('input[name="amount"]').val();
      comment = $('textarea[name="comments"]').val();
      return $.ajax({
        type: 'post',
        url: '/backoffice/financials/save-commission',
        data: {
          'investor_id': investorId,
          'business_id': businessId,
          'type': type,
          'comment': comment,
          'amount': amount
        },
        success: function(data) {
          if (type === 'wm') {
            investmentClientTable.ajax.reload();
          } else {
            businessClientTable.ajax.reload();
          }
          return $("#addFeesModel").modal('hide');
        }
      });
    });
  });

}).call(this);

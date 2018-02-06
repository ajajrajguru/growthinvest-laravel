(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var IntermediaryTable, api, businesslistingsTable, entrepreneurTable, firmsTable, fundmanagerTable, getUrlVars, initSerachForTable, updateSerachinput, usersTable;
    getUrlVars = function() {
      var hash, hashes, i, vars;
      vars = [];
      hash = void 0;
      hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
      i = 0;
      while (i < hashes.length) {
        hash = hashes[i].split('=');
        vars[hash[0]] = hash[1];
        console.log($('td[data-search="' + hash[0] + '"]').length);
        $('td[data-search="' + hash[0] + '"]').find('input').val(hash[1]);
        i++;
      }
      return vars;
    };
    $('.dataFilterTable thead th.w-search').each(function() {
      var title;
      title = $(this).text();
      $(this).closest('table').find('tr.filters td').eq($(this).index()).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });
    updateSerachinput = function(tableObj) {
      var urlParms;
      urlParms = getUrlVars();
      tableObj.columns().eq(0).each(function(colIdx) {
        var colVal;
        colVal = $('input', $('.filters td')[colIdx]).val();
        tableObj.column(colIdx).search(colVal).draw();
      });
    };
    initSerachForTable = function(tableObj) {
      var urlParms;
      urlParms = getUrlVars();
      tableObj.columns().eq(0).each(function(colIdx) {
        $('input', $('.filters td')[colIdx]).on('keyup change', function() {
          tableObj.column(colIdx).search(this.value).draw();
        });
      });
    };
    if ($('#datatable-firms').length) {
      firmsTable = $('#datatable-firms').DataTable({
        "paging": false,
        "info": true,
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
    }
    $(document).on('keyup', '.user-search-input input', function() {
      var urlParams;
      urlParams = '';
      $('.user-search-input input').each(function() {
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
    }
    if ($('#datatable-Intermediary').length) {
      IntermediaryTable = $('#datatable-Intermediary').DataTable({
        "paging": false,
        "info": true,
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
            'data': 'lbgr',
            "orderable": false
          }, {
            'data': 'action',
            "orderable": false
          }
        ]
      });
      initSerachForTable(IntermediaryTable);
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
                return IntermediaryTable.row($(this).closest('tr')).remove();
              }
            });
            $('.gi-success').removeClass('d-none');
            $('.gi-danger').addClass('d-none');
            $('.gi-success #message').html("Intermediaries Deleted Successfully.");
            return IntermediaryTable.draw();
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
      'aaSorting': [[1, 'asc']],
      'ajax': {
        url: '/backoffice/business-listings/get-businesslistings',
        type: 'post',
        data: function(data) {
          var filters;
          filters = {};
          filters.firm_name = $('select[name="firm_name"]').val();
          filters.business_listings_type = $('select[name="business_listings_type"]').val();
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
        url: '/backoffice/business-listings/get-businesslistings',
        type: 'post',
        data: function(data) {
          var filters;
          filters = {};
          filters.firm_name = $('select[name="firm_name"]').val();
          filters.business_listings_type = $('select[name="business_listings_type"]').val();
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
          'data': 'created_date',
          "orderable": false
        }, {
          'data': 'modified_date',
          "orderable": false
        }, {
          'data': 'firmtoraise'
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
    return $('.btn-view-invite').click(function() {
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
  });

}).call(this);

(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var IntermediaryTable, api, firmsTable, initSerachForTable, investorTable, usersTable;
    $('.dataFilterTable thead th.w-search').each(function() {
      var title;
      title = $(this).text();
      $(this).closest('table').find('tr.filters td').eq($(this).index()).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });
    initSerachForTable = function(tableObj) {
      tableObj.columns().eq(0).each(function(colIdx) {
        $('input', $('.filters td')[colIdx]).on('keyup change', function() {
          tableObj.column(colIdx).search(this.value).draw();
        });
      });
    };
    if ($('#datatable-firms').length) {
      firmsTable = $('#datatable-firms').DataTable({
        "paging": false,
        "info": false,
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
    if ($('#datatable-users').length) {
      usersTable = $('#datatable-users').DataTable({
        "paging": false,
        "info": false,
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
    }
    if ($('#datatable-Intermediary').length) {
      IntermediaryTable = $('#datatable-Intermediary').DataTable({
        "paging": false,
        "info": false,
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
      return $('.cancelFirmUpdateBtn').removeClass('d-none');
    });
    $(document).on('click', '.cancelFirmUpdateBtn', function() {
      $('.editmode').addClass('d-none');
      $('.reqField').addClass('d-none');
      $('.viewmode').removeClass('d-none');
      $(this).addClass('d-none');
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
    investorTable = $('#datatable-investors').DataTable({
      'pageLength': 50,
      'processing': true,
      'serverSide': true,
      'bAutoWidth': false,
      'aaSorting': [[1, 'desc']],
      'ajax': {
        url: '/backoffice/investor/get-investors',
        type: 'post',
        data: function(data) {
          var filters;
          filters = {};
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
          'data': 'name'
        }, {
          'data': 'certification_date'
        }, {
          'data': 'client_categorisation'
        }, {
          'data': 'parent_firm'
        }, {
          'data': 'registered_date'
        }, {
          'data': 'action',
          "orderable": false
        }
      ]
    });
    return $('.jobsearchinput').change(function() {
      investorTable.ajax.reload();
      return;
    });
  });

}).call(this);

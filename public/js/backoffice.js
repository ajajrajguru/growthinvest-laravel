(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var IntermediaryTable, api, firmsTable, initSerachForTable, investorTable, usersTable, validateQuiz;
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
    $('form').parsley().on('form:success', function() {
      $(this)[0].$element.find('.save-btn .fa-check').addClass('d-none');
      return $(this)[0].$element.find('.save-btn').addClass('running');
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
      'processing': false,
      'serverSide': true,
      'bAutoWidth': false,
      'aaSorting': [[1, 'asc']],
      'ajax': {
        url: '/backoffice/investor/get-investors',
        type: 'post',
        data: function(data) {
          var filters;
          filters = {};
          filters.firm_name = $('select[name="firm_name"]').val();
          filters.investor_name = $('select[name="investor_name"]').val();
          filters.client_category = $('select[name="client_category"]').val();
          filters.client_certification = $('select[name="client_certification"]').val();
          filters.investor_nominee = $('select[name="investor_nominee"]').val();
          filters.idverified = $('select[name="idverified"]').val();
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
          'data': 'parent_firm',
          "orderable": false
        }, {
          'data': 'registered_date',
          "orderable": false
        }, {
          'data': 'action',
          "orderable": false
        }
      ]
    });
    $('.download-investor-csv').click(function() {
      var client_category, client_certification, firm_name, idverified, investor_name, investor_nominee, userIds;
      firm_name = $('select[name="firm_name"]').val();
      investor_name = $('select[name="investor_name"]').val();
      client_category = $('select[name="client_category"]').val();
      client_certification = $('select[name="client_certification"]').val();
      investor_nominee = $('select[name="investor_nominee"]').val();
      idverified = $('select[name="idverified"]').val();
      userIds = '';
      $('.ck_investor').each(function() {
        if ($(this).is(':checked')) {
          return userIds += $(this).val() + ',';
        }
      });
      return window.open("/backoffice/investor/export-investors?firm_name=" + firm_name + "&investor_name=" + investor_name + "&client_category=" + client_category + "&client_certification=" + client_certification + "&investor_nominee=" + investor_nominee + "&idverified=" + idverified + "&user_ids=" + userIds);
    });
    $('.investorSearchinput').change(function() {
      investorTable.ajax.reload();
    });
    validateQuiz = function(btnObj) {
      var err;
      err = 0;
      $(btnObj).closest('.quiz-container').find('.questions').each(function() {
        if ($(this).find('input[data-correct="1"]:checked').length === 0) {
          $(this).find('.quiz-question').addClass('text-danger');
          return err++;
        } else {
          return $(this).find('.quiz-question').removeClass('text-danger');
        }
      });
      return err;
    };
    $('.submit-quiz').click(function() {
      var err;
      err = validateQuiz($(this));
      console.log(err);
      if (err > 0) {
        $(this).closest('.quiz-container').find('.quiz-success').addClass('d-none');
        $(this).closest('.quiz-container').find('.quiz-danger').removeClass('d-none');
        return $(this).closest('.quiz-container').find('.quiz-danger').find('#message').html("I'm sorry you got " + err + " answers wrong, please try again");
      } else {
        $(this).closest('.quiz-container').find('.quiz-success').removeClass('d-none');
        $(this).closest('.quiz-container').find('.quiz-danger').addClass('d-none');
        $(this).closest('.quiz-container').find('.quiz-success').find('#message').html("Congratulations you answered all questions correctly. Please now read the following statement and make the declaration thereafter");
        $(this).addClass('d-none');
        return $(this).attr('submit-quiz', "true");
      }
    });
    $('.save-retial-certification').click(function() {
      var btnObj, certification_type, clientCategoryId, err, giCode, inputData;
      btnObj = $(this);
      err = validateQuiz($(".retail-quiz-btn"));
      if (err > 0) {
        $(".retail-quiz-btn").closest('.quiz-container').find('.quiz-danger').removeClass('d-none');
        return $(".retail-quiz-btn").closest('.quiz-container').find('.quiz-danger').find('#message').html("Please answer the questionnaire before submitting.");
      } else {
        $(".retail-quiz-btn").closest('.quiz-container').find('.quiz-danger').addClass('d-none');
        clientCategoryId = $(this).attr('client-category');
        giCode = $(this).attr('inv-gi-code');
        certification_type = $('select[name="certification_type"]').val();
        inputData = '';
        $('.retail-input').each(function() {
          if ($(this).is(':checked')) {
            return inputData += $(this).attr('name') + ',';
          }
        });
        return $.ajax({
          type: 'post',
          url: '/backoffice/investor/' + giCode + '/save-client-categorisation',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            'save-type': 'retail',
            'certification_type': certification_type,
            'client_category_id': clientCategoryId,
            'input_name': inputData
          },
          success: function(data) {
            return btnObj.addClass('d-none');
          }
        });
      }
    });
    $('.save-sophisticated-Investor').click(function() {
      var btnObj, certification_type, clientCategoryId, conditions, giCode, terms;
      btnObj = $(this);
      clientCategoryId = $(this).attr('client-category');
      giCode = $(this).attr('inv-gi-code');
      certification_type = $('select[name="certification_type"]').val();
      terms = '';
      $('.sop-terms-input').each(function() {
        if ($(this).is(':checked')) {
          return terms += $(this).attr('name') + ',';
        }
      });
      conditions = '';
      $('.sop-conditions-input').each(function() {
        if ($(this).is(':checked')) {
          return conditions += $(this).attr('name') + ',';
        }
      });
      console.log(terms);
      if (terms === '') {
        $(this).closest('.tab-pane').find('.alert-danger').removeClass('d-none');
        return $(this).closest('.tab-pane').find('.alert-danger').find('#message').html("Please select atleast one of the Sophisticated Investor criteria.");
      } else {
        $(this).closest('.tab-pane').find('.alert-danger').addClass('d-none');
        return $.ajax({
          type: 'post',
          url: '/backoffice/investor/' + giCode + '/save-client-categorisation',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            'save-type': 'sophisticated',
            'certification_type': certification_type,
            'client_category_id': clientCategoryId,
            'conditions': conditions,
            'terms': terms
          },
          success: function(data) {
            return btnObj.addClass('d-none');
          }
        });
      }
    });
    return $('.save-high-net-worth').click(function() {
      var btnObj, certification_type, clientCategoryId, conditions, giCode, terms;
      btnObj = $(this);
      clientCategoryId = $(this).attr('client-category');
      giCode = $(this).attr('inv-gi-code');
      certification_type = $('select[name="certification_type"]').val();
      terms = '';
      $('.hi-terms-input').each(function() {
        if ($(this).is(':checked')) {
          return terms += $(this).attr('name') + ',';
        }
      });
      conditions = '';
      $('.hi-conditions-input').each(function() {
        if ($(this).is(':checked')) {
          return conditions += $(this).attr('name') + ',';
        }
      });
      if (terms === '') {
        $(this).closest('.tab-pane').find('.alert-danger').removeClass('d-none');
        return $(this).closest('.tab-pane').find('.alert-danger').find('#message').html("Please select atleast one of the High Net Worth Individual criteria.");
      } else {
        $(this).closest('.tab-pane').find('.alert-danger').addClass('d-none');
        return $.ajax({
          type: 'post',
          url: '/backoffice/investor/' + giCode + '/save-client-categorisation',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            'save-type': 'high_net_worth',
            'certification_type': certification_type,
            'client_category_id': clientCategoryId,
            'conditions': conditions,
            'terms': terms
          },
          success: function(data) {}
        });
      }
    });
  });

}).call(this);

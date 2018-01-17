(function() {
  $(document).ready(function() {
    var firmsTable, initSerachForTable, usersTable;
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
      $('#cke_ent_invite_content').removeClass('d-none')
      $('#cke_inv_invite_content').removeClass('d-none')
      $('#cke_fundmanager_invite_content').removeClass('d-none')
      $('.percentlbl').removeClass('d-none');
      return $('.cancelFirmUpdateBtn').removeClass('d-none');
    });
    $(document).on('click', '.cancelFirmUpdateBtn', function() {
      $('.editmode').addClass('d-none');
      $('.reqField').addClass('d-none');
      $('.viewmode').removeClass('d-none');
      $(this).addClass('d-none');
      $('#cke_ent_invite_content').addClass('d-none')
      $('#cke_inv_invite_content').addClass('d-none')
      $('#cke_fundmanager_invite_content').addClass('d-none')
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
    $('[data-toggle="popover"]').popover();

    return $('#giMenu').mmenu({
      navbar: {
        title: false
      }
    }, {
      clone: true
    });
  });

}).call(this);

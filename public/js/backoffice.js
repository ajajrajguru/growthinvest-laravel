(function() {
  var firmsTable, usersTable;

  firmsTable = $('#datatable-firms').DataTable({
    "paging": false,
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

  usersTable = $('#datatable-users').DataTable({
    "paging": false,
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

}).call(this);

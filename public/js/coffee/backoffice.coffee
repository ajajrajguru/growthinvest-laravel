$(document).ready ->
  $('.dataFilterTable thead th.w-search').each ->
    title = $(this).text()
    $(this).closest('table').find('tr.filters td').eq($(this).index()).html '<input type="text" class="form-control" placeholder="Search ' + title + '" />'
    return

  initSerachForTable = (tableObj) ->
    tableObj.columns().eq(0).each (colIdx) ->
      $('input', $('.filters td')[colIdx]).on 'keyup change', ->
        tableObj.column(colIdx).search(@value).draw()
        return
      return
    return

  if $('#datatable-firms').length
    firmsTable = $('#datatable-firms').DataTable(
      "paging": false
      "info": false

      'columns': [
        { 'data': 'logo' , "orderable": false}
        { 'data': 'name' }
        { 'data': 'firm_type' }
        { 'data': 'parent_firm'}
        { 'data': 'gi_code' }
        { 'data': 'action' , "orderable": false}
      ]

    )
    initSerachForTable(firmsTable)

  if $('#datatable-users').length
    usersTable = $('#datatable-users').DataTable(
      "paging": false
      "info": false

      'columns': [
        { 'data': 'name' }
        { 'data': 'email' }
        { 'data': 'role'}
        { 'data': 'firm' }
        { 'data': 'action' , "orderable": false}
      ]

    )
    initSerachForTable(usersTable)

  $(document).on 'click', '.editUserBtn', ->
    $('.editmode').removeClass('d-none');
    $('.reqField').removeClass('d-none');
    $('.viewmode').addClass('d-none'); 

    $(this).addClass('d-none');
    $('.cancelUpdateBtn').removeClass('d-none');

  $(document).on 'click', '.cancelUpdateBtn', ->
    $('.editmode').addClass('d-none');
    $('.reqField').addClass('d-none');
    $('.viewmode').removeClass('d-none'); 
    $(this).addClass('d-none');
    $('.editUserBtn').removeClass('d-none');

  # Menu JS
  $('#giMenu').mmenu { navbar: title: false }, clone: true
         


$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

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
      'aaSorting': [[1,'asc']]
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
      'aaSorting': [[0,'asc']]
      'columns': [
        { 'data': 'name' }
        { 'data': 'email' }
        { 'data': 'role'}
        { 'data': 'firm' }
        { 'data': 'action' , "orderable": false}
      ]

    )
    initSerachForTable(usersTable)

  if $('#datatable-Intermediary').length
    IntermediaryTable = $('#datatable-Intermediary').DataTable(
      "paging": false
      "info": false
      'aaSorting': [[1,'asc']]
      'columns': [
        { 'data': 'ckbox'  , "orderable": false}
        { 'data': 'intm_details' }
        { 'data': 'comp_name' }
        { 'data': 'comp_desc'}
        { 'data': 'submitted_on' }
        { 'data': 'lbgr'  , "orderable": false}
        { 'data': 'action' , "orderable": false}
      ]

    )
    initSerachForTable(IntermediaryTable)

  $(document).on 'change', '.delete_intm_users', ->
    if($('input[name="intermediary_user_delete[]"]:checked').length > 0)
      $('.delete-all-user').removeClass('d-none');
    else
      $('.delete-all-user').addClass('d-none');



  $(document).on 'click', '.select-all-user', ->
    $(this).addClass('d-none');
    $('.select-none-user').removeClass('d-none');
    $('.delete-all-user').removeClass('d-none');
    $(".delete_intm_users").prop('checked',true);

  $(document).on 'click', '.select-none-user', ->
    $(this).addClass('d-none');
    $('.select-all-user').removeClass('d-none');
    $('.delete-all-user').addClass('d-none');
    $(".delete_intm_users").prop('checked',false);

  $(document).on 'click', '.delete-all-user', ->
    userIds = ''

    $('.delete_intm_users').each ->
      if $(this).is(':checked')
        userIds += $(this).val()+','

    $.ajax
      type: 'post'
      url: '/backoffice/user/delete-user'
      headers:
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      data:
        'user_id': userIds
      success: (data) ->
        if data.status
          $('.delete_intm_users').each ->
            if $(this).is(':checked')
               IntermediaryTable.row($(this).closest('tr')).remove()

          $('.gi-success').removeClass('d-none')
          $('.gi-danger').addClass('d-none')
          $('.gi-success #message').html "Intermediaries Deleted Successfully."

          IntermediaryTable.draw()
        else
          $('.gi-success').addClass('d-none')
          $('.gi-danger').removeClass('d-none')
          $('.gi-danger #message').html "Failed to delete intermediaries."




  $(document).on 'click', '.editUserBtn', ->
    $('.editmode').removeClass('d-none');
    $('.reqField').removeClass('d-none');
    $('.viewmode').addClass('d-none');
    $('.disabledInput').attr('disabled',false)

    $(this).addClass('d-none');
    $('.cancelUpdateBtn').removeClass('d-none');

  $(document).on 'click', '.cancelUpdateBtn', ->
    $('.editmode').addClass('d-none');
    $('.reqField').addClass('d-none');
    $('.viewmode').removeClass('d-none');
    $('.disabledInput').attr('disabled',true)
    $(this).addClass('d-none');
    $('.editUserBtn').removeClass('d-none');


  $(document).on 'click', '.editFirmBtn', ->
    $('.editmode').removeClass('d-none');
    $('.reqField').removeClass('d-none');
    $('.viewmode').addClass('d-none');

    $(this).addClass('d-none');
    $('.cancelFirmUpdateBtn').removeClass('d-none');

  $(document).on 'click', '.cancelFirmUpdateBtn', ->
    $('.editmode').addClass('d-none');
    $('.reqField').addClass('d-none');
    $('.viewmode').removeClass('d-none');
    $(this).addClass('d-none');
    $('.editFirmBtn').removeClass('d-none');


  $(document).on 'click', '#change_pwd', ->
    $(this).addClass('d-none');
    $('#cancel_pwd').removeClass('d-none');
    $('.setpassword-cont').removeClass('d-none');

  $(document).on 'click', '#cancel_pwd', ->
    $(this).addClass('d-none');
    $('#change_pwd').removeClass('d-none');
    $('.setpassword-cont').addClass('d-none');

  $('[data-toggle="popover"]').popover()

  # Menu JS
  $('#giMenu').mmenu {
    navbar: title: false
    extensions: [ 'pagedim-black', 'theme-dark' ]
  }, clone: true
  api = $('#mm-giMenu').data('mmenu')
  api.bind 'open:start', ->
    $('.mobile-menu-toggle').addClass 'is-active'
  api.bind 'close:start', ->
    $('.mobile-menu-toggle').removeClass 'is-active'


  $(window).scroll ->
    scroll = $(window).scrollTop()
    if scroll >= 1
      $('header').addClass 'sticky'
      $('.navbar-menu').addClass 'dark'
    else
      $('header').removeClass 'sticky'
      $('.navbar-menu').removeClass 'dark'


  investorTable = $('#datatable-investors').DataTable(
    'pageLength': 50
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[1,'asc']]
    'ajax':
      url: '/backoffice/investor/get-investors'
      type: 'post'
      data: (data) ->

        filters = {}
        filters.firm_name = $('select[name="firm_name"]').val()
        filters.investor_name = $('select[name="investor_name"]').val()
        filters.client_category = $('select[name="client_category"]').val()
        filters.client_certification = $('select[name="client_certification"]').val()
        filters.investor_nominee = $('select[name="investor_nominee"]').val()
        filters.idverified = $('select[name="idverified"]').val()

        data.filters = filters
        data

      error: ->


        return


    'columns': [
      { 'data': '#' , "orderable": false}
      { 'data': 'name' }
      { 'data': 'certification_date'}
      { 'data': 'client_categorisation' }
      { 'data': 'parent_firm', "orderable": false }
      { 'data': 'registered_date', "orderable": false}
      { 'data': 'action' , "orderable": false}
    ])


  $('.download-investor-csv').click ->
    firm_name = $('select[name="firm_name"]').val()
    investor_name = $('select[name="investor_name"]').val()
    client_category = $('select[name="client_category"]').val()
    client_certification = $('select[name="client_certification"]').val()
    investor_nominee = $('select[name="investor_nominee"]').val()
    idverified = $('select[name="idverified"]').val()

    userIds = ''

    $('.ck_investor').each ->
      if $(this).is(':checked')
        userIds += $(this).val()+','

    window.open("/backoffice/investor/export-investors?firm_name="+firm_name+"&investor_name="+investor_name+"&client_category="+client_category+"&client_certification="+client_certification+"&investor_nominee="+investor_nominee+"&idverified="+idverified+"&user_ids="+userIds);

  $('.investorSearchinput').change ->
    investorTable.ajax.reload()
    return
 
  validateQuiz = (btnObj) ->  
    err = 0
    $(btnObj).closest('.quiz-container').find('.questions').each ->
      if($(this).find('input[data-correct="1"]:checked').length == 0)
        $(this).find('.quiz-question').addClass('text-danger')
        err++
      else
        $(this).find('.quiz-question').removeClass('text-danger')

    return err


  $('.submit-quiz').click ->
    err = validateQuiz($(this))
    console.log err

    if err > 0
      $(this).closest('.quiz-container').find('.quiz-success').addClass('d-none')
      $(this).closest('.quiz-container').find('.quiz-danger').removeClass('d-none')
      $(this).closest('.quiz-container').find('.quiz-danger').find('#message').html("I'm sorry you got "+err+" answers wrong, please try again")
    else
      $(this).closest('.quiz-container').find('.quiz-success').removeClass('d-none')
      $(this).closest('.quiz-container').find('.quiz-danger').addClass('d-none')
      $(this).closest('.quiz-container').find('.quiz-success').find('#message').html("Congratulations you answered all questions correctly. Please now read the following statement and make the declaration thereafter")
      $(this).addClass('d-none')
      $(this).attr('submit-quiz',"true")

  $('.save-retial-certification').click ->
    btnObj = $(this)
    err = validateQuiz($(".retail-quiz-btn"))
    
    if err > 0
      $(".retail-quiz-btn").closest('.quiz-container').find('.quiz-danger').removeClass('d-none')
      $(".retail-quiz-btn").closest('.quiz-container').find('.quiz-danger').find('#message').html("Please answer the questionnaire before submitting.")
    else
      clientCategoryId = $(this).attr('client-category')
      giCode = $(this).attr('inv-gi-code')
      certification_type = $('select[name="certification_type"]').val()
      inputData = '';
      $('.retail-input').each ->
        if $(this).is(':checked')
          inputData += $(this).attr('name')+','

      $.ajax
        type: 'post'
        url: '/backoffice/investor/'+giCode+'/save-client-categorisation'
        headers:
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        data:
          'save-type': 'retail'
          'certification_type': certification_type
          'client_category_id': clientCategoryId
          'input_name': inputData
        success: (data) ->
          btnObj.addClass('d-none')
 


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
    $('#cke_ent_invite_content').removeClass('d-none')
    $('#cke_inv_invite_content').removeClass('d-none')
    $('#cke_fundmanager_invite_content').removeClass('d-none')
    $('.percentlbl').removeClass('d-none');
    $('.cancelFirmUpdateBtn').removeClass('d-none');

  $(document).on 'click', '.cancelFirmUpdateBtn', ->
    $('.editmode').addClass('d-none');
    $('.reqField').addClass('d-none');
    $('.viewmode').removeClass('d-none');
    $(this).addClass('d-none');
    $('#cke_ent_invite_content').addClass('d-none')
    $('#cke_inv_invite_content').addClass('d-none')
    $('#cke_fundmanager_invite_content').addClass('d-none')
    $('.percentlbl').addClass('d-none');
    $('.editFirmBtn').removeClass('d-none');


  $(document).on 'click', '#change_pwd', ->
    $(this).addClass('d-none');
    $('#cancel_pwd').removeClass('d-none');
    $('.setpassword-cont').removeClass('d-none');

  $(document).on 'click', '#cancel_pwd', ->
    $(this).addClass('d-none');
    $('#change_pwd').removeClass('d-none');
    $('.setpassword-cont').addClass('d-none');

 
  if $('form').length && $('form').attr('data-parsley-validate') == true
    $('form').parsley().on 'form:success', ->
      $(this)[0].$element.find('.save-btn .fa-check').addClass('d-none')
      $(this)[0].$element.find('.save-btn').addClass 'running'
 


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


  entrepreneurTable = $('#datatable-entrepreneurs').DataTable(
    'pageLength': 50
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[0,'asc']]
    'ajax':
      url: '/backoffice/entrepreneurs/get-entrepreneurs'
      type: 'post'
      data: (data) ->
        filters = {}
        filters.firm_name = $('select[name="firm_name"]').val()
        data.filters = filters
        data

      error: ->


        return


    'columns': [        
      { 'data': 'name' }
      { 'data': 'email' }
      { 'data': 'firm'}
      { 'data': 'business' }         
      { 'data': 'registered_date'}
      { 'data': 'source', "orderable": false}
      { 'data': 'action' , "orderable": false}
    ])


  $('.entrepreneurSearchinput').change ->
    entrepreneurTable.ajax.reload()
    return

  $('.download-entrepreneur-csv').click ->
    firm_name = $('select[name="firm_name"]').val() 
    window.open("/backoffice/entrepreneur/export-entrepreneurs?firm_name="+firm_name);

  $('body').on 'click', '.entrepreneurs-reset-filters', ->
    $('select[name="firm_name"]').val('').trigger('change') 
    entrepreneurTable.ajax.reload()
    return

  fundmanagerTable = $('#datatable-fundmanagers').DataTable(
    'pageLength': 50
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[0,'asc']]
    'ajax':
      url: '/backoffice/fundmanagers/get-fundmanagers'
      type: 'post'
      data: (data) ->
        filters = {}
        filters.firm_name = $('select[name="firm_name"]').val()
        data.filters = filters
        data

      error: ->


        return


    'columns': [        
      { 'data': 'name' }
      { 'data': 'email' }
      { 'data': 'firm'}
      { 'data': 'business' }         
      { 'data': 'registered_date'}
      { 'data': 'source', "orderable": false}
      { 'data': 'action' , "orderable": false}
    ])


  $('.fundmanagerSearchinput').change ->
    fundmanagerTable.ajax.reload()
    return

  $('.download-fundmanager-csv').click ->
    firm_name = $('select[name="firm_name"]').val() 
    window.open("/backoffice/fundmanager/export-fundmanagers?firm_name="+firm_name);

  $('body').on 'click', '.fundmanagers-reset-filters', ->
    $('select[name="firm_name"]').val('').trigger('change') 
    fundmanagerTable.ajax.reload()
    return

  businesslistingsTable = $('#datatable-businesslistings').DataTable(
    'pageLength': 50
    'searching':false
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[1,'asc']]
    'ajax':
      url: '/backoffice/business-listings/get-businesslistings'
      type: 'post'
      data: (data) ->
        filters = {}
        filters.firm_name = $('select[name="firm_name"]').val()
        filters.business_listings_type = $('select[name="business_listings_type"]').val()
        data.filters = filters
        data

      error: ->


        return


    'columns': [    
      { 'data': 'logo' , "orderable": false}    
      { 'data': 'name' }
      { 'data': 'duediligence' }
      { 'data': 'created_date'}
      { 'data': 'modified_date'}
      { 'data': 'firmtoraise', "orderable": false}          
      { 'data': 'activity_sitewide', "orderable": false}
      { 'data': 'activity_firmwide', "orderable": false}
      { 'data': 'action' , "orderable": false}
    ])


  $('.businesslistingsSearchinput').change ->
    businesslistingsTable.ajax.reload()
    return
 

  $(document).on 'change', '#managebusiness_type', -> 
    window.open("/backoffice/"+$(this).val(),"_self");
  
  $('.download-business-listings-csv').click ->
    firm_name = $('select[name="firm_name"]').val() 
    business_listings_type = $('select[name="business_listings_type"]').val() 
    window.open("/backoffice/business-listing/export-business-listings?firm_name="+firm_name+"&business_listings_type="+business_listings_type);

  $('body').on 'click', '.business-listings-reset-filters', ->
    $('select[name="firm_name"]').val('').trigger('change') 
    $('select[name="business_listings_type"]').val('').trigger('change') 
    businesslistingsTable.ajax.reload()
    return


  businesslistingsTable = $('#datatable-currentbusinessvaluations').DataTable(
    'pageLength': 50
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[1,'asc']]
    'ajax':
      url: '/backoffice/business-listings/get-businesslistings'
      type: 'post'
      data: (data) ->
        filters = {}
        filters.firm_name = $('select[name="firm_name"]').val()
        filters.business_listings_type = $('select[name="business_listings_type"]').val()
        data.filters = filters
        data

      error: ->


        return


    'columns': [    
      { 'data': 'logo' , "orderable": false}    
      { 'data': 'name' }
      { 'data': 'duediligence' }
      { 'data': 'created_date', "orderable": false}
      { 'data': 'modified_date', "orderable": false}
      { 'data': 'firmtoraise'}          
      { 'data': 'activity_sitewide', "orderable": false}
      { 'data': 'activity_firmwide', "orderable": false}
      { 'data': 'action' , "orderable": false}
    ])

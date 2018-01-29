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
      $(".retail-quiz-btn").closest('.quiz-container').find('.quiz-danger').addClass('d-none')
      clientCategoryId = $(this).attr('client-category')
      giCode = $(this).attr('inv-gi-code')
      certification_type = $('select[name="certification_type"]').val()
      conditions = '';
      $('.retail-input').each ->
        if $(this).is(':checked')
          conditions += $(this).attr('name')+','

      quizAnswers = {};
      $(".retail-quiz-btn").closest('.quiz-container').find('.questions').each ->
        if($(this).find('input[data-correct="1"]:checked').length > 0)
          qid = $(this).find('input[data-correct="1"]:checked').attr('data-qid')
          optionLabel = $(this).find('input[data-correct="1"]:checked').attr('data-label')
          quizAnswers[qid]=optionLabel

      btnObj.addClass('running')
      $.ajax
        type: 'post'
        url: '/backoffice/investor/'+giCode+'/save-client-categorisation'
        headers:
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        data:
          'save-type': 'retail'
          'certification_type': certification_type
          'client_category_id': clientCategoryId
          'conditions': conditions
          'quiz_answers': quizAnswers
        success: (data) ->
          btnObj.removeClass('running')
          $('.elective-prof-inv-btn').removeClass('d-none')
          $(".submit-quiz").removeClass('d-none')
          $(".retail-quiz-btn").addClass('d-none')
          $(".save-certification").removeClass('d-none')
          btnObj.addClass('d-none')
          $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)
          

  $('.save-sophisticated-Investor').click ->
    btnObj = $(this)
    
    clientCategoryId = $(this).attr('client-category')
    giCode = $(this).attr('inv-gi-code')
    certification_type = $('select[name="certification_type"]').val()
    terms = '';
    $('.sop-terms-input').each ->
      if $(this).is(':checked')
        terms += $(this).attr('name')+','

    conditions = '';
    $('.sop-conditions-input').each ->
      if $(this).is(':checked')
        conditions += $(this).attr('name')+','

    console.log terms
    if(terms == '')
      $(this).closest('.tab-pane').find('.alert-danger').removeClass('d-none')
      $(this).closest('.tab-pane').find('.alert-danger').find('#message').html("Please select atleast one of the Sophisticated Investor criteria.")
    else
      $(this).closest('.tab-pane').find('.alert-danger').addClass('d-none')
      btnObj.addClass('running')
      $.ajax
        type: 'post'
        url: '/backoffice/investor/'+giCode+'/save-client-categorisation'
        headers:
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        data:
          'save-type': 'sophisticated'
          'certification_type': certification_type
          'client_category_id': clientCategoryId
          'conditions': conditions
          'terms': terms
        success: (data) ->
          btnObj.removeClass('running')
          $('.elective-prof-inv-btn').removeClass('d-none')
          $(".save-certification").removeClass('d-none')
          btnObj.addClass('d-none')
          $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)

  $('.save-high-net-worth').click ->
    btnObj = $(this)
    
    clientCategoryId = $(this).attr('client-category')
    giCode = $(this).attr('inv-gi-code')
    certification_type = $('select[name="certification_type"]').val()
    terms = '';
    $('.hi-terms-input').each ->
      if $(this).is(':checked')
        terms += $(this).attr('name')+','

    conditions = '';
    $('.hi-conditions-input').each ->
      if $(this).is(':checked')
        conditions += $(this).attr('name')+','

 
    if(terms == '')
      $(this).closest('.tab-pane').find('.alert-danger').removeClass('d-none')
      $(this).closest('.tab-pane').find('.alert-danger').find('#message').html("Please select atleast one of the High Net Worth Individual criteria.")
    else
      $(this).closest('.tab-pane').find('.alert-danger').addClass('d-none')
      btnObj.addClass('running')
      $.ajax
        type: 'post'
        url: '/backoffice/investor/'+giCode+'/save-client-categorisation'
        headers:
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        data:
          'save-type': 'high_net_worth'
          'certification_type': certification_type
          'client_category_id': clientCategoryId
          'conditions': conditions
          'terms': terms
        success: (data) ->
          btnObj.removeClass('running')
          $('.elective-prof-inv-btn').removeClass('d-none')
          $(".save-certification").removeClass('d-none')
          btnObj.addClass('d-none')
          $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)


  $('.save-professsional-inv').click ->
    btnObj = $(this)
    clientCategoryId = $(this).attr('client-category')
    giCode = $(this).attr('inv-gi-code')
    certification_type = $('select[name="certification_type"]').val()

    conditions = '';
    $('.pi-conditions-input').each ->
      if $(this).is(':checked')
        conditions += $(this).attr('name')+','

    btnObj.addClass('running')
    $.ajax
      type: 'post'
      url: '/backoffice/investor/'+giCode+'/save-client-categorisation'
      headers:
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      data:
        'save-type': 'professsional_investors'
        'certification_type': certification_type
        'client_category_id': clientCategoryId
        'conditions': conditions
      success: (data) ->
        btnObj.removeClass('running')
        $('.elective-prof-inv-btn').removeClass('d-none')
        $(".save-certification").removeClass('d-none')
        btnObj.addClass('d-none')
        $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
        $('.investor-certification').html(data.html)

  $('.save-advised-investor').click ->
    btnObj = $(this)
    
    clientCategoryId = $(this).attr('client-category')
    giCode = $(this).attr('inv-gi-code')
    certification_type = $('select[name="certification_type"]').val()
    
    if($('form[name="advised_investor"]').parsley().validate())
      conditions = '';
      $('.ai-conditions-input').each ->
        if $(this).is(':checked')
          conditions += $(this).attr('name')+','

      financialAdvisorInfo = {};
      financialAdvisorInfo['havefinancialadvisor']=$('input[name="havefinancialadvisor"]:checked').val()
      financialAdvisorInfo['advicefromauthorised']=$('input[name="advicefromauthorised"]:checked').val()
      financialAdvisorInfo['companyname']=$('input[name="companyname"]').val()
      financialAdvisorInfo['fcanumber']=$('input[name="fcanumber"]').val()
      financialAdvisorInfo['principlecontact']=$('input[name="principlecontact"]').val()
      financialAdvisorInfo['primarycontactfca']=$('input[name="primarycontactfca"]').val()
      financialAdvisorInfo['email']=$('input[name="email"]').val()
      financialAdvisorInfo['telephone']=$('input[name="telephone"]').val()
      financialAdvisorInfo['address']=$('textarea[name="address"]').val()
      financialAdvisorInfo['address2']=$('textarea[name="address2"]').val()
      financialAdvisorInfo['city']=$('input[name="city"]').val()
      financialAdvisorInfo['county']=$('select[name="county"]').val()
      financialAdvisorInfo['postcode']=$('input[name="postcode"]').val()
      financialAdvisorInfo['country']=$('select[name="country"]').val()

      btnObj.addClass('running')
      $.ajax
        type: 'post'
        url: '/backoffice/investor/'+giCode+'/save-client-categorisation'
        headers:
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        data:
          'save-type': 'advice_investors'
          'certification_type': certification_type
          'client_category_id': clientCategoryId
          'conditions': conditions
          'financial_advisor_info': financialAdvisorInfo
        success: (data) ->
          btnObj.removeClass('running')
          $('.elective-prof-inv-btn').removeClass('d-none')
          $(".save-certification").removeClass('d-none')
          btnObj.addClass('d-none')
          $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)

          
  $('.elective-prof-inv-btn').click ->
    $(this).attr('data-agree',"yes")
  
  $('.save-elective-prof-inv').click ->
    btnObj = $(this)
    
    err = validateQuiz($(".elective-prof-inv-quiz-btn"))
    
    if err > 0
      $(".elective-prof-inv-quiz-btn").closest('.quiz-container').find('.quiz-danger').removeClass('d-none')
      $(".elective-prof-inv-quiz-btn").closest('.quiz-container').find('.quiz-danger').find('#message').html("Please answer the questionnaire before submitting.")
    else
      
      $(".elective-prof-inv-quiz-btn").closest('.quiz-container').find('.quiz-danger').addClass('d-none')
      clientCategoryId = $(this).attr('client-category')
      giCode = $(this).attr('inv-gi-code')
      certification_type = $('select[name="certification_type"]').val()
 
      quizAnswers = {};
      $(".elective-prof-inv-quiz-btn").closest('.quiz-container').find('.questions').each ->
        if($(this).find('input[data-correct="1"]:checked').length > 0)
          qid = $(this).find('input[data-correct="1"]:checked').attr('data-qid')
          optionLabel = $(this).find('input[data-correct="1"]:checked').attr('data-label')
          quizAnswers[qid]=optionLabel
      btnObj.addClass('running')
      $.ajax
        type: 'post'
        url: '/backoffice/investor/'+giCode+'/save-client-categorisation'
        headers:
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        data:
          'save-type': 'elective_prof'
          'certification_type': certification_type
          'client_category_id': clientCategoryId
          'quiz_answers': quizAnswers
          'investor_statement': $('.elective-prof-inv-btn').attr('data-agree')
        success: (data) ->
          btnObj.removeClass('running')
          $('.elective-prof-inv-btn').addClass('d-none')
          $(".submit-quiz").removeClass('d-none')
          $(".elective-prof-inv-quiz-btn").addClass('d-none')
          $(".save-certification").removeClass('d-none')
          btnObj.addClass('d-none')
          $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)
 



  entrepreneurTable = $('#datatable-entrepreneurs').DataTable(
    'pageLength': 50
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[1,'asc']]
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
      { 'data': 'registered_date', "orderable": false}
      { 'data': 'source', "orderable": false}
      { 'data': 'action' , "orderable": false}
    ])


  $('.entrepreneurSearchinput').change ->
    entrepreneurTable.ajax.reload()
    return

  $('.download-entrepreneur-csv').click ->
    firm_name = $('select[name="firm_name"]').val() 
    window.open("/backoffice/entrepreneur/export-entrepreneurs?firm_name="+firm_name);



  fundmanagerTable = $('#datatable-fundmanagers').DataTable(
    'pageLength': 50
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[1,'asc']]
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
      { 'data': 'registered_date', "orderable": false}
      { 'data': 'source', "orderable": false}
      { 'data': 'action' , "orderable": false}
    ])


  $('.fundmanagerSearchinput').change ->
    fundmanagerTable.ajax.reload()
    return

  $('.download-fundmanager-csv').click ->
    firm_name = $('select[name="firm_name"]').val() 
    window.open("/backoffice/fundmanager/export-fundmanagers?firm_name="+firm_name);


  businesslistingsTable = $('#datatable-businesslistings').DataTable(
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


  $('.businesslistingsSearchinput').change ->
    businesslistingsTable.ajax.reload()
    return
 

  $(document).on 'change', '#managebusiness_type', -> 
    window.open("/backoffice/"+$(this).val(),"_self");
  

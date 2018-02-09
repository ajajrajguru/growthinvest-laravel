$(document).ready ->
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

  $('body').on 'click', '.reset-filters', ->
    $('select[name="firm_name"]').val('').trigger('change')
    $('select[name="investor_name"]').val('').trigger('change')
    $('select[name="client_category"]').val('')
    $('select[name="client_certification"]').val('')
    $('select[name="investor_nominee"]').val('')
    $('select[name="idverified"]').val('')
   
    investorTable.ajax.reload()
    return


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

  scrollTopContainer = (containerId) ->
    $('html, body').animate { scrollTop: $(containerId).offset().top }, 500
    false


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
      scrollTopContainer("#client-category-tabs")
      btnObj.closest('.tab-pane').find('.retail-investor-danger').removeClass('d-none')
      btnObj.closest('.tab-pane').find('.retail-investor-danger').find('#message').html("Please answer the questionnaire before submitting.")
    else
      btnObj.closest('.tab-pane').find('.retail-investor-danger').addClass('d-none')
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
          if data.isWealthManager == true
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          else
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)
          scrollTopContainer("#add_clients")
          

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
      scrollTopContainer("#client-category-tabs")
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
          if data.isWealthManager == true
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          else
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)
          scrollTopContainer("#add_clients")


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
      scrollTopContainer("#client-category-tabs")
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
          if data.isWealthManager == true
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          else
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)
          scrollTopContainer("#add_clients")


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
        if data.isWealthManager == true
          $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
        else
          $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
        $('.investor-certification').html(data.html)
        scrollTopContainer("#add_clients")

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
          if data.isWealthManager == true
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          else
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)
          scrollTopContainer("#add_clients")

          
  $('.elective-prof-inv-btn').click ->
    $(this).attr('data-agree',"yes")
    $(this).addClass('d-none')

  $(document).on 'change', '.has-financial-advisor', ->
    if($(this).val()=='yes')
      $('.advised-investor-questionnaire').removeClass('d-none');
    else
      $('.advised-investor-questionnaire').addClass('d-none');


  $(document).on 'change', 'input[name="investortype"]', ->
    if($(this).val()=='Angel')
      $('.investortype-angel').removeClass('d-none');
    else
      $('.investortype-angel').addClass('d-none');
  


  $('.save-elective-prof-inv').click ->
    btnObj = $(this)
    
    err = validateQuiz($(".elective-prof-inv-quiz-btn"))
    
    if err > 0
      btnObj.closest('.tab-pane').find('.elective-professional-investor-danger').removeClass('d-none')
      btnObj.closest('.tab-pane').find('.elective-professional-investor-danger').find('#message').html("Please answer the questionnaire before submitting.")
      scrollTopContainer("#client-category-tabs")
    else
      btnObj.closest('.tab-pane').find('.elective-professional-investor-danger').addClass('d-none')
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
          if data.isWealthManager == true
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          else
            $('.gi-success').removeClass('d-none').find('#message').html("Your client has successfully been confirmed as Investor on our platform. He/She will be now be able to participate in business proposal.")
          $('.investor-certification').html(data.html)
          scrollTopContainer("#add_clients")

  $(document).on 'click', '.submit-signature', ->
    $('input[name="send_signature"]').val 'yes'
    $('form[name="add-investor-ia"]').submit()
    
  $(document).on 'change', 'input[name="advdetailsnotapplicable"]', ->
    if $(this).is(':checked')
      $('.adv-details-applicable-data').find('.form-control').removeClass('text-input-status').removeClass('completion_status')
    else
      $('.adv-details-applicable-data').find('.form-control').addClass('text-input-status').addClass('completion_status')  

  $(document).on 'change', 'input[name="nonationalinsuranceno"]', ->
    if $(this).is(':checked')
      $('.nonationalinsuranceno-container').removeClass('d-none');
      $('input[name="nationality"]').attr('data-parsley-required',true).addClass('text-input-status').addClass('completion_status') 
      $('input[name="domiciled"]').attr('data-parsley-required',true).addClass('text-input-status').addClass('completion_status')  
    else
      $('.nonationalinsuranceno-container').addClass('d-none');
      $('input[name="nationality"]').attr('data-parsley-required',false).removeClass('text-input-status').removeClass('completion_status')  
      $('input[name="domiciled"]').attr('data-parsley-required',false).removeClass('text-input-status').removeClass('completion_status')  

  $(document).on 'change', 'input[name="sendtaxcertificateto"]', ->
    if($(this).val()=='yourself')
      $('.sendtaxcertificateto-yourself').addClass('d-none');
      $('.sendtaxcertificateto-yourself').find('.form-control').attr('data-parsley-required',false).removeClass('text-input-status').removeClass('completion_status')   
    else
      $('.sendtaxcertificateto-yourself').removeClass('d-none');
      $('.sendtaxcertificateto-yourself').find('.form-control').attr('data-parsley-required',true).addClass('text-input-status').addClass('completion_status') 

  $(document).on 'change', 'input[name="transfer_at_later_stage"]', ->
    if($(this).val()=='no')
      $('.bank-input').each ->
        if($(this).val() != '')
          $(this).attr('data-parsley-required',true).attr('readonly',false).addClass('text-input-status').addClass('completion_status') 
         
      $('input[name="subscriptiontransferdate"]').attr('data-parsley-required',false).attr('readonly',false).addClass('text-input-status').addClass('completion_status')   
    else
      $('.bank-input').attr('data-parsley-required',false).attr('readonly',true).removeClass('text-input-status').removeClass('completion_status')    

  $(document).on 'change', 'input[name="nomineeverification"]', ->
    status = 'Not Yet Requested'
    if $(this).is(':checked')
      status = $(this).attr('data-text')
      if($(this).val()=='complete_pending_evidence')
        $('input[name="nomverificationwithoutface"]').attr('readonly',false) 
        $('.requested-input').prop('checked',false) 
      else if($(this).val()=='requested')
        $('input[name="nomverificationwithoutface"]').attr('readonly',true) 
        $('.complete-pending-evidence-input').prop('checked',false) 
        $('input[name="nomverificationwithoutface"]').prop('checked',false) 

    $('input[name="verdisplaystatus"]').val(status) 

 
  $(document).on 'change', 'input[name="subscriptioninvamntbank"]', ->
    if($(this).val() != '')
      $('input[name="subscriptioninvamntcheq"]').attr('readonly',true).attr('data-parsley-required',false)
      $('input[name="subscriptioninvamntcheq"]').removeClass('text-input-status').removeClass('completion_status')
    else
      $('input[name="subscriptioninvamntcheq"]').attr('readonly',false).attr('data-parsley-required',true)
      $('input[name="subscriptioninvamntcheq"]').addClass('text-input-status').addClass('completion_status')


  $(document).on 'change', 'input[name="subscriptioninvamntcheq"]', ->
    if($(this).val() != '')
      $('input[name="subscriptioninvamntbank"]').attr('readonly',true).attr('data-parsley-required',false)
      $('input[name="subscriptioninvamntbank"]').removeClass('text-input-status').removeClass('completion_status')
    else
      $('input[name="subscriptioninvamntbank"]').attr('readonly',false).attr('data-parsley-required',true)
      $('input[name="subscriptioninvamntbank"]').addClass('text-input-status').addClass('completion_status')

 
  $(document).on 'change', '.completion_status', ->
    cardObj = $(this).closest('.parent-tabpanel')
    sectionNo = cardObj.attr('data-section')
    dataValid = 0

    # validate section
    cardObj.find('.completion_status').each ->
      if(!$(this).parsley().isValid())
        dataValid++

    # check if data is complete
    dataInComp = 0

    cardObj.find('.text-input-status').each ->
      if($(this).val() == '')
        dataInComp++

    cardObj.find('.checked-input-status').each ->
      ckName = $(this).attr 'name'
      if !$('input[name="'+ckName+'"]').is(':checked')
        dataInComp++

    console.log dataInComp
    console.log dataValid
    if dataInComp == 0 && dataValid == 0
      console.log 'Complete'
      $('.section'+sectionNo+'-status').text('Complete') 
      $('.section'+sectionNo+'-status-input').val('complete') 
    else
      console.log 'Incomplete'
      $('.section'+sectionNo+'-status').text('Incomplete') 
      $('.section'+sectionNo+'-status-input').val('incomplete')
    
 
  $(document).on 'keyup', '.invest-perc', ->
    $('.investment-input').attr('readonly',false)
    $('.aic-investment-input').attr('readonly',false)
    ipEmpty = true
    $('.invest-perc').each ->
      if($(this).val()!="" && ipEmpty)
        ipEmpty = false

    if !ipEmpty
      $('.aic-investment-input').attr('readonly',true)
      $('.invest-amount').attr('readonly',true)

  $(document).on 'keyup', '.invest-amount', ->
    $('.investment-input').attr('readonly',false)
    $('.aic-investment-input').attr('readonly',false)
    iaEmpty = true
    $('.invest-amount').each ->
      if($(this).val()!="" && iaEmpty)
        iaEmpty = false

    if !iaEmpty
      $('.aic-investment-input').attr('readonly',true)
      $('.invest-perc').attr('readonly',true)

  $(document).on 'keyup', '.aic-investment-perc', ->
    $('.investment-input').attr('readonly',false)
    $('.aic-investment-input').attr('readonly',false)
    if($(this).val()!="")
      $('.investment-input').attr('readonly',true)
      $('.aic-investment-amount').attr('readonly',true)

  $(document).on 'keyup', '.aic-investment-amount', ->
    $('.investment-input').attr('readonly',false)
    $('.aic-investment-input').attr('readonly',false)
    if($(this).val()!="")
      $('.investment-input').attr('readonly',true)
      $('.aic-investment-perc').attr('readonly',true)


  $(document).on 'click', '.reply-comment', ->
    $(this).closest('.reply-del-action').addClass('d-none')
    $(this).closest('.media-action').find('.reply-to-comment').removeClass('d-none')


  $(document).on 'click', '.submit-query', ->
    btnObj = $(this)
    query = $(this).closest('.submit-query-cont').find('textarea').val()
    parentId = $(this).attr('parent-id')
    qType = $('#question_type').val()
    objectType = $('#object_type').val()
    objectId = $('#object_id').val()
    $.ajax
      type: 'post'
      url: '/backoffice/save-news-update'
      data:
        'query': query
        'parentId': parentId
        'type': qType
        'object-type': objectType
        'object-id': objectId
      success: (data) ->
        console.log parentId
        if parentId != '0'
          btnObj.closest('.media-body').append(data.comment_html)
          btnObj.closest('.media-action').find('.reply-del-action').removeClass('d-none')
          btnObj.closest('.media-action').find('.reply-to-comment').addClass('d-none')
           
        else
          $('.main-media-container').append(data.comment_html)
          console.log "child"

        btnObj.closest('.submit-query-cont').find('textarea').val ''

        return
      error: (request, status, error) ->
        throwError()
        return

  $(document).on 'click', '.delete-comment', ->
    if confirm('Are you sure you want to delete this comment?')
      btnObj = $(this)
      commentId = $(this).attr('comment-id')
      $.ajax
        type: 'post'
        url: '/backoffice/delete-news-update'
        data:
          'commentId': commentId
        success: (data) ->
           
          btnObj.closest('.media').remove()

          return
        error: (request, status, error) ->
          throwError()
          return


  investorInvestTable = $('#datatable-investor-invest').DataTable(
    'pageLength': 50
    'processing': false
    'serverSide': true
    'bAutoWidth': false
    'aaSorting': [[0,'asc']]
    'ajax':
      url: '/backoffice/investor/get-investor-invest'
      type: 'post'
      data: (data) ->

        filters = {}
        filters.company = $('select[name="company"]').val()
        filters.sector = $('select[name="sector"]').val()
        filters.type = $('select[name="type"]').val()
        filters.manager = $('select[name="manager"]').val()

        status = ''
        $('input[name="tax_status[]"]').each ->
          if $(this).is(':checked')
            status += $(this).val()+','

        filters.tax_status = status
 
        data.filters = filters
        data

      error: ->


        return


    'columns': [
      { 'data': 'offer' }
      { 'data': 'manager' }
      { 'data': 'tax_status'}
      { 'data': 'type' }
      { 'data': 'focus' }
      { 'data': 'taget_raise' }
      { 'data': 'min_inv' }
      { 'data': 'amt_raised' }
      { 'data': 'invest' , "orderable": false}
      { 'data': 'download' , "orderable": false}

    ])


  
  $('body').on 'change', 'input[name="tax_status[]"]', ->
    if $(this).is(':checked') && $(this).val()=='all'
      $('input[name="tax_status[]"]').prop('checked',false).attr('disabled',true)
      $(this).prop('checked',true).attr('disabled',false)
    else
      $('input[name="tax_status[]"]').attr('disabled',false)




  $('body').on 'click', '.alter-table', ->
    $('.invest-cols').each ->
      colIndex = $(this).val()
      if $(this).is(':checked')
        investorInvestTable.column( colIndex ).visible( true );
      else
        investorInvestTable.column( colIndex ).visible( false );
    # investorInvestTable.draw()

  $('body').on 'click', '.apply-invest-filters', ->
    investorInvestTable.ajax.reload()

  $('body').on 'click', '.reset-invest-filters', ->
    $('select[name="company"]').val('')
    $('select[name="sector"]').val('')
    $('select[name="type"]').val('')
    $('select[name="manager"]').val('')
    $('input[name="tax_status[]"]').prop('checked',false)
   
    investorInvestTable.ajax.reload()
    return

 

  






      
 
  

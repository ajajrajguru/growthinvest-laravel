$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->
  getInvestmentOpportunity = () -> 

    $('.investment-loader').addClass('d-flex').removeClass('d-none')
    $('.no-data-conatiner').removeClass('d-flex').addClass('d-none')
    $('.business-listing').html ''
    $('.platform-listing').html ''

    urlParams = ''
    filters = {}
    filters.business_listing_type = $('input[name="business_listing_type"]').val();
    filters.order_by = $('select[name="order_by"]').val();

    status = ''
    status_slug = ''
    $('input[name="tax_status[]"]').each ->
      if $(this).is(':checked')
        status += $(this).val()+','
        status_slug += $(this).attr('slug-val')+','

    filters.tax_status = status

    if(status_slug!='')
      urlParams +='&investment-type='+status_slug

    ######***##### 
    sectors = ''
    sectors_slug = ''
    $('input[name="business_sector[]"]').each ->
      if $(this).is(':checked')
        sectors += $(this).val()+','
        sectors_slug += $(this).attr('slug-val')+','

    filters.sectors = sectors

    if(sectors_slug!='')
      urlParams +='&business-sector='+sectors_slug

    ######***##### 
    due_deligence = ''
    due_deligence_slug = ''
    $('input[name="due_deligence[]"]').each ->
      if $(this).is(':checked')
        due_deligence += $(this).val()+','
        due_deligence_slug += $(this).attr('slug-val')+','

    filters.due_deligence = due_deligence

    if(due_deligence_slug!='')
      urlParams +='&due-diligence='+due_deligence_slug

    ######***##### 
    business_stage = ''
    business_stage_slug = ''
    $('input[name="business_stage[]"]').each ->
      if $(this).is(':checked')
        business_stage += $(this).val()+','
        business_stage_slug += $(this).attr('slug-val')+','

    filters.business_stage = business_stage

    if(business_stage_slug!='')
      urlParams +='&business-stage='+business_stage_slug

    ######***##### 
    funded_per = ''
    funded_per_slug = ''
    $('input[name="funded_per[]"]').each ->
      if $(this).is(':checked')
        funded_per += $(this).val()+','
        funded_per_slug += $(this).attr('slug-val')+','

    filters.funded_per = funded_per

    if(funded_per_slug!='')
      urlParams +='&funded='+funded_per_slug

    ######***##### 
    investment_sought = ''
    investment_sought_slug = ''
    $('input[name="investment_sought[]"]').each ->
      if $(this).is(':checked')
        investment_sought += $(this).val()+','
        investment_sought_slug += $(this).attr('slug-val')+','

    filters.investment_sought = investment_sought

    if(investment_sought_slug!='')
      urlParams +='&investment-sought='+investment_sought_slug

    ######***##### 
    search_title = $('input[name="search_title"]').val()
    filters.search_title = search_title

    if(search_title!='')
      urlParams +='&title='+search_title
    
    ######***##### 
    



    fund_type = ''
    fund_type_slug = ''
    $('input[name="fund_type[]"]').each ->
      if $(this).is(':checked')
        fund_type += $(this).val()+','
        fund_type_slug += $(this).attr('slug-val')+','

    filters.fund_type = fund_type

    if(fund_type_slug!='')
      urlParams +='&fund-regulatory-status='+fund_type_slug

    ######***##### 
    
    fund_status = ''
    fund_status_slug = ''
    $('input[name="fund_status[]"]').each ->
      if $(this).is(':checked')
        fund_status += $(this).val()+','
        fund_status_slug += $(this).attr('slug-val')+','

    filters.fund_status = fund_status
    if(fund_status_slug!='')
      urlParams +='&fund-status='+fund_status_slug

    ######***##### 
    
    fund_investmentobjective = ''
    fund_investmentobjective_slug = ''
    $('input[name="fund_investmentobjective[]"]').each ->
      if $(this).is(':checked')
        fund_investmentobjective += $(this).val()+','
        fund_investmentobjective_slug += $(this).attr('slug-val')+','

    filters.fund_investmentobjective = fund_investmentobjective
    if(fund_investmentobjective_slug!='')
      urlParams +='&investment-focus='+fund_investmentobjective_slug

    ######***##### 

    vct_type = ''
    vct_type_slug = ''
    $('input[name="vct_type[]"]').each ->
      if $(this).is(':checked')
        vct_type += $(this).val()+','
        vct_type_slug += $(this).attr('slug-val')+','

    filters.vct_type = vct_type
    if(vct_type_slug!='')
      urlParams +='&vct-type='+vct_type_slug

     ######***##### 
    vct_investmentstrategy = ''
    vct_investmentstrategy_slug = ''
    $('input[name="vct_investmentstrategy[]"]').each ->
      if $(this).is(':checked')
        vct_investmentstrategy += $(this).val()+','
        vct_investmentstrategy_slug += $(this).attr('slug-val')+','

    filters.vct_investmentstrategy = vct_investmentstrategy
    if(vct_investmentstrategy_slug!='')
      urlParams +='&vct-investment-strategy='+vct_investmentstrategy_slug

     ######***##### 
    vct_offeringtype = ''
    vct_offeringtype_slug = ''
    $('input[name="vct_offeringtype[]"]').each ->
      if $(this).is(':checked')
        vct_offeringtype += $(this).val()+','
        vct_offeringtype_slug += $(this).attr('slug-val')+','

    filters.vct_offeringtype = vct_offeringtype
    if(vct_offeringtype_slug!='')
      urlParams +='&vct-offering-type='+vct_offeringtype_slug

     ######***##### 
    aic_sector = ''
    aic_sector_slug = ''
    $('input[name="aic_sector[]"]').each ->
      if $(this).is(':checked')
        aic_sector += $(this).val()+','
        aic_sector_slug += $(this).attr('slug-val')+','

    filters.aic_sector = aic_sector
    if(aic_sector_slug!='')
      urlParams +='&aic-sector='+aic_sector_slug



    window.history.pushState("", "", "?"+urlParams);


    $.ajax
      type: 'post'
      url: '/investment-opportunities/filter-listings'
      data:filters
      success: (reponse) ->
        $('.business-listing').html ''
        $('.platform-listing').html ''
        
        if($('.business-listing').length)
          if reponse.businesslistingHtml !=""
            $('.open-investment-offers').removeClass('d-none')
          else
            $('.open-investment-offers').addClass('d-none')

          $('.business-listing').html reponse.businesslistingHtml

          if reponse.platformListingHtml !=""
            $('.platform-listing-section').removeClass('d-none')
          else
            $('.platform-listing-section').addClass('d-none')
          
          $('.platform-listing').html reponse.platformListingHtml

          # $('.knob').each ->
          #   $this = $(this)
          #   myVal = $this.attr('value')
          #   $this.knob 'readOnly': true
          #   $this.knob 'min': 0
          #   $this.knob 'max': 100
          #   $(value: 0).animate { value: myVal },
          #     duration: 1000
          #     easing: 'swing'
          #     step: ->
          #       $this.val(Math.ceil(@value)).trigger 'change'
          #       return
          #   return
          #   
          
          $('.knob').each ->
            $this = $(this)
            myVal = $this.attr('value')

            if(parseFloat(myVal)>100)
              $(this).attr('data-bgColor','#74b9eb')
              $(this).attr('data-fgColor','#E9D460')

            $(this).knob
              'min': 0
              'max': 100
              'readOnly': true
              'dynamicDraw': true
              'tickColorizeValues': true
              'skin': 'tron'
              'draw': ->
                $(@i).val myVal + '%'
                return

            $(value: 0).animate { value: myVal },
              duration: 1000
              easing: 'swing'
              step: ->
                $this.val(Math.ceil(@value)).trigger 'change'
                return


          $('.investment-loader').removeClass('d-flex').addClass('d-none')

          #tooltip
          $('[data-toggle="tooltip"]').tooltip(); 

          #due diligence popover
          $('[data-toggle="popover"]').popover
            trigger: 'hover'
            html: true
            content: ->
              $('#popover-content').html()

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
            
          #sticky header - white bg
          $(window).scroll ->
            scroll = $(window).scrollTop()
            if scroll >= 1
              $('header').addClass 'sticky'
              $('.navbar-menu').addClass 'dark'
            else
              $('header').removeClass 'sticky'
              $('.navbar-menu').removeClass 'dark'    

          if(reponse.totalBusinessListings==0)
            $('.no-data-conatiner').addClass('d-flex').removeClass('d-none')

        return
      error: (request, status, error) ->
        throwError()
        return 
  
  if($('.business-listing').length)    
    getInvestmentOpportunity()
 
  $(document).on 'change', 'select[name="order_by"]', ->
    getInvestmentOpportunity()
    
  # $(document).on 'change', '.filter-business-list', ->
  #   getInvestmentOpportunity()
  
  
  $(document).on 'click', '.apply-investment-opportunity', ->
    getInvestmentOpportunity()

  $(document).on 'click', '.search-by-title', ->
    getInvestmentOpportunity()

  $(document).on 'click', '.reset-investment-opportunity', ->
    $('input[name="tax_status[]"]').prop('checked',false)
    $('input[name="business_sector[]"]').prop('checked',false)
    $('input[name="due_deligence[]"]').prop('checked',false)
    $('input[name="business_stage[]"]').prop('checked',false)
    $('input[name="funded_per[]"]').prop('checked',false)
    $('input[name="investment_sought[]"]').prop('checked',false)
    $('input[name="aic_sector[]"]').prop('checked',false)
    $('input[name="fund_type[]"]').prop('checked',false)
    $('input[name="fund_status[]"]').prop('checked',false)
    $('input[name="fund_investmentobjective[]"]').prop('checked',false)
    $('input[name="vct_investmentstrategy[]"]').prop('checked',false)
    $('input[name="vct_type[]"]').prop('checked',false)
    $('input[name="vct_investmentstrategy[]"]').prop('checked',false)
    $('input[name="vct_offeringtype[]"]').prop('checked',false)
    $('input[name="search_title"]').val('')
    $('select[name="order_by"]').val('')
    getInvestmentOpportunity() 



    return

    
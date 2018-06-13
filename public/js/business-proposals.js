(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {
    var calculateFundRaised, calculateTargetRaised;
    $('.save-business-proposal').click(function() {
      var btnObj, form_data, hrefId, isValidTab, save_type, title, titleInvalidTabHeadObj;
      btnObj = $(this);
      title = $('input[name="title"]').val();
      save_type = btnObj.attr('save-type');
      if (save_type === 'submit') {
        if (!confirm('Are you sure you want to publish this changes?')) {
          return;
        }
      }
      hrefId = $('input[name="title"]').closest('.parent-tabpanel').attr('id');
      titleInvalidTabHeadObj = $('a[href="#' + hrefId + '"]').closest('.card-header');
      if (title === '') {
        $('input[name="title"]').parsley().validate();
        titleInvalidTabHeadObj.addClass('border border-danger');
        titleInvalidTabHeadObj.find('.has-invalid-data').removeClass('d-none');
      } else {
        titleInvalidTabHeadObj.removeClass('border border-danger');
        titleInvalidTabHeadObj.find('.has-invalid-data').addClass('d-none');
      }
      isValidTab = 0;
      if (save_type === 'submit') {
        $('form').find('.parent-tabpanel').each(function() {
          var invalidTabHeadObj, isComplete, sectionCount;
          hrefId = $(this).attr('id');
          sectionCount = $(this).attr('data-section');
          invalidTabHeadObj = $('a[href="#' + hrefId + '"]').closest('.card-header');
          invalidTabHeadObj.removeClass('border border-danger');
          invalidTabHeadObj.find('.has-invalid-data').addClass('d-none');
          $(this).find('.valid_input').each(function() {
            if (!$(this).parsley().isValid()) {
              $(this).parsley().validate();
              isValidTab++;
              if (isValidTab > 0) {
                invalidTabHeadObj.addClass('border border-danger');
                return invalidTabHeadObj.find('.has-invalid-data').removeClass('d-none');
              }
            }
          });
          isComplete = 0;
          $(this).find('.completion_status').each(function() {
            if ($(this).val() === '') {
              return isComplete++;
            }
          });
          if (isComplete === 0) {
            $('input[name="section_status_' + sectionCount + '"]').val('Complete');
            return $('.section' + sectionCount + '-status').text('Complete');
          } else {
            $('input[name="section_status_' + sectionCount + '"]').val('Incomplete');
            return $('.section' + sectionCount + '-status').text('Incomplete');
          }
        });
      }
      if (title !== '' && isValidTab === 0) {
        form_data = $('form').serializeArray();
        return $.ajax({
          type: 'post',
          url: '/business-proposals/save-all',
          data: {
            'form_data': form_data,
            'save_type': save_type
          },
          success: function(data) {
            $('input[name="refernce_id"]').val(data.refernce_id);
            if (data.gi_code !== '') {
              $('.is_published_config').removeClass('d-none');
            }
            $('.gi-success').html('Data Successfully Saved in Draft.').removeClass('d-none');
            if (save_type === 'submit') {
              window.location.href = "/investment-opportunities/" + data.business_type + "/" + data.business_slug;
            }
            if (data.redirect) {
              return window.location.href = "/investment-opportunities/" + data.business_type + "/" + data.business_slug + "/edit";
            } else {
              return console.log(data.gi_code);
            }
          }
        });
      }
    });
    $('.save-section').click(function() {
      var btnObj, form_data, hrefId, invalidTabHeadObj, isComplete, isValidTab, save_type, sectionCount, submitType, title, titleInvalidTabHeadObj;
      btnObj = $(this);
      title = $('input[name="title"]').val();
      submitType = btnObj.attr('submit-type');
      save_type = btnObj.attr('save-type');
      hrefId = $('input[name="title"]').closest('.parent-tabpanel').attr('id');
      titleInvalidTabHeadObj = $('a[href="#' + hrefId + '"]').closest('.card-header');
      if (title === '') {
        $('input[name="title"]').parsley().validate();
        titleInvalidTabHeadObj.addClass('border border-danger');
        titleInvalidTabHeadObj.find('.has-invalid-data').removeClass('d-none');
      } else {
        titleInvalidTabHeadObj.removeClass('border border-danger');
        titleInvalidTabHeadObj.find('.has-invalid-data').addClass('d-none');
      }
      hrefId = btnObj.closest('.parent-tabpanel').attr('id');
      isValidTab = 0;
      invalidTabHeadObj = $('a[href="#' + hrefId + '"]').closest('.card-header');
      invalidTabHeadObj.removeClass('border border-danger');
      invalidTabHeadObj.find('.has-invalid-data').addClass('d-none');
      btnObj.closest('.parent-tabpanel').find('.valid_input').each(function() {
        if (!$(this).parsley().isValid()) {
          $(this).parsley().validate();
          isValidTab++;
          if (isValidTab > 0) {
            invalidTabHeadObj.addClass('border border-danger');
            return invalidTabHeadObj.find('.has-invalid-data').removeClass('d-none');
          }
        }
      });
      isComplete = 0;
      sectionCount = btnObj.closest('.parent-tabpanel').attr('data-section');
      btnObj.closest('.parent-tabpanel').find('.completion_status').each(function() {
        if ($(this).val() === '') {
          return isComplete++;
        }
      });
      if (isComplete === 0) {
        $('input[name="section_status_' + sectionCount + '"]').val('Complete');
        $('.section' + sectionCount + '-status').text('Complete');
      } else {
        $('input[name="section_status_' + sectionCount + '"]').val('Incomplete');
        $('.section' + sectionCount + '-status').text('Incomplete');
      }
      if (title !== '' && isValidTab === 0) {
        form_data = btnObj.closest('form').serializeArray();
        return $.ajax({
          type: 'post',
          url: '/business-proposals/save',
          data: {
            'save_type': save_type,
            'submit_type': submitType,
            'form_data': form_data
          },
          success: function(data) {
            $('input[name="refernce_id"]').val(data.refernce_id);
            $('#' + submitType + '_msg').removeClass('d-none').delay(5000).fadeOut();
            if (data.redirect) {
              return window.location.href = "/investment-opportunities/" + data.business_type + "/" + data.business_slug + "/edit";
            } else {
              return console.log(data.business_slug);
            }
          }
        });
      }
    });
    $(document).on('click', '.discard-draft-changes', function() {
      var gi_code, refernce_id;
      if (!confirm('Are you sure you want to discard this changes?')) {
        return;
      }
      refernce_id = $('input[name="refernce_id"]').val();
      gi_code = $('input[name="gi_code"]').val();
      return $.ajax({
        type: 'post',
        url: '/business-proposals/discard-changes',
        data: {
          'refernce_id': refernce_id,
          'gi_code': gi_code
        },
        success: function(data) {
          return window.location.href = "/investment-opportunities/" + data.business_type + "/" + data.business_slug + "/edit";
        }
      });
    });
    $(document).on('change', 'input[name="not-calculated-share"]', function() {
      if ($(this).is(':checked')) {
        $("#target-raised-label").text("Targeted Raise");
        $("#target-raised-helper").text("Eg: £17,500.");
        $("#post-money-valuation-helper").text("");
        $("#post-money-valuation-label").text("Post-investment % shareholding to be issued");
        calculateTargetRaised();
        $('#investment-sought').removeAttr('readonly');
        $('#post-money-valuation').removeAttr('readonly');
        $('.not-calculated-share-checked').addClass('d-none');
        $('#no-of-shares-issue').attr('data-parsley-required', false);
        $('#no-of-new-shares-issue').attr('data-parsley-required', false);
        $('#share-price-curr-inv-round').attr('data-parsley-required', false);
        $('#share-class-issued').attr('data-parsley-required', false);
        return $('#nominal-value-share').attr('data-parsley-required', false);
      } else {
        $("#target-raised-label").text("Raise Amount");
        $("#target-raised-helper").text("This field is auto-calculated");
        $("#post-money-valuation-helper").text("This field is auto-calculated.");
        $("#post-money-valuation-label").text("Post-Investment % Equity Offer");
        calculateFundRaised();
        $('#investment-sought').attr('readonly', 'readonly');
        $('#post-money-valuation').attr('readonly', 'readonly');
        $('.not-calculated-share-checked').removeClass('d-none');
        $('#no-of-shares-issue').attr('data-parsley-required', true);
        $('#no-of-new-shares-issue').attr('data-parsley-required', true);
        $('#share-price-curr-inv-round').attr('data-parsley-required', true);
        $('#share-class-issued').attr('data-parsley-required', true);
        return $('#nominal-value-share').attr('data-parsley-required', true);
      }
    });
    calculateFundRaised = function() {
      var newpostmoneyval, newpremoneyval, newraiseamount, newsharepricewocomma, nosharepricewocomma, post_equity, postmoneyval, premoneyval, raiseamount, sharepricewocomma;
      if ($('#no-of-new-shares-issue').val() !== '' && $('#share-price-curr-inv-round').val() !== '') {
        sharepricewocomma = $('#share-price-curr-inv-round').val();
        newsharepricewocomma = $('#no-of-new-shares-issue').val();
        raiseamount = parseFloat(newsharepricewocomma) * parseFloat(sharepricewocomma);
        newraiseamount = parseFloat(raiseamount.toFixed(2));
        $('#investment-sought').val(newraiseamount);
        $('#investment-sought').attr('readonly', 'readonly');
      }
      if ($('#no-of-shares-issue').val() !== '' && $('#share-price-curr-inv-round').val() !== '') {
        sharepricewocomma = $('#share-price-curr-inv-round').val();
        nosharepricewocomma = $('#no-of-shares-issue').val();
        premoneyval = parseFloat(nosharepricewocomma) * parseFloat(sharepricewocomma);
        newpremoneyval = parseFloat(premoneyval.toFixed(2));
        $('#pre-money-valuation').val(newpremoneyval);
      }
      if ($('#no-of-new-shares-issue').val() !== '' && $('#no-of-new-shares-issue').val() !== '' && $('#share-price-curr-inv-round').val() !== '') {
        sharepricewocomma = $('#share-price-curr-inv-round').val();
        newsharepricewocomma = $('#no-of-new-shares-issue').val();
        nosharepricewocomma = $('#no-of-shares-issue').val();
        postmoneyval = (parseFloat(nosharepricewocomma) + parseFloat(newsharepricewocomma)) * parseFloat(sharepricewocomma);
        newpostmoneyval = parseFloat(postmoneyval.toFixed(2));
        $('#post-money-valuation').val(newpostmoneyval);
        $('#post-money-valuation').attr('readonly', 'readonly');
      }
      if ($('#no-of-new-shares-issue').val() !== '' && $('#no-of-shares-issue').val() !== '') {
        newsharepricewocomma = $('#no-of-new-shares-issue').val();
        nosharepricewocomma = $('#no-of-shares-issue').val();
        post_equity = parseFloat(newsharepricewocomma) / (parseFloat(newsharepricewocomma) + parseFloat(nosharepricewocomma)) * 100;
        $('#percentage-giveaway').val(post_equity.toFixed(2));
      }
    };
    calculateTargetRaised = function() {
      var investment_sought, percentage_giveaway, post_money_valuation, pre_money_valuation;
      investment_sought = $('#investment-sought').val();
      console.log(investment_sought);
      if (isNaN(investment_sought) || investment_sought === '') {
        investment_sought = 0;
      } else {
        investment_sought = parseFloat(investment_sought);
      }
      post_money_valuation = $('#post-money-valuation').val();
      console.log(post_money_valuation);
      if (isNaN(post_money_valuation) || post_money_valuation === '') {
        post_money_valuation = 0;
      } else {
        post_money_valuation = parseFloat(post_money_valuation);
      }
      pre_money_valuation = '';
      percentage_giveaway = '';
      if (post_money_valuation !== 0 && investment_sought !== 0) {
        pre_money_valuation = post_money_valuation - investment_sought;
        percentage_giveaway = investment_sought / post_money_valuation * 100;
        percentage_giveaway = Math.round(percentage_giveaway * 100) / 100;
      }
      $('#percentage-giveaway').val(percentage_giveaway);
      $('#pre-money-valuation').val(pre_money_valuation);
    };
    $(document).on('keyup', '.money-valuation-change', function() {
      return calculateTargetRaised();
    });
    $(document).on('keyup', '.share-price-change', function() {
      return calculateFundRaised();
    });
    $(document).on('click', '.delete_funds_row', function() {
      if (confirm('Are you sure you want to delete this Fund from your List?')) {
        return $(this).closest('.add-use-of-funds').remove();
      }
    });
    $(document).on('click', '.add_funds_row', function() {
      var html;
      html = '<div class="row add-use-of-funds"> <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode" name="use_of_funds" placeholder="" ></div></div> <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode" name="use_of_funds_amount" placeholder="" ></div></div> <div class="col-sm-2"><a class="delete_funds_row btn btn-primary text-right" ><i class="fa fa-trash"></i> &nbsp;</a></div> </div>';
      return $('.add-use-of-funds-container').append(html);
    });
    $(document).on('click', '.add-team-member', function() {
      var $btnObj, memberCounter;
      $btnObj = $(this);
      memberCounter = $('.member-counter').val();
      return $.ajax({
        type: 'post',
        url: '/business-proposals/add-team-member',
        data: {
          'memberCounter': memberCounter
        },
        success: function(data) {
          $("#crop-modal-container").append(data.cropModal);
          $btnObj.before(data.memberHtml);
          $('.member-counter').val(data.memberCount);
          uploadCropImage(data.containerId, data.pickFile, data.imageCLass, data.postUrl);
          return $('input[name="member_data"]').val('1');
        }
      });
    });
    $(document).on('click', '.delete-team-member', function() {
      console.log($('input[name="member_counter"]').val());
      if (($('.team-member').length)) {
        $('input[name="member_data"]').val('');
      }
      return $(this).closest('.team-member').remove();
    });
    $(document).on('click', '.add-social-link', function() {
      var $btnObj, html, linkCount, linkCounter, memberCounter;
      $btnObj = $(this);
      memberCounter = $('.member-counter').val();
      linkCounter = $('input[name="socialmedia_link_counter_' + memberCounter + '"]').val();
      linkCount = parseInt(linkCounter) + 1;
      html = '<div class="row social-link-row div-row-container"> <div class="col-sm-4 text-center"> <label>Social Media Link ' + linkCount + '</label> <input type="text" name="social_link_' + memberCounter + '_' + linkCount + '" class="form-control editmode"> </div> <div class="col-sm-4 text-center"> <label>Link Type</label> <select type="text" name="link_type_' + memberCounter + '_' + linkCount + '" placeholder="" class="form-control " > <option>--select--</option> <option>Facebook</option> <option>Twitter</option> <option>LinkedIn</option> <option>Other Weblink</option> </select> </div> <div class="col-sm-2 text-center"> <a href="javascript:void(0)" class="btn btn-default remove-social-link remove-row"><i class="fa fa-trash"></i></a> </div> </div>';
      $('input[name="socialmedia_link_counter_' + memberCounter + '"]').val(linkCount);
      return $btnObj.before(html);
    });
    $(document).on('click', '.remove-row', function() {
      return $(this).closest('.div-row-container').remove();
    });
    $(document).on('click', '.add-external-links ', function() {
      var $btnObj, html, linkCount, linkCounter, type;
      $btnObj = $(this);
      type = $btnObj.attr('link-type');
      console.log(type);
      linkCounter = $('input[name="' + type + '-counter"]').val();
      linkCount = parseInt(linkCounter) + 1;
      console.log(linkCount);
      html = '<div class="row div-row-container"> <div class="col-sm-4 text-center"> <input type="text" placeholder="Add File Title" name="' + type + '_title_' + linkCount + '" class="form-control editmode"> </div> <div class="col-sm-4 text-center"> <input type="text" placeholder="Add File Path" name="' + type + '_path_' + linkCount + '" class="form-control editmode"> </div> <div class="col-sm-2 text-center"> <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> </div> </div>';
      $('input[name="' + type + '-counter"]').val(linkCount);
      return $('.' + type + '-external-links').append(html);
    });
    $(document).on('click', '.save-business-video', function() {
      var counter, edit_container_count, embed_code, feedback, feedbackHtml, html, video_counter, video_name;
      video_name = $('input[name="video_name"]').val();
      embed_code = $('textarea[name="embed_code"]').val();
      edit_container_count = $('input[name="edit_container_count"]').val();
      if ($('input[name="feedback"]').is(":checked")) {
        feedback = 'yes';
        feedbackHtml = '<span class="fa fa-commenting  fa-2x" aria-hidden="true"></span>';
      } else {
        feedback = 'no';
        feedbackHtml = '-';
      }
      video_counter = $('input[name="video_counter"]').val();
      if (edit_container_count !== '') {
        counter = edit_container_count;
      } else {
        counter = parseInt(video_counter) + 1;
      }
      html = '';
      if (edit_container_count === '') {
        html = '<div class="row div-row-container" video-container-count="' + counter + '">';
      }
      html += '<div class="col-sm-3 text-center"> <input type="hidden" class="video_name" name="video_name_' + counter + '" value="' + video_name + '"> ' + video_name + '</div> <div class="col-sm-5 text-center"> <textarea name="embed_code_' + counter + '" class="d-none embed_code"> ' + embed_code + '    </textarea> <div height="200">' + embed_code + ' </div> </div> <div class="col-sm-2 text-center"> <input type="hidden" class="feedback" name="feedback_' + counter + '" value="' + feedback + '"> ' + feedbackHtml + '</div> <div class="col-sm-2 text-center"> <button type="button" class="edit-video" >edit</button> <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> </div>';
      if (edit_container_count === '') {
        html += '</div>';
      }
      if (edit_container_count === '') {
        $('input[name="video_counter"]').val(counter);
        $('.proposal-video-container').append(html);
      } else {
        $('div[video-container-count="' + edit_container_count + '"]').html(html);
      }
      $("#addVideos").modal('hide');
      $('input[name="video_name"]').val('');
      $('input[name="edit_container_count"]').val('');
      $('textarea[name="embed_code"]').val('');
      $('input[name="edit_container_count"]').val('');
      return $('input[name="feedback"]').prop("checked", false);
    });
    return $(document).on('click', '.edit-video', function() {
      var count, embed_code, feedback, video_name;
      video_name = $(this).closest('.video-container').find('.video_name').val();
      embed_code = $(this).closest('.video-container').find('.embed_code').val();
      feedback = $(this).closest('.video-container').find('.feedback').val();
      count = $(this).closest('.video-container').attr('video-container-count');
      $('input[name="edit_container_count"]').val(count);
      $('input[name="video_name"]').val(video_name);
      $('textarea[name="embed_code"]').val(embed_code);
      if (feedback === 'yes') {
        $('input[name="feedback"]').prop("checked", true);
      } else {
        $('input[name="feedback"]').prop("checked", false);
      }
      return $("#addVideos").modal('show');
    });
  });

}).call(this);

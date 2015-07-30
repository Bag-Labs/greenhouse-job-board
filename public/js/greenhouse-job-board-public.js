jQuery(document).ready(function($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	 
	$('.greenhouse-job-board[data-type="accordion"] .jobs').on('click', '.job_read_full', function(e){
		e.preventDefault();
		var job_id = $(this).parents('.job').data('id');
		if ( $(this).hasClass('open') ) {
			$(this).removeClass('open');
			$(this).text( $(this).data('closed-text') );
			$('.job_description_' + job_id).toggle(false);
			$('.job_description_' + job_id).removeClass('open');
		}
		else {
			$(this).addClass('open');
			$(this).text( $(this).data('opened-text') );
			$('.job_description_' + job_id).toggle(true);
			$('.job_description_' + job_id).addClass('open');
		}
	});
	$('.greenhouse-job-board').on('click', '.job_apply', function(e){
		
		e.preventDefault();
		
		if ( 	$('.greenhouse-job-board').data('form_type') === 'iframe' &&
				$(this).hasClass('open') ) {
			//closing since already open
			$(this).text( $(this).data('closed-text') );
			$(this).removeClass('open');
			if ($('#grnhse_app').hasClass('open')) {
				$('#grnhse_app').empty(); 
				$('#grnhse_app').removeClass('open');
			}
		}
		else if (	$('.greenhouse-job-board').data('form_type') === 'iframe' &&
					!$(this).hasClass('open') ){
			//close others
			$('.job_apply').removeClass('open');
			$('.job_apply').text( $(this).data('closed-text') );
			if ($('#grnhse_app').hasClass('open')) {
				$('#grnhse_app').empty(); 
				$('#grnhse_app').removeClass('open');
			}
			//open this one
			$(this).addClass('open');
			$(this).text( $(this).data('opened-text') );

			$(this).parent().append( $('#grnhse_app') ); 
			$('#grnhse_app').addClass('open');
			var jid = $(this).parents('.job').data('id');
		 	// console.log(jid);
		 	// Loads job with ID 5555555 with a source tracking token taken 
		 	// from the gh_src querystring parameter. NOTE: this is what you
		 	// want to do to ensure source tracking works (i.e., tracking
		 	// where a candidate came from)
		 	// Grnhse.Iframe.load(jid, 'abc123');

		 	// Loads job with ID 5555555 with no source tracking token
		 	Grnhse.Iframe.load(jid);

		 	// Loads the job board (not a specific application)
		 	// Grnhse.Iframe.load();	 });
		}
		// cycle job board with iframe form - reset height of container to contain the iframe
		if ( $('.greenhouse-job-board').data('form_type') === 'iframe' &&
			 $('.greenhouse-job-board').data('type') == 'cycle' ) {
			// setTimeout( reset_cycle_container_height, 1000);
		}
		
		// cycle job board with inline form
		if ( $('.greenhouse-job-board').data('form_type') === 'inline' ) {
			
			
			//pre select positions select
			var jobid = $(this).parents('.job').data('id');
			// console.log(jobid);
			update_form_per_position(null, jobid);
			
			$('.greenhouse-job-board[data-type="cycle"] .all_jobs').cycle('goto', 1 );
			jobs_scroll_top();
			
		}
	});

	// $('.greenhouse-job-board').on('blur', '#positions', update_form_per_position );

	function update_form_per_position( e, jobid ){
		// get json questoin data for this job
		var this_job = $.grep(ghjb_jobs, function (o,i){
			return o.id == jobid;
		});
		var job_questions = this_job[0].questions;
		
		//get form_fields from settings
		var form_fields = $('.jobs').attr('data-form_fields');
		if ( typeof form_fields !== typeof undefined && form_fields !== false ) {
			form_fields = form_fields.split('|');
		}
		else {
			form_fields = ['*'];
		}
				
		$("#apply_form *").remove();
		
		$("#apply_form").append('<h2>' + this_job[0].title + '</h2>');
		
		var hidden_field = "<input type='hidden' id='hidden_id' name='id' value='" + jobid + "' />";
		$("#apply_form").append(hidden_field);
		hidden_field = "<input type='hidden' id='hidden_mapped_url_token' name='mapped_url_token' value='" + this_job[0].absolute_url + "' />";
		$("#apply_form").append(hidden_field);
		
		
		for ( var i = 0; i < job_questions.length; i++){
			
			//check that the field is listed if form fields are specified
			// console.log(form_fields, job_questions[i].fields[0].name, job_questions[i].label);
			if ( form_fields[0] === '*' ||
				 jQuery.inArray( job_questions[i].fields[0].name, form_fields ) >= 0 ||
				 jQuery.inArray( job_questions[i].label, form_fields ) >= 0  ) {
			
				var field_wrap = "<div class='field_wrap field_" + job_questions[i].fields[0].name + "'>";
				//write label for field
				field_wrap += "<label for='" + job_questions[i].fields[0].name + "'>" + job_questions[i].label  + "</label>";
				
				//detect input type and write proper html for correct type
				if ( job_questions[i].fields[0].type === 'input_text' ) {
					field_wrap += "<input type='text' name='" + job_questions[i].fields[0].name + "' id='" + job_questions[i].fields[0].name + "' title='" + job_questions[i].label  + "' class='required' />"
				}
				else if ( job_questions[i].fields[0].type === 'textarea' ) {
					field_wrap += "<textarea name='" + job_questions[i].fields[0].name + "' id='" + job_questions[i].fields[0].name + "' title='" + job_questions[i].label  + "' class='required' />"
				}
				else if ( job_questions[i].fields[0].type === 'input_file' ) {
					field_wrap += "<input type='file' name='" + job_questions[i].fields[0].name + "' id='" + job_questions[i].fields[0].name + "' title='" + job_questions[i].label  + "' class='required' />"
				}
				
				$("#apply_form").append(field_wrap);
			}
			
		}
		
		var submit_button = "<div class='field_wrap field_submit'><button class='submit button'>Submit Application</button></div></div>";
		
		$("#apply_form").append(submit_button);
	}
	
	function jobs_scroll_top(){
		//scroll to top of section
		$('html, body').animate({
        	scrollTop: $('.greenhouse-job-board').offset().top 
	    }, 500);
	}
	
	//navigation
	$('.all_jobs').on('click', '.job_goto', function(e){
		e.preventDefault();
		
		//find correct slide by data-id
		var jobid = parseInt( $(this).parents('.job').data('id') );
		var slideindex = $('.cycle-slide[data-id="' + jobid + '"]').index();

		jobs_scroll_top();
		$('.greenhouse-job-board[data-type="cycle"] .all_jobs').cycle('goto', slideindex );

		
	});
	
	$('.all_jobs').on('click', '.return', function(e){
		e.preventDefault();
		
		$('.greenhouse-job-board[data-type="cycle"] .all_jobs').cycle('goto', 0 );
		jobs_scroll_top();
	});
	
	

	$('.all_jobs').on('click', '.apply_jobs .submit', function(e){
		
		var form_id = '#apply_form';
		
		if ( is_valid( form_id ) ){
			// console.log('submitting form');
			ajax_submit( form_id, null);
		}
		return false;
	});
	
	function get_linkedin_name(jobid){
		var linkedin = '';
		for (var i = 0; i < ghjb_jobs.length; i++){
			if ( ghjb_jobs[i].id == jobid) {
				for( var j = 0; j < ghjb_jobs[i].questions.length; j++){
					if ( ghjb_jobs[i].questions[j].label == "LinkedIn Profile" ){
						linkedin = ghjb_jobs[i].questions[j].fields[0].name;
						// console.log('found linkedin name', linkedin, jobid);

					}
				}
			}
		}
		return linkedin;
	}
	function get_cover_name(jobid){
		var coverletter = '';
		for (var i = 0; i < ghjb_jobs.length; i++){
			if ( ghjb_jobs[i].id == jobid) {
				for( var j = 0; j < ghjb_jobs[i].questions.length; j++){
					if ( ghjb_jobs[i].questions[j].label == "I’m curious as to why you reached out to us? Are you looking for a change, new adventure, etc?" ||
						 ghjb_jobs[i].questions[j].label == "Let me elaborate: " ){
						coverletter = ghjb_jobs[i].questions[j].fields[0].name;
						// console.log('found cover name', coverletter, jobid);

					}
				}
			}
		}
		return coverletter;
	}
	
	
	
	//on submit, set hidden fields to values for that job// id and url token
	function is_valid(formid){
		// console.log('validating', formid);
		var validates = true;
		$( formid + ' .required').each(function(){
			// console.log('validating field:', $(this).attr('title') );
			$(this).parent().find('.required_message').remove();
			if ( $(this).hasClass('url') &&
					$(this).val() != $(this).attr('name') &&
					$(this).val() != '' ) {
				if ( !is_url( $(this).val())){
					$(this).addClass('required_error');
					$(this).after('<span class="required_message">Invalid LinkedIn url</span>');
					validates = false;
				}
			}
			else if ( $(this).hasClass('email') &&
					$(this).val() != $(this).attr('title') &&
					$(this).val() != '' ) {
				if ( !is_email( $(this).val())){
					$(this).addClass('required_error');
					$(this).after('<span class="required_message">Invalid email</span>');
					validates = false;
				}
			}
			else if( $(this).hasClass('phone') &&
					$(this).val() != $(this).attr('title') &&
					$(this).val() != ''){
				if ( !is_phone( $(this).val() )){
					$(this).addClass('required_error');
					$('input.tel').addClass('required_error');
					$(this).after('<span class="required_message">Invalid phone number</span>');
		    		validates = false;
		    	}
		    }
		    
			if(	$(this).val() == $(this).attr('title') ||
						$(this).val() == ''){
				$(this).addClass('required_error');
				$(this).after('<span class="required_message">' + $(this).attr('title') + ' is required</span>');
				validates = false;
			}
		});
		//if(!validates){ alert("Please, fill all required fields"); }
		return validates;
	}
	function validate_me(ele) {
		if (ele.hasClass('email')) {
			if ( is_email( ele.val() )){
				ele.removeClass('required_error');
				ele.parent().find('.required_message').remove();
			} else if (!ele.hasClass('required_error') ) {
				ele.addClass('required_error');
				ele.after('<span class="required_message">Invalid email</span>');
			}
		}
		else if(ele.hasClass('url')){
			if ( is_url( ele.val() )){
				ele.removeClass('required_error');
				ele.parent().find('.required_message').remove();
			} else if (!ele.hasClass('required_error') ) {
				ele.addClass('required_error');
				ele.after('<span class="required_message">Invalid LinkedIn url</span>');
			}
		}
		else if(ele.hasClass('tel')){
			if ( is_phone( $('.tel1').val() + '' + $('.tel2').val() + '' + $('.tel3').val() )){
				$('#phone_number').removeClass('required_error');
				$('input.tel').removeClass('required_error');
				$('#phone_number').parent().find('.required_message').remove();
			} else if (!$('#phone_number').hasClass('required_error') ) {
				$('#phone_number').addClass('required_error');
				$('input.tel').addClass('required_error');
				$('#phone_number').after('<span class="required_message">Invalid phone number</span>');
			}
		}
		else {
			if( is_not_empty( ele.val() )){
				ele.removeClass('required_error');
				ele.parent().find('.required_message').remove();
			} else if (!ele.hasClass('required_error') ) {
				ele.addClass('required_error');
				ele.after('<span class="required_message">' + ele.attr('title') + ' is required</span>');
			}
		}
	}
	$(".field_wrap").on('blur', '.required, .tel', function(e){
		$(this).addClass('edited');
		validate_me( $(this) );
	});
	$(".field_wrap").on('keyup change', '.edited', function(e){
		validate_me( $(this) );
	});
	function is_not_empty(val){      
		return val != '';
	}
	function is_email(email){      
		var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		return emailReg.test(email);
	}
	function is_phone(the_val){
		var phoneValidChars = /^[0-9()#x+. \t-]+$/;
      	var digCount = 0;
		var digits = "0123456789";
		
		for (var ix = 0; ix < the_val.length; ix++) {
		    if (digits.indexOf(the_val.charAt(ix)) != -1) {
			    digCount++;
		    }
		}
		if (!phoneValidChars.test(the_val) || (digCount < 10) || (digCount > 15)) {
			return false;
		}
		return true;
	}
	function is_url(url){
		if ( 	url.indexOf('http://www.linkedin.com/') == 0 ||
				url.indexOf('https://www.linkedin.com/') == 0 ||
				url.indexOf('http://linkedin.com/') == 0 ||
				url.indexOf('https://linkedin.com/') == 0 ||
				url.indexOf('www.linkedin.com/in/') == 0 ||
				url.indexOf('www.linkedin.com/pub/') == 0 ||
				url.indexOf('linkedin.com/in/') == 0 ||
				url.indexOf('linkedin.com/pub/') == 0
			) {
			return true;
		}
		return false;
	}
	
	function ajax_submit(formid, redirect){
		var formData = new FormData( $(formid)[0]);
		$.ajax({
		    type: $(formid).attr('method'),
		    url: $(formid).attr('action'),
		    data: formData,
		    async: false,
	        cache: false,
	        contentType: false,
	        processData: false,
	        enctype: 'multipart/form-data',
	        mimeType: 'multipart/form-data', 
		    success: function(data, textStatus, jqXHR) {
		    	console.log('success', textStatus, data, jqXHR);
		    	thanks_message();
		    },
		    error: function(jqXHR, textStatus, errorThrown) {
		    	// console.log('error', textStatus, errorThrown, jqXHR);
		    },
		    complete: function(jqXHR, textStatus) {
		    	// console.log('complete', textStatus, jqXHR);
		    	if (redirect != null && redirect != undefined) {
			    	window.location.href = redirect;
			    }
		    },

		});
		return false;
	}
	
	
	function thanks_message(){
		$('.greenhouse-job-board[data-type="cycle"] .all_jobs').cycle('goto', 2 );
		jobs_scroll_top();
	}
	
	
	$('input.tel').keyup(function(){
	    if( this.value.length == $(this).attr("maxlength" )){
	        $(this).next('.tel').focus();
	    }
	    $('input[name="phone"]').val( $('.tel1').val() + '' + $('.tel2').val() + '' + $('.tel3').val() );
	});
	
	greenhouse_jobs(ghjb_json);
	

	

function greenhouse_jobs(json){
 	// console.log(json);
 	
 	var board_type = $(".greenhouse-job-board").data('type');
 	
 	//setup handlebars
 	var job_html, job_html_template, slide_html, slide_html_template;
 	job_html = $("#job-template").html();
 	job_html_template = Handlebars.compile(job_html);
 	
 	if (board_type == 'cycle' ) {
 		slide_html = $("#job-slide-template").html();
	 	slide_html_template = Handlebars.compile(slide_html);
 	}
 	//sort
 	
 	//list all jobs
    for (var i = 0; i < json.jobs.length; i++){
     	// console.log( json.jobs[i].id);
     	
     	//hide_forms val
     	var hide_forms = $('.jobs').attr('data-hide_forms');
     	
     	//filter pass values
     	var department_filter_pass = true;
     	var department_filter_exclude = false;
     	var job_filter_pass = true;
     	var job_filter_exclude = false;
     	var office_filter_pass = true;
     	var office_filter_exclude = false;
     	var location_filter_pass = true;
     	var location_filter_exclude = false;
     	
     	//////////
     	// Department Filter - can a single job have multiple departments? 
     	//
     	var department_filter = false;
     	if ( $('.jobs').attr('data-department_filter') ) {
     		department_filter = $('.jobs').attr('data-department_filter').split('|');
     		if ( department_filter[0].charAt(0) == '-' ) {
     			// condition met for exclude flag, set dept filter to look for excludes
     			department_filter_exclude = true;
     		}
     		department_filter_pass = false;
	     	
	     	//read job department(s) and test against filter
	     	// var departments = [];
	     	for( var j = 0; j < json.jobs[i].departments.length; j++ ) {
	     		//add to array of departments
	     		// departments.push( json.jobs[i].departments[j].name );
	     		// departments.push( json.jobs[i].departments[j].id );
	     		//if not excluding check if department matches any department filter
	     		if ( 	!department_filter_exclude &&
	     				(jQuery.inArray( json.jobs[i].departments[j].name, department_filter ) >= 0 ||
	 					 jQuery.inArray( json.jobs[i].departments[j].id + '', department_filter ) >= 0 )) {
	     			department_filter_pass = true;
	     		}
	     		//if excluding check to see if not department match by name or id
	     		else if ( 	department_filter_exclude &&
	     					jQuery.inArray( '-'+json.jobs[i].departments[j].name, department_filter ) == -1 &&
	     					jQuery.inArray( '-'+json.jobs[i].departments[j].id, department_filter ) == -1 ) {
	     			department_filter_pass = true;
	     		}
	     	}
	     	// console.log('department filter:', department_filter, 'pass=', department_filter_pass);
     	}
     	
     	    	
    	//////////
    	// Office Filter - can a single job have multiple offices YES
    	//
    	var office_filter = false;
    	if ( $('.jobs').attr('data-office_filter') ) {
    		office_filter = $('.jobs').attr('data-office_filter').split('|');
    		if ( office_filter[0].charAt(0) == '-' ) {
    			// condition met for exclude flag, set office filter to look for excludes
    			office_filter_exclude = true;
    		}
    		office_filter_pass = false;
    	
	    	//read job office(s) and test against filter
	    	for( var j = 0; j < json.jobs[i].offices.length; j++ ) {
	    		//if not excluding check if office matches any office filter
	    		if ( 	!office_filter_exclude &&
	    				(jQuery.inArray( json.jobs[i].offices[j].name, office_filter ) >= 0 ||
						 jQuery.inArray( json.jobs[i].offices[j].id + '', office_filter ) >= 0 )) {
	    			office_filter_pass = true;
	    		}
	    		//if excluding check to see if not office match by name or id
	    		else if ( 	office_filter_exclude &&
	    					jQuery.inArray( '-'+json.jobs[i].offices[j].name, office_filter ) == -1 &&
	    					jQuery.inArray( '-'+json.jobs[i].offices[j].id, office_filter ) == -1 ) {
	    			office_filter_pass = true;
	    		}
	    	}
	    	// console.log('office filter:', office_filter, 'pass=', office_filter_pass);
     	}
     	
     	    	
    	//////////
    	// Location Filter - can a single job have multiple locations. NO. 
    	// Location is a text field. Must be an exact match.
    	var location_filter = false;
    	if ( $('.jobs').attr('data-location_filter') ) {
    		location_filter = $('.jobs').attr('data-location_filter').split('|');
    		if ( location_filter[0].charAt(0) == '-' ) {
    			// condition met for exclude flag, set location filter to look for excludes
    			location_filter_exclude = true;
    		}
    		location_filter_pass = false;
    	
	    	//read job location(s) and test against filter
			//if not excluding check if location matches any location filter
			if ( 	!location_filter_exclude &&
					jQuery.inArray( json.jobs[i].location.name, location_filter ) >= 0 ) {
				location_filter_pass = true;
			}
			//if excluding check to see if not location match by name or id
			else if ( 	location_filter_exclude &&
						jQuery.inArray( '-'+json.jobs[i].location.name, location_filter ) == -1 ) {
				location_filter_pass = true;
			}
	    	// console.log('location filter:', location_filter, 'pass=', location_filter_pass);
     	}
     	
     	
     	//////////
     	// Job Filter  - a single job can only have one title or id
     	//
     	var job_filter = false;
     	if ( $('.jobs').attr('data-job_filter') ) {
     		job_filter = $('.jobs').attr('data-job_filter').split('|');
     		if ( job_filter[0].charAt(0) == '-' ) {
     			// condition met for exclude flag, set dept filter to look for excludes
     			job_filter_exclude = true;
     		}
     		job_filter_pass = false;
     	
	     	//read job id and test against filter
	 		//if not excluding check if job matches any job filter
	 		if ( 	!job_filter_exclude &&
	 				(jQuery.inArray( json.jobs[i].id + '', job_filter ) >= 0 ||
	 				 jQuery.inArray( json.jobs[i].title + '', job_filter ) >= 0 ) ) {
	 			job_filter_pass = true;
	 		}
	 		//if excluding check to see if not job match by id
	 		else if ( 	job_filter_exclude &&
	 					jQuery.inArray( '-'+json.jobs[i].id, job_filter ) == -1 &&
	 					jQuery.inArray( '-'+json.jobs[i].title, job_filter ) == -1 ) {
	 			job_filter_pass = true;
	 		}
	     	// console.log('job filter:', job_filter, 'pass=', job_filter_pass);
     	}
     	
     	//display val
     	var display = $('.jobs').attr('data-display').split('|');
     	var display_office = null;
     	var display_location = null;
     	var display_department = null;
     	var display_description = null;
     	
     	if ( jQuery.inArray( 'office', display ) >= 0 ) {
     		if ( json.jobs[i].offices.length > 0) {
     			display_office = json.jobs[i].offices[0].name;
     		}
     		if ( json.jobs[i].offices.length > 1) {
	     		for( var j = 0; j < json.jobs[i].offices.length; j++ ) {
		     		display_office += ', ' + json.jobs[i].offices[j].name;
		     	}
		    }
     	}
     	if ( jQuery.inArray( 'department', display ) >= 0 ) {
     		if ( json.jobs[i].departments.length > 0) {
     			display_department = json.jobs[i].departments[0].name;
     		}
     		if ( json.jobs[i].departments.length > 1) {
	     		for( var j = 0; j < json.jobs[i].departments.length; j++ ) {
		     		display_department += ', ' + json.jobs[i].departments[j].name;
		     	}
		    }
     	}
     	//location is one field only
     	if ( jQuery.inArray( 'location', display ) >= 0 ) {
	     	display_location = json.jobs[i].location.name;
     	}
     	if ( jQuery.inArray( 'description', display ) >= 0 ) {
	     	display_description = true;
     	}
     	
     	// if filters pass
     	if ( 	department_filter_pass &&
     			job_filter_pass &&
     			office_filter_pass &&
     			location_filter_pass ){
     	
	     	
	     	if ( board_type == "accordion" ) {
	     		var jobshtml = job_html_template({
		 			index: i,
		 			id: json.jobs[i].id,
		 			title: json.jobs[i].title,
		 			content: get_excerpt_from_content( json.jobs[i].content ),
		 			hide_forms: hide_forms,
		 			display_description: display_description,
		 			display_department: display_department,
		 			display_office: display_office,
		 			display_location: display_location
		 		});
	     		$('.all_jobs .jobs').append(jobshtml);
	     	}
     		else if ( board_type == "cycle" ) {
	     		var jobshtml = job_html_template({
		 			index: i,
		 			id: json.jobs[i].id,
		 			title: json.jobs[i].title,
		 			excerpt: get_excerpt_from_content( json.jobs[i].content ),
		 			hide_forms: hide_forms,
		 			display_description: display_description,
		 			display_department: display_department,
		 			display_office: display_office,
		 			display_location: display_location
		 		});
	     		$('.all_jobs .jobs').append(jobshtml);
	     		
	     		var slidehtml = slide_html_template({
		 			index: i,
		 			id: json.jobs[i].id,
		 			title: json.jobs[i].title,
		 			content: decodeHtml( json.jobs[i].content ),
		 			hide_forms: hide_forms,
		 			display_description: display_description,
		 			display_department: display_department,
		 			display_office: display_office,
		 			display_location: display_location
	     		});
     			$('.all_jobs').append(slidehtml);
	     	}
	     	
	     	if ( board_type == 'cycle' ) {
	     		add_position( json.jobs[i].id, json.jobs[i].title );
	     	}	
		    
	    }
    }
     
    if (board_type == 'cycle' ) {
     	
     	$('.all_jobs').cycle({
     		fx: 'fade',
     		slides: '.cycle-slide',
     		timeout: 0,
     		autoHeight: 'container',
     		log: false
     	});
     	
    }
     
}
function add_position(id, title){
	// console.log('add_position', id, title);
	//add option to form select
	$("#positions").append('<option value="'+id+'">'+title+'</option>');
};



function decodeHtml(html){
	var txt = document.createElement("textarea");
    txt.innerHTML = html;
    var text = txt.value;
    text = text.replace(/\u00a0/g, ' ');
    return text;
}

function strip_tags(input, allowed) {
  //  discuss at: http://phpjs.org/functions/strip_tags/
  allowed = (((allowed || '') + '')
    .toLowerCase()
    .match(/<[a-z][a-z0-9]*>/g) || [])
    .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
    commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return input.replace(commentsAndPhpTags, '')
    .replace(tags, function($0, $1) {
      return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}

function get_excerpt_from_content(content, limit){
	limit = typeof limit !== 'undefined' ? limit : 120;
	
	//decode
	var this_content = decodeHtml(content);
	//strip tags
	this_content = strip_tags(this_content);
	
	//get the first full sentence 
	//OR
	//get the first number of characters and the last full word
	//OR
	//get the full content if total length is less than the limit
	
	//start at 0
	var short_content_start = 0;
	var content_length = this_content.length;
	
	//
	if ( content_length <= limit) {
		short_content_end = content_length;
	}
	else {
	
		//find period
		var short_content_end = this_content.indexOf(".", short_content_start);
	
	
	//if too short get next sentence too
	if ( (short_content_end - short_content_start) < length) {
		short_content_end = this_content.indexOf(".", short_content_end+1);
	}
	var short_content = this_content.slice(short_content_start, short_content_end + 1);
	if (short_content_start < 0){
		short_content = this_content.slice(0, short_content_end + 1);
	}
	
	return short_content;
}

	
});


Handlebars.registerHelper('ifeq', function (a, b, options) {
	if (a == b) { return options.fn(this); }
});
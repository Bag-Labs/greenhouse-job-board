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
	 
	$('.jobs').on('click', '.job_read_full', function(e){
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
	$('.jobs').on('click', '.job_apply', function(e){
		e.preventDefault();
		if ( $(this).hasClass('open') ) {
			//closing since already open
			$(this).text( $(this).data('closed-text') );
			$(this).removeClass('open');
			if ($('#grnhse_app').hasClass('open')) {
				$('#grnhse_app').empty(); 
				$('#grnhse_app').removeClass('open');
			}
		}
		else{
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
	});


	
	$('.greenhouse-job-board[data-type="cycle"] .all_jobs').cycle({
		fx: 'fade',
		slides: '.cycle-slide',
		timeout: 0,
		autoHeight: 'container',
		// log: false
	});
	
	window.reset_cycle = function (){
		$('.jobs-cycle').cycle('reinit');
	};

	window.add_slide = function(newSlide, id, title){
		//add to cycle
		$('.jobs-cycle').cycle('add', newSlide);
		
		//trigger hashchange
		$(window).trigger('hashchange');
		// console.log('hashchange trigger');
		// $('.jobs-cycle').reinit();
		
		
	};
	function jobs_scroll_top(){
		//scroll to top of section
		$('html, body').animate({
        	scrollTop: $('#grnhse_app').offset().top - $('#header').height()
	    }, 500);
	}
	
	//navigation
	$('.all_jobs').on('click', '.job_goto', function(e){
		e.preventDefault();
		
		//find correct slide by data-id
		var jobid = parseInt( $(this).parents('.job').data('id') );
		var slideindex = $('.cycle-slide[data-id="' + jobid + '"]').index();
		console.log(jobid, slideindex, $('.cycle-slide [data-id="' + jobid + '"] .job_title').text() );
		// if (slideindex < 0) {
		// 	//job failed to load via json, reload it.
		// 	var jobshtml = '<script type="text/javascript" src="https://api.greenhouse.io/v1/boards/brownbagmarketing/embed/job?id=';
		// 	jobshtml += jobid;
		// 	jobshtml += '&questions=true&callback=greenhouse_jobs_job_late"></s';
		// 	jobshtml += 'cript>'
			
		// 	$('.all_jobs').append(jobshtml);
		// }
		// else {
			$('.greenhouse-job-board[data-type="cycle"] .all_jobs').cycle('goto', slideindex );
			// jobs_scroll_top();
		// }
		
	});
	
	$('.all_jobs').on('click', '.return', function(e){
		e.preventDefault();
		
		$('.greenhouse-job-board[data-type="cycle"] .all_jobs').cycle('goto', 0 );
		// jobs_scroll_top();
	});
	
	
	
});

	

function greenhouse_jobs(json){
 	console.log(json);
 	
 	var board_type = jQuery(".greenhouse-job-board").data('type');
 	
 	//setup handlebars
 	var job_html, job_html_template, slide_html, slide_html_template;
 	job_html = jQuery("#job-template").html();
 	job_html_template = Handlebars.compile(job_html);
 	
 	if (board_type == 'cycle' ) {
 		slide_html = jQuery("#job-slide-template").html();
	 	slide_html_template = Handlebars.compile(slide_html);
 	}
 	//sort
 	
 	//list all jobs
    for (var i = 0; i < json.jobs.length; i++){
     	// console.log( json.jobs[i].id);
     	
     	//hide_forms val
     	var hide_forms = jQuery('.jobs').attr('data-hide_forms');
     	
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
     	if ( jQuery('.jobs').attr('data-department_filter') ) {
     		department_filter = jQuery('.jobs').attr('data-department_filter').split('|');
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
    	if ( jQuery('.jobs').attr('data-office_filter') ) {
    		office_filter = jQuery('.jobs').attr('data-office_filter').split('|');
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
    	if ( jQuery('.jobs').attr('data-location_filter') ) {
    		location_filter = jQuery('.jobs').attr('data-location_filter').split('|');
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
     	if ( jQuery('.jobs').attr('data-job_filter') ) {
     		job_filter = jQuery('.jobs').attr('data-job_filter').split('|');
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
     	var display = jQuery('.jobs').attr('data-display').split('|');
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
     	
     		var jobshtml = job_html_template({
	 			index: i,
	 			id: json.jobs[i].id,
	 			title: json.jobs[i].title,
	 			excerpt: get_role_from_content( json.jobs[i].content ),
	 			hide_forms: hide_forms,
	 			display_description: display_description,
	 			display_department: display_department,
	 			display_office: display_office,
	 			display_location: display_location
	 		});
	     	jQuery('.all_jobs .jobs').append(jobshtml);	
	     	
     		if ( board_type == "cycle" ) {
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
     			jQuery('.all_jobs').append(slidehtml);
			    //reset_cycle();
	     	}
	     	
		    
	    }
 		// add_position( json.jobs[i].id, json.jobs[i].title );
     }
     
     // jobshtml = '<a href="#" class="apply">Apply Now</a>';
}


function greenhouse_jobs_job(json){
	jobs.push(json);
	// console.log(jobs);
	// console.log(json);
	
	var jobhtml = '';
	jobhtml += '<div class="job" ';
	jobhtml += ' data-id="' + json.id + '" ';
	jobhtml += ' data-cycle-hash="' + json.title + '"><div class="job_single">';
	jobhtml += '	<h2 class="job_title">' + json.title + '</h2>';
	jobhtml += '	<div class="job_description"><p><strong>Location:</strong> ' + json.location.name + '</p>' + decodeHtml( json.content ) + '</div>';
	jobhtml += '</div></div>';
	
	// add_slide( jobhtml, json.id, json.title );
	jQuery('.job_description_' + json.id ).append(jobhtml);
}

function decodeHtml(html){
	var txt = document.createElement("textarea");
    txt.innerHTML = html;
    text = txt.value;
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

Handlebars.registerHelper('ifeq', function (a, b, options) {
	if (a == b) { return options.fn(this); }
});

function get_role_from_content(content){
	//decode
	var this_content = decodeHtml(content);
	//strip tags
	this_content = strip_tags(this_content);
	
	var short_content_start = this_content.indexOf("ROLE:");
	var short_content_end = this_content.indexOf(".", short_content_start);
	//if too short get next sentence too
	if ( (short_content_end - short_content_start) < 120) {
		short_content_end = this_content.indexOf(".", short_content_end+1);

	}
	var short_content = this_content.slice(short_content_start + 5, short_content_end + 1);
	if (short_content_start < 0){
		short_content = this_content.slice(0, short_content_end + 1);
	}
	// console.log(short_content);
	//remove extra space
	if ( 	short_content.indexOf('&nbsp;') == 0 ) {
		short_content = short_content.slice(6);
	}
	
	return short_content;
}

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
		$(this).next('.job_description').toggle();
		$(this).next('.job_description').toggleClass('open');
		var temp = $(this).data('toggle-text');
		$(this).data( 'toggle-text', $(this).text() );
		$(this).text( temp );
	});
	$('.jobs').on('click', '.job_apply', function(e){
		if ($('#grnhse_app').hasClass('open')) {
			$('#grnhse_app').empty(); 
			$('#grnhse_app').removeClass('open');
		}
		else{
			$(this).parent().append( $('#grnhse_app') ); 
			$('#grnhse_app').addClass('open');
			var jid = $(this).parent().data('id');
		 	
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
});

	

function greenhouse_jobs(json){
 	// console.log(json);
 	
 	
 	//setup handlebars
 	var job_html = jQuery("#job-template").html();
 	// console.log( job_html );
 	var job_html_template = Handlebars.compile(job_html);
 	
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
     	//Department Filter - can a single job have miultiple departments? 
     	//
     	var department_filter = false;
     	if ( jQuery('.jobs').attr('data-department_filter') ) {
     		department_filter = jQuery('.jobs').attr('data-department_filter').split('|');
     		if ( department_filter[0].charAt(0) == '-' ) {
     			// condition met for exclude flag, set dept filter to look for excludes
     			department_filter_exclude = true;
     		}
     		department_filter_pass = false;
     	}
     	//read job department(s) and test against filter
     	var departments = [];
     	for( var j = 0; j < json.jobs[j].departments.length; j++ ) {
     		//add to array of departments
     		departments.push( json.jobs[i].departments[j].name );
     		departments.push( json.jobs[i].departments[j].id );
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
     	// console.log('department filter:', department_filter, departments, department_filter_pass);
     	
     	
     	//////////
     	//Job Filter  - a single job can only have one title or id
     	//
     	var job_filter = false;
     	if ( jQuery('.jobs').attr('data-job_filter') ) {
     		job_filter = jQuery('.jobs').attr('data-job_filter').split('|');
     		if ( job_filter[0].charAt(0) == '-' ) {
     			// condition met for exclude flag, set dept filter to look for excludes
     			job_filter_exclude = true;
     		}
     		job_filter_pass = false;
     	}
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
     	// console.log('job filter:', job_filter, json.jobs[i].id, '-'+json.jobs[i].title, job_filter_pass, job_filter_exclude);
     	
     	
     	
     	// if filters pass
     	if ( 	department_filter_pass &&
     			job_filter_pass &&
     			office_filter_pass &&
     			location_filter_pass ){
     	
     		var jobshtml = job_html_template({
	 			index: i,
	 			id: json.jobs[i].id,
	 			title: json.jobs[i].title,
	 			content: decodeHtml( json.jobs[i].content ),
	 			departments: departments.join('|'),
	 			hide_forms: hide_forms
	 		});
	     	
	     	jQuery('.all_jobs .jobs').append(jobshtml);
	    }
 		// add_position( json.jobs[i].id, json.jobs[i].title );
     }
     
     // jobshtml = '<a href="#" class="apply">Apply Now</a>';	
     // jQuery('.all_jobs').append(jobshtml);
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

Handlebars.registerHelper('ifeq', function (a, b, options) {
	if (a == b) { return options.fn(this); }
});

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


// var jobs = [];

function greenhouse_jobs(json){
 	// console.log(json);
 	
 	// var jobshtml = '<a href="#" class="apply">Apply Now</a>';
 	// jQuery('.all_jobs').append(jobshtml);
 	
 	//sort
 	
 	//list all jobs
     for (var i = 0; i < json.jobs.length; i++){
     	// console.log( json.jobs[i].id);
 		var jobshtml = '';
 	    	jobshtml += '<div class="job" data-id="' + json.jobs[i].id + '" data-index="' + (i+2) + '">';
 	    	jobshtml += '	<h2 class="job_title">' + json.jobs[i].title + '</h2>';
 	    	jobshtml += '	<div class="job_read_full">Read full description</div>';
 	    	// jobshtml += '	<div class="job_description">' + get_role_from_content( json.jobs[i].content ) + '</div>';
 	    	jobshtml += '	<div class="job_description job_description_' + json.jobs[i].id + '">' + decodeHtml( json.jobs[i].content ) + '</div>';
 	    	//load each job to greenhouse_jobs_job
 	    	jobshtml += '	<div class="job_apply job_apply_' + json.jobs[i].id + '">Apply Now</div>';
 	    	// jobshtml += '	<script type="text/javascript" src="https://api.greenhouse.io/v1/boards/brownbagmarketing/embed/job?id=';
 	    	// jobshtml += json.jobs[i].id;
 	    	// jobshtml += '&questions=true&callback=greenhouse_jobs_job"></s';
 	    	// jobshtml += 'cript>'
 	    	jobshtml += '</div>';
     	
     	jQuery('.all_jobs .jobs').append(jobshtml);
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
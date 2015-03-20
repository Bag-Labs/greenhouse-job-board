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
	 });

});


var jobs = [];

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
 	    	jobshtml += '	<div class="job_apply_' + json.jobs[i].id + '></div>';
 	    	//load each job to greenhouse_jobs_job
 	    	jobshtml += '	<script type="text/javascript" src="https://api.greenhouse.io/v1/boards/brownbagmarketing/embed/job?id=';
 	    	jobshtml += json.jobs[i].id;
 	    	jobshtml += '&questions=true&callback=greenhouse_jobs_job"></s';
 	    	jobshtml += 'cript>'
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
	console.log(json);
	
	var jobhtml = '';
	jobhtml += '<div class="job" ';
	jobhtml += ' data-id="' + json.id + '" ';
	jobhtml += ' data-cycle-hash="' + json.title + '"><div class="job_single">';
	jobhtml += '	<a href="#" class="return">All Positions</a>';
	jobhtml += '	<h2 class="job_title">' + json.title + '</h2>';
	jobhtml += '	<a href="#" class="apply" data-id="' + json.id + '">Apply Now</a>';
	jobhtml += '	<div class="job_description"><p><strong>Location:</strong> ' + json.location.name + '</p>' + decodeHtml( json.content ) + '</div>';
	jobhtml += '	<a href="#" class="apply" data-id="' + json.id + '">Apply Now</a>';
	jobhtml += '	<a href="#" class="return return_bottom">All Positions</a>';
	jobhtml += '</div></div>';
	
	// add_slide( jobhtml, json.id, json.title );
	jQuery('.job_apply_' + json.id ).append(jobhtml);
}

function decodeHtml(html){
	var txt = document.createElement("textarea");
    txt.innerHTML = html;
    text = txt.value;
    text = text.replace(/\u00a0/g, ' ');
    return text;
}
<?php
/**
 * @since      2.0.0
 */

require_once('../../../../../wp-load.php');
$options = get_option( 'greenhouse_job_board_settings' );
// echo $options['greenhouse_job_board_api_key'];
$ghjb_d = false;
if ( $options['greenhouse_job_board_debug'] === 'true' ) {
	$ghjb_d = true;	
}
$ghjb_e = false;
if ( $options['greenhouse_job_log_errors'] === 'true' ) {
	$ghjb_e = true;	
}

// print_r($_POST);
// print_r($_FILES);

// $postfields = http_build_query($_POST);

//add resume to post vars
// print_r($_FILES['resume']);
if ( isset( $_FILES['resume'] ) ) {
	$resume_path = $_FILES['resume']['tmp_name'];
	$resume_filename = basename( $_FILES['resume']['name'] );
	$resume_filesize = $_FILES['resume']['size'];
	$resume_filetype = $_FILES['resume']['type'];
}
//add cover_letter to post vars
// print_r($_FILES['cover_letter']);
if ( isset( $_FILES['cover_letter'] ) ) {
	$cover_path = $_FILES['cover_letter']['tmp_name'];
	$cover_filename = basename( $_FILES['cover_letter']['name'] );
	$cover_filesize = $_FILES['cover_letter']['size'];
	$cover_filetype = $_FILES['cover_letter']['type'];
}

//for PHP 5.5+ with curlfile 
if ( function_exists('curl_file_create') ) {
	//CURLFile curl_file_create ( string $filename [, string $mimetype [, string $postname ]] )
	if ( $resume_path ) {
		$_POST['resume'] = new CURLFile($resume_path, $resume_filetype, $resume_filename );
	}
	if ( $cover_path ) {
		$_POST['cover_letter'] = new CURLFile($cover_path, $cover_filetype, $cover_filename );
	}
}
//for PHP 5.5-
else {
	if ( $resume_path ) {
		$_POST['resume'] = '@' . $resume_path . ';filename=' . $resume_filename . ';type=' . $resume_filetype;
	}
	if ( $cover_path ) {
		$_POST['cover_letter'] = '@' . $cover_path . ';filename=' . $cover_filename . ';type=' . $cover_filetype;
	}
}
// print_r($_POST);



//load json job questions to double-check required fields

// if ( false === ( $ghjb_jobs = get_transient( 'ghjb_jobs' ) ) ) {
// 	// It wasn't there, so regenerate the data and save the transient
// 	//read job ids from json data
// 	$ghjb_json_php = json_decode($ghjb_json);
// 	//retreive json object for each job and save into transient
// 	$ghjb_jobs = '';//$ghjb_json_php->jobs[0]->id;
// 	foreach ( $ghjb_json_php->jobs as $job) {
// 		$job_json = wp_remote_retrieve_body( wp_remote_get('https://api.greenhouse.io/v1/boards/' . $options['greenhouse_job_board_url_token'] . '/embed/job?id=' . $job->id . '&questions=true'));
		
// 		$ghjb_jobs .= $job_json . ',';
// 	}
// 	$ghjb_jobs = '[' . $ghjb_jobs . ']';
// 	set_transient( 'ghjb_jobs', $ghjb_jobs, $options['greenhouse_job_board_cache_expiry'] );

// }
// 57463 - mobile dev id
// echo $ghjb_jobs;
if ( $ghjb_e &&
	 $_POST['id'] ) {
	$job = wp_remote_retrieve_body( wp_remote_get('https://api.greenhouse.io/v1/boards/' . $options['greenhouse_job_board_url_token'] . '/embed/job?id=' . $_POST['id'] . '&questions=true'));
	 
	$job_json = json_decode($job);
	$errors = array();
	/*?><script>console.log(<?php echo $job; ?>);</script><?php*/
	// print_r( $job_json->questions );
	// check each question that's required and make sure it's included in the post object
	foreach ( $job_json->questions as $question ) {
		// echo '. field ' . $question->fields[0]->name;
		// echo ' required: '.$question->required;
		if ( $question->required ) {
			if ( !isset( $_POST[ $question->fields[0]->name ] ) ){
				$errors[] = $question->fields[0]->name;
			}
		}
	}
	//if any errors print to log
	if ( count($errors) > 0 ) {
		// echo 'ERROR- required fields missing: ';
		error_log( date("Y.m.d H:i:s") . ' -ERROR- required fields missing: ' . json_encode($errors) . '. post: ' . json_encode($_POST) . '.
', 3, dirname(__FILE__).'/errors.log' );
		// print_r($errors);
	}
}




$url = "https://" . $options['greenhouse_job_board_api_key'] . ":@api.greenhouse.io/v1/applications/";
$header = array('Content-Type: multipart/form-data');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
// curl_setopt($ch, CURLOPT_INFILE, $filename);
// curl_setopt($ch, CURLOPT_INFILESIZE, $$filesize);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);
// curl_setopt($ch, CURLOPT_VERBOSE, 1);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
$response = curl_exec($ch);

if ( $ghjb_d ){
	// echo '
	// -RESPONSE-
	// ';
	print_r( $_POST );
	print_r( $response );
	// echo '
	// -RESPONSE END-
	// ';
	
	//versions
	echo '
	php version: ' . phpversion();
	$curl_v = curl_version();
	echo '
	curl version: ' . $curl_v['version'];

	if ($response === FALSE) {
	    echo "
	    curl error: " . curl_error($ch);
		echo '
		-end error-
		';
		print_r($ch);
		echo '
		curl error num: ' . curl_errno($ch);
		$info = curl_getinfo($ch);
		// print_r( $info );
	}
}

curl_close($ch);

// phpinfo();

?>
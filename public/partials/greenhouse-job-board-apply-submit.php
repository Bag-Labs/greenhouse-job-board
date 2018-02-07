<?php
/**
 * Proxy processing file to send data from inline forms to greenhouse API.
 *
 * Using CURL library, so it needs that be available on the server.
 * TODO - rebuild with builtin wp_remote_post functions if possible.
 *
 * @since      2.0.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public/partials
 */

require_once '../../../../../wp-load.php';
$options = get_option( 'greenhouse_job_board_settings' );

$ghjb_d = false;
if ( 'true' === $options['greenhouse_job_board_debug'] ) {
	$ghjb_d = true;
}
$ghjb_e = false;
if ( 'true' === $options['greenhouse_job_log_errors'] ) {
	$ghjb_e = true;
}

// add resume to post vars.
if ( isset( $_FILES['resume'] ) ) {
	$resume = $_FILES['resume'];
	if ( isset( $resume['tmp_name'] ) &&
		isset( $resume['name'] ) &&
		isset( $resume['size'] ) &&
		isset( $resume['type'] ) ) {
		$resume_path     = $resume['tmp_name'];
		$resume_filename = basename( $resume['name'] );
		$resume_filesize = $resume['size'];
		$resume_filetype = $resume['type'];
	}
}
// add cover_letter to post vars.
if ( isset( $_FILES['cover_letter'] ) ) {
	$cover_letter = $_FILES['resume'];
	if ( isset( $cover_letter['tmp_name'] ) &&
		isset( $cover_letter['name'] ) &&
		isset( $cover_letter['size'] ) &&
		isset( $cover_letter['type'] ) ) {
		$cover_path     = $cover_letter['tmp_name'];
		$cover_filename = basename( $cover_letter['name'] );
		$cover_filesize = $cover_letter['size'];
		$cover_filetype = $cover_letter['type'];
	}
}

// for PHP 5.5+ with curlfile.
if ( function_exists( 'curl_file_create' ) ) {
	// CURLFile reference curl_file_create ( string $filename [, string $mimetype [, string $postname ]] ).
	if ( $resume_path ) {
		$_POST['resume'] = new CURLFile( $resume_path, $resume_filetype, $resume_filename );
	}
	if ( $cover_path ) {
		$_POST['cover_letter'] = new CURLFile( $cover_path, $cover_filetype, $cover_filename );
	}
} // for PHP 5.5-.
else {
	if ( $resume_path ) {
		$_POST['resume'] = '@' . $resume_path . ';filename=' . $resume_filename . ';type=' . $resume_filetype;
	}
	if ( $cover_path ) {
		$_POST['cover_letter'] = '@' . $cover_path . ';filename=' . $cover_filename . ';type=' . $cover_filetype;
	}
}
// print_r($_POST);
// load json job questions to double-check required fields.
// if ( false === ( $ghjb_jobs = get_transient( 'ghjb_jobs' ) ) ) {
// It wasn't there, so regenerate the data and save the transient
// read job ids from json data
// $ghjb_json_php = json_decode($ghjb_json);
// retreive json object for each job and save into transient
// $ghjb_jobs = '';//$ghjb_json_php->jobs[0]->id;
// foreach ( $ghjb_json_php->jobs as $job) {
// $job_json = wp_remote_retrieve_body( wp_remote_get('https://api.greenhouse.io/v1/boards/' . $options['greenhouse_job_board_url_token'] . '/embed/job?id=' . $job->id . '&questions=true'));
// $ghjb_jobs .= $job_json . ',';
// }
// $ghjb_jobs = '[' . $ghjb_jobs . ']';
// set_transient( 'ghjb_jobs', $ghjb_jobs, $options['greenhouse_job_board_cache_expiry'] );
// }
// 57463 - mobile dev id.
// echo $ghjb_jobs;//.
if ( $ghjb_e &&
	isset( $_POST['id'] ) ) {

	$url = 'https://api.greenhouse.io/v1/boards/' . $options['greenhouse_job_board_url_token'] . '/embed/job?id=' . $_POST['id'] . '&questions=true';
	$job = wp_remote_retrieve_body( wp_remote_get( $url ) );

	$job_json = json_decode( $job );
	$errors   = array();

	// check each question that's required and make sure it's included in the post object.
	foreach ( $job_json->questions as $question ) {
		if ( $question->required ) {
			if ( ! isset( $_POST[ $question->fields[0]->name ] ) ) {
				$errors[] = $question->fields[0]->name;
			}
		}
	}
	// if any errors print to log.
	if ( count( $errors ) > 0 ) {
		// ERROR - required fields missing.
		error_log(
			date( 'Y.m.d H:i:s' ) .
			' -ERROR- required fields missing: ' .
			wp_json_encode( $errors ) .
			'. post: ' .
			wp_json_encode( $_POST ) .
			'.
',
			3,
			dirname( __FILE__ ) . '/errors.log'
		);
	}
}

/**
 * CURL stuff
 * I know, fun, right?!
 * 
 * rebuild with wp_remote_post in the future as long as we can still attach files.
 * https://stackoverflow.com/questions/46345259/using-wp-remote-post-to-post-multipart-form-data-with-image-to-inaturalist-res perhaps?
 */
$url    = 'https://' . $options['greenhouse_job_board_api_key'] . ':@api.greenhouse.io/v1/applications/';
$header = array( 'Content-Type: multipart/form-data' );
$ch     = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $_POST );
curl_setopt( $ch, CURLOPT_HEADER, false );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_UNRESTRICTED_AUTH, 1 );
$response = curl_exec( $ch );

if ( $ghjb_d ) {
	print_r( $_POST );
	print_r( $response );

	// versions.
	echo '
	php version: ' . esc_attr( phpversion() );
	$curl_v = curl_version();
	echo '
	curl version: ' . esc_attr( $curl_v['version'] );

	if ( ! $response ) {
		echo '
	    curl error: ' . esc_attr( curl_error( $ch ) );
		echo '
		-end error-
		';
		print_r( $ch );
		echo '
		curl error num: ' . esc_attr( curl_errno( $ch ) );
		$info = curl_getinfo( $ch );
	}
}

curl_close( $ch );

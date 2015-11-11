<?php
/**
 * @since      2.0.0
 */

require('../../../../../wp-blog-header.php');
$options = get_option( 'greenhouse_job_board_settings' );
// echo $options['greenhouse_job_board_api_key'];
$ghjb_d = false;
if ( $options['greenhouse_job_board_debug'] === 'true' ) {
	$ghjb_d = true;	
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

if ($response === FALSE && $ghjb_d) {
    echo "curl error: " . curl_error($ch);
	echo '-end error-';
	print_r($ch);
	echo 'curl error num: ' . curl_errno($ch);
	$info = curl_getinfo($ch);
	print_r($info);
}
if ( $ghjb_d ){
	echo '-RESPONSE-';
	print_r($response);
	echo '-RESPONSE END-';
	
	//versions
	echo 'php version: '.phpversion();
	echo 'curl version: '.curl_version();
}

curl_close($ch);

// phpinfo();

?>
<?php
require('../../../../../wp-blog-header.php');
$options = get_option( 'greenhouse_job_board_settings' );
// echo $options['greenhouse_job_board_api_key'];

// print_r($_POST);
// print_r($_FILES);

// $postfields = http_build_query($_POST);

//add resume to post vars
// print_r($_FILES['resume']);
$tmpfile = $_FILES['resume']['tmp_name'];
$filename = basename($_FILES['resume']['name']);
$filesize = $_FILES['resume']['size'];
$filetype = $_FILES['resume']['type'];
$_POST['resume'] = '@'.$tmpfile.';filename='.$filename.';type='.$filetype;


//add cover_letter to post vars
// print_r($_FILES['cover_letter']);
// $tmpfile2 = $_FILES['cover_letter']['tmp_name'];
// $filename2 = basename($_FILES['cover_letter']['name']);
// $filesize2 = $_FILES['cover_letter']['size'];
// $filetype2 = $_FILES['cover_letter']['type'];
// $_POST['cover_letter'] = '@'.$tmpfile2.';filename='.$filename2.';type='.$filetype2;

// print_r($_POST);

$url = "https://" . $options['greenhouse_job_board_api_key'] . ":@api.greenhouse.io/v1/applications/";
$header = array('Content-Type: multipart/form-data');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); // allow depreciated @
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

if ($response === FALSE) {
    echo "curl error: " . curl_error($ch);
	// echo '-end error-';
	// print_r($ch);
	echo 'curl error num: ' . curl_errno($ch);
	$info = curl_getinfo($ch);
	// print_r($info);
}

// echo 'RESPONSE: ';
print_r($response);
curl_close($ch);
// echo '-end response-';



// phpinfo();

?>
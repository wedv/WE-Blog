<?php

ini_set("display_errors", "Off"); error_reporting(E_ALL);
require_once '../bcs.class.php';
$host = 'bcs.duapp.com';
$ak = 'F22796dc4324bbd59407ddf7588abcb5';
$sk = '8fffc46d7e0e704ca7fa126ea9134e68';
$bucket = 'liuxos2';
$object = '/att/a.txt';
$fileUpload = './a.txt';
$fileWriteTo = './a.' . time () . '.txt';
$baiduBCS = new BaiduBCS ( $ak, $sk, $host );

//step1. create a bucket
$response = $baiduBCS->create_bucket ( $bucket );

if ($response->isOK ()) {
	echo "Create bucket[$bucket] success<br>";

	//step2. create an object
	sleep ( 3 );
    $opt = array('acl'=>'public-read');
	$response = $baiduBCS->create_object ( $bucket, $object, $fileUpload, $opt );
	if (! $response->isOK ()) {
		die ( "Create object failed." );
	}
	echo "Create object[$object] in bucket[$bucket] success<br>";

	//step3. download this object
	sleep ( 3 );
	$opt = array (
			"fileWriteTo" => $fileWriteTo );
	$response = $baiduBCS->get_object ( $bucket, $object, $opt );
	if (! $response->isOK ()) {
		die ( "Download object failed." );
	}
	echo "Download object[$object] in bucket[$bucket] success. And write to [$fileWriteTo]<br>";
    $a = $baiduBCS->list_bucket();
    print_r($a);
die;
    //step4. delete this object
	sleep ( 3 );
    $response = $baiduBCS->delete_object ( $bucket, $object);
	if (! $response->isOK ()) {
		die ( "Delete object failed." );
	}
	echo "Delete object[$object] in bucket[$bucket] success<br>";

    //step5. delete this bucket
	sleep ( 3 );
    $response = $baiduBCS->delete_bucket ( $bucket);
	if (! $response->isOK ()) {
		die ( "Delete bucket failed." );
	}
	echo "Delete bucket[$bucket] success<br>";
}

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	// Implementation specific variables
	$FBappID	= '422655207771714';						// Facebook App ID
	$FBpageName	= 'www.facebook.com/XcriCourseSearchApp';	// Facebook Page where the app should run (without http(s)://)
	$AppProvID	= '4e149a55-c321-4250-b3ad-6cd5e8932dbd';	// Provider ID from aggregator
	$AppGAaccID	= 'UA-5836281-22';							// Google Analytics account ID

    $FBappInfo	= json_decode(file_get_contents("https://graph.facebook.com/".$FBappID), true);
	$FBprotocol	= ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
					isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://');
	$FBpageName	= $FBprotocol . $FBpageName;
	$FBappURL	= $FBprotocol . "apps.facebook.com/".$FBappInfo['namespace'];
	$FBtitle	= 'Course Search';
	$FBimage	= $FBappInfo['logo_url'];
	$FBdesc 	= $FBappInfo['description'];
?>

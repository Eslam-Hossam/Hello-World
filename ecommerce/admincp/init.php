<?php 
	
	include "config.php";
	//Routes
	
	$temp = 'includes/temp/'; // temp directory
	$css  = 'layout/css/';    // css directory
	$js   = 'layout/js/';     // js directory
	$lang = 'includes/lang/'; // language directory
	$func = 'includes/func/'; // function directory

	// VIP File

	include $func .  'function.php';
	
	include $lang . "eng.php";

	include $temp . 'header.php';

	// include navbar on all pages expect the one with nonavbar variable

	if(!isset($noNavbar)) {	include $temp . 'navbar.php'; }
?>

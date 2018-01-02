<?php 
	
	include "admincp/config.php";


	$sessionuser  = '';

	if ( isset($_SESSION['user']) ) {

		$sessionuser = $_SESSION['user'];
	}

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

?>

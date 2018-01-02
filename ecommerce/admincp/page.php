<?php 

	$do ='';

	if(isset($_GET['do'])) {

		$do = $_GET['do'];
	
	} else{

		$do = 'Manage';
	}

	if($do == 'Manage') {

		echo 'welcome in mange';
		echo'<a href="page.php?do=add"> Add New Item </a>';

	} elseif ($do == 'add') {
		
		echo'your item will be added';

	} elseif($do == 'delete') {

		echo'your item deleted';

	} else {

		echo'5or fe dahia yala';
	}

?>
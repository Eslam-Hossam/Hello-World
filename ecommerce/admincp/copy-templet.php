<?php
	
	ob_start();

	session_start();
	
	if(isset($_SESSION['Username'])){
	
		$pagetitle = '';

		include'init.php';
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

		if ($do == 'Mange') { //mange user page

			echo "Welcome";

		} elseif ($do == 'Add') { //add users page


			
		} elseif($do == 'Insert') {  // insert page



		} elseif ($do == 'Edit') { //edit page 



		} elseif ( $do == 'Update' ) { //update users



		} elseif ($do == 'Delete') {



		} elseif($do == 'Activate') { // active users



		} elseif($do == 'Deactivate') {



		}
		
		include $temp . "footer.php";
	


	} else {
		
		header('Location: index.php');
	
		exit();
	}

	ob_end_flush();
	
?>
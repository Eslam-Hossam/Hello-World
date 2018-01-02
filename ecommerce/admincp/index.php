<?php
	session_start();
	$noNavbar  =  '';
	$pagetitle =  'Login Page';

	if(isset($_SESSION['Username'])){

		header('location: adminpanel.php');
	}
	

	include "init.php";


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$username   =  $_POST['log_username'];
		$password   =  $_POST['log_password'];
		$hashedPass =  sha1($password);

		$stmt = $con->prepare("SELECT 
									UserID, Username, Password 
								FROM 
									users 
								WHERE
									Username = ? 
								AND 
									Password = ? 
								AND 
									GroupID = 1 
								LIMIT 1 ");

		$stmt->execute(array($username, $hashedPass));
		$row   = $stmt->fetch();
		$count = $stmt->rowCount();
		
		if($count > 0 ){

			$_SESSION['Username'] = $username;
			$_SESSION['ID'] = $row['UserID'];
			header('location: adminpanel.php');
			exit();
		}
	}
 ?>


 
 	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="post">

 		<h1 class="hco text-center"> Admin <span> Login </span> </h1>

 		<input class="form-control"  type="text" name="log_username" placeholder="Enter Your User Name" autocomplete="off" /> 
 		<input class="form-control"  type="PassWord" name="log_password" placeholder="PassWord" autocomplete="new-password" />
 		<input class="btn btn-primary btn-block" type="submit" value="login" />
 	
 	</form>


<?php include $temp . "footer.php"; ?>
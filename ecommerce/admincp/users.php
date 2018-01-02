<?php
	
	session_start();
	
	if(isset($_SESSION['Username'])){
	
		$pagetitle = 'Users';

		include'init.php';
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

		if ($do == 'Mange') { //mange user page 

			$qu = '';

			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

				$qu = 'AND RegStatus = 0';
			}

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $qu ORDER BY UserID DESC");
			$stmt->execute();
			$rows =$stmt->fetchAll();

			if ( !empty($rows) ){

			?>

				<h1 class="text-center"> Mange User </h1>
				
				<div class="container"> 

					<div class="table-responsive">
					<table class="mtable table table-bordered text-center">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registerd Date</td>
							<td>Control</td>
						</tr>

						<?php  
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['UserID']    . "</td>";
									echo "<td>" . $row['Username']  . "</td>";
									echo "<td>" . $row['Email']     . "</td>";
									echo "<td>" . $row['FullName']  . "</td>";
									echo "<td>" . $row['Date']      ."</td>";
									echo "<td>
										<a href='users.php?do=Edit&userid=".$row['UserID']."' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a>
										<a href='users.php?do=Delete&userid=".$row['UserID']."' class='btn btn-danger conf'><i class='fa fa-close'></i>Delete</a>";
										if($row['RegStatus'] == 1) {
											echo "<a href='users.php?do=Deactivate&userid=".$row['UserID']."' class='btn btn-info conf conf1'><i class='fa fa-close'></i> Deactivate</a>";
										}
										if($row['RegStatus'] == 0) {
											echo"<a href='users.php?do=Activate&userid=".$row['UserID']."' class='btn btn-info conf conf1'><i class='fa fa-check-square'></i>Active</a>";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
					
					</table>
					</div>
					<a href='users.php?do=Add' class="btn btn-success">Add New User  <i class="fa fa-plus"></i></a>

				</div>
			<?php } else { 
				echo" <div class'contanier'> <div class='alert alert-info'> There\'s No Record To Show </div> </div> "; 
				} 
				?>


	<?php	} elseif ($do == 'Add') { //add users page ?> 
			
			<h1 class="text-center">Add New Users</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="post">
					
				<!-- start username field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="username" class="form-control" placeholder="Username to Login" autocomplete="off" required="required"/>
						</div>
					</div>
					<!-- end username field -->
					
					<!-- start password field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10 col-md-4">
							
							<input type="password" name="userpass" class="password form-control" autocomplete="new-password" placeholder="Enter your password" required="required" />
							<i class="show-pass fa fa-eye fa-1x"></i>

						</div>
					</div>
					<!-- end pass field -->
				
					<!-- start email field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-4">
							<input type="email" name="useremail" placeholder="Your Mail" class="form-control" required="required" />
						</div>
					</div>
					<!-- end email field -->


					<!-- start fullname field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Full Name</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="userfullname" placeholder="Full name" class="form-control" required="required" />
						</div>
					</div>
					<!-- end fullname field -->
					

					<!-- start btn field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add User" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- end btn field -->
					
				</form>
			</div>

			<!--  Insert page *******************  -->

	<?php } elseif($do == 'Insert'){  // insert page


		if($_SERVER['REQUEST_METHOD'] == 'POST'){


		echo "<h1 class='text-center'> Insert Users </h1>";
		echo "<div class='container'>";


			$user     = $_POST['username'];
			$pass     = ($_POST['userpass']);
			$email    = $_POST['useremail'];
			$full     = $_POST['userfullname'];

			$hashpass = sha1($pass);
			// vaildtion form in server side
			$formerror = array();
			

			if(empty($user)) {
				$formerror[] = 'user name cant be <strong> empty </strong>';
			}

			if(strlen($user) > 20 or strlen($user) < 4 ) {
				$formerror[] = ' Username cant be less than <strong> 4 characters </strong> or cant be more than <strong> 20 characters </strong>';
			}

			if(empty($email)){
				$formerror[] = 'email cant be <strong> empty </strong>';
			}

			if(empty($pass)) {
				$formerror[] = 'Enter El Pass Yabn el EL <strong> 3abita :D </strong>';
			}

			if(empty($full)){
				$formerror[] = 'full name cant be <strong> empty </strong>';
			}

			foreach ($formerror as $error) {

				echo'<div class="alert alert-danger">' .$error. '</div>';
			}

				if(empty($formerror)) {
				
					// if user name in database stop and echo error massage
				
					$check = checkitem("Username", "users", $user);

					if ($check == 1) {

						$errorms = " <div class='alert alert-danger'>Sorry, that Username is already taken. </div>";

						redhome($errorms, 'back');

					} else {

					// PDO  conect to database Insert user

					$stmt = $con->prepare('INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date)
						VALUES(:user, :pass, :email, :fname, 1, now()) ');

					$stmt->execute( Array(':user'=>$user ,':pass'=>$hashpass ,':email'=>$email,':fname'=>$full) );


				// masage

				$errorms = "<div class='alert alert-success'>".$stmt->rowCount(). "Record Insert</div>";

				redhome($errorms, 'back');
				
				}
					}


		} else {

			echo'<div class="container"> <br/> <br/>';

			$errorms = "<div class='alert alert-danger'> you cant Browse this Page Directly </div>";
			
			redhome($errorms);

			echo "</div>";
		}

		echo "</div>";


		/*******  Edite page   */

			} elseif ($do == 'Edit') { //edit page 

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?	LIMIT 1 ");

			$stmt->execute(array($userid));
			$row   = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) { ?>
			<h1 class="text-center">Edit Users</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="post">
					<input type="hidden" name="userid" value="<?php echo $userid ?>" />
				<!-- start username field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required"/>
						</div>
					</div>
					<!-- end username field -->
					
					<!-- start password field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10 col-md-4">
							<input type="hidden" name="olduserpass" value="<?php echo $row['Password'] ?>" />
							<input type="password" name="newuserpass" class="form-control" autocomplete="new-password" />

						</div>
					</div>
					<!-- end pass field -->
				
					<!-- start email field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-4">
							<input type="email" name="useremail" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
						</div>
					</div>
					<!-- end email field -->


					<!-- start fullname field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Full Name</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="userfullname" value="<?php echo $row['FullName'] ?>" class="form-control" required="required"/>
						</div>
					</div>
					<!-- end fullname field -->
					

					<!-- start btn field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Submit" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- end btn field -->
					
				</form>
			</div>

		<?php  } else {

			echo "<div class='container'> <br/> <br/>";

			$errorms = "<div class='alert alert-danger'> Theres NO Such ID</div>";

			redhome($errorms);

			echo "</div>";
		}

	} elseif ( $do == 'Update' ) { //update users

		echo "<h1 class='text-center'> Update Users </h1>";
		echo "<div class='container'>";

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$id      = $_POST['userid'];
			$user    = $_POST['username'];
			$email   = $_POST['useremail'];
			$full    = $_POST['userfullname'];


			//password change >> short if condition

			$pass = empty($_POST['newuserpass']) ? $_POST['olduserpass'] : sha1($_POST['newuserpass']) ;
			

			// vaildtion form in server side
			$formerror = array();
			

			if(empty($user)) {
				$formerror[] = '<div class="alert alert-danger"> user name cant be <strong> empty </strong> </div>';
			}

			if(strlen($user) > 20 or strlen($user) < 4 ) {
				$formerror[] = '<div class="alert alert-danger"> Username cant be less than <strong> 4 characters </strong> or cant be more than <strong> 20 characters </strong> </div>';
			}

			if(empty($email)){
				$formerror[] = '<div class="alert alert-danger"> email cant be <strong> empty </strong></div>';
			}

			if(empty($full)){
				$formerror[] = '<div class="alert alert-danger"> full name cant be <strong> empty </strong></div>';
			}

			foreach ($formerror as $error) {
				echo $error;
			}

				if(empty($formerror)) {

					$stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
					$stmt2->execute(array($user, $id));
					$chek = $stmt2->rowCount();

					if ( $chek == 1 ){

						$errorms = "<div class='alert alert-danger'> This User Name Taken befor </div>";
						redhome($errorms, 'back');

					} else {
											
					// PDO  conect to database Update
					$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
					$stmt->execute(array($user, $email, $full, $pass, $id));
					$errorms = "<div class='alert alert-success'>".$stmt->rowCount(). "Record Update</div>";

					redhome($errorms, 'back');
						
					}
				}

		} else {

			$errorms = "<div class='alert alert-danger'> you cant see this page </div>";

			redhome($errorms);
		}

		echo "</div>";
	} elseif ($do == 'Delete') {

			echo "<h1 class='text-center'> Delete Users </h1>";

			//check if get request userid in number and get the int value of it
			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
			
			// 
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?	LIMIT 1 ");

			$stmt->execute(array($userid));
			$count = $stmt->rowCount();

			if ($count > 0) {

				if($userid == 1) {

				$errorms = "<br/ <br/> <br/> <div class='alert alert-danger'> you are haker :S we hanfo5k </div> ";
				
				redhome($errorms, 'back');

				echo "</div>";

				} else {

				echo "<div class='container'>";
				
					$stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid ");
					$stmt->bindParam(':userid', $userid);
					$stmt->execute();


				$errorms = "<div class='alert alert-success'>" . $count . " Record Deleted </div>";

				redhome($errorms, 'back');

				echo "</div>";
				}

			} else{

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms, 'back');

				echo "</div>";
			}

	} elseif($do == 'Activate') { // active users

			echo "<h1 class='text-center'> Activate Users </h1>";
			echo "<div class='container'>";

			//check if get request userid in number and get the int value of it
			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			$count = checkitem('userid','users',$userid); // mack stmt query with function checkitem >> 

 			/***************************************************************************************
 			i can use this 3 stmt or user ^^ this function to minmize my code
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?	LIMIT 1 ");
			$stmt->execute(array($userid));
			$count = $stmt->rowCount();
			*****************************************************************************************/

			if ($count > 0) {
				
					$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ? ");
					$stmt->execute(array($userid));

				$errorms = "<div class='alert alert-success'> Done you Activate" . $count . " User </div>";

				redhome($errorms, 'back');

				} else{

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms, 'back');
				
			}
		echo "</div>";

	} elseif($do == 'Deactivate') {

		echo "<h1 class='text-center'> Deactivate page </h1> <div class='container'>";
		$userid = isset($_GET['userid']) && is_numeric($_GET["userid"]) ? intval($_GET["userid"]) : 0;
		$count = checkitem('userid','users',$userid);

		if($count > 0) {

			$stmt = $con->prepare("UPDATE users SET RegStatus = 0 WHERE UserID = ? ");
			$stmt->execute(array($userid));

			$errorms = "<div class='alert alert-success'> You Deactive ". $count . " User <br/><br/>";
			redhome($errorms, 'back');
		} else {

		}

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms, 'back');				

	}
		
		include $temp . "footer.php";
	
	} else{
		
		header('Location: index.php');
	
		exit();
	}

?>
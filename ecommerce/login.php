<?php
	ob_start();
	session_start();
	$pagetitle = 'Login Page';

	if(isset($_SESSION['user'])) {

		header('location: index.php');
	}

	include "init.php";


	if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

		if ( isset( $_POST['login'] ) ) {
		
			$user  	  = $_POST['log_name'];
			$pass 	  = $_POST['log_pass'];
			$hashpass = sha1($pass);

			$stmt	=  $con->prepare('SELECT * FROM users WHERE Username = ? AND Password = ?');
			$stmt	-> execute(array($user,$hashpass));
			$row 	=  $stmt->fetch();
			$count  =  $stmt->rowCount();

			if( $count > 0 ) {

				$_SESSION['user'] = $user;
				header('location: index.php');
				exit();
			}
		} else {

			$formError = array();

			$regUser 	= $_POST['reg_name'];
			$regPass 	= $_POST['reg_pass'];
			$regCopass 	= $_POST['reg_copass'];
			$regEmail 	= $_POST['reg_email'];
			$regFname 	= $_POST['reg_fname'];


			if (isset($regUser)){

				$filterdUser = filter_var($regUser, FILTER_SANITIZE_STRING);

				if(strlen($filterdUser) < 4 ){

					$formError[] = 'Username Must Be MORE Than 4 Characters';
				}
			}

			if (isset($regPass) && isset($regCopass)){

				if (empty($_POST['reg_pass'])){

					$formError[] = 'Sorry Password Cant Be Empty';
				}


				if ( sha1($regPass) !== sha1($regCopass) ) {

					$formError[] = 'Sorry Password Is Not match';
				}

			}

			if (isset($regEmail))	{

				$filterdEmail = filter_var($regEmail, FILTER_SANITIZE_EMAIL);

				if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

					$formError[] = 'This Email Is Not Valid';
				}
			}

			if (isset($regFname)) {

				$filterdFname = filter_var($regFname, FILTER_SANITIZE_STRING);

				if ( str_word_count($filterdFname) < 3 ) {

					$formError[] = 'You Shold Be Enter Your Triple  Name';

				}

			}

			if ( empty($formError) ) {

				$check = checkitem('Username','users', $regUser);

				if ($check == 1) {

					$formError[] = "Sorry, that Username is already taken.";


				} else {

					$stmt = $con->prepare('INSERT INTO users (Username, Password, Email, FullName, RegStatus, Date)
					 VALUES(:zuer, :zpas, :zemail, :zfulln, 0, now()) ');
					$stmt->execute(array(
							'zuer' 		=> $regUser,
							'zpas' 		=> sha1($regPass),
							'zemail'	=> $regEmail,
							'zfulln'	=> $regFname,
						));

				$errorms = "<br/><br/><br/> <div class='alert alert-success'>".$stmt->rowCount(). "Congrats You Are Now Registerd User";
				
				}
			}
		

		}
	}
?>
	<div class="login-page">

		<div class="container login-page">
			<h1 class="text-center"> <span class="active" data-class="login">Login</span> | <span data-class="signup"> Signup </span> </h1>

			<!--   /****  Login form   ****/    -->
			<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="post">
				<div class="input-cont">
					<input class="form-control" type="text" name="log_name" autocomplete="off" placeholder="User Name" required />
				</div>
				<div class="input-cont">
					<input class="form-control" type="password" name="log_pass" autocomplete="new-password" placeholder="PassWord" required />
				</div>
				<input class="btn  btn-primary btn-block" type="submit" name="login" value="Login" />
			</form>
			<!--   /**** end Login form   ****/    -->


			<!--   /****  Signup form   ****/    -->

			<form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="input-cont">
					<input class="form-control" type="text" id="Username" pattern=".{4,}" title="User Name Must Be More Than 4 Characters" name="reg_name" autocomplete="off" placeholder="User Name" required />
					<div id="status"> </div>
				</div>
				<div class="input-cont">
					<input class="form-control" type="password" minlength="4" name="reg_pass" autocomplete="new-password" placeholder="PassWord" required />
				</div>
				<div class="input-cont">
					<input class="form-control" type="password" minlength="4" name="reg_copass" autocomplete="new-password" placeholder="PassWord Again" required />
				</div>
				<div class="input-cont">
					<input class="form-control" type="email" name="reg_email" autocomplete="off" placeholder="Vaild E-mail" required />
				</div>
				<div class="input-cont">
					<input class="form-control" type="text" name="reg_fname" autocomplete="off" placeholder="Your Full Name" required />
				</div>
				<input class="btn  btn-success btn-block" name="signup" type="submit" value="Signup" />
			</form>
		</div>

	</div>

	<section class="errosmsg text-center">
		
		<?php 
			
			if(!empty($formError)){

				foreach ($formError as $error) {
				
					echo "<div class='msg'>" . $error . "</div>";

				}
			} 
		?>

	</section>
<?php
	include $temp . "footer.php";
	ob_end_flush();
?>
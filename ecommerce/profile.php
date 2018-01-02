<?php

	session_start();
	$pagetitle = "Profile Page";

	include "init.php";

	if (isset($_SESSION['user'])) {

		$stmtuser = $con->prepare('SELECT * FROM users WHERE Username = ?');
		$stmtuser->execute(array($sessionuser));
		$info = $stmtuser->fetch();


?>
	<h1 class="text-center"> My Profile </h1>
	<div class="information block"> 
		<section class="container">
			 <div class="panel panel-primary">
			 	<div class="panel-heading"> My Information </div>
			 		<section class="panel-body">
			 			<ul class="list-unstyled">
			 				<li> 
			 					<i class="fa fa-unlock-alt fa-fw"></i>
			 					<span> Name </span> : <?php echo $info['Username']; ?> 
			 				</li>
			 				<li>
			 					<i class="fa fa-envelope-o fa-fw"></i>
			 					<span> Email </span> : <?php echo $info['Email']; ?>
			 				</li>
			 				<li> 
			 					<i class="fa fa-calendar fa-fw"></i>
			 					<span> Registerd Date </span> : <?php echo $info['Date']; ?>
			 				</li>
			 				<li>
			 					<i class="fa fa-user fa-fw"></i>
			 					<span> Full Name </span> : <?php echo $info['FullName']; ?>
			 				</li>
			 				<li> 
			 					<i class="fa fa-tags fa-fw"></i>
			 					<span> Fav Category </span> :
			 				</li>
			 			</ul>
			 		</section>
			 </div>
		</section>
	</div>
	<div class="my-ads block">
		<section class="container">
			 <div class="panel panel-primary">
			 	<div class="panel-heading"> My Adds </div>
			 		<section class="panel-body">
			 			
							<?php
									if (!empty(getitems('User_ID',$info['UserID']))){
										echo "<div class='row'>";
										foreach ( getitems('User_ID',$info['UserID']) as $item ) {
											echo'<div class="col-sm-6 col-md-3">';
												echo'<div class="thumbnail item-box">';
													echo'<span class="price">' . $item['Price'] . '</span>';
													echo'<img src="default-avatar.jpg" alt=""/>';
													echo'<div class="caption">';
														echo'<h3>'.$item['Name'].'</h3>';
														echo'<p>'.$item['Descrption'].'</p>';
													echo'</div>';
												echo'</div>';
											echo'</div>';
										}
									echo "</div>";
								} else {

									echo"There/s No Adds To Show, Create <a href='newad.php'> New Ad </a></div></div>";
								}
							?>
						
			 		</section>
			 </div>
		</section>
	</div>
	<div class="my-com block"> 
		<section class="container">
			 <div class="panel panel-primary">
			 	<div class="panel-heading"> Latest Comments </div>
			 		<section class="panel-body">
			 			<?php

			 				$stmt = $con->prepare('SELECT * FROM comments WHERE user_id = ?');
			 				$stmt->execute(array($info['UserID']));
			 				$rows = $stmt->fetchAll();

			 				if(!empty($rows)){

				 				foreach ($rows as $row ) {
				 				
				 					echo '<p>' .$row['comment'] . '</p>';
				 				
				 				}

			 				} else {

			 					echo "There Is No Comments To Show.";
			 				
			 				}
			 			?>
			 		</section>
			 </div>
		</section>
	</div>

<?php
	
	} else {

		header('location:login.php');

		exit();
	}

	include $temp . "footer.php";

?>
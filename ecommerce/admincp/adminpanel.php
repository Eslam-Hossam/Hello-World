<?php
	
	ob_start();
	session_start();
	
	if(isset($_SESSION['Username'])){
	
		$pagetitle = 'Admin Panel';

		include'init.php';
		
		/* start this page */
		$latestu = 5;  // number of latest user
		$latestuser = getlatest('*','users', 'WHERE GroupID = 0' ,'UserID', $latestu); //function get items

		$numItems = 5;
		$latestI = getlatest('*','items','Item_ID', $numItems);

		$numcom = 5;

		?>
		<section class="home-s">
			<div class="container">
				
			<h1 class="text-center"> Admin Panel </h1>

			<div class="row text-center">
				<div class="col-md-3">
					<div class="stat st-1">
						<i class="fa fa-users"> </i>
						<div class="info">
							Total Users <span>
							<a href="users.php"> <?php echo countfun('UserID','users'); ?> </a>
							</span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-2">
						<i class="fa fa-user-plus"></i>
						<div class="info">
							Pending Users <span>
							<a href="users.php?do=Mange&page=Pending"> <?php echo countandchcek("RegStatus", "users", 0); ?> </a>
							</span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-3">
						<i class="fa fa-tag"> </i>
						<div class="info">
							Total Items <span><a href="items.php"> <?php echo countfun('Item_ID','items'); ?> </a></span>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stat st-4">
						<i class="fa fa-comments"></i>
						<div class="info">
							Total Coments <span> <a href="comments.php"> <?php echo countfun('cid','comments'); ?> </a> </span>
						</div>
					</div>
				</div>
			
			</div>

			</div>
		</section>

		<section class="latest">
			<div class="container">

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">

						<div class="panel-heading">
							<i class="fa fa-users">  </i> Latest <?php echo $latestu?> Reg Users
							<span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-user">
								<?php

								if (! empty($latestuser)) {

									foreach ($latestuser as $user) {
										echo "<li>";
											echo $user['Username'];
											echo"<span class='btn btn-success pull-right'>";
												echo '<i class="fa fa-edit"></i> <a href="users.php?do=Edit&userid='.$user['UserID'].'">Edit</a>';
											echo"</span>";
										if($user['RegStatus'] == 1) {
											echo "<a href='users.php?do=Deactivate&userid=".$user['UserID']."' class='pull-right btn btn-info conf conf1 btn-ativ'><i class='fa fa-edit'></i> Deactivate</a>";
										}
										if($user['RegStatus'] == 0) {
											echo"<a href='users.php?do=Activate&userid=".$user['UserID']."' class='pull-right btn btn-info conf conf1 btn-ativ'><i class='fa fa-check-square'></i>Active</a>";
										}
										echo"</li>";
									} 
								} else {
									echo "There\'s No Record To Show";
								}
								?>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-bar-chart">  </i> Latest <?php echo $numItems ;?> Items
							<span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-user">
								<?php 
									if ( !empty($latestI) ){
										foreach ($latestI as $item) {
											echo "<li>";
												echo $item['Name'];
												echo"<span class='btn btn-success pull-right'>";
													echo '<i class="fa fa-edit"></i> <a href="items.php?do=Edit&itemid='.$item['item_ID'].'">Edit</a>';
												echo"</span>";
											if($item['Approve'] == 0) {
												echo"<a href='items.php?do=Approve&itemid=".$item['item_ID']."' class='pull-right btn btn-info conf conf1 btn-ativ'><i class='fa fa-check-square'></i>Active</a>";
											}
											echo"</li>";
										}
									} else { echo "There\'s No Record To Show"; } 
								?>
							</ul>
						</div>
					</div>
				</div>

						<!--  comment  -->

			</div>


				<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">

						<div class="panel-heading">
							<i class="fa fa-comments-o">  </i> Latest <?php echo $numcom; ?> Comments
							<span class="toggle-info pull-right">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							
							<?php 

								$stmt = $con->prepare("SELECT comments.*, users.Username FROM comments INNER JOIN users ON users.UserID = comments.user_id ORDER BY cid DESC LIMIT $numcom");
								$stmt->execute();
								$rows = $stmt->fetchAll();

								if(!empty($rows)){

									foreach ( $rows as $row ){

										echo "<div class='com-box'>";

											echo " <span class='com-user comen-com'> <a href='users.php?do=Edit&userid=".$row['user_id']."'> " . $row['Username'] . "</a> </span> ";
											echo " <p class='com-com'> " . $row['comment']  . " </span> ";
											echo "
											<span class='com-btn'>
											<a href='comments.php?do=Edit&cid=".$row['cid']."' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i> Edit</a>
											<a href='comments.php?do=Delete&cid=".$row['cid']."' class='btn btn-danger btn-sm conf'><i class='fa fa-close'></i>Delete</a>";

											if($row['status'] == 0) {
												echo"<a href='comments.php?do=Approve&cid=".$row['cid']."' class='btn btn-info btn-sm conf conf1'><i class='fa fa-check-square'></i>Approve</a></span>";
											}
										
										echo "</div>";
									}
								} else { echo "There\'s No Record To Show"; }
							?>
							
						</div>
					</div>
				</div>

			</div>


			</div>
		</section>

		<?php

		/* end this page */
		
		include $temp . "footer.php";
	
	} else{
		
		header('Location: index.php');
	
		exit();
	}

	ob_end_flush();

?>
<?php
	
	session_start();
	
	if(isset($_SESSION['Username'])){
	
		$pagetitle = 'Comments';

		include'init.php';
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

		if ($do == 'Mange') { //mange comments page 

			$stmt = $con->prepare("SELECT comments.*, items.Name AS Item_Name, users.Username FROM comments INNER JOIN items ON items.item_ID = comments.item_id INNER JOIN users ON users.UserID = comments.user_id ORDER BY cid DESC ");
			$stmt->execute();
			$rows =$stmt->fetchAll();

		?>

			<h1 class="text-center"> Mange Comments </h1>
			
			<div class="container"> 

				<div class="table-responsive">
				<table class="mtable table table-bordered text-center">
					<tr>
						<td>#ID</td>
						<td>Comment</td>
						<td>Item Name</td>
						<td>User Name</td>
						<td>Added Date</td>
						<td>Control</td>
					</tr>

					<?php  
						foreach ($rows as $row) {
							echo "<tr>";
								echo "<td>" . $row['cid']    . "</td>";
								echo "<td>" . $row['comment']  . "</td>";
								echo "<td>" . $row['Item_Name']     . "</td>";
								echo "<td>" . $row['Username']  . "</td>";
								echo "<td>" . $row['comment_date']      ."</td>";
								echo "<td>
									<a href='comments.php?do=Edit&cid=".$row['cid']."' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i> Edit</a>
									<a href='comments.php?do=Delete&cid=".$row['cid']."' class='btn btn-danger btn-sm conf'><i class='fa fa-close'></i>Delete</a>";

									if($row['status'] == 0) {
										echo"<a href='comments.php?do=Approve&cid=".$row['cid']."' class='btn btn-info btn-sm conf conf1'><i class='fa fa-check-square'></i>Approve</a>";
									}
								echo "</td>";
							echo "</tr>";
						}
					?>
				
				</table>
				</div>
			</div>


		<?php	

		} elseif ($do == 'Edit') { //edit page 

			$comid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
		
			$stmt = $con->prepare("SELECT * FROM comments WHERE cid = ?");

			$stmt->execute(array($comid));
			$row   = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) { ?>
			<h1 class="text-center">Edit Comment</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="post">
					<input type="hidden" name="comid" value="<?php echo $comid ?>" />
				<!-- start Comment field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Comment</label>
						<div class="col-sm-10 col-md-4">
							<textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
						</div>
					</div>
					<!-- end Comment field -->

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

		echo "<h1 class='text-center'> Update Comment </h1>";
		echo "<div class='container'>";

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$id      = $_POST['comid'];
			$com    = $_POST['comment'];

				// PDO  conect to database Update
				$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE cid = ?");
				$stmt->execute(array($com, $id));

				
				//
				$errorms = "<div class='alert alert-success'>".$stmt->rowCount(). "Record Update</div>";

					redhome($errorms, 'back');

		} else {

			$errorms = "<div class='alert alert-danger'> you cant see this page </div>";

			redhome($errorms);
		}

		echo "</div>";

	} elseif ($do == 'Delete') {

			echo "<h1 class='text-center'> Delete Comment </h1>";

			$comid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
			
			// 
			$stmt = $con->prepare("SELECT * FROM comments WHERE cid = ? LIMIT 1 ");
			$stmt->execute(array($comid));
			$count = $stmt->rowCount();

			if ($count > 0) {

				echo "<div class='container'>";
				
					$stmt = $con->prepare("DELETE FROM comments WHERE cid = :comid ");
					$stmt->bindParam(':comid', $comid);
					$stmt->execute();


				$errorms = "<div class='alert alert-success'>" . $count . " Record Deleted </div>";

				redhome($errorms, 'back');

				echo "</div>";
				

			} else{

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms, 'back');

				echo "</div>";
			}

	} elseif($do == 'Approve') { // active users

			echo "<h1 class='text-center'> Approve Comment </h1>";
			echo "<div class='container'>";

			//check if get request userid in number and get the int value of it
			$comid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;

			$count = checkitem('cid','comments',$comid); // mack stmt query with function checkitem >> 

 			/***************************************************************************************
 			i can use this 3 stmt or user ^^ this function to minmize my code
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?	LIMIT 1 ");
			$stmt->execute(array($userid));
			$count = $stmt->rowCount();
			*****************************************************************************************/

			if ($count > 0) {
				
					$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE cid = ? ");
					$stmt->execute(array($comid));

				$errorms = "<div class='alert alert-success'> Done you Activate" . $count . " User </div>";

				redhome($errorms, 'back');

				} else{

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms, 'back');
				
			}
		echo "</div>";

	} 	

	include $temp . "footer.php";
	
	} else {
		
		header('Location: index.php');
	
		exit();
	}

?>
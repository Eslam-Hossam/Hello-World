<?php
	
	ob_start();

	session_start();
	
	if(isset($_SESSION['Username'])){
	
		$pagetitle = 'Items';

		include'init.php';
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

		if ($do == 'Mange') { //mange items page


			$stmt = $con->prepare("SELECT items.*, categories.Name AS Cat_Name, users.Username AS User_Name FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users on users.UserID = items.User_ID ORDER BY item_ID DESC");
			$stmt->execute();
			$items=$stmt->fetchAll();

		?>

			<h1 class="text-center"> Mange Items </h1>
			
			<div class="container"> 

				<div class="table-responsive">
				<table class="mtable table table-bordered text-center">
					<tr>
						<td>#ID</td>
						<td>Name</td>
						<td>Description</td>
						<td>Price</td>
						<td>Adding Date</td>
						<td>Cateogry</td>
						<td>Username</td>
						<td>Control</td>
					</tr>

					<?php  
						foreach ($items as $item) {
							echo "<tr>";
								echo "<td>" . $item['item_ID']  	. "</td>";
								echo "<td>" . $item['Name'] 		. "</td>";
								echo "<td>" . $item['Descrption']   . "</td>";
								echo "<td>" . $item['Price']  		. "</td>";
								echo "<td>" . $item['Add_Date']     . "</td>";
								echo "<td>" . $item['Cat_Name']     . "</td>";
								echo "<td>" . $item['User_Name']     . "</td>";
								echo "<td>
									<a href='items.php?do=Edit&itemid=".$item['item_ID']."' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a>
									<a href='items.php?do=Delete&itemid=".$item['item_ID']."' class='btn btn-danger conf'><i class='fa fa-close'></i>Delete</a>";
									if($item['Approve'] == 0) {
										echo"<a href='items.php?do=Approve&itemid=".$item['item_ID']."' class='btn btn-info conf conf1'><i class='fa fa-check-square'></i>Approve</a>";
									}
									if($item['Approve'] == 1) {
										echo"<a href='items.php?do=Approve&itemid=".$item['item_ID']."' class='btn btn-info conf conf1'><i class='fa fa-close'></i>Refusal</a>";
									}
								echo "</td>";
							echo "</tr>";
						}
					?>
				
				</table>
				</div>
				<a href='items.php?do=Add' class="btn btn-success"> Add New Item  <i class="fa fa-plus"></i></a>

			</div>

			<?php 
		} elseif ($do == 'Add') { //add users page ?>


			<h1 class="text-center">Add New Item</h1>

			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="post">
					
					<!-- start name field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="name" class="form-control" placeholder="Name Of The Item" autocomplete="off" required="required"/>
						</div>
					</div>
					<!-- end name field -->
					<!-- start desc field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Descrption</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="descrption" class="form-control" placeholder="Descrption Of The Item" autocomplete="off" required="required"/>
						</div>
					</div>
					<!-- end desc field -->
					<!-- start price field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="price" class="form-control" placeholder="Price Of The Item" autocomplete="off" required="required"/>
						</div>
					</div>
					<!-- end price field -->
					<!-- start country made field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country Made</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="country_made" class="form-control" placeholder="Country Of Made" autocomplete="off" required="required"/>
						</div>
					</div>
					<!-- end country made field -->
					<!-- start status field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-4">
							<select name="status" >
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Uesd</option>
								<option value="4">Old</option>
							</select>
						</div>
					</div>
					<!-- end status field -->
					<!-- start users field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">User</label>
						<div class="col-sm-10 col-md-4">
							<select name="users" >
								<option value="0">...</option>
								<?php

									$stmt = $con->prepare('SELECT * FROM users ');
									$stmt->execute();
									$users = $stmt->fetchAll();
									foreach ($users as $user) {
										echo "<option value='". $user['UserID'] ."'>". $user['Username'] ."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- end users field -->
					<!-- start categories field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-4">
							<select name="categories" >
								<option value="0">...</option>
								<?php

									$stmt1 =$con->prepare('SELECT * FROM categories');
									$stmt1->execute();
									$cats = $stmt1->fetchAll();
									foreach ($cats as $cat) {
										echo "<option value='". $cat['ID'] ."'>". $cat['Name'] ."</option>";
									}

								?>
							</select>
						</div>
					</div>
					<!-- end categories field -->


					<!-- start btn field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
						</div>
					</div>
					<!-- end btn field -->
					
				</form>
			</div>

			
			<?php 

		} elseif($do == 'Insert') {  // insert item page


			if($_SERVER['REQUEST_METHOD'] == 'POST'){


				echo "<h1 class='text-center'> Insert Item </h1>";
				echo "<div class='container'>";


				$name 			= $_POST['name'];
				$desc 			= $_POST['descrption'];
				$price 			= $_POST['price'];
				$country 		= $_POST['country_made'];
				$status 		= $_POST['status'];
				$users 			= $_POST['users'];
				$categories 	= $_POST['categories'];




				// vaildtion form in server side
				$formerror = array();
				

				if(empty($name)) {
					$formerror[] = 'name cant be <strong> Empty </strong>';
				}

				if(empty($desc)) {
					$formerror[] = 'Descrption cant be <strong> Empty </strong>';
				}

				if(empty($price)){
					$formerror[] = 'Price cant be <strong> Empty </strong>';
				}

				if(empty($country)) {
					$formerror[] = 'Country cant be <strong> Empty </strong>';
				}

				if($status == 0 ){
					$formerror[] = 'You Must Choose the   <strong> Status </strong>';
				}

				if($users == 0 ) {
					$formerror[] = 'User cant be <strong> Empty </strong>';
				}

				if($categories == 0 ) {
					$formerror[] = 'Category cant be <strong> Empty </strong>';
				}


				foreach ($formerror as $error) {

					echo'<div class="alert alert-danger">' .$error. '</div>';
				}

					if(empty($formerror)) {
					

						// PDO  conect to database Insert user

						$stmt = $con->prepare('INSERT INTO items(Name, Descrption, Price, Country_Made, Status, Cat_ID, User_ID, Add_Date) 
							VALUES(:name, :des, :pri, :coun, :stu, :catid, :userid, now()) ');

						$stmt->execute( Array(':name'=>$name ,':des'=>$desc ,':pri'=>$price,':coun'=>$country,':stu'=>$status,':catid'=>$categories,':userid'=>$users  ) );


					// masage

					$errorms = "<div class='alert alert-success'>".$stmt->rowCount(). "Record Insert</div>";

					redhome($errorms, 'back');
					
					}
						}


			 else {

				echo'<div class="container"> <br/> <br/>';

				$errorms = "<div class='alert alert-danger'> you cant Browse this Page Directly </div>";
				
				redhome($errorms, 'back');

				echo "</div>";
			}

				echo "</div>";


		} elseif ($do == 'Edit') { //edit page

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
		
			$stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");

			$stmt->execute(array($itemid));
			$item   = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) { ?>
			
				<h1 class="text-center">Edit Item</h1>

				<div class="container">
				<form class="form-horizontal" action="?do=Update" method="post">
					<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />

					
					<!-- start name field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="name" class="form-control" placeholder="Name Of The Item" autocomplete="off" required="required" value="<?php echo $item['Name']; ?>" />
						</div>
					</div>
					<!-- end name field -->
					<!-- start desc field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Descrption</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="descrption" class="form-control" placeholder="Descrption Of The Item" autocomplete="off" required="required" value="<?php echo $item['Descrption']; ?>" />
						</div>
					</div>
					<!-- end desc field -->
					<!-- start price field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="price" class="form-control" placeholder="Price Of The Item" autocomplete="off" required="required" value="<?php echo $item['Price']; ?>"/>
						</div>
					</div>
					<!-- end price field -->
					<!-- start country made field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country Made</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="country_made" class="form-control" placeholder="Country Of Made" autocomplete="off" required="required" value="<?php echo $item['Country_Made']; ?>"/>
						</div>
					</div>
					<!-- end country made field -->
					<!-- start status field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-4">
							<select name="status" >
								<option value="1" <?php if($item['Status'] == 1){echo "selected";} ?>>New</option>
								<option value="2" <?php if($item['Status'] == 2){echo "selected";} ?>>Like New</option>
								<option value="3" <?php if($item['Status'] == 3){echo "selected";} ?> >Uesd</option>
								<option value="4"<?php if($item['Status'] == 4){echo "selected";} ?> >Old</option>
							</select>
						</div>
					</div>
					<!-- end status field -->
					<!-- start users field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">User</label>
						<div class="col-sm-10 col-md-4">
							<select name="users" >
								<option value="0">...</option>
								<?php

									$stmt = $con->prepare('SELECT * FROM users ');
									$stmt->execute();
									$users = $stmt->fetchAll();
									foreach ($users as $user) {
										echo "<option value='". $user['UserID'] ."'";if($item['User_ID'] == $user['UserID']){echo "selected";}echo">". $user['Username'] ."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- end users field -->
					<!-- start categories field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-4">
							<select name="categories" >
								<?php

									$stmt1 =$con->prepare('SELECT * FROM categories');
									$stmt1->execute();
									$cats = $stmt1->fetchAll();
									foreach ($cats as $cat) {
										echo "<option value='". $cat['ID'] ."'"; if($item['Cat_ID'] == $cat['ID']){ echo "selected";} echo">". $cat['Name'] ."</option>";
									}

								?>
							</select>
						</div>
					</div>
					<!-- end categories field -->


					<!-- start btn field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
						</div>
					</div>
					<!-- end btn field -->
					
				</form>

			<?php

			$stmt = $con->prepare("SELECT comments.*, users.Username FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ? ");
			$stmt->execute(array($itemid));
			$rows =$stmt->fetchAll();

			if (!empty($rows)){

		?>

			<h1 class="text-center"> Mange [ <?php echo $item['Name']; ?> ] Comments </h1>
			
				<div class="table-responsive">
				<table class="mtable table table-bordered text-center">
					<tr>
						<td>Comment</td>
						<td>User Name</td>
						<td>Added Date</td>
						<td>Control</td>
					</tr>

					<?php  
						foreach ($rows as $row) {
							echo "<tr>";
								echo "<td>" . $row['comment']  . "</td>";
								echo "<td>" . $row['Username']  . "</td>";
								echo "<td>" . $row['comment_date']      ."</td>";
								echo "<td>
									<a href='comments.php?do=Edit&cid=".$row['cid']."' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a>
									<a href='comments.php?do=Delete&cid=".$row['cid']."' class='btn btn-danger conf'><i class='fa fa-close'></i>Delete</a>";

									if($row['status'] == 0) {
										echo"<a href='comments.php?do=Approve&cid=".$row['cid']."' class='btn btn-info conf conf1'><i class='fa fa-check-square'></i>Approve</a>";
									}
								echo "</td>";
							echo "</tr>";
						}
					?>
				
				</table>
				</div>
			</div>


			<?php } } else {

				echo "<div class='container'> <br/> <br/>";

				$errorms = "<div class='alert alert-danger'> Theres NO Such ID</div>";

				redhome($errorms);

				echo "</div>";
			}


		} elseif ( $do == 'Update' ) { //update users


			echo "<h1 class='text-center'> Update Items </h1>";
			echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$id     = $_POST['itemid'];
				$name   = $_POST['name'];
				$descr  = $_POST['descrption'];
				$pric   = $_POST['price'];
				$cmade  = $_POST['country_made'];
				$sts    = $_POST['status'];
				$user   = $_POST['users'];
				$cates  = $_POST['categories'];

				// vaildtion form in server side
				$formerror = array();
				

				if(empty($name)) {
					$formerror[] = 'name cant be <strong> Empty </strong>';
				}

				if(empty($descr)) {
					$formerror[] = 'Descrption cant be <strong> Empty </strong>';
				}

				if(empty($pric)){
					$formerror[] = 'Price cant be <strong> Empty </strong>';
				}

				if(empty($cmade)) {
					$formerror[] = 'Country cant be <strong> Empty </strong>';
				}

				if($sts == 0 ){
					$formerror[] = 'You Must Choose the   <strong> Status </strong>';
				}

				if($user == 0 ) {
					$formerror[] = 'User cant be <strong> Empty </strong>';
				}

				if($cates == 0 ) {
					$formerror[] = 'Category cant be <strong> Empty </strong>';
				}


				foreach ($formerror as $error) {
					echo $error;
				}

					if(empty($formerror)) {

					// PDO  conect to database Update
					$stmt = $con->prepare("UPDATE items SET Name = ?, Descrption = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, User_ID = ? WHERE item_ID = ?");
					$stmt->execute(array($name, $descr, $pric, $cmade, $sts, $cates, $user, $id));

					//
					$errorms = "<div class='alert alert-success'>".$stmt->rowCount(). "Record Update</div>";

						redhome($errorms, 'back');
					
					}

			} else {

				$errorms = "<div class='alert alert-danger'> you cant see this page </div>";

				redhome($errorms);
			}

			echo "</div>";


		} elseif ($do == 'Delete') { /* delete */

			echo "<h1 class='text-center'> Delete Item </h1>";

			//check if get request itemid in number and get the int value of it
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
			
			// 
			$stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ? LIMIT 1 ");
			$stmt->execute(array($itemid));
			$count = $stmt->rowCount();

			if ($count > 0) {

				echo "<div class='container'>";
				
					$stmt = $con->prepare("DELETE FROM items WHERE item_ID = :itemid ");
					$stmt->bindParam(':itemid', $itemid);
					$stmt->execute();


				$errorms = "<div class='alert alert-success'>" . $count . " Record Deleted </div>";

				redhome($errorms, 'back');

				echo "</div>";
				

			} else{

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms);

				echo "</div>";
			}


		} elseif($do == 'Approve') { // active users

			echo "<h1 class='text-center'> Approve Item </h1>";
			echo "<div class='container'>";

			//check if get request itemid in number and get the int value of it
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			$count = checkitem('item_ID','items',$itemid); // mack stmt query with function checkitem >> 

 			/***************************************************************************************
 			i can use this 3 stmt or user ^^ this function to minmize my code
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?	LIMIT 1 ");
			$stmt->execute(array($userid));
			$count = $stmt->rowCount();
			*****************************************************************************************/

			if ($count > 0) {
				
					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ? ");
					$stmt->execute(array($itemid));

				$errorms = "<div class='alert alert-success'> Done you Approved" . $count . " User </div>";

				redhome($errorms, 'back');

				} else{

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms, 'back');
				
			}
		echo "</div>";


		} elseif($do == 'Deactivate') {


		}
		
		include $temp . "footer.php";
	


	} else {
		
		header('Location: index.php');
	
		exit();
	}

	ob_end_flush();
	
?>
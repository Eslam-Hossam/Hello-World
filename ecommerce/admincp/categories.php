<?php

	/* */

	ob_start();

	session_start();
	
	if(isset($_SESSION['Username'])){
	
		$pagetitle = 'Categorise';

		include'init.php';
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

		if ($do == 'Mange') { //mange cat page /*************************************                 /********/

			$sort = 'ASC';

			$sort_array = array('ASC','DESC');

			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

				$sort=$_GET['sort'];
			}

			$stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort ");
			$stmt2->execute();
			$cats = $stmt2->FetchAll(); ?>

			<h1 class="text-center"> Mange Categories </h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading"> <i class="fa fa-edit"></i> Mange Categories 
						<div class="Option pull-right">
							<i class="fa fa-sort"></i> Ordering:[
							<a class='<?php if($_GET['sort'] == 'ASC' or $_GET['sort'] == '' ) {echo "active"; } ?>' href="?sort=ASC">  ASC  <i class="fa fa-sort-numeric-asc"></i></a>
							|
							<a class='<?php if($_GET['sort'] == 'DESC') {echo "active"; } ?>' href="?sort=DESC"> DESC <i class="fa fa-sort-numeric-desc"></i></a>
							]
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full" >Full</span> |
							<span data-view="classic" >Classic</span> ]
						</div>
					</div>
						<div class="panel-body">
							<?php

								foreach ($cats as $cat) {

									echo "<div class='cat'>";

										echo "<div class='hidden-but'>";

											echo "<a href='categories.php?do=Edit&catid=".$cat['ID']."' class='btn btn-xs btn-primary'> <i class='fa fa-edit'> </i> Edit </a>";

											echo "<a href='categories.php?do=Delete&catid=".$cat['ID']."' class='conf btn btn-xs btn-danger'> <i class='fa fa-close'> </i> Delete </a>";

										echo"</div>";

										echo "<h3>" . $cat['Name'] . " </h3>";

										echo "<div class='full-view'>";

											echo "<p>"; if(empty($cat['Description'])) { echo "This Category has No Description"; } else { echo $cat['Description'] ;} echo"</p>" ;

											if ($cat['Visibility'] == 1) { echo "<span class='Visi'> <i class='fa fa-eye'></i> Hidden </span>"; };

											if ($cat['Allow_Comment'] == 1) { echo "<span class='comen'> <i class='fa fa-close'></i> Comment Disabled </span>"; };

											if ($cat['Allow_Adss'] == 1) { echo "<span class='addv'> <i class='fa fa-close'></i> Ads Disabled </span>"; };

										echo"</div>";

									echo "</div>";
									echo "<hr>";
								}
							?>
						</div>
				</div>
					<a class="add_btn btn btn-primary" href="Categories.php?do=Add" > <i class="fa fa-plus"></i> Add New Category </a>
			</div>



	<?php	} elseif ($do == 'Add') { //add cat page // -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-  ?>

			<h1 class="text-center">Add New Category</h1>

			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="post">
					
				<!-- start name field -->

					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="name" class="form-control" placeholder="Name Of The Gategory" autocomplete="off" required="required"/>
						</div>
					</div>
					<!-- end name field -->
					
					<!-- start Description field -->

					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-4">
							
							<input type="text" name="description" class="form-control" placeholder="Enter your Description" />

						</div>
					</div>
					<!-- end Description field -->
				
					<!-- start Ordering field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="ordering" placeholder="Number" class="form-control"/>
						</div>
					</div>
					<!-- end Ordering field -->


					<!-- start Visible field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"> Visible </label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="vis-yes" type="radio" name="Visibility" value="0" checked/>
								<label for="vis-yes"> Yes </label> 
							</div>
							<div>
								<input id="vis-no" type="radio" name="Visibility" value="1" />
								<label for="vis-no"> No </label> 
							</div>
						</div>
					</div>
					<!-- end Visible field -->
					


					<!-- start Comment field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"> Comment </label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="com-yes" type="radio" name="Comment" value="0" checked/>
								<label for="com-yes"> Yes </label> 
							</div>
							<div>
								<input id="com-no" type="radio" name="Comment" value="1" />
								<label for="com-no"> No </label> 
							</div>
						</div>
					</div>
					<!-- end Comment field -->

					<!-- start adds field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"> Adds </label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="adds-yes" type="radio" name="Adds" value="0" checked/>
								<label for="adds-yes"> Yes </label> 
							</div>
							<div>
								<input id="adds-no" type="radio" name="Adds" value="1" />
								<label for="adds-no"> No </label> 
							</div>
						</div>
					</div>
					<!-- end adds field -->


					<!-- start btn field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- end btn field -->
					
				</form>
			</div>

			<?php
			
		} elseif($do == 'Insert') {  // insert Category -*-*-*-*-*-**-*-*-*-*-***-*-*-*-*-*-*-*-*-*


		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name']) ){


		echo "<h1 class='text-center'> Insert Category </h1>";
		echo "<div class='container'>";


			$name     = $_POST['name'];
			$desc     = ($_POST['description']);
			$orde     = $_POST['ordering'];
			$vis      = $_POST['Visibility'];
			$com      = $_POST['Comment'];
			$adds      = $_POST['Adds'];
				
			// if Category in database stop and echo error massage
		
			$check = checkitem("Name", "categories", $name);

			if ($check == 1) {

				$errorms = " <div class='alert alert-danger'>Sorry, that Category is already taken. </div>";

				redhome($errorms, 'back');

			} else {

			// PDO conect to database Insert Category

			$stmt = $con->prepare('INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Adss)
				VALUES(:name, :zdesc, :order, :vis, :com, :adds)');

			$stmt->execute( Array(':name'=>$name ,':zdesc'=>$desc ,':order'=>$orde,':vis'=>$vis,':com'=>$com,':adds'=>$adds ));


			// masage

			$errorms = "<div class='alert alert-success'>".$stmt->rowCount(). "Record Insert</div>";

			redhome($errorms, 'back');

			}
			


		} else {

			echo'<div class="container"> <br/> <br/>';

			$errorms = "<div class='alert alert-danger'> you cant Browse this Page Directly </div>";
			
			redhome($errorms, 'back');

			echo "</div>";
		}

			echo "</div>";

		} elseif ($do == 'Edit') { //edit cat page -*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* EDIT

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
		
			$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? ");

			$stmt->execute(array($catid));
			$cat   = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0) { ?>


			<h1 class="text-center">Edit Category</h1>			 
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="post">
					<input type="hidden" name="catid" value="<?php echo$catid?>" />
					
				<!-- start name field -->

					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="name" class="form-control" placeholder="Name Of The Gategory" required="required" value="<?php echo $cat['Name']; ?>" />
						</div>
					</div>
					<!-- end name field -->
					
					<!-- start Description field -->

					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-4">
							
							<input type="text" name="description" class="form-control" placeholder="Enter your Description" value="<?php echo $cat['Description']; ?>" />

						</div>
					</div>
					<!-- end Description field -->
				
					<!-- start Ordering field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-4">
							<input type="text" name="ordering" placeholder="Number" class="form-control" value="<?php echo $cat['Ordering']; ?>"/>
						</div>
					</div>
					<!-- end Ordering field -->


					<!-- start Visible field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"> Visible </label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="vis-yes" type="radio" name="Visibility" value="0" <?php if( $cat["Visibility"] == 0 ) { echo'checked' ; }  ?> />
								<label for="vis-yes"> Yes </label> 
							</div>
							<div>
								<input id="vis-no" type="radio" name="Visibility" value="1" <?php if( $cat["Visibility"] == 1 ) { echo'checked' ; }  ?> />
								<label for="vis-no"> No </label> 
							</div>
						</div>
					</div>
					<!-- end Visible field -->
					


					<!-- start Comment field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"> Comment </label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="com-yes" type="radio" name="Comment" value="0" <?php if ( $cat['Allow_Comment'] == 0 ) {echo 'checked';} ?> />
								<label for="com-yes"> Yes </label> 
							</div>
							<div>
								<input id="com-no" type="radio" name="Comment" value="1" <?php if ( $cat['Allow_Comment'] == 1 ) {echo 'checked';} ?> />
								<label for="com-no"> No </label> 
							</div>
						</div>
					</div>
					<!-- end Comment field -->

					<!-- start adds field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"> Adds </label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="adds-yes" type="radio" name="Adds" value="0" <?php if ( $cat['Allow_Adss'] == 0 ) { echo 'checked' ;} ?> />
								<label for="adds-yes"> Yes </label> 
							</div>
							<div>
								<input id="adds-no" type="radio" name="Adds" value="1" <?php if ( $cat['Allow_Adss'] == 1 ) { echo 'checked' ;} ?> /> 
								<label for="adds-no"> No </label> 
							</div>
						</div>
					</div>
					<!-- end adds field -->


					<!-- start btn field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Save Category" class="btn btn-primary btn-lg" />
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

		} elseif ( $do == 'Update' ) { //update cat -*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*

			echo "<h1 class='text-center'> Update Category </h1>";
			echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$id   		= $_POST['catid'];
				$name  		= $_POST['name'];
				$desc  		= $_POST['description'];
				$ord   		= $_POST['ordering'];
				$vis    	= $_POST['Visibility'];
				$allow_com  = $_POST['Comment'];
				$allow_ad   = $_POST['Adds'];

				


					// PDO  conect to database Update
					$stmt = $con->prepare("UPDATE 
												categories 
											SET 
												Name = ?,
												Description = ?,
												Ordering = ?,
												Visibility = ?,
												Allow_Comment = ?,
												Allow_Adss = ?
											WHERE  ID = ? ");
					$stmt->execute(array($name, $desc, $ord, $vis, $allow_com, $allow_ad, $id ));

					
					// this fucntion show masage and redircet to prv page
					$errorms = "<div class='alert alert-success'>".$stmt->rowCount(). "Record Update</div>";

						redhome($errorms, 'back');
					

			} else {

				$errorms = "<div class='alert alert-danger'> you cant see this page </div>";

				redhome($errorms);
			}

			echo "</div>";


		} elseif ($do == 'Delete') { // delete cat -*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*


			echo "<h1 class='text-center'> Delete Category </h1>";

			//check if get request ctaid in number and get the int value of it
			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
			
 
			$stmt = $con->prepare("SELECT * FROM Categories WHERE ID = ? LIMIT 1 ");

			$stmt->execute(array($catid));
			$count = $stmt->rowCount();

			if ($count > 0) {

				echo "<div class='container'>";
				
					$stmt = $con->prepare("DELETE FROM categories WHERE ID = :id ");
					$stmt->bindParam(':id', $catid);
					$stmt->execute();


				$errorms = "<div class='alert alert-success'>" . $count . " Record Deleted </div>";

				redhome($errorms, 'back');

				echo "</div>";
			

			} else{

				$errorms = "<div class='container'><div class='alert alert-danger'> emshy yala </div>";

				redhome($errorms, 'back');

				echo "</div>";
			}

		} elseif($do == 'Activate') { // active cat  -*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*




		} elseif($do == 'Deactivate') { // deactivate cat -*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*




		}
		
		include $temp . "footer.php";
	


	} else {
		
		header('Location: index.php');
	
		exit();
	}

	ob_end_flush();

?>
<?php

	ob_start();
	session_start();

	$pagetitle = 'New Ad';

	include 'init.php';

	if (isset($_SESSION['user'])){

?>

		<h1 class="text-center"> Create New Ad </h1>
		<div class="create-ad block">
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading"> Cerate New Ad </div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-9">
								<form action="<?php echo $_SEREVER['PHP.SELF']; ?>" method="post" class="form-horizontal">
									<!-- start name field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Name</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="name" class="form-control live-name" placeholder="Name Of The Item" autocomplete="off" required="required"/>
										</div>
									</div>
									<!-- end name field -->
									<!-- start desc field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Descrption</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="descrption" class="form-control live-desc" placeholder="Descrption Of The Item" autocomplete="off" required="required"/>
										</div>
									</div>
									<!-- end desc field -->
									<!-- start price field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Price</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="price" class="form-control live-price" placeholder="Price Of The Item" autocomplete="off" required="required"/>
										</div>
									</div>
									<!-- end price field -->
									<!-- start country made field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Country Made</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="country_made" class="form-control" placeholder="Country Of Made" autocomplete="off" required="required"/>
										</div>
									</div>
									<!-- end country made field -->
									<!-- start status field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Status</label>
										<div class="col-sm-10 col-md-9">
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
									<!-- start categories field -->
									<div class="form-group form-group-lg">
										<label class="col-sm-2 control-label">Category</label>
										<div class="col-sm-10 col-md-9">
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
							<div class="col-sm-3">
								<div class="thumbnail item-box live-preview">
									<span class="price"> 0 </span>
									<img src="default-avatar.jpg" alt=""/>
								<div class="caption">
									<h3> Title </h3>
									<p>Descrption</p>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
 

<?php

	} else {
		header('location: index.php');
		exit();
	}

	include  $temp . 'footer.php';
	ob_end_flush();
?>
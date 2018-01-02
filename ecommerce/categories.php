<?php
	session_start();
	$pagetitle = "categories";
	include "init.php";
?>

	<div class="container">
		<h1 class="text-center"> <?php  echo str_replace('-', ' ', $_GET['pagename']); ?> </h1>
		<div class="row">
			<?php

				foreach ( getitems('Cat_ID',$_GET['pageid']) as $item ) {
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

			?>
		</div>	
	</div>



<?php	include $temp . "footer.php"; ?>
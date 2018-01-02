<?php 
	

	/* front end func get cats */
	function getcat() {
	
		global $con;

		$stmt = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
		$stmt->execute();
		$rows= $stmt->fetchAll();

		return $rows;
	}
	
	function getitems($where, $value) {

		global $con;

		$getitm = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY item_ID DESC");
		$getitm->execute(array($value));
		$items=$getitm->fetchAll();

		return $items;
	}


	function checkuserstatus($user) { //check user status if 0 or 1 active or not
		global $con;

		$stmtx	=  $con->prepare('SELECT Username, RegStatus FROM users WHERE Username = ? AND RegStatus = 0');
		$stmtx	-> execute(array($user));
		$status  =  $stmtx->rowCount();

		return $status;

	}

	function checkitem ($select, $from, $value) { // to check item form database

		global $con;

		$stmtf = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$stmtf->execute(array($value));

		$count = $stmtf->rowCount();

		return $count ;

	}




































	function drawTitle() { // name title
	
		global $pagetitle;

		if(isset($pagetitle)) {

			echo $pagetitle;
		
		} else {

			echo 'default';
		}
	
	} 

	function redhome ($errorms, $url = null, $sec = 3) { // redirect to home

		if ($url === null) {

			$url  = 'index.php';
			$link = 'Home Page';
		
		} else {

			if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== "") {

				$url  = $_SERVER["HTTP_REFERER"];
				$link = "Previous Page";

			} else {

				$url  = "index.php";
				$link = "Home Page";

			}
		}

		echo $errorms ;

		echo "<div class='alert alert-info'>you will be Redericted to " .$link. "After $sec Seconds </div>";

		header("refresh:$sec;url=$url");

		exit();
	}

/*
	function checkitem ($select, $from, $value) { // to check item form database

		global $con;

		$stmtf = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$stmtf->execute(array($value));

		$count = $stmtf->rowCount();

		return $count ;

	}
*/

	function countfun ($item, $table) { // to count items or members or any thing in my database

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		
		$stmt2->execute();
		
		return $stmt2->fetchColumn();

	}

//checkitem ("RegStatus","users", 0)

	function countandchcek ($sel, $tab, $val=NULL) { //check in database rows and count items too

		global $con;

		$esquery = '';

		if($val !== NULL) {

			$esquery = "WHERE $sel = ?";
		}

		$stmt3 = $con->prepare("SELECT $sel FROM $tab $esquery");
		$stmt3->execute(array($esquery));
		$count = $stmt3->rowCount();
		return $count;
	}

	function getlatest ($select1, $table1 ,$where = NULL, $order , $limit = 5) { //get latest items or any thing form database
		
		if ($where == NULL) {
			$where = "";
		}

		global $con;



		$stmt4 = $con->prepare("SELECT $select1 FROM $table1 $where ORDER BY $order DESC LIMIT $limit");
		$stmt4->execute();
		$rows = $stmt4->fetchAll();
		return $rows;


	}

?>
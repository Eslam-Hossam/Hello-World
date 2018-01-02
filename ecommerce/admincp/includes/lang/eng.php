<?php 
	
	function lang( $phrase ) {

		static $lang =  array(
			//admin panel
			//navbar
			'home_admin' =>   'AdminPanel',
			'Categories' =>   'Categories',
			'EditProfile'=>   'Edit Profile',
			'Settings'   =>   'Settings',
			'Logout'     =>   'Logout',
			'ITEMS'      =>   'Items',
			'Users'      =>   'Users',
			'STATISTICS' =>   'Statistics',
			'LOGS'       =>   'Logs',
			'COMMENTS'	 =>	  'Comments',
		);

		return $lang[$phrase];
	}

?>

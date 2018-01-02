<?php 

	function lang($phrase) {

		static $lang =array(
				//navbar
				'home_admin'  => 'الرئيسة',
				'Categories'  => 'تصنيفات',
				'EditProfile' => 'تعديل الملف الشخصي',
				'Settings'    => 'الاعدادات',
				'Logout'      => 'تسجيل الخروج',
				'ITEMS'       => 'سلع',
				'Users'       => 'اعضاء',
				'STATISTICS'  => 'ستيتك',
				'LOGS'        => 'لوج',
				'COMMENTS'	  => 'ألتعليقات',
				''=>'',
				''=>'',


			);
		return $lang[$phrase]; 
	}



?>
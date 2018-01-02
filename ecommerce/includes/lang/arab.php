<?php 

	function lang($phrase) {

		static $lang =array(
				//navbar
				'home_admin'  => 'لوحة التحكم',
				'Categories'  => 'تصنيفات',
				'EditProfile' => 'تعديل الملف الشخصي',
				'Settings'    => 'الاعدادات',
				'Logout'      => 'تسجيل الخروج',
				'ITEMS'       => 'سلع',
				'Users'       => 'اعضاء',
				'STATISTICS'  => 'ستيتك',
				'LOGS'        => 'لوج',
				'COMMENTS'	  => 'ألتعليقات',
				'home_n'	  => 'الرئيسية',
				''=>'',


			);
		return $lang[$phrase]; 
	}



?>
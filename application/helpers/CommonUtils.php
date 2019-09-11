<?php 

class Zend_Controller_Action_Helper_CommonUtils extends Zend_Controller_Action_Helper_Abstract
{
	function getVnDateTime($input_date= null)
	{
		 //date_default_timezone_set('Asia/Ho_Chi_Minh');
		
		// create a date object
		 $date = new Zend_Date(($input_date == null ) ? date('Y-m-d H:i:s') : $input_date, null , null);
		 
		 $date2=date_create($date);
		 return date_format($date2,"Y-m-d H:i:s");	
	}
	
	function formatDateAsVnDateTime($str_date)
	{	 
		 $date2=date_create($str_date);
		 return date_format($date2,"d-m-Y H:i:s");
	}
	
	
	function checkUserRole(){
		
	}
}


?>
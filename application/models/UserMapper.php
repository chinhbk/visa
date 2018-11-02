<?php
	//location: application/models/
	class Application_Model_UserMapper{
		protected $_db_table;
		public function __construct()
		{
			$this->_db_table = new Application_Model_DbTable_User();
		}
		
		public function changePass($user_id , $new_password){
			
			$data = array(
						'ID' => $user_id,
					    'PASSWORD' => $new_password
			);

			try{
				//Zend_Debug::dump( $data);die();
				$this->_db_table->update($data, array('ID = ?' => $user_id));
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}						
		}
		
	}
?>
<?php
	//location: application/models/
	class Application_Model_NewsTypeMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the Product table
			$this->_db_table = new Application_Model_DbTable_NewsType();
		}
		 
		public function getAll(){
			try{
				$select = $this->_db_table->select()
									->from('NEWS_TYPE', array('ID','NAME'));
									
				$result = $this->_db_table->getAdapter()->fetchAll($select);
			} catch (Exception $e) {
					Zend_Debug::dump( $e);die();
			}
			return $result;
								
		}
		
	}
	
?>
<?php
	//location: application/models/
	class Application_Model_VisaSettingMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'VISA_SETTING';
		public function __construct()
		{			
			$this->_db_table = new Application_Model_DbTable_VisaSetting();
		}
		 
		public function save(Application_Model_VisaSetting $obj)
		{
		    //Create an associative array
		    //of the data you want to update
		    $data = array(
		        'VALUE' => $obj->value,
		        'TEXT' => $obj->text
		    );
		    
		    //Check if the product object has an ID
		    //if no, it means the product is a new product
		    //if yes, then it means you're updating an old product
		    try {
		        if( is_null($obj->name) ) {
		            //Zend_Debug::dump( $data);		die;
		            $this->_db_table->insert($data);		            
		        } else {
		            //Zend_Debug::dump( $data);		die;
		            $this->_db_table->update($data, array('NAME = ?' => $obj->name));
		        }
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		}
		
		public function getById($id)
		{
		    //use the Table Gateway to find the row that
		    //the id represents
		    try {
		        $result = $this->_db_table->find($id);
		        
		        //if not found, throw an exception
		        if( count($result) == 0 ) {
		            throw new Exception('visa setting not found');
		        }
		        
		        //if found, get the result, and map it to the
		        //corresponding Data Object
		        $row = $result->current();
		        $obj = new Application_Model_VisaType($row);
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    //return the user object
		    return $obj;
		}
		 
		public function getAll($text = null){
			try{
				$select = $this->_db_table->select()
				->from(self::TABLE, array('NAME', 'VALUE', 'TEXT'));
				
				if(isset($text)){
				    $select = $select->where('TEXT IS NOT NULL');
				}
				
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				$arr = array();
				//Zend_Debug::dump($result);die();		
				foreach ($result as $row){
					//Zend_Debug::dump( $row['ID']);die();								
				    $obj = new Application_Model_VisaSetting($row);
					//Zend_Debug::dump( $tour_object);die();
					array_push($arr, $obj);
				}
				//Zend_Debug::dump( $tour_type_arr);die();				
			
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $arr;							
		}			
		
		public function delete($name){
		    $where = $this->_db_table->getAdapter()->quoteInto("NAME = ?", $name);
			$this->_db_table->delete($where);
		}
	}
	
?>
<?php
	//location: application/models/
	class Application_Model_SettingMapper{
		protected $_db_table;
		public function __construct()
		{

			$this->_db_table = new Application_Model_DbTable_Setting();
		}
		 
		public function save(Application_Model_Setting $setting_object)
		{  
			//Create an associative array
			//of the data you want to update
		    $setting_object->id = 1;
			$data = array();
			if (!is_null($setting_object->hotline)) {
			    $data['HOTLINE'] =	$setting_object->hotline;
			}
			
			if (!is_null($setting_object->email)) {
			    $data['EMAIL'] =	$setting_object->email;
			}
			
			if (!is_null($setting_object->address)) {
			    $data['ADDRESS'] =	$setting_object->address;
			}
			
			if (!is_null($setting_object->contact)) {
			    $data['CONTACT'] =	$setting_object->contact;
            }
            
            if (!is_null($setting_object->whyus)) {
                $data['WHYUS'] =$setting_object->whyus;
            }
            //Zend_Debug::dump( $data);		die;	
			//Check if the product object has an ID
			//if no, it means the product is a new product
			//if yes, then it means you're updating an old product
			try {
			    if( is_null($setting_object->id) ) {
						//Zend_Debug::dump( $data);		die;		
					$this->_db_table->insert($data);
				} else {
					//Zend_Debug::dump( $data);		die;
				    $this->_db_table->update($data, array('ID = ?' => $setting_object->id));
				}
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
		}
		 
		public function get()
		{
			//use the Table Gateway to find the row that
			//the id represents
			
		    try {
				$result = $this->_db_table->find(1);
			
				//if not found, throw an exception
				if( count($result) == 0 ) {
					throw new Exception('Setting is not found');
				}
				
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();					
				$obj = new Application_Model_Setting($row);
				//Zend_Debug::dump($obj);die();
			 } catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//return the user object
			return $obj;
		}		
	}
?>
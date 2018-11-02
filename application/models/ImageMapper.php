<?php
	//location: application/models/
	class Application_Model_ImageMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		public function __construct()
		{

			$this->_db_table = new Application_Model_DbTable_Image();
		}
		 
		public function save(Application_Model_Image $image_object)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
				'ID' => $image_object->id,
				'IMAGE' => $image_object->image,
				'STATUS' =>	$image_object->status,
			);
			  
			//Check if the product object has an ID
			//if no, it means the product is a new product
			//if yes, then it means you're updating an old product
			try {
				if( is_null($image_object->id) ) {
						//Zend_Debug::dump( $data);		die;		
					$this->_db_table->insert($data);
				} else {
					//Zend_Debug::dump( $data);		die;
					$this->_db_table->update($data, array('ID = ?' => $image_object->id));
				}
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
		}
		 
		public function getImageById($id)
		{
			//use the Table Gateway to find the row that
			//the id represents
			try {
				$result = $this->_db_table->find($id);
				 
				//if not found, throw an exception
				if( count($result) == 0 ) {
					throw new Exception('Image is not found');
				}
			
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();
				$image_object = new Application_Model_Image($row);
			 } catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//return the user object
			return $image_object;
		}
		
		public function getAll(){
			
			try{
				$select = $this->_db_table->select()
				->from('IMAGE');
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
		
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		
		}		
	}
?>
<?php
	//location: application/models/
	class Application_Model_OrderMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the Product table
			$this->_db_table = new Application_Model_DbTable_Order();
		}
		 
		public function save(Application_Model_Order $order_object)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
				'NAME' => $order_object->name,
				'PHONE' => $order_object->phone,
				'EMAIL' => $order_object->email,
				'PROVINCE' => $order_object->province,
				'ADDRESS' => $order_object->address,
				'IS_SHIP' => $order_object->is_ship,
				'SHIP_CODE' => $order_object->ship_code,				
				'STATUS' => $order_object->status,		
				'NOTE'   =>	$order_object->note,
				'UPDATE_DATE' => $order_object->update_date,
			);
			  
			//Check if the product object has an ID
			//if no, it means the product is a new product
			//if yes, then it means you're updating an old product
			try {
				if( is_null($order_object->id) ) {
						//Zend_Debug::dump( $data);		die;	
					$data['STATUS'] = 0;//pending...
					$data['CREATE_DATE'] = $order_object->create_date;
					return $this->_db_table->insert($data);
				} else {
					$this->_db_table->update($data, array('ID = ?' => $order_object->id));
				}
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
		}
		 
		public function getOrderById($id)
		{
			//use the Table Gateway to find the row that
			//the id represents
			try {
				$result = $this->_db_table->find($id);
				 
				//if not found, throw an exception
				if( count($result) == 0 ) {
					throw new Exception('Order is not found');
				}
			
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();
				$order_object = new Application_Model_Order($row);
			 } catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//return the user object
			return $order_object;
		}
		
		public function change(Application_Model_Order $order_object){
			
			$data = array(
						'STATUS' => $order_object->status,
					    'UPDATE_DATE' => $order_object->update_date
			);
			if($order_object->status == 6 && $order_object->is_ship == 1){
				$data['SHIP_CODE'] = $order_object->ship_code;						
			}
			
			try{
				//Zend_Debug::dump( $data);die();
				$this->_db_table->update($data, array('ID = ?' => $order_object->id));
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}						
		}
		
		public function search($status, $name, $sort_update_date){
			try{
				//  die($status . $sort_update_date);
				
				$select = $this->_db_table->select()
									->from('ORDER')
									->order('UPDATE_DATE '.$sort_update_date);
				if($status >= 0){
					$select = $select->where('STATUS = ?', $status);
				}		
				if(strlen($name) > 0){
					$name = strtolower($name);
					$select = $select->where('LOWER(NAME) LIKE ?', "%$name%");				
				}
													
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
								
		}	
		
		public function delete($id){			
			$where = $this->_db_table->getAdapter()->quoteInto("ID = ?", $id);
			$this->_db_table->delete($where);
		}
	}
?>
<?php
	//location: application/models/
	class Application_Model_OrderDetailMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		public function __construct()
		{			
			$this->_db_table = new Application_Model_DbTable_OrderDetail();
		}
		 
		public function save(Application_Model_OrderDetail $order_detail_object)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
				'ORDER_ID' => $order_detail_object->order_id,
				'PRODUCT_ID' => $order_detail_object->product_id,
				'QUANTITY' => $order_detail_object->quantity,
				'PRICE' => $order_detail_object->price,
				'DISCOUNT_PRICE' => $order_detail_object->discount_price,					
			);
			  
			//Check if the product object has an ID
			//if no, it means the product is a new product
			//if yes, then it means you're updating an old product
			try {
					$this->_db_table->insert($data);
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
		}
		
		
		public function get($orderId = null, $productId = null){
			try{
				$select = $this->_db_table->select()
				->from('ORDER_DETAIL');
				if($orderId != null){
					$select = $select->where('ORDER_ID = ?', $orderId);
				}
				if($productId != null){
					$select = $select->where('PRODUCT_ID = ?', $productId);
				}
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
		
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		
		}
		 
	}
?>
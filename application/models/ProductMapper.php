<?php
	//location: application/models/
	class Application_Model_ProductMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the Product table
			$this->_db_table = new Application_Model_DbTable_Product();
		}
		 
		public function save(Application_Model_Product $product_object)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
				'PRODUCT_TYPE_ID' => $product_object->product_type_id,
				'SUB_PRODUCT_TYPE_ID' => $product_object->sub_product_type_id,
				'CODE' => $product_object->code,
				'NAME' => $product_object->name,
				'PRICE' => $product_object->price,
				'DISCOUNT_PRICE' => $product_object->discount_price,
				'PROMOTION' => $product_object->promotion,
				'IMAGE_MAIN' => $product_object->image_main,
				'IMAGE_SECOND' => $product_object->image_second,				
				'IMAGE_THIRD' => $product_object->image_third,
				'PROMOTION' => $product_object->promotion,				
				'SHORT_DESC' => $product_object->short_desc,
				'DETAILS' => $product_object->details,
				'IS_TYPE_PRIORITY' => $product_object->is_type_priority,
				'IS_SUBTYPE_PRIORITY' => $product_object->is_subtype_priority,
				'IS_HOT' => $product_object->is_hot,
				'COLOR' => $product_object->color,
				'MATERIAL' => $product_object->material,
				'ORIGIN' => $product_object->origin,					
			);
			  
			//Check if the product object has an ID
			//if no, it means the product is a new product
			//if yes, then it means you're updating an old product
			try {
				if( is_null($product_object->id) ) {
						//Zend_Debug::dump( $data);		die;		
					$this->_db_table->insert($data);
				} else {
					//Zend_Debug::dump( $data);		die;
					$this->_db_table->update($data, array('ID = ?' => $product_object->id));
				}
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
		}
		 
		public function getProductById($id)
		{
			//use the Table Gateway to find the row that
			//the id represents
			try {
				$result = $this->_db_table->find($id);
				 
				//if not found, throw an exception
				if( count($result) == 0 ) {
					throw new Exception('Product not found');
				}
			
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();
				$product_object = new Application_Model_Product($row);
			 } catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//return the user object
			return $product_object;
		}
		
		public function getAllProductType(){
			
			try{
				$select = $this->_db_table->select()
				->from('PRODUCTS', array('ID','NAME','PARENT_ID'))
				->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
		
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		
		}
		
/*		public function getProductTypesByParentId($product_type_id){
				
			try{
				$select = $this->_db_table->select()
							   ->from('PRODUCT_TYPE', array('ID','NAME','PARENT_ID'));
							   //->where('PARENT_ID = ?', $product_type_id);
				
				$result = $this->_db_table->getAdapter()->fetchAll($select);
		
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		
		}
	*/	
		
		public function getProductsHotAndPriority($product_type_id = null, $numberRecords = null){
			try{
				$select = $this->_db_table->select()
									->from('PRODUCT', array('ID', 'NAME', 'PRODUCT_TYPE_ID', 'SUB_PRODUCT_TYPE_ID', 'IMAGE_MAIN', 'PRICE', 'DISCOUNT_PRICE' , 'IS_TYPE_PRIORITY', 'IS_SUBTYPE_PRIORITY', 'IS_HOT'));
				if($product_type_id != null){
					$select = $select->where('PRODUCT_TYPE_ID = ?', $product_type_id);
				}
				if($numberRecords != null){
					$select = $select->limit($numberRecords, 0);;
				}				
									
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
								
		}
		
		public function getProductsPriority($numberRecords = null){
			// http://framework.zend.com/apidoc/1.9/Zend_Db/Table/Zend_Db_Table_Abstract.html
			// http://zendguru.wordpress.com/2009/04/17/zend-framework-select-statement-and-where-clause-examples/
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
									->from('PRODUCTS', array('ID','TITLE','SMALL_IMAGE'))
									->limit($numberRecords, 0);
									
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
								
		}
		
		
		public function getAllNameAndImageMainProducts($product_type_id = null, $sub_product_type_id = null, $numberRecords = null){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
				->from('PRODUCT', array('ID','NAME','IMAGE_MAIN', 'PRICE', 'DISCOUNT_PRICE'))
				->limit($numberRecords, 0);
				
				if($product_type_id > 0){
					$select = $select->where('PRODUCT_TYPE_ID = ?', $product_type_id);
				}	
				if($sub_product_type_id > 0){
					$select = $select->where('SUB_PRODUCT_TYPE_ID = ?', $sub_product_type_id);
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
		
		public function search($key){
		    $key = strtolower($key);
			$select = $this->_db_table->_db->select()
								->from('PRODUCT', array('TITLE','SMALL_IMAGE'))
								->where('LOWER(TITLE) LIKE ?', $key)
								->limit($_recordPerPage, 0);
								
			$result = $this->_db_table->getAdapter()->fetchAll($select);

			return $result;	
		}
		
		//Lam
		public function getAllProductTypePriorityByType($numberRecords = null, $type_id){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
					->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where('IS_TYPE_PRIORITY = 1 AND PRODUCT_TYPE_ID = ?', $type_id)
					->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				
// 				$allProductPriority = array();
// 				foreach ($result as $row){
// 					$product_obj =  new Application_Model_Product ( $row );
// 					array_push($allProductPriority, $product_obj);
// 				}
			
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		public function getAllHotProduct($numberRecords = null){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
				->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
				->where('IS_HOT = 1')
				->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);				
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		//Lam
		public function getAllProductPriorityBySubType2($numberRecords = null, $subType){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
				->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
				->where('IS_TYPE_PRIORITY = 1 AND SUB_PRODUCT_TYPE_ID = ?', $subType)
				->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
					
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		
		//Lam 10.24 07.01.2015
		public function getAllProductBySubType2($numberRecords = null, $subType){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
				->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
				->where('SUB_PRODUCT_TYPE_ID = ?', $subType)
				->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
					
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		//Lam 14.00 07.01.2015
		public function searchByKey($numberRecords = null, $key){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			$lowerKey = strtolower($key);
			try{
				$select = $this->_db_table->select()
					->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where("LOWER(NAME) LIKE ?", "%{$lowerKey}%")
					->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
					
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		//Lam 9.23 08.01.2015
		public function filterProduct($type, $stype, $min, $max, $numberRecords = null ){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			
			if(!is_null($type)){
				if(is_null($min) && is_null($max)){
					$select = $this->_db_table->select()
					->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where('PRODUCT_TYPE_ID = ?', $type)
					->limit($numberRecords, 0);
				} else {
					if(!is_null($min) && !is_null($max)){
						$select = $this->_db_table->select()
						->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
						->where('PRODUCT_TYPE_ID = ?', $type)
						->where('PRICE >= ?', $min)->where('PRICE <= ?', $max)
						->limit($numberRecords, 0);
					} else {
						if(is_null($max)){
							$select = $this->_db_table->select()
							->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('PRODUCT_TYPE_ID = ?', $type)
							->where('PRICE <= ?', $min)
							->limit($numberRecords, 0);
						} else {
							$select = $this->_db_table->select()
							->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('PRODUCT_TYPE_ID = ?', $type)
							->where('PRICE >= ?', $max)
							->limit($numberRecords, 0);
						}
					}
				}
			}
			
			if(!is_null($stype)){
				if(is_null($min) && is_null($max)){
					$select = $this->_db_table->select()
					->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where('SUB_PRODUCT_TYPE_ID = ?', $stype)
					->limit($numberRecords, 0);
							
				} else {
					if(!is_null($min) && !is_null($max)){
						$select = $this->_db_table->select()
						->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
						->where('SUB_PRODUCT_TYPE_ID = ?', $stype)
						->where('PRICE >= ?', $min)->where('PRICE <= ?', $max)
						->limit($numberRecords, 0);
					} else {
						if(is_null($max)){
							$select = $this->_db_table->select()
							->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('SUB_PRODUCT_TYPE_ID = ?', $stype)
							->where('PRICE <= ?', $min)
							->limit($numberRecords, 0);
						} else {
							$select = $this->_db_table->select()
							->from('PRODUCT', array('ID','PRODUCT_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('SUB_PRODUCT_TYPE_ID = ?', $stype)
							->where('PRICE >= ?', $max)
							->limit($numberRecords, 0);
						}
					}
				}
			}
			try{
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				//Zend_Debug::dump( $result);die();
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//Zend_Debug::dump( $result);die();
			return $result;
		}
	}
?>
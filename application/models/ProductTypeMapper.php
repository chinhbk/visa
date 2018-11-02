<?php
	//location: application/models/
	class Application_Model_ProductTypeMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the Product table
			$this->_db_table = new Application_Model_DbTable_ProductType();
		}
		 
		public function save(Application_Model_News $news_object)
		{
			//Create an associative array
			//of the data you want to update
			$data = array(
				'CATEGORY_ID' => $news_object->category_id,
				'TITLE' => $news_object->title,
				'SUMMARY' => $news_object->summary,
				'SMALL_IMAGE' => $news_object->image,
				'CONTENT' => $news_object->content,
			);
			 
			//Check if the product object has an ID
			//if no, it means the product is a new product
			//if yes, then it means you're updating an old product
			try {
				if( is_null($news_object->id) ) {
					$data['CREATE_DATE'] = date('Y-m-d H:i:s');
					$data['UPDATE_DATE'] = date('Y-m-d H:i:s');
					$this->_db_table->insert($data);
				} else {
					$data['UPDATE_DATE'] = date('Y-m-d H:i:s');
					$this->_db_table->update($data, array('ID = ?' => $news_object->id));
				}
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
		}
		 
		
		public function getAllProductType($product_type_id = null){
			try{
				$select = $this->_db_table->select()
					->from('PRODUCT_TYPE', array('ID', 'NAME', 'PARENT_ID'));
				if(is_null($product_type_id)){
					$select = $select->where('PARENT_ID IS NULL');
				}else{
					$select = $select->where('PARENT_ID = ?', $product_type_id);
				}		
				
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				$product_type_arr = array();
						
				foreach ($result as $row){
					//Zend_Debug::dump( $row['ID']);die();								
					$product_object = new Application_Model_ProductType($row);
					//Zend_Debug::dump( $product_object);die();
					array_push($product_type_arr, $product_object);
				}
				//Zend_Debug::dump( $product_type_arr);die();				
			
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $product_type_arr;							
		}
		
		public function delete($id){
			$where = $this->_db_table->getAdapter()->quoteInto("ID = ?", $id);
			$this->_db_table->delete($where);
		}
		
		//Lam
		public function getTypes(){
		try {
			$select = $this->_db_table->select ()->from ( 'PRODUCT_TYPE', array (
					'ID',
					'NAME',
					'PARENT_ID'
			) )->where('PARENT_ID IS NULL');
			$result = $this->_db_table->getAdapter ()->fetchAll ( $select );

		} catch ( Exception $e ) {
			Zend_Debug::dump ( $e );
			die ();
		}
			return $result;
		}
		
		public function getAllProductType2() {
		try {
			$select = $this->_db_table->select ()->from ( 'PRODUCT_TYPE', array (
					'ID',
					'NAME',
					'PARENT_ID' 
			) );
			$result = $this->_db_table->getAdapter ()->fetchAll ( $select );
			$product_type = array ();
			foreach ( $result as $row ) {
				$product_object = new Application_Model_ProductType ( $row );
				array_push ( $product_type, $product_object );
			}
		} catch ( Exception $e ) {
			Zend_Debug::dump ( $e );
			die ();
		}
		return $product_type;
	}
	
	//Lam
	public function getAllSubTypeByType2($type) {
		try {
			$select = $this->_db_table->select ()->from ( 'PRODUCT_TYPE', array ('ID','NAME','PARENT_ID'))
			->where('PARENT_ID = ?', $type);
	
			$result = $this->_db_table->getAdapter ()->fetchAll ( $select );
			$product_type = array ();
			foreach ( $result as $row ) {
				$product_object = new Application_Model_ProductType ( $row );
				array_push ( $product_type, $product_object );
			}
		} catch ( Exception $e ) {
			Zend_Debug::dump ( $e );
			die ();
		}
		return $product_type;
	}
	
	//Lam 10.32 07.01.2015
	public function getTypeById2($id){
		try {
			$select = $this->_db_table->select ()->from ( 'PRODUCT_TYPE', array ('ID','NAME','PARENT_ID'))
			->where('ID = ?', $id);
		
			$result = $this->_db_table->getAdapter ()->fetchAll ( $select );
			foreach ( $result as $row ) {
				$product_object = new Application_Model_ProductType ( $row );
			}
		} catch ( Exception $e ) {
			Zend_Debug::dump ( $e );
			die ();
		}
		return $product_object;
	}
	
	//Lam 13.45 07.01.2015
	public function getAllTypeOrSubType(){
		
	}
	
	}
	
?>
<?php
	//location: application/models/
	class Application_Model_TourTypeMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'TOUR_TYPE';
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the Product table
			$this->_db_table = new Application_Model_DbTable_TourType();
		}
		 
		public function save(Application_Model_TourType $obj)
		{
		    //Create an associative array
		    //of the data you want to update
		    $data = array(
		        'NAME' => $obj->name,
		        'PARENT_ID' =>	$obj->parent_id,
		    );
		    
		    //Check if the product object has an ID
		    //if no, it means the product is a new product
		    //if yes, then it means you're updating an old product
		    try {
		        if( is_null($obj->id) ) {
		            //Zend_Debug::dump( $data);		die;
		            $obj->id = $this->_db_table->insert($data);
		            return $obj;
		        } else {
		            //Zend_Debug::dump( $data);		die;
		            $this->_db_table->update($data, array('ID = ?' => $obj->id));
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
		            throw new Exception('tour type not found');
		        }
		        
		        //if found, get the result, and map it to the
		        //corresponding Data Object
		        $row = $result->current();
		        $obj = new Application_Model_TourType($row);
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    //return the user object
		    return $obj;
		}
		 
		
		public function getAllTourType($tour_type_id = null){
			try{
				$select = $this->_db_table->select()
				->from(self::TABLE, array('ID', 'NAME', 'PARENT_ID'));
				if(is_null($tour_type_id)){
					$select = $select->where('PARENT_ID IS NULL');
				}else{
					$select = $select->where('PARENT_ID = ?', $tour_type_id);
				}		
				
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				$tour_type_arr = array();
						
				foreach ($result as $row){
					//Zend_Debug::dump( $row['ID']);die();								
					$tour_object = new Application_Model_TourType($row);
					//Zend_Debug::dump( $tour_object);die();
					array_push($tour_type_arr, $tour_object);
				}
				//Zend_Debug::dump( $tour_type_arr);die();				
			
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $tour_type_arr;							
		}
		
		public function searchByName($keyword = null){
		    try{
		        $select = $this->_db_table->select()
		        ->from(self::TABLE, array('ID', 'NAME', 'PARENT_ID'));
		        
		        if(!is_null($keyword) && strlen($keyword) > 0){
		            $keyword = strtolower($keyword);
		            $select = $select->where('LOWER(NAME) LIKE ?', "%{$keyword}%");
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $tour_type_arr = array();
		        
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row['ID']);die();
		            $tour_object = new Application_Model_TourType($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($tour_type_arr, $tour_object);
		        }
		        //Zend_Debug::dump( $tour_type_arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $tour_type_arr;
		}
		
		public function delete($id){
			$where = $this->_db_table->getAdapter()->quoteInto("ID = ?", $id);
			$this->_db_table->delete($where);
		}
		
		//Lam
		public function getTypes(){
		try {
			$select = $this->_db_table->select ()->from (self::TABLE, array (
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
			$select = $this->_db_table->select ()->from (self::TABLE, array (
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
			$select = $this->_db_table->select ()->from (self::TABLE, array ('ID','NAME','PARENT_ID'))
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
			$select = $this->_db_table->select ()->from (self::TABLE, array ('ID','NAME','PARENT_ID'))
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
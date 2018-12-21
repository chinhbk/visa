<?php
	//location: application/models/
	class Application_Model_TourPriceGroupMapper{
		protected $_db_table;
		protected $_recordPerPage = 20;
		const TABLE = 'TOUR_PRICE_GROUP';
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the tour table
		    $this->_db_table = new Application_Model_DbTable_TourPriceGroup();
		}
		 
		public function save(Application_Model_TourPriceGroup $obj)
		{  
		    ///Create an associative array
		    //of the data you want to update
		    $data = array(
		        'NAME' => $obj->name
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
		
		public function getIdByName($keyword = null){
		    try{
		        $select = $this->_db_table->select()
		        ->from(self::TABLE, array('ID', 'NAME'));
		        
		        if(!is_null($keyword) && strlen($keyword) > 0){
		            $keyword = strtolower($keyword);
		            $select = $select->where('LOWER(NAME) = ?', strtolower($keyword));
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row['ID']);die();
		            $object = new Application_Model_TourPriceGroup($row);
		            return $object->id;
		        }
		        //Zend_Debug::dump( $tour_type_arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return null;
		}
		 
		public function getAll($numberRecords = null)
		{
		    try{
		        if($numberRecords == null) $numberRecords = $this->_recordPerPage;
		        
		        $select = $this->_db_table->select()
		        ->from(self::TABLE, array('ID', 'NAME'))
		        ->limit($numberRecords, 0);
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $arr = array();
		        
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row['ID']);die();
		            $object = new Application_Model_TourPriceGroup($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($arr, $object);
		        }
		        //Zend_Debug::dump( $tour_type_arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $arr;
		}
		
	}
?>
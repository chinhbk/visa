<?php
	//location: application/models/
	class Application_Model_NationalityVisaTypeMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'NATIONALITY_VISA_TYPE';
		public function __construct()
		{			
			$this->_db_table = new Application_Model_DbTable_NationalityVisaType();
		}
		 
		public function save(Application_Model_NationalityVisaType $obj)
		{
		    //Create an associative array
		    //of the data you want to update
		    $data = array(
		        'NATIONALITY_ID' => $obj->nationality_id,
		        'VISA_TYPE_ID' => $obj->visa_type_id,
		        'PRICE' => $obj->price,
		        'PURPOSE_OF_VISIT' => $obj->purpose_of_visit,
		        'UPDATE_DATE' => $obj->update_date,
		    );
		    //Zend_Debug::dump( $data);die();
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
		            throw new Exception('visa type not found');
		        }
		        
		        //if found, get the result, and map it to the
		        //corresponding Data Object
		        $row = $result->current();
		        $obj = new Application_Model_NationalityVisaType($row);
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    //return the user object
		    return $obj;
		}		
		
		public function getPrices($purpose_of_visit, $visa_type_ids, $nationality_id)
		{
		    $select = $this->_db_table->select()
		    ->from(array('t' => self::TABLE));
		    
		    
		    //default values
		    if($purpose_of_visit == null){
		        $purpose_of_visit = 'TOURIST VISA';
		    }
		    if($visa_type_ids == null){
		        $visa_type_ids =  array(1);
		    }
		    if($nationality_id == null){
		        $nationality_id = 1;
		    }
		    
		    $select = $select->where('PURPOSE_OF_VISIT = ?', $purpose_of_visit);
		    $select = $select->where('VISA_TYPE_ID IN (?)', $visa_type_ids);
		    $select = $select->where('NATIONALITY_ID = ?', $nationality_id);
		    
		    $result = $this->_db_table->getAdapter()->fetchAll($select);
		    $arr = array();
		    //Zend_Debug::dump( $result);die();
		    foreach ($result as $row){
		        //Zend_Debug::dump( $row);die();
		        $obj = new Application_Model_NationalityVisaType($row);
		        //Zend_Debug::dump( $tour_object);die();
		        array_push($arr, $obj);
		    }
		    //Zend_Debug::dump( $result);die();
		    //if not found, throw an exception
		    return $arr;
		}
		
		public function getId($purpose_of_visit, $visa_type_id, $nationality_id)
		{
		    $select = $this->_db_table->select()
		    ->from(array('t' => self::TABLE), array('ID'))
		    ->order('ID DESC')
		    ->limit(1, 0);		    
		    
		    //default values
		    if($purpose_of_visit == null){
		        $purpose_of_visit = 'TOURIST VISA';		        
		    }
		    if($visa_type_id == null){
		        $visa_type_id =  1;
		    }
		    if($nationality_id == null){
		        $nationality_id = 1;
		    }		    
		    
		    $select = $select->where('PURPOSE_OF_VISIT = ?', $purpose_of_visit);		    
		    $select = $select->where('VISA_TYPE_ID = ?', $visa_type_id);		    		   
		    $select = $select->where('NATIONALITY_ID = ?', $nationality_id);	    
		    
		    $result = $this->_db_table->getAdapter()->fetchRow($select);
		    //Zend_Debug::dump( $result);die();
		    //if not found, throw an exception
		    if( count($result) == 0 ) {
		        return null;
		    }
		    return $result['ID'];
		}
		
		public function delete($id){
			$where = $this->_db_table->getAdapter()->quoteInto("ID = ?", $id);
			$this->_db_table->delete($where);
		}
	}
	
?>
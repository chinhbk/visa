<?php
	//location: application/models/
	class Application_Model_NationalityMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'NATIONALITY';
		public function __construct()
		{			
			$this->_db_table = new Application_Model_DbTable_Nationality();
		}
		 
		public function save(Application_Model_Nationality $obj)
		{
		    //Create an associative array
		    //of the data you want to update
		    $data = array(
		        'NAME' => $obj->name
		    );
		    if(isset($obj->is_show) && !empty($obj->is_show)){
		        $data['IS_SHOW'] = $obj->is_show;
		    }
		    
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
		            throw new Exception('nationality not found');
		        }
		        
		        //if found, get the result, and map it to the
		        //corresponding Data Object
		        $row = $result->current();
		        $obj = new Application_Model_Nationality($row);
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    //return the user object
		    return $obj;
		}
		 
		public function getAll($is_show = null, $is_difficult = null, $keyword=null){
			try{
				$select = $this->_db_table->select()
				->from(self::TABLE, array('ID', 'NAME', 'IS_SHOW', 'IS_DIFFICULT'));
				if($is_show == 1){
				    $select = $select->where('IS_SHOW = ?', $is_show);
				}
				if(isset($is_difficult)){
				    $select = $select->where('IS_DIFFICULT = ?', $is_difficult);
				}
				if(!is_null($keyword) && strlen($keyword) > 0){
				    $keyword = strtolower($keyword);
				    $select = $select->where('LOWER(NAME) LIKE ?', "%{$keyword}%");
				    //$select = $select->where('LOWER(EMAIL) LIKE ?', "%{$keyword}%");
				}
				
				$select = $select->order('NAME ASC');
				
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				$arr = array();
				//Zend_Debug::dump($result);die();		
				foreach ($result as $row){
					//Zend_Debug::dump( $row['ID']);die();								
				    $obj = new Application_Model_Nationality($row);
					//Zend_Debug::dump( $tour_object);die();
					array_push($arr, $obj);
				}
				//Zend_Debug::dump( $tour_type_arr);die();				
			
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $arr;							
		}
		
		public function search($keyword=null, $purpose_of_visit=null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('n' => self::TABLE), array('NAME'))
		        ->joinLeft(array('nv' => 'NATIONALITY_VISA_TYPE'),'n.ID = nv.NATIONALITY_ID', array('NATIONALITY_ID', 'VISA_TYPE_ID', 'PRICE'))
		        ->joinLeft(array('v' => 'VISA_TYPE'),'v.ID = nv.VISA_TYPE_ID', array('VISA_TYPE' => 'NAME'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('n.NAME ASC');
		        
		        if(!is_null($keyword) && strlen($keyword) > 0){
		            $keyword = strtolower($keyword);
		            $select = $select->where('LOWER(n.NAME) LIKE ?', "%{$keyword}%");
		            //$select = $select->where('LOWER(EMAIL) LIKE ?', "%{$keyword}%");
		        }
		        
		        if($purpose_of_visit) {
		            $select = $select->where('LOWER(nv.PURPOSE_OF_VISIT) = ?', strtolower($purpose_of_visit));
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $arr = array();
		        //Zend_Debug::dump($result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $obj = new Application_Model_NationalityVisaType($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($arr, $obj);
		        }
		        //Zend_Debug::dump( $arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $arr;
		}
		
		public function searchProcessingTime($keyword=null, $purpose_of_visit=null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('n' => self::TABLE), array('NAME'))
		        ->joinLeft(array('np' => 'NATIONALITY_PROCESSING_TIME_TYPE'),'n.ID = np.NATIONALITY_ID', array('NATIONALITY_ID', 'PROCESSING_TIME_TYPE_ID', 'PRICE'))
		        ->joinLeft(array('p' => 'PROCESSING_TIME_TYPE'),'p.ID = np.PROCESSING_TIME_TYPE_ID', array('PROCESSING_TIME_TYPE' => 'NAME'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('n.NAME ASC');
		        
		        if(!is_null($keyword) && strlen($keyword) > 0){
		            $keyword = strtolower($keyword);
		            $select = $select->where('LOWER(n.NAME) LIKE ?', "%{$keyword}%");
		            //$select = $select->where('LOWER(EMAIL) LIKE ?', "%{$keyword}%");
		        }
		        
		        if($purpose_of_visit) {
		            $select = $select->where('LOWER(np.PURPOSE_OF_VISIT) = ?', strtolower($purpose_of_visit));
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $arr = array();
		        //Zend_Debug::dump($result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $obj = new Application_Model_NationalityProcessingTimeType($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($arr, $obj);
		        }
		        //Zend_Debug::dump( $arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $arr;
		}
		
		
		public function getNationalitiesApplyForVisaType($purpose_of_visit, $visa_type_id = null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('n' => self::TABLE), array('NAME', 'IS_DIFFICULT'))		        
		        ->joinLeft(array('nv' => 'NATIONALITY_VISA_TYPE'),'n.ID = nv.NATIONALITY_ID', array('VISA_TYPE_ID', 'NATIONALITY_ID'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('n.NAME ASC');		       
		        
		        if($purpose_of_visit) {
		            $select = $select->where('LOWER(nv.PURPOSE_OF_VISIT) = ?', strtolower($purpose_of_visit));
		            $select = $select->where('nv.PRICE IS NOT NULL ');
		        }
		        
		        if($visa_type_id) {
		            $select = $select->where('nv.VISA_TYPE_ID = ?', $visa_type_id);		           
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $arr = array();
		        //Zend_Debug::dump($result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $obj = new Application_Model_NationalityVisaType($row);
		           // Zend_Debug::dump( $obj);die();
		            array_push($arr, $obj);
		        }
		        //Zend_Debug::dump( $arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $arr;
		}
		
		public function delete($id){
			$where = $this->_db_table->getAdapter()->quoteInto("ID = ?", $id);
			$this->_db_table->delete($where);
		}
	}
	
?>
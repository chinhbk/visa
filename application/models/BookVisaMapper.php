<?php
	//location: application/models/
	class Application_Model_BookVisaMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'BOOK_VISA';
		public function __construct()
		{
		    $this->_db_table = new Application_Model_DbTable_BookVisa();
		}
		 
		public function save(Application_Model_BookVisa $obj)
		{
		    //Create an associative array
		    //of the data you want to update
		    $data = array(
		        'CODE' => $obj->code,
		        'PURPOSE_OF_VISIT' => $obj->purpose_of_visit,
		        'VISA_TYPE_ID' => $obj->visa_type_id,
		        'PROCESSING_TIME_TYPE_ID' => $obj->processing_time_type_id,
		        'VISA_LETTER' => $obj->visa_letter,
		        'NUMBER_OF_VISA' => $obj->number_of_visa,
		        'PRICE_DETAIL' => $obj->price_detail,
		        'TOTAL_PRICE' => $obj->total_price,
		        'ARRIVAL_DATE' => $obj->arrival_date,
		        'PAYMENT' => $obj->payment,
		        'ARRIVAL_AIRPORT' => $obj->arrival_airport,
		        'CONTACT_NAME' => $obj->contact_name,
		        'CONTACT_EMAIL' => $obj->contact_email,
		        'CONTACT_PHONE' => $obj->contact_phone,
		        'STATUS' => $obj->status,
		        'UPDATE_DATE' => $obj->update_date,
		    );

		    
		    try {
		        if($is_update == false) {
		            //Zend_Debug::dump( $data);		die;
		            $data['CREATE_DATE'] = $obj->create_date;
		            return $this->_db_table->insert($data);
		        } else {
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
		            throw new Exception('book visa not found');
		        }
		        
		        //if found, get the result, and map it to the
		        //corresponding Data Object
		        $row = $result->current();
		        $obj = new Application_Model_BookVisa($row);
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    //return the user object
		    return $obj;
		}
		
		public function getByCode($code)
		{
		    $select = $this->_db_table->select()
		    ->from(array('t' => self::TABLE))
		    ->order('ID DESC')
		    ->limit(1, 0);
		    
		    if(!is_null($code) && strlen($code) > 0){
		        $select = $select->where('LOWER(CODE) = ?', strtolower($code));		        
		    }
		    
		    
		    $row = $this->_db_table->getAdapter()->fetchRow($select);
		    $obj = new Application_Model_BookVisa($row);
		    return $obj;
		}
		
		public function getLatestId()
		{
		    $select = $this->_db_table->select()
		    ->from(array('t' => self::TABLE), array('ID'))
		    ->order('ID DESC')
		    ->limit(1, 0);
		    
		    $result = $this->_db_table->getAdapter()->fetchRow($select);
		    //Zend_Debug::dump( $result);die();
		    //if not found, throw an exception
		    if( count($result) == 0 ) {
		        return 0;
		    }
		    return $result['ID'];
		}
		
		public function search($keyword=null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('b' => self::TABLE), array('ID', 'CODE', 'PURPOSE_OF_VISIT', 'VISA_TYPE_ID', 'PROCESSING_TIME_TYPE_ID', 'VISA_LETTER', 'NUMBER_OF_VISA', 'TOTAL_PRICE', 'ARRIVAL_DATE', 'ARRIVAL_AIRPORT', 'CONTACT_NAME', 'CONTACT_EMAIL', 'CONTACT_PHONE', 'STATUS', 'UPDATE_DATE'))
		        ->join(array('v' => 'VISA_TYPE'),'v.ID = b.VISA_TYPE_ID', array('VISA_TYPE' => 'NAME'))		        
		        ->join(array('p' => 'PROCESSING_TIME_TYPE'),'p.ID = b.PROCESSING_TIME_TYPE_ID', array('PROCESSING_TIME_TYPE' => 'NAME'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('UPDATE_DATE DESC');
		        
		        if(!is_null($keyword) && strlen($keyword) > 0){
		            $keyword = strtolower($keyword);
		            $select = $select->where('LOWER(CODE) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(CONTACT_NAME) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(CONTACT_EMAIL) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(CONTACT_PHONE) LIKE ?', "%{$keyword}%");
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $arr = array();
		        //Zend_Debug::dump( $result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $obj = new Application_Model_BookVisa($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($arr, $obj);
		        }
		        //Zend_Debug::dump( $tour_arr);die();
		        
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
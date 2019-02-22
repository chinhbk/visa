<?php
	//location: application/models/
class Application_Model_ApplicantVisaMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'APPLICANT_VISA';
		public function __construct()
		{
		    $this->_db_table = new Application_Model_DbTable_ApplicantVisa();
		}
		 
		public function save(Application_Model_ApplicantVisa $obj)
		{
		    //Create an associative array
		    //of the data you want to update
		    $data = array(
		        'BOOK_VISA_ID' => $obj->book_visa_id,
		        'NATIONALITY_ID' => $obj->nationality_id,		      
		        'NAME' => $obj->name,
		        'GENDER' => $obj->gender,
		        'DATE_OF_BIRTH' => $obj->date_of_birth,
		        'PASSPORT_NUMBER' => $obj->passport_number,
		        'PASSPORT_EXPIRY_DATE' => $obj->passport_expiry_date,
		    );

		    
		    try {
		        if($is_update == false) {
		            //Zend_Debug::dump( $data);		die;
		            //$data['CREATE_DATE'] = $obj->create_date;
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
		        $obj = new Application_Model_ApplicantVisa($row);
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    //return the user object
		    return $obj;
		}
		
		public function getApplicants($bookVisaId = null, $keyword = null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('a' => self::TABLE), array('ID', 'NATIONALITY_ID', 'NAME', 'GENDER', 'DATE_OF_BIRTH', 'PASSPORT_NUMBER', 'PASSPORT_EXPIRY_DATE'))
		        ->join(array('tt' => 'NATIONALITY'),'tt.ID = a.NATIONALITY_ID', array('NATIONALITY' => 'NAME'))	
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('ID ASC');
		        
		        if(!is_null($bookVisaId) && strlen($bookVisaId) > 0){
		            $select = $select->where('BOOK_VISA_ID = ?', $bookVisaId);
		        }
		        if(!is_null($keyword) && strlen($keyword) > 0){
		            $keyword = strtolower($keyword);
		            $select = $select->where('LOWER(NAME) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(PASSPORT_NUMBER) LIKE ?', "%{$keyword}%");
		        }		        
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $arr = array();
		        //Zend_Debug::dump( $result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $obj = new Application_Model_ApplicantVisa($row);
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
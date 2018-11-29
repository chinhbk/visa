<?php
	//location: application/models/
	class Application_Model_BookTourMapper {
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'BOOK_TOUR';
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the tour table
			$this->_db_table = new Application_Model_DbTable_BookTour();
		}
		 
		public function save(Application_Model_BookTour $obj, $is_update = false)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
			    'ID' => $obj->id,
			    'TOUR_ID' => $obj->tour_id,
			    'CODE' => $obj->code,
			    'NAME' => $obj->name,
			    'EMAIL' => $obj->email,
			    'PHONE' => $obj->phone,				
			    'COUNTRY' => $obj->country,
			    'STATUS' => $obj->status,
			    'NO' => $obj->no,
			    'COMMENT' => $obj->comment,
			    'ARRIVAL_DATE' => $obj->arrival_date,
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
			//echo $id; die;
			try {
				$result = $this->_db_table->find($id);
				 
				//if not found, throw an exception
				if( count($result) == 0 ) {
					throw new Exception('book tour not found');
				}
			
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();
				$obj = new Application_Model_Tour($row);
			 } catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//return the user object
			return $obj;
		}
		
		public function getByIds($ids=null, $is_hot = null, $numberRecords = null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('t' => self::TABLE), array('TOUR_TYPE_ID','SHORT_DESC', 'CODE','IMAGE_SMALL', 'IS_HOT'))
		        ->join(array('tt' => 'TOUR_TYPE'),'tt.ID = t.TOUR_TYPE_ID', array('NAME', 'PARENT_ID'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('PARENT_ID ASC');
		        
		        if(!empty($ids) && sizeof($ids) > 0){
		            $select = $select->where('TOUR_TYPE_ID IN (?)', $ids);
		        }
		        
		        if($is_hot){
		            $select = $select->where('IS_HOT = 1');
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $tour_arr = array();
		        //Zend_Debug::dump( $result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $tour_object = new Application_Model_Tour($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($tour_arr, $tour_object);
		        }
		        //Zend_Debug::dump( $tour_arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $tour_arr;
		}
	}
?>
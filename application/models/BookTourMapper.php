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
			    'TOUR_PRICE_GROUP_ID' => $obj->tour_price_group_id,
			    'CODE' => $obj->code,
			    'NAME' => $obj->name,
			    'EMAIL' => $obj->email,
			    'PHONE' => $obj->phone,				
			    'COUNTRY' => $obj->country,
			    'STATUS' => $obj->status,
			    'NO' => $obj->no,
			    'TOTAL_PRICE' => $obj->total_price,
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
		
		public function search($keyword=null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('t' => self::TABLE), array('ID', 'TOUR_ID', 'TOUR_PRICE_GROUP_ID', 'NO', 'TOTAL_PRICE', 'ARRIVAL_DATE', 'CODE','NAME', 'EMAIL', 'PHONE', 'COUNTRY', 'STATUS', 'UPDATE_DATE'))
		        ->join(array('tt' => 'TOUR_TYPE'),'tt.ID = t.TOUR_ID', array('TOUR_NAME' => 'NAME'))
		        ->joinLeft(array('tp' => 'TOUR_PRICE_GROUP'),'tp.ID = t.TOUR_PRICE_GROUP_ID', array('PRICE_GROUP_NAME' => 'NAME'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('UPDATE_DATE DESC');	     
		        
		        if(!is_null($keyword) && strlen($keyword) > 0){
		            $keyword = strtolower($keyword);
		            $select = $select->where('LOWER(t.NAME) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(EMAIL) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(PHONE) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(tt.NAME) LIKE ?', "%{$keyword}%");
		            $select = $select->orWhere('LOWER(tp.NAME) LIKE ?', "%{$keyword}%");
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $tour_arr = array();
		        //Zend_Debug::dump( $result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $tour_object = new Application_Model_BookTour($row);
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
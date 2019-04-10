<?php
	//location: application/models/
	class Application_Model_TravelGuideMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'TRAVEL_GUIDE';
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the tour table
			$this->_db_table = new Application_Model_DbTable_TravelGuide();
		}
		 
		public function save(Application_Model_TravelGuide $obj)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
			    'NAME' => $obj->name,
			    'SHORT_DESC' => $obj->short_desc,
			    'IMAGE_SMALL' => $obj->image_small,
			    'IMAGE' => $obj->image,
			    'DETAILS' => $obj->details,				
			    'IS_SHOW' => $obj->is_show,
			    'UPDATE_DATE' => $obj->update_date,
			);
			//echo $is_update;
			//Zend_Debug::dump( $data);die();
			try {
			    if( is_null($obj->id) ) {
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
					throw new Exception('tour not found');
				}
			
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();
				$obj = new Application_Model_TravelGuide($row);
			 } catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//return the user object
			return $obj;
		}
		
		public function getAll(){
		    try{
		        $select = $this->_db_table->select()
		        ->from(self::TABLE, array('ID', 'NAME', 'SHORT_DESC', 'IMAGE_SMALL', 'IS_SHOW'));
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $arr = array();
		        //Zend_Debug::dump($result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row['ID']);die();
		            $object = new Application_Model_TravelGuide($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($arr, $object);
		        }
		        //Zend_Debug::dump( $tour_type_arr);die();
		        
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
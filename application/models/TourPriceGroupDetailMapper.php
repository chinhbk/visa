<?php
	//location: application/models/
	class Application_Model_TourPriceGroupDetailMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'TOUR_PRICE_GROUP_DETAIL';
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the tour table
		    $this->_db_table = new Application_Model_DbTable_TourPriceGroupDetail();
		}
		 
		public function save(Application_Model_TourPriceGroupDetail $obj)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
			    'TOUR_TYPE_ID' => $obj->tour_type_id,
			    'TOUR_PRICE_GROUP_ID' => $obj->tour_price_group_id,
			    'FROM_PAX' => $obj->from_pax,
			    'TO_PAX' => $obj->to_pax,
			    'PRICE' => $obj->price,
			    'IS_ADD_PRICE' => $obj->is_add_price,				
			    'ORDER' => $obj->order,
			    //'UPDATE_DATE' => $obj->update_date,
			);

			try {
			    if( is_null($obj->id) ) {
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
			//echo $id; die;
			try {
				$result = $this->_db_table->find($id);
				 
				//if not found, throw an exception
				if( count($result) == 0 ) {
					throw new Exception('tour price group detail not found');
				}
			
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();
				$obj = new Application_Model_TourPriceGroupDetail($row);
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
		
		//get by tour_price_group_id
		public function getByTourIdAndOrGroupIds( $tour_type_id = null, $parent_ids = null, $order = null)
		{
		    try{
		        if($order == null) $order = 'ASC';
		        $select = $this->_db_table->select()
		        ->from(array('t' => self::TABLE), array('ID', 'TOUR_TYPE_ID', 'TOUR_PRICE_GROUP_ID', 'FROM_PAX', 'TO_PAX', 'PRICE', 'ORDER', 'IS_ADD_PRICE'))
		        ->join(array('tt' => 'TOUR_PRICE_GROUP'),'tt.ID = t.TOUR_PRICE_GROUP_ID', array('NAME'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('TOUR_PRICE_GROUP_ID '.$order)
		        ->order('ORDER '.$order);
		        
		        if($parent_ids){
		            $select = $select->where('TOUR_PRICE_GROUP_ID IN (?)', $parent_ids);
		        }
		        
		        if($tour_type_id){
		            $select = $select->where('TOUR_TYPE_ID = ?', $tour_type_id);
		        }
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        $tour_arr = array();
		        //Zend_Debug::dump( $select);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $tour_object = new Application_Model_TourPriceGroupDetail($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($tour_arr, $tour_object);
		        }
		        //Zend_Debug::dump( $tour_arr);die();
		        
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $tour_arr;
		}		
				
		public function deleteByTourTypeId($tour_type_id){
		    $where = $this->_db_table->getAdapter()->quoteInto("TOUR_TYPE_ID = ?", $tour_type_id);
		    $this->_db_table->delete($where);
		}
		
		public function delete($id){			
			$where = $this->_db_table->getAdapter()->quoteInto("ID = ?", $id);
			$this->_db_table->delete($where);
		}		
		
	}
?>
<?php
	//location: application/models/
	class Application_Model_TourMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		const TABLE = 'TOUR';
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the tour table
			$this->_db_table = new Application_Model_DbTable_Tour();
		}
		 
		public function save(Application_Model_tour $obj, $is_update = false)
		{  
			//Create an associative array
			//of the data you want to update
			$data = array(
			    'TOUR_TYPE_ID' => $obj->tour_type_id,
			    'SHORT_DESC' => $obj->short_desc,
			    'IMAGE_SMALL' => $obj->image_small,
			    'IMAGE' => $obj->image,
			    'CODE' => $obj->code,
			    'DURATION' => $obj->duration,
			    'PRICE' => $obj->price,
			    'DETAILS' => $obj->details,				
			    'IS_HOT' => $obj->is_hot,
			    'UPDATE_DATE' => $obj->update_date,
			);

			try {
			    if($is_update == false) {
			        //Zend_Debug::dump( $data);		die;
			        $data['CREATE_DATE'] = $obj->create_date;
			        return $this->_db_table->insert($data);
			    } else {
			        $this->_db_table->update($data, array('TOUR_TYPE_ID = ?' => $obj->tour_type_id));
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
		
		public function getByParentId($parent_id = null)
		{
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('t' => self::TABLE), array('TOUR_TYPE_ID','SHORT_DESC', 'CODE','IMAGE_SMALL', 'IS_HOT', 'PRICE', 'DURATION'))
		        ->join(array('tt' => 'TOUR_TYPE'),'tt.ID = t.TOUR_TYPE_ID', array('NAME', 'PARENT_ID'))
		        ->setIntegrityCheck(false) // ADD This Line
		        ->order('PARENT_ID ASC');		      
		        
		        if($parent_id){
		            $select = $select->where('PARENT_ID = ?', $parent_id);
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
		
		public function getAllHotTour($numberRecords = null){
		   // echo getcwd().'\library'; die;
		    //$select11 = new Select;
		    //$select11->from(self::TABLE)->join('TOUR_TYPE', 'TOUR_TYPE.ID = TOUR.TOUR_TYPE_ID', array('TOUR_TYPE_ID', 'NAME', 'SHORT_DESC', 'CODE','IMAGE_SMALL', 'IS_HOT'));
		   // $a = $this->_db_table->getAdapter()->fetchAll($select11);
		//    Zend_Debug::dump( $a);die();
		    if($numberRecords == null){
		        $numberRecords = $this->_recordPerPage;
		    }
		    try{
		        $select = $this->_db_table->select()
		        ->from(array('t' => self::TABLE), array('TOUR_TYPE_ID','SHORT_DESC', 'CODE','IMAGE_SMALL', 'IS_HOT'))
		        ->join(array('tt' => 'TOUR_TYPE'),'tt.ID = t.TOUR_TYPE_ID', array('NAME', 'PARENT_ID'))
		        ->where('IS_HOT = 1')
		        ->setIntegrityCheck(false) // ADD This Line
		        ->limit($numberRecords, 0);
		        
		        $result = $this->_db_table->getAdapter()->fetchAll($select);
		        
		        $tour_arr = array();
		        //Zend_Debug::dump( $result);die();
		        foreach ($result as $row){
		            //Zend_Debug::dump( $row);die();
		            $tour_object = new Application_Model_Tour($row);
		            //Zend_Debug::dump( $tour_object);die();
		            array_push($tour_arr, $tour_object);
		        }
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		    return $tour_arr;
		}
		
		public function changeHot($id, $is_hot=null){
		    
		    $data = array(
		        'IS_HOT' => $is_hot
		    );
		    
		    try{
		        //Zend_Debug::dump( $data);die();
		        $this->_db_table->update($data, array('TOUR_TYPE_ID = ?' => $id));
		    } catch (Exception $e) {
		        Zend_Debug::dump( $e);die();
		    }
		}
		
		public function getAlltourType(){
			
			try{
				$select = $this->_db_table->select()
				->from('tourS', array('ID','NAME','PARENT_ID'))
				->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
		
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		
		}
		
/*		public function gettourTypesByParentId($tour_type_id){
				
			try{
				$select = $this->_db_table->select()
							   ->from('tour_TYPE', array('ID','NAME','PARENT_ID'));
							   //->where('PARENT_ID = ?', $tour_type_id);
				
				$result = $this->_db_table->getAdapter()->fetchAll($select);
		
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		
		}
	*/	
		
		public function delete($id){			
			$where = $this->_db_table->getAdapter()->quoteInto("TOUR_TYPE_ID = ?", $id);
			$this->_db_table->delete($where);
		}
		
		public function search($key){
		    $key = strtolower($key);
			$select = $this->_db_table->_db->select()
								->from('TOUR', array('TITLE','SMALL_IMAGE'))
								->where('LOWER(TITLE) LIKE ?', $key)
								->limit($_recordPerPage, 0);
								
			$result = $this->_db_table->getAdapter()->fetchAll($select);

			return $result;	
		}
		
		//Lam
		public function getAlltourTypePriorityByType($numberRecords = null, $type_id){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
					->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where('IS_TYPE_PRIORITY = 1 AND tour_TYPE_ID = ?', $type_id)
					->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				
// 				$alltourPriority = array();
// 				foreach ($result as $row){
// 					$tour_obj =  new Application_Model_tour ( $row );
// 					array_push($alltourPriority, $tour_obj);
// 				}
			
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		//Lam
		public function getAlltourPriorityBySubType2($numberRecords = null, $subType){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
				->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
				->where('IS_TYPE_PRIORITY = 1 AND SUB_tour_TYPE_ID = ?', $subType)
				->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
					
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		
		//Lam 10.24 07.01.2015
		public function getAlltourBySubType2($numberRecords = null, $subType){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
				->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
				->where('SUB_tour_TYPE_ID = ?', $subType)
				->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
					
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		//Lam 14.00 07.01.2015
		public function searchByKey($numberRecords = null, $key){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			$lowerKey = strtolower($key);
			try{
				$select = $this->_db_table->select()
					->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where("LOWER(NAME) LIKE ?", "%{$lowerKey}%")
					->limit($numberRecords, 0);
					
				$result = $this->_db_table->getAdapter()->fetchAll($select);
					
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;
		}
		
		//Lam 9.23 08.01.2015
		public function filtertour($type, $stype, $min, $max, $numberRecords = null ){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			
			if(!is_null($type)){
				if(is_null($min) && is_null($max)){
					$select = $this->_db_table->select()
					->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where('tour_TYPE_ID = ?', $type)
					->limit($numberRecords, 0);
				} else {
					if(!is_null($min) && !is_null($max)){
						$select = $this->_db_table->select()
						->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
						->where('tour_TYPE_ID = ?', $type)
						->where('PRICE >= ?', $min)->where('PRICE <= ?', $max)
						->limit($numberRecords, 0);
					} else {
						if(is_null($max)){
							$select = $this->_db_table->select()
							->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('tour_TYPE_ID = ?', $type)
							->where('PRICE <= ?', $min)
							->limit($numberRecords, 0);
						} else {
							$select = $this->_db_table->select()
							->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('tour_TYPE_ID = ?', $type)
							->where('PRICE >= ?', $max)
							->limit($numberRecords, 0);
						}
					}
				}
			}
			
			if(!is_null($stype)){
				if(is_null($min) && is_null($max)){
					$select = $this->_db_table->select()
					->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
					->where('SUB_tour_TYPE_ID = ?', $stype)
					->limit($numberRecords, 0);
							
				} else {
					if(!is_null($min) && !is_null($max)){
						$select = $this->_db_table->select()
						->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
						->where('SUB_tour_TYPE_ID = ?', $stype)
						->where('PRICE >= ?', $min)->where('PRICE <= ?', $max)
						->limit($numberRecords, 0);
					} else {
						if(is_null($max)){
							$select = $this->_db_table->select()
							->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('SUB_tour_TYPE_ID = ?', $stype)
							->where('PRICE <= ?', $min)
							->limit($numberRecords, 0);
						} else {
							$select = $this->_db_table->select()
							->from('tour', array('ID','tour_TYPE_ID','CODE','NAME','PRICE','DISCOUNT_PRICE','IMAGE_MAIN','PROMOTION'))
							->where('SUB_tour_TYPE_ID = ?', $stype)
							->where('PRICE >= ?', $max)
							->limit($numberRecords, 0);
						}
					}
				}
			}
			try{
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				//Zend_Debug::dump( $result);die();
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//Zend_Debug::dump( $result);die();
			return $result;
		}
	}
?>
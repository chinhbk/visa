<?php
	//location: application/models/
	class Application_Model_NewsMapper{
		protected $_db_table;
		protected $_recordPerPage = 10;
		public function __construct()
		{
			//Instantiate the Table Data Gateway for the Product table
			$this->_db_table = new Application_Model_DbTable_News();
		}
		 
		public function save(Application_Model_News $news_object)
		{
			//Create an associative array
			//of the data you want to update
			$data = array(
				'NEWS_TYPE_ID' => $news_object->news_type_id,
				'TITLE' => $news_object->title,
				'SUMMARY' => $news_object->summary,
				'SMALL_IMAGE' => $news_object->small_image,
				'CONTENT' => $news_object->content,
			);
			 
			//Check if the product object has an ID
			//if no, it means the product is a new product
			//if yes, then it means you're updating an old product
			try {
				if( is_null($news_object->id) ) {
					$this->_db_table->insert($data);
				} else {
					//Zend_Debug::dump( $news_object); echo '----';die();
					$this->_db_table->update($data, array('ID = ?' => $news_object->id));
				}
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
		}
		 
		public function getNewsById($id)
		{
			//use the Table Gateway to find the row that
			//the id represents
			try {
				$result = $this->_db_table->find($id);
				 
				//if not found, throw an exception
				if( count($result) == 0 ) {
					throw new Exception('News is not found');
				}
				 
				//if found, get the result, and map it to the
				//corresponding Data Object
				$row = $result->current();
				$news_object = new Application_Model_News($row);
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			//return the user object
			return $news_object;
		}
		
		public function get($news_type_id, $numberRecords = null){
			if($numberRecords == null){
				$numberRecords = $this->_recordPerPage;
			}
			try{
				$select = $this->_db_table->select()
									->from('NEWS')
									->where('NEWS_TYPE_ID = ?', $news_type_id)
									->limit($numberRecords, 0);				
				if($news_type_id > 0){
					$select = $select->where('NEWS_TYPE_ID = ?', $news_type_id);
				}									
				$result = $this->_db_table->getAdapter()->fetchAll($select);
				
			} catch (Exception $e) {
				Zend_Debug::dump( $e);die();
			}
			return $result;							
		}
		
		public function delete($id){
			$where = $this->_db_table->getAdapter()->quoteInto("ID = ?", $id);
			$this->_db_table->delete($where);
		}
		
		
	}
	
?>
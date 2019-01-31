<?php

class Application_Model_ProcessingTimeType
{   
    public $id;
	public $name;
	public $is_show;
	public $purpose_of_visit;
	public $price = 0; // data for FE
     
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($type_row = null)
    {
        if( !is_null($type_row)) {
            $this->id = $type_row instanceof Zend_Db_Table_Row  ? $type_row->ID : $type_row['ID'];
			$this->name =  $type_row instanceof Zend_Db_Table_Row  ? $type_row->NAME : $type_row['NAME'];
			$this->is_show = $type_row instanceof Zend_Db_Table_Row  ? $type_row->IS_SHOW : $type_row['IS_SHOW'];
			$this->purpose_of_visit = $type_row instanceof Zend_Db_Table_Row  ? $type_row->PURPOSE_OF_VISIT : $type_row['PURPOSE_OF_VISIT'];
        }
        
    }
     
    //magic function __set to set the
    //attributes of the User model
    public function __set($name, $value)
    {  
        //set the attribute with the value
        $this->$name = $value;
    }
     
    public function __get($name)
    {
        return $this->$name;
    }
    
}
?>
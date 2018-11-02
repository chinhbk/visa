<?php
	//location : application/models/News.php 
class Application_Model_ProductType
{   
    public $id;
	public $name;
	public $parent_id;
     
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($type_row = null)
    {
        if( !is_null($type_row)) {
            $this->id = $type_row instanceof Zend_Db_Table_Row  ? $type_row->ID : $type_row['ID'];
			$this->name =  $type_row instanceof Zend_Db_Table_Row  ? $type_row->NAME : $type_row['NAME'];
			$this->parent_id = $type_row instanceof Zend_Db_Table_Row  ? $type_row->PARENT_ID : $type_row['PARENT_ID'];
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
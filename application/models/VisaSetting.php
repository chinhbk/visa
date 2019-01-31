<?php

class Application_Model_VisaSetting
{   
	public $name;
	public $value;
     
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($type_row = null)
    {
        if( !is_null($type_row)) {
			$this->name =  $type_row instanceof Zend_Db_Table_Row  ? $type_row->NAME : $type_row['NAME'];
			$this->value = $type_row instanceof Zend_Db_Table_Row  ? $type_row->VALUE : $type_row['VALUE'];
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
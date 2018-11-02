<?php
	//location : application/models/News.php 
class Application_Model_NewsType
{   
 
    private $id;
	private $name;
     
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($newstype_row = null)
    {
        if( !is_null($newstype_row) && $newstype_row instanceof Zend_Db_Table_Row ) {
            $this->id = $newstype_row->ID;
			$this->name = $newstype_row->NAME;
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
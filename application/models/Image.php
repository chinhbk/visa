<?php

class Application_Model_Image
{   
    //declare the product's attributes
    private $id;
	private $image;
	private $status;
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($image_row = null)
    {
        if( !is_null($image_row) && $image_row instanceof Zend_Db_Table_Row ) {
            $this->id = $image_row->ID;
			$this->image = $image_row->IMAGE;
			$this->status = $image_row->STATUS;
        }
    }
     
    //magic function __set to set the
    //attributes of the User model
    public function __set($name, $value)
    {  
        $this->$name = $value;
    }
     
    public function __get($name)
    {
        return $this->$name;
    }
}
?>
<?php
	//location : application/models/Product.php 
class Application_Model_PriorityProduct
{   
    //declare the product's attributes
    private $typeName;
	private $priorities;
	
	public function __construct()
	{
		
	}

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
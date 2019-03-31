<?php

class Application_Model_NationalityVisaType
{   
    public $id;
    public $nationality_id;
    public $visa_type_id;
	public $purpose_of_visit;
	public $price;
	public $update_date;	
	public $name; //FE
	public $visa_type; //FE
	public $is_difficult; //FE
     
    //upon construction, map the values
    //from the $product_row if available
	public function __construct($obj = null)
    {
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
            $this->id = $obj->ID;
            $this->nationality_id = $$obj->NATIONALITY_ID;
            $this->visa_type_id = $obj->VISA_TYPE_ID;            
            $this->purpose_of_visit = $obj->PURPOSE_OF_VISIT;
            $this->price = $obj->PRICE;
            $this->update_date = $obj->UPDATE_DATE;
            
        }
        if(is_array($obj)){
        	if(isset($obj['ID']))  $this->id = $obj['ID'];
            $this->nationality_id = $obj['NATIONALITY_ID'];
            $this->visa_type_id = $obj['VISA_TYPE_ID'];
            if(isset($obj['PURPOSE_OF_VISIT'])) $this->purpose_of_visit = $obj['PURPOSE_OF_VISIT'];
            if(isset($obj['PRICE']))  $this->price = $obj['PRICE'];
            if(isset($obj['NAME'])) $this->name = $obj['NAME'];
            if(isset($obj['VISA_TYPE'])) $this->visa_type = $obj['VISA_TYPE'];
            if(isset($obj['IS_DIFFICULT'])) $this->is_difficult = $obj['IS_DIFFICULT'];
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

<?php

class Application_Model_NationalityProcessingTimeType
{   
    public $id;
    public $nationality_id;
    public $processing_time_type_id;
	public $purpose_of_visit;
	public $price;
	public $update_date;
	public $name; //FE
	public $processing_time_type; //FE
     
    //upon construction, map the values
    //from the $product_row if available
	public function __construct($obj = null)
    {
        
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
            $this->id = $obj->ID;
            $this->nationality_id = $$obj->NATIONALITY_ID;
            $this->processing_time_type_id = $obj->PROCESSING_TIME_TYPE_ID;
            $this->purpose_of_visit = $obj->PURPOSE_OF_VISIT;
            $this->price = $obj->PRICE;
            $this->update_date = $obj->UPDATE_DATE;
            
        }
        if(is_array($obj)){
            $this->id = $obj['ID'];
            $this->nationality_id = $obj['NATIONALITY_ID'];
            $this->processing_time_type_id = $obj['PROCESSING_TIME_TYPE_ID'];
            $this->purpose_of_visit = $obj['PURPOSE_OF_VISIT'];
            $this->price = $obj['PRICE'];
            if(isset($obj['NAME'])) $this->name = $obj['NAME'];
            if(isset($obj['PROCESSING_TIME_TYPE'])) $this->processing_time_type = $obj['PROCESSING_TIME_TYPE'];
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

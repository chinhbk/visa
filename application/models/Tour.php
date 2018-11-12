<?php
	//location : application/models/tour.php 
class Application_Model_Tour
{   
    //declare the tour's attributes    
	private $tour_type_id;
	private $short_desc;
	private $image_small;
	private $image;
    private $code;
    private $duration;
    private $price;
	private $details;
    private $is_hot;
    private $create_date;
    private $update_date;
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
			$this->tour_type_id = $obj->TOUR_TYPE_ID;
			$this->short_desc = $obj->SHORT_DESC;
			$this->image_small = $obj->IMAGE_SMALL;
			$this->image = $obj->IMAGE;
			$this->code = $obj->CODE;
			$this->duration = $obj->DURATION;
			$this->price = $obj->PRICE;
          	$this->details = $obj->DETAILS;
			$this->is_hot = $obj->IS_HOT;
			$this->create_date = $obj->CREATE_DATE;
			$this->update_date = $obj->UPDATE_DATE;			
        }
        
        if(is_array($obj)){
            //echo $obj['TOUR_TYPE_ID'];die;
            $this->tour_type_id = $obj['TOUR_TYPE_ID'];
            $this->short_desc = $obj['SHORT_DESC'];
            $this->code = $obj['CODE'];
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
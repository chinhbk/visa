<?php
	//location : application/models/tour.php 
class Application_Model_BookTour
{   
    //declare the tour's attributes    
	private $id;
	private $tour_id;
	private $code;
	private $name;
	private $email;
	private $phone;
	private $country;
	private $no; //number_of_travellers
	private $comment;
	private $status;
    private $create_date;
    private $update_date;
    private $tour_name; //DTO
    
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
            $this->id = $obj->ID;
            $this->tour_id = $obj->TOUR_ID;
			$this->code = $obj->CODE;
			$this->name = $obj->NAME;
			$this->email = $obj->EMAIL;
			$this->phone = $obj->PHONE;
			$this->country = $obj->COUNTRY;
			$this->comment = $obj->COMMENT;
			$this->no = $obj->no;
			$this->status = $obj->STATUS;
			$this->create_date = $obj->CREATE_DATE;
			$this->update_date = $obj->UPDATE_DATE;			
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
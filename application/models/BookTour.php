<?php
	//location : application/models/tour.php 
class Application_Model_BookTour
{   
    //declare the tour's attributes    
	private $id;
	private $tour_id;
	private $tour_price_group_id;
	private $code;
	private $name;
	private $email;
	private $phone;
	private $country;
	private $no; //number_of_travellers
	private $total_price;
	private $arrival_date;
	private $comment;
	private $status;
    private $create_date;
    private $update_date;
    private $tour_name; //DTO
    private $price_group_name;
    
    private $trans_code;
    private $trans_number;
    private $onepay_link;
    
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
            $this->id = $obj->ID;
            $this->tour_id = $obj->TOUR_ID;
            $this->tour_price_group_id = $obj->TOUR_PRICE_GROUP_ID;
            $this->arrival_date = $obj->ARRIVAL_DATE;
			$this->code = $obj->CODE;
			$this->name = $obj->NAME;
			$this->email = $obj->EMAIL;
			$this->phone = $obj->PHONE;
			$this->country = $obj->COUNTRY;
			$this->comment = $obj->COMMENT;
			$this->no = $obj->NO;
			$this->total_price = $obj->TOTAL_PRICE;
			$this->status = $obj->STATUS;
			$this->trans_code = $obj->TRANS_CODE;
			$this->trans_number = $obj->TRANS_NUMBER;
			$this->onepay_link = $obj->ONEPAY_LINK;
			$this->create_date = $obj->CREATE_DATE;
			$this->update_date = $obj->UPDATE_DATE;			
        }
        if(is_array($obj)){            
            $this->id = $obj['ID'];
            $this->tour_id = $obj['TOUR_ID'];
            $this->tour_price_group_id = $obj['TOUR_PRICE_GROUP_ID'];
            $this->no = $obj['NO'];
            $this->total_price = $obj['TOTAL_PRICE'];
            $this->arrival_date = $obj['ARRIVAL_DATE'];
            $this->code = $obj['CODE'];
            $this->name = $obj['NAME'];
            $this->email = $obj['EMAIL'];
            $this->phone = $obj['PHONE'];
            $this->country = $obj['COUNTRY'];
            $this->comment = $obj['COMMENT'];
            $this->status = $obj['STATUS'];
            $this->trans_code = $obj['TRANS_CODE'];
            $this->trans_number = $obj['TRANS_NUMBER'];
            if(isset($obj['ONEPAY_LINK'])) $this->onepay_link = $obj['ONEPAY_LINK'];
            if(isset($obj['TOUR_NAME'])) $this->tour_name = $obj['TOUR_NAME'];
            if(isset($obj['PRICE_GROUP_NAME'])) $this->price_group_name = $obj['PRICE_GROUP_NAME'];
            if(isset($obj['CREATE_DATE'])) $this->create_date = $obj['CREATE_DATE'];
            if(isset($obj['UPDATE_DATE'])) $this->update_date = $obj['UPDATE_DATE'];
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
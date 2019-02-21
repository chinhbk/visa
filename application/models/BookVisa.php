<?php
//location : application/models/tour.php
class Application_Model_BookVisa
{
    //declare the tour's attributes
    private $id;
    private $code;
    private $purpose_of_visit;
    private $visa_type;
    private $processing_time_type;
    private $visa_letter;
    private $number_of_visa;
    private $price_detail;
    private $total_price;
    private $arrival_date;
    private $arrival_airport;
    private $contact_name;
    private $contact_email;
    private $contact_phone;
    private $create_date;
    private $update_date;
    private $status;
    
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
      if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
         $this->id = $obj->ID;
         $this->code = $obj->CODE;
         $this->purpose_of_visit = $obj->PURPOSE_OF_VISIT;
         $this->visa_type = $obj->VISA_TYPE;
         $this->processing_time_type = $obj->PROCESSING_TIME_TYPE;
         $this->visa_letter = $obj->VISA_LETTER;
         $this->number_of_visa = $obj->NUMBER_OF_VISA;
         $this->price_detail = $obj->PRICE_DETAIL;
         $this->total_price = $obj->TOTAL_PRICE;
         $this->arrival_date = $obj->ARRIVAL_DATE;
         $this->arrival_airport = $obj->ARRIVAL_AIRPORT;
         
         $this->contact_name = $obj->CONTACT_NAME;
         $this->contact_email = $obj->CONTACT_EMAIL;
         $this->contact_phone = $obj->CONTACT_PHONE;
         
         $this->status = $obj->STATUS;
         $this->create_date = $obj->CREATE_DATE;
         $this->update_date = $obj->UPDATE_DATE;
         }
         if(is_array($obj)){
         $this->id = $obj['ID'];
         $this->code = $obj['CODE'];
         $this->purpose_of_visit = $obj['PURPOSE_OF_VISIT'];
         $this->visa_type = $obj['VISA_TYPE'];
         $this->processing_time_type = $obj['PROCESSING_TIME_TYPE'];
         $this->visa_letter = $obj['VISA_LETTER'];
         $this->number_of_visa = $obj['NUMBER_OF_VISA'];
         $this->price_detail = $obj['PRICE_DETAIL'];
         $this->total_price = $obj['TOTAL_PRICE'];
         $this->arrival_date = $obj['ARRIVAL_DATE'];
         $this->arrival_airport = $obj['ARRIVAL_AIRPORT'];
         
         $this->contact_name = $obj['contact_name'];
         $this->contact_email = $obj['CONTACT_EMAIL'];
         $this->contact_phone = $obj['CONTACT_PHONE'];
         
         $this->status = $obj['STATUS'];
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
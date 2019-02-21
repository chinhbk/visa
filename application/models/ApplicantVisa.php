<?php
	//location : application/models/tour.php 
class Application_Model_ApplicantVisa
{   
    //declare the tour's attributes    
	private $id;
	private $book_visa_id;
	private $nationality;
	private $name;
	private $gender;
	private $date_of_birth;
	private $passport_number;
	private $passport_expiry_date;
    
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
            $this->id = $obj->ID;
            $this->book_visa_id = $obj->BOOK_VISA_ID;
            $this->nationality = $obj->NATIONALITY;

            $this->name = $obj->NAME;
            $this->gender = $obj->GENDER;
            $this->date_of_birth = $obj->DATE_OF_BIRTH;
			
            $this->passport_number = $obj->PASSPORT_NUMBER;
            $this->passport_expiry_date = $obj->PASSPORT_EXPIRY_DATE;		
        }
        if(is_array($obj)){            
            $this->id = $obj['ID'];
            $this->book_visa_id = $obj['BOOK_VISA_ID'];
            
            $this->name = $obj['NAME'];
            $this->gender = $obj['GENDER'];
            $this->passport_number = $obj['PASSPORT_NUMBER'];
            $this->passport_expiry_date = $obj['PASSPORT_EXPIRY_DATE'];
            
            if(isset($obj['NATIONALITY'])) $this->nationality = $obj['NATIONALITY'];
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
<?php
	
class Application_Model_TravelGuide
{    
	private $id;
	private $name;
	private $image_small;
	private $image;
	private $details;
    private $is_show;
    private $create_date;
    private $update_date;
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
        //Zend_Debug::dump($obj); die;
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
			$this->id = $obj->ID;
			$this->name = $obj->NAME;
			$this->short_desc = $obj->SHORT_DESC;
			$this->image_small = $obj->IMAGE_SMALL;
			$this->image = $obj->IMAGE;
          	$this->details = $obj->DETAILS;
			$this->is_show = $obj->IS_SHOW;
			$this->create_date = $obj->CREATE_DATE;
			$this->update_date = $obj->UPDATE_DATE;			
        }
        
        if(is_array($obj)){
            //echo $obj['TOUR_TYPE_ID'];die;
            $this->id = $obj['ID'];
            $this->short_desc = $obj['SHORT_DESC'];
            $this->image_small = $obj['IMAGE_SMALL'];
            $this->is_show = $obj['IS_SHOW'];
            $this->name = $obj['NAME'];
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
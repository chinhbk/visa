<?php

class Application_Model_TourPriceGroup
{
    private $id;
    private $name;
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
            $this->id = $obj->ID;
            $this->name = $obj->NAME;
        }
        
        if(is_array($obj)){
            //echo $obj['TOUR_TYPE_ID'];die;
            $this->id = $obj['ID'];
            if(isset($obj['name'])) $this->name = $obj['NAME'];
        }
    }
    
    //magic function __set to set the
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
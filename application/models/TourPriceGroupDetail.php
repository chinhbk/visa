<?php

class Application_Model_TourPriceGroupDetail
{
    private $id;
    private $tour_type_id;
    private $tour_price_group_id;
    private $from_pax;
    private $to_pax;
    private $price;
    private $is_add_price;
    private $order;
    private $create_date;
    private $update_date;
    private $name; //group name DTO
    //upon construction, map the values
    //from the $obj if available
    public function __construct($obj = null)
    {
        if( !is_null($obj) && $obj instanceof Zend_Db_Table_Row ) {
            $this->id = $obj->ID;
            $this->tour_type_id = $obj->TOUR_TYPE_ID;
            $this->tour_price_group_id = $obj->TOUR_PRICE_GROUP_ID;
            $this->from_pax = $obj->FROM_PAX;
            $this->to_pax = $obj->TO_PAX;
            $this->price = $obj->PRICE;
            $this->is_add_price = $obj->IS_ADD_PRICE;
            $this->order = $obj->ORDER;
            $this->name = $obj->NAME;
            //$this->create_date = $obj->CREATE_DATE;
            //$this->update_date = $obj->UPDATE_DATE;
        }
        
        if(is_array($obj)){
            //echo $obj['TOUR_TYPE_ID'];die;
            $this->id = $obj['ID'];
            $this->tour_type_id = $obj['TOUR_TYPE_ID'];
            $this->tour_price_group_id = $obj['TOUR_PRICE_GROUP_ID'];
            $this->from_pax = $obj['FROM_PAX'];
            $this->to_pax = $obj['TO_PAX'];
            $this->price = $obj['PRICE'];
            $this->order = $obj['ORDER'];
            $this->is_add_price = $obj['IS_ADD_PRICE'];
            if(isset($obj['NAME'])) $this->name = $obj['NAME'];
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
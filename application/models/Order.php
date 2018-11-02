<?php

class Application_Model_Order
{   
   
    private $id;
    private $name;
    private $phone;
	private $email;
	private $province;
	private $address;
    private $is_ship;
	private $ship_code;
	private $status;
	private $note;
	private $create_date;
	private $update_date;
    //upon construction, map the values
    //from the $order_row if available
    public function __construct($order_row = null)
    {
        if( !is_null($order_row) && $order_row instanceof Zend_Db_Table_Row ) {
            $this->id = $order_row->ID;
            $this->name = $order_row->NAME;
			$this->phone = $order_row->PHONE;
			$this->email = $order_row->EMAIL;
             
			$this->province = $order_row->PROVINCE;
			$this->address = $order_row->ADDRESS;
			$this->is_ship = $order_row->IS_SHIP;
			$this->ship_code = $order_row->SHIP_CODE;
			$this->note = $order_row->NOTE;
			$this->status = $order_row->STATUS;
			$this->create_date = $order_row->CREATE_DATE;
			$this->update_date = $order_row->UPDATE_DATE;
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
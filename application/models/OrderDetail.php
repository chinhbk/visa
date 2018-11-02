<?php
	//location : application/models/Product.php 
class Application_Model_OrderDetail
{   
    //declare the product's attributes
    private $id;
    private $order_id;
    private $product_id;
	private $quantity;
	private $price;
	private $discount_price;
   
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($order_detail_row = null)
    {
        if( !is_null($order_detail_row) && $order_detail_row instanceof Zend_Db_Table_Row ) {
            $this->id = $order_detail_row->ID;
            $this->order_id = $order_detail_row->ORDER_ID;
			$this->product_id = $order_detail_row->PRODUCT_ID;
			$this->quantity = $order_detail_row->QUANTITY;
			$this->price = $order_detail_row->PRICE;             
			$this->discount_price = $product_row->DISCOUNT_PRICE;
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
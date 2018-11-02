<?php
	//location : application/models/Product.php 
class Application_Model_Product
{   
    //declare the product's attributes
    private $id;
	private $product_type_id;
    private $sub_product_type_id;
    private $code;
    private $name;
    private $price;
	private $discount_price;
	private $image_main;
	private $image_second;
	private $image_third;
	private $promotion;
	private $short_desc;
	private $details;
	private $is_type_priority;
	private $is_subtype_priority;
    private $is_hot;
	private $color;
	private $material;
	private $origin;
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($product_row = null)
    {
        if( !is_null($product_row) && $product_row instanceof Zend_Db_Table_Row ) {
            $this->id = $product_row->ID;
			$this->product_type_id = $product_row->PRODUCT_TYPE_ID;
            $this->sub_product_type_id = $product_row->SUB_PRODUCT_TYPE_ID;
			$this->code = $product_row->CODE;
            $this->name = $product_row->NAME;
			$this->price = $product_row->PRICE;
			$this->discount_price = $product_row->DISCOUNT_PRICE;
             
			$this->image_main = $product_row->IMAGE_MAIN;
			$this->image_second = $product_row->IMAGE_SECOND;
			$this->image_third = $product_row->IMAGE_THIRD;
			
			$this->promotion = $product_row->PROMOTION;
			$this->short_desc = $product_row->SHORT_DESC;
			$this->details = $product_row->DETAILS;
			$this->is_type_priority = $product_row->IS_TYPE_PRIORITY;
			$this->is_subtype_priority = $product_row->IS_SUBTYPE_PRIORITY;
			$this->is_hot = $product_row->IS_HOT;
			$this->color = $product_row->COLOR;
			$this->material = $product_row->MATERIAL;
			$this->origin = $product_row->ORIGIN;			
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
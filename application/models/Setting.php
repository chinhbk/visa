<?php

class Application_Model_Setting
{

    // declare the product's attributes
    private $id;

    private $hotline;

    private $email;

    private $address;

    private $contact;

    private $whyus;

    // upon construction, map the values
    // from the $product_row if available
    public function __construct($setting_row = null)
    {
        if (! is_null($setting_row) && $setting_row instanceof Zend_Db_Table_Row) {
            $this->id = $setting_row->ID;
            $this->hotline = $setting_row->HOTLINE;
            $this->email = $setting_row->EMAIL;
            $this->address = $setting_row->ADDRESS;
            $this->contact = $setting_row->CONTACT;
            $this->whyus = $setting_row->WHYUS;
        }
    }

    // magic function __set to set the
    // attributes of the User model
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
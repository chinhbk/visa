<?php

class Application_Model_Setting
{

    // declare the product's attributes
    private $id;

    private $logo;
    
    private $hotline;

    private $email;

    private $address;

    private $contact;

    private $whyus;
    
    private $tourterm;
    
    private $visastep;
    
    private $visafaq;
    
    private $visaterm;

    // upon construction, map the values
    // from the $product_row if available
    public function __construct($setting_row = null)
    {
        if (! is_null($setting_row) && $setting_row instanceof Zend_Db_Table_Row) {
            $this->id = $setting_row->ID;
            $this->logo = $setting_row->LOGO;
            $this->hotline = $setting_row->HOTLINE;
            $this->email = $setting_row->EMAIL;
            $this->address = $setting_row->ADDRESS;
            $this->contact = $setting_row->CONTACT;
            $this->whyus = $setting_row->WHYUS;
            $this->tourterm = $setting_row->TOURTERM;
            $this->visastep = $setting_row->VISASTEP;
            $this->visafaq = $setting_row->VISAFAQ;
            $this->visaterm = $setting_row->VISATERM;
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
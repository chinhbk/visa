<?php
	//location : application/models/News.php 
class Application_Model_News
{   
    //declare the product's attributes
    private $id;
	private $news_type_id;
    private $title;
    private $summary;
    private $small_image;
    private $content;
    
    //upon construction, map the values
    //from the $product_row if available
    public function __construct($news_row = null)
    {
        if( !is_null($news_row) && $news_row instanceof Zend_Db_Table_Row ) {			
			$this->id = $news_row->ID;
			$this->news_type_id = $news_row->NEWS_TYPE_ID;
            $this->title = $news_row->TITLE;
            $this->summary = $news_row->SUMMARY;
            $this->small_image = $news_row->SMALL_IMAGE;
            $this->content = $news_row->CONTENT;
        }
    }
     
    //magic function __set to set the
    //attributes of the User model
    public function __set($name, $value)
    {  
        //set the attribute with the value
        $this->$name = $value;
    }
     
    public function __get($name)
    {
        return $this->$name;
    }
}
?>
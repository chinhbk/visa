<?php

class ProductController extends Zend_Controller_Action
{

    public function init()
    {
		$product_type_mapper = new Application_Model_ProductTypeMapper();
		$menu_types = $product_type_mapper->getAllProductType2();
		//Zend_Debug::dump( $types);die();
		$this->view->menuTypes = $menu_types;
    }

    public function indexAction()
    {
		
    }

    public function detailAction()
    {
    	$request = $this->getRequest();
    	//Zend_Debug::dump( $request);die();
    	$id = $request->getParam('id');
    	//die($id);
    	$product_mapper = new Application_Model_ProductMapper();
    	$product = $product_mapper->getProductById($id);
    	$this->view->product =  $product;
    	//Zend_Debug::dump( $product);die();
		
		$hotProduct = $product_mapper->getAllHotProduct(4);
		$this->view->hots = $hotProduct;
    }
}


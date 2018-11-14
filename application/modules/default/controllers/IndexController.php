<?php

class IndexController extends Zend_Controller_Action
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
		$request = $this->getRequest();
		
		
		$tour_mapper = new Application_Model_TourMapper();
		$tour_type_mapper = new Application_Model_TourTypeMapper();
		$hot_tour = $tour_mapper->getByIds(null, 1);		
		$tour = $tour_mapper->getByIds();
		//Zend_Debug::dump($hot_tour);die();
		
		//get names of all root 
		$arr_ids = array();
		foreach($hot_tour as $row){
		    array_push($arr_ids, $row->parent_id);
		}
		
		
		$tour_level_1 = $tour_type_mapper->getByIds($arr_ids);
		$this->view->hot_tour = $hot_tour;
		$this->view->tour = $tour;
		$this->view->tour_level_1 = $tour_level_1;
		//Zend_Debug::dump($tour);die();
	
		//menu
		$tour_type_mapper = new Application_Model_TourTypeMapper();
		$menu_level_0 = $tour_type_mapper->getAllTourType(null);
		$this->view->menu_level_0 = $menu_level_0;
		
		$data_menu = $menu_level_0;
		foreach($data_menu as $menu){
		    $menu->menu1 = $tour_type_mapper->getAllTourType($menu->id);
		    foreach($menu->menu1 as $menu1){
		        $menu1->menu2 =  $tour_type_mapper->getAllTourType($menu1->id);
		    }
		}
		//Zend_Debug::dump($data_menu);die();
		$this->view->data_menu = $data_menu;
		
		$product_mapper = new Application_Model_ProductMapper();
		$product_type_mapper = new Application_Model_ProductTypeMapper();
		
		$types = $product_type_mapper->getTypes();
		//Zend_Debug::dump( $types);die();
		$allProductPriorityType = array();
		for($i = 1; $i < 7; $i++){
			$productPriType_obj = $product_mapper->getAllProductTypePriorityByType(4,$i);
			$productPriority = new Application_Model_PriorityProduct();
			$type_name = '';
			foreach ($types as $type){
				if($type['ID'] == $i){
					$type_name = $type['NAME'];
				}
			}
			
			$productPriority->typeName = $type_name;
			$productPriority->priorities = $productPriType_obj;
			
			array_push($allProductPriorityType, $productPriority);
		}
		
		$hotProduct = $product_mapper->getAllHotProduct(4);
		
		$allType = $product_type_mapper->getAllProductType();
		
		$this->view->types = $allType;
		$this->view->products = $allProductPriorityType;
		$this->view->hots = $hotProduct;
    }
    
    public function tourDetailAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $tour_mapper = new Application_Model_TourMapper();
        $tour = $tour_mapper->getById($id);
        
        //get name of tour
        $tourType_mapper = new Application_Model_TourTypeMapper();
        $sub_tour_type = $tourType_mapper->getById($id);        
        $tour->name = $sub_tour_type->name;
        $this->view->tour = $tour;
        
        //menu
        $tour_type_mapper = new Application_Model_TourTypeMapper();
        $menu_level_0 = $tour_type_mapper->getAllTourType(null);
        $this->view->menu_level_0 = $menu_level_0;
        
        $data_menu = $menu_level_0;
        foreach($data_menu as $menu){
            $menu->menu1 = $tour_type_mapper->getAllTourType($menu->id);
            foreach($menu->menu1 as $menu1){
                $menu1->menu2 =  $tour_type_mapper->getAllTourType($menu1->id);
            }
        }
        //Zend_Debug::dump($data_menu);die();
        $this->view->data_menu = $data_menu;
        //Zend_Debug::dump($tour);die();
        
    }
    
    public function applyOnlineAction()
    {
        //menu
        $tour_type_mapper = new Application_Model_TourTypeMapper();
        $menu_level_0 = $tour_type_mapper->getAllTourType(null);
        $this->view->menu_level_0 = $menu_level_0;
        
        $data_menu = $menu_level_0;
        foreach($data_menu as $menu){
            $menu->menu1 = $tour_type_mapper->getAllTourType($menu->id);
            foreach($menu->menu1 as $menu1){
                $menu1->menu2 =  $tour_type_mapper->getAllTourType($menu1->id);
            }
        }
        //Zend_Debug::dump($data_menu);die();
        $this->view->data_menu = $data_menu;
        
    }
	
	public function typeAction()
	{
	  $request = $this->getRequest();
	  $typeId = $request->getParam('typeId');
	  
	  $productType_mapper = new Application_Model_ProductTypeMapper();
	  $subTypes = $productType_mapper->getAllSubTypeByType2($typeId);
	  //Zend_Debug::dump( $subTypes);die();
	  
	  $product_mapper = new Application_Model_ProductMapper();
	  
	  $all_PriorityBySubType = array();
	  
	  foreach ($subTypes as $subType){
	  	$productPriBySubType = $product_mapper->getAllProductPriorityBySubType2(4, $subType->id);
	  	$priorityProduct = new Application_Model_PriorityProduct();
	  	$priorityProduct->typeName = $subType->name;
	  	$priorityProduct->priorities = $productPriBySubType;
	  	
	  	array_push($all_PriorityBySubType, $priorityProduct);
	  }
	  
	  //Zend_Debug::dump( $all_PriorityBySubType);die();
	  
	  $allType = $productType_mapper->getAllProductType();
	  
	  $this->view->types = $allType;
	  $this->view->products = $all_PriorityBySubType; 
	}
	
	public function subtypeAction(){
		$request = $this->getRequest();
		//Lam 10.25 07.01.2015
		$stype = $request->getParam('stype');
		$product_mapper = new Application_Model_ProductMapper();
		$productType_mapper = new Application_Model_ProductTypeMapper();
		$subType = $productType_mapper->getTypeById2($stype);
		
		$products = $product_mapper->getAllProductBySubType2(28, $stype);
		//Zend_Debug::dump( $subType);die();
		
		$allType = $productType_mapper->getAllProductType();
		
		$this->view->types = $allType;
		$this->view->products = $products;
		$this->view->subtype = $subType;
	}

	//Lam 13.35 07.01.2015
	public function searchAction(){
		$request = $this->getRequest();
		$key = $request->getParam('key');
		
		$product_mapper = new Application_Model_ProductMapper();
		$productType_mapper = new Application_Model_ProductTypeMapper();
		
		if(is_null($key)){
			
		} else {
			$products = $product_mapper->searchByKey(24, $key);
			$types = $productType_mapper->getAllProductType();
			//Zend_Debug::dump( $products);die();
			$this->view->products = $products;
			$this->view->types = $types;
		}
	}
	
	//Lam 15.20 07.01.2015
	public function filterAction(){
		$request = $this->getRequest();
		$paramType = $request->getParam('type');
		$min = $request->getParam('min');
		$max = $request->getParam('max');
		
		$productType_mapper = new Application_Model_ProductTypeMapper();
		$product_mapper = new Application_Model_ProductMapper();
		
		$p_sTypes = $productType_mapper->getAllSubTypeByType2($paramType);
		$p_products = null;
		$p_sTypeSelected = null;
		$p_priceSelected = null;

		//$paramType = stype
		if(sizeof($p_sTypes) == 0){
			$p_sTypeSelected = $productType_mapper->getTypeById2($paramType);
			if(is_null($min) && is_null($max)){
				$p_products = $product_mapper->filterProduct(null, $paramType, null, null, 28);
			} else {
				$p_products = $product_mapper->filterProduct(null, $paramType, $min, $max, 28);
				$p_priceSelected = array($min, $max);
				//Zend_Debug::dump( $p_products);die();
			}
		} else { //$paramType = type
			if(is_null($min) && is_null($max)){
				$p_products = $product_mapper->filterProduct($paramType, null, null, null, 28);
			} else {
				$p_products = $product_mapper->filterProduct($paramType, null, $min, $max, 28);
				$p_priceSelected = array($min, $max);
			}
		}
		
		//Zend_Debug::dump( $p_products);die();
		
		$this->view->stypes = $p_sTypes;
		$this->view->products = $p_products;
		$this->view->stypeSelected = $p_sTypeSelected;
		$this->view->priceSelected = $p_priceSelected;
	}
}


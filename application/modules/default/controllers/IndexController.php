<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_menu();
				
		$mapper = new Application_Model_SettingMapper();		
		$setting = $mapper->get();
		$this->view->setting = $setting;
		
		// dynamic page title
		//echo $controller = $this->getRequest()->getControllerName();
		$page_title = 'Vietnam Visa Tours - Best Vietnam Vacation Tours';
		$action = $this->getRequest()->getActionName();
		$id = $this->_request->getParam('id');
		//die($action);
		switch($action){
		    case 'tour-menu':
		    case 'tour-detail':
		    case 'tour-book':
		        $tourType_mapper = new Application_Model_TourTypeMapper();
		        $sub_tour_type = $tourType_mapper->getById($id);
		        $page_title = $sub_tour_type->name.' | Vietnam Visa Tours';
		        break;
		    case 'visa-step':
		        $page_title = 'Steps to apply visa'.' | Vietnam Visa Tours';
		    case 'apply-online': 
		        $page_title = 'Visa apply online'.' | Vietnam Visa Tours';
		        break;
		    case 'visa-faq':
		        $page_title = 'Visa FAQ'.' | Vietnam Visa Tours';
		        break;
		    case 'visa-service':
		        $page_title = 'Visa Extra Services'.' | Vietnam Visa Tours';
		        break;
		    default: 
		        if($action != 'index')
		          $page_title = str_replace('-', ' ', $action) . ' | Vietnam Visa Tours';
		        break;
		}
		$this->view->page_title = ucwords(strtolower($page_title));
		//echo ucwords(strtolower($page_title));die;
    }
    
    public function _generateURL($id, $name, $type){
        switch($type){
            case 1: $type = 'tours'; break;
            case 2: $type = 'tour'; break;
            case 3: $type = 'tour-book'; break;
        }
        $params = $id.'-'.$name;
        //replace non-alphanumeric character
        $params = preg_replace("![^a-z0-9]+!i", "-", $params);
        return '/'.$type.'/'.strtolower($params);
    }
    
    protected function _menu(){
        $tour_type_mapper = new Application_Model_TourTypeMapper();
        $menu_level_0 = $tour_type_mapper->getAllTourType(null);
        $this->view->menu_level_0 = $menu_level_0;
        
        $data_menu = $menu_level_0;
        foreach($data_menu as $menu){
            $menu->menu1 = $tour_type_mapper->getAllTourType($menu->id);
            foreach($menu->menu1 as $menu1){
                $menu1->menu2 =  $tour_type_mapper->getAllTourType($menu1->id);
                //generate url
                $menu1->url = $this->_generateURL($menu1->id, $menu1->name, 1);
                foreach($menu1->menu2 as $menu2){
                    $menu2->url = $this->_generateURL($menu2->id, $menu2->name, 2);
                }
            }
        }
        //Zend_Debug::dump($menu_level_0);die();
        $this->view->data_menu = $data_menu;
    }
    
    public function sendMailAction(){
        try{
            //Prepare email
            $config = array(
                'ssl' => 'tls',
                'port'     => 587,
                'auth'     => 'login',
                'username' => 'vietnamvisatours@gmail.com',
                'password' => 'vietnamvisatours2018@'
            );
            
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            $mail = new Zend_Mail();
            
            $mail
            ->setFrom('vietnamvisatours@gmail.com', 'VietnamVisaTours.Com')
            ->setSubject('Subject')
            ->setBodyText('This is the text of the mail.')
            ->addTo('chinhbk88@gmail.com')
            ->send($transport);
            
        } catch (Zend_Exception $e){
            die($e);
            //Do something with exception
        }
    }
    
    protected function _sendMail($subject, $bodyHtml, $to){
        try{
            //Prepare email
            $config = array(
                'ssl' => 'tls',
                'port'     => 587,
                'auth'     => 'login',
                'username' => 'vietnamvisatours@gmail.com',
                'password' => 'vietnamvisatours2018@'
            );
            
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            $mail = new Zend_Mail();
            
            $mail
            ->setFrom('vietnamvisatours@gmail.com', 'VietnamVisaTours.Com')
            ->setSubject($subject)
            ->setBodyHtml($bodyHtml)
            ->addTo($to)
            ->send($transport);
            
        } catch (Zend_Exception $e){
            die($e);
            //Do something with exception
        }
    }
    
    protected function _generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function indexAction()
    {
		$request = $this->getRequest();
		
		
		$tour_mapper = new Application_Model_TourMapper();
		$tour_type_mapper = new Application_Model_TourTypeMapper();
		$hot_tour = $tour_mapper->getByIds(null, 1);		
		$tour = $tour_mapper->getByIds();
		//Zend_Debug::dump(array_chunk($hot_tour, 3));
		//Zend_Debug::dump(array_slice($hot_tour, 3, 3));
		//$arr_hot_tour = array();
		//die();
		
		//get names of all root 
		$arr_ids = array();
		foreach($hot_tour as $row){
		    array_push($arr_ids, $row->parent_id);
		    $row->url = $this->_generateURL($row->tour_type_id, $row->name, 2);
		}
		
		foreach($tour as $t){
		    $t->url = $this->_generateURL($t->tour_type_id, $t->name, 2);
		}
		
		
		$tour_level_1 = $tour_type_mapper->getByIds($arr_ids);
		$this->view->hot_tour = array_chunk($hot_tour, 2);
		$this->view->tour = $tour;
		$this->view->tour_level_1 = $tour_level_1;
		//Zend_Debug::dump($tour);die();
				
		$image_mapper = new Application_Model_ImageMapper();
		$images = $image_mapper->getAll();
		//Zend_Debug::dump( $images);die();
		$this->view->images = $images;
    }
    
    public function tourMenuAction(){
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $tour_mapper = new Application_Model_TourMapper();
        $tour = $tour_mapper->getByParentId($id);
        //Zend_Debug::dump($tour);die();
        
        $tour_type_mapper = new Application_Model_TourTypeMapper();
        $tour_type = $tour_type_mapper->getById($id);
        //Zend_Debug::dump($name);die();
        $this->view->tour = $tour;
        $this->view->parent_name = $tour_type->name;
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
		$tour->parent_id = $sub_tour_type->parent_id;
		$tour->book_url = $this->_generateURL($tour->tour_type_id, $tour->name, 3);
		//parse images
		$str =  str_replace('[', '', $tour->image);
		$str =  str_replace(']', '', $str);
		$str =  str_replace('"', '', $str);
		//$str =  str_replace(',', '', $str);
		//Zend_Debug::dump(explode(',', $str));die();
		$tour->image = explode(',', $str);
        $this->view->tour = $tour;
		//get parent
		$parent = $tourType_mapper->getById($tour->parent_id);
        $this->view->parent = $parent;
		//Zend_Debug::dump($parent);die();
		        
        $tour_mapper = new Application_Model_TourMapper();
        $tours = $tour_mapper->getByParentId($tour->parent_id);
        foreach($tours as $t){
            $t->url = $this->_generateURL($t->tour_type_id, $t->name, 2);
        }
        $this->view->tours = $tours;
        //Zend_Debug::dump($tours);die();
    }
    
    public function tourBookAction() {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $tour_mapper = new Application_Model_TourMapper();
        $tour = $tour_mapper->getById($id);
        
        //get name of tour
        $tourType_mapper = new Application_Model_TourTypeMapper();
        $sub_tour_type = $tourType_mapper->getById($id);
        $tour->name = $sub_tour_type->name;
        $this->view->tour = $tour;
    }
    
    
    public function tourBookPostAction() {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $tour_mapper = new Application_Model_TourMapper();
        $tour = $tour_mapper->getById($id);
        
        //get name of tour
        $tourType_mapper = new Application_Model_TourTypeMapper();
        $sub_tour_type = $tourType_mapper->getById($id);
        $tour->name = $sub_tour_type->name;
        $this->view->tour = $tour;
        
        if ($request->isPost()) {
            $name = $request->getParam('name');
            $arivaldate = $request->getParam('arivaldate');
            $total_price = $request->getParam('total_price');
            $email = $request->getParam('email');
            $no_traveller = $request->getParam('no_traveller');
            $phone = $request->getParam('phone');
            $nationality = $request->getParam('nationality');
            //die($phone);
            $book_time = $request->getParam('book_time');
            $comment = $request->getParam('comment');
            //die($comment);
            $request_code = $this->_generateRandomString();
            
            //send mail
            $html = new Zend_View();
            $html->setScriptPath(APPLICATION_PATH . '/modules/default/views/scripts/index/');
            // die(APPLICATION_PATH . '/modules/default/views/scripts/index/');
            // assign valeues
            $html->assign('tour_id', $id);
            $html->assign('tour_name', $tour->name);
            $html->assign('request_code', $request_code);
            $html->assign('book_time', $book_time);
            $html->assign('name', $name);
            $html->assign('arivaldate', $arivaldate);
            $html->assign('total_price', $total_price);
            $html->assign('email', $email);
            $html->assign('no_traveller', $no_traveller);
            $html->assign('phone', $phone);
            $html->assign('nationality', $nationality);
            $html->assign('email', $email);
            $html->assign('comment', $comment);
            //die('a');
            // render view
            
            $bodyHtml = $html->render('tour-book-email.phtml');
            //die($bodyHtml);
            $subject = 'Your Travel request to vietnamvisatours.com at '.$book_time;
            $this->_sendMail($subject, $bodyHtml, $email);
            
            
            //save data
            $book_tour = new Application_Model_BookTour();
            $book_tour->tour_id = $id;
            $book_tour->arivaldate = $arivaldate;
            $book_tour->code = $request_code;
            $book_tour->name = $name;
            $book_tour->email = $email;
            $book_tour->no = $no_traveller;
            $book_tour->phone = $phone;
            $book_tour->country = $nationality;
            $book_tour->comment = $comment;
            $book_tour->status = 'NEW';
            $book_tour->arrival_date = $arivaldate;
            $book_tour->create_date = $this->_helper->CommonUtils->getVnDateTime();;
            $book_tour->update_date = $this->_helper->CommonUtils->getVnDateTime();;
            
            $booktour_mapper = new Application_Model_BookTourMapper();
            $booktour_mapper->save($book_tour);
            
            $this->view->request_code = $request_code;
        }
    }
    
    public function tourBookSuccessAction() {
    }
    
    public function tourTermConditionAction() {        
    }
    
    public function visaTermConditionAction() {        
    }
    
    public function applyOnlineAction()
    {       
        $request = $this->getRequest();  
        if ($request->isPost()) {
            $purposeOfVisit = $request->getParam('dropPurposeOfVisit');
            $numberApp = $request->getParam('dropNumberApp');
            $type_of_visa = $request->getParam('type_of_visa');
            $arrival_date = $request->getParam('arrival_date');
            $processing_time = $request->getParam("processing_time");
            $pay = $request->getParam("radioPay");
            $Arrival_Airport =  $request->getParam("Arrival_Airport");
            $contact_name = $request->getParam("contact_name");
            $contact_email = $request->getParam("contact_email");
            $contact_cc_email = $request->getParam("contact_cc_email");
            $contact_phone = $request->getParam("contact_phone");
            $private = $request->getParam("radioPrivate"); //Private/Shared visa
            $booking_code = "V".$this->_generateRandomString();
            $book_time = $request->getParam('book_time');
            //echo $purposeOfVisit; die;
            
            // Application 1
            $nationality1 = $request->getParam("nationality1");
            $fullname1 = $request->getParam("fullname1");
            $gender1 = $request->getParam("gender1");
            $dateOfBirth1 = $request->getParam("dateOfBirth1");
            $passport_number1 = $request->getParam("passport_number1");
            $passportExpiryDate1 = $request->getParam("passportExpiryDate1");
            
            // Application 2
            $nationality2 = $request->getParam("nationality2");
            $fullname2 = $request->getParam("fullname2");
            $gender2 = $request->getParam("gender2");
            $dateOfBirth2 = $request->getParam("dateOfBirth2");
            $passport_number2 = $request->getParam("passport_number2");
            $passportExpiryDate2 = $request->getParam("passportExpiryDate2");
            
            
            //echo $gender1; die;
            //send mail
            $html = new Zend_View();
            $html->setScriptPath(APPLICATION_PATH . '/modules/default/views/scripts/index/');
            // die(APPLICATION_PATH . '/modules/default/views/scripts/index/');
            // assign valeues
            $html->assign('contact_name', $contact_name);
            $html->assign('booking_code', $booking_code);
            $html->assign('purposeOfVisit', $purposeOfVisit);
            $html->assign('type_of_visa', $type_of_visa);
            $html->assign('arrival_date', $arrival_date);
            $html->assign('processing_time', $processing_time);
            $html->assign('private', $private);
            $html->assign('numberApp', $numberApp);
            //detail
            $html->assign('nationality1', $nationality1);
            $html->assign('fullname1', $fullname1);
            $html->assign('gender1', $gender1);
            $html->assign('dateOfBirth1', $dateOfBirth1);
            $html->assign('passport_number1', $passport_number1);
            $html->assign('passportExpiryDate1', $passportExpiryDate1);
            
            
            $html->assign('nationality2', $nationality2);
            $html->assign('fullname2', $fullname2);
            $html->assign('gender2', $gender2);
            $html->assign('dateOfBirth2', $dateOfBirth2);
            $html->assign('passport_number2', $passport_number2);
            $html->assign('passportExpiryDate2', $passportExpiryDate2);
            
            //die($nationality1);
            // render view
            
            $bodyHtml = $html->render('visa-book-email.phtml');
            //die($bodyHtml);
            $subject = 'Visa request from '.$contact_name .' at '.$book_time;
            $this->_sendMail($subject, $bodyHtml, $contact_email);
            
            //save to DB
        }
    }
    
    public function whyUsAction(){    
    }    
    
    public function contactUsAction(){
    }
        
    public function visaFaqAction(){
    }
    
    public function visaStepAction(){
    }
    
    public function visaServiceAction(){
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


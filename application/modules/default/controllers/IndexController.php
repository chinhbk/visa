<?php

class IndexController extends Zend_Controller_Action
{

    private static $PRICE_GROUP_ID = 10;
    private static $PRICE_PRIVATE_ID = 11;
    private static $HOMESTAY_DORM_ID = 0;
    private static $HOMESTAY_PRIVATE_ID = 1;
    private static $HOTEL_2_STAR_ID = 2;
    private static $HOTEL_3_STAR_ID = 3;
    private static $HOTEL_4_STAR_ID = 4;
    private static $HOTEL_5_STAR_ID = 5;
    private static $CRUISE_3_STAR_ID = 6;
    private static $CRUISE_4_STAR_ID = 7;
    private static $CRUISE_4_PLUS_STAR_ID = 8;
    private static $CRUISE_5_STAR_ID = 9;
    
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
    
    public function _generateURL($id, $name, $type, $parent_name = null){
        switch($type){
            case 1: //list tours
                $type = '/';                 
                break;
            case 2: //tour detail
                $parent_name = preg_replace("![^a-z0-9]+!i", "-", strtolower($parent_name));
                $type = '/'.($parent_name).'/'; 
                break;
            case 3: //book 1 tour
                $type = '/booking/';
                break;
        }
        $name = preg_replace("![^a-z0-9]+!i", "-", strtolower($name));
        $url = $type.$name.'/'.$id;  
    
        return $url;
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
                    $menu2->url = $this->_generateURL($menu2->id, $menu2->name, 2, $menu1->name);
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
    
    //$arr of Application_Model_TourType
    protected function _getName($arr, $id) {
        foreach($arr as $tour_type){
            if($tour_type->id == $id){
                return $tour_type->name;
            }
        }
        return '';
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
		}		
		
		$tour_level_1 = $tour_type_mapper->getByIds($arr_ids);
		$this->view->hot_tour = array_chunk($hot_tour, 2);
		$this->view->tour = $tour;
		$this->view->tour_level_1 = $tour_level_1;
		//Zend_Debug::dump($tour_level_1);die();
        
        //generate URLs
        foreach($hot_tour as $row){
            $row->url = $this->_generateURL($row->tour_type_id, $row->name, 2, $this->_getName($tour_level_1, $row->parent_id));
        }
		foreach($tour as $t){
		    $t->url = $this->_generateURL($t->tour_type_id, $t->name, 2, $this->_getName($tour_level_1, $t->parent_id));
		}
				
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
        foreach($tour as $t){
		    $t->url = $this->_generateURL($t->tour_type_id, $t->name, 2, $tour_type->name);
		}
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
		//processing get group prices
		$this->_getPrice($tour);
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
            $t->url = $this->_generateURL($t->tour_type_id, $t->name, 2, $parent->name);
        }
        $this->view->tours = $tours;
        //Zend_Debug::dump($tours);die();
        
        //get random 5 tours
        $tour_level_1 = $tourType_mapper->getByIds();
        $random = $tour_mapper->getRandom(5);
        foreach($random as $t){
            $t->url = $this->_generateURL($t->tour_type_id, $t->name, 2, $this->_getName($tour_level_1, $t->parent_id));
        }
        //Zend_Debug::dump($random);die();
        $this->view->random = $random;
    }
    
    protected function _getPrice($tour){
        $tour_price_group_detail_mapper = new Application_Model_TourPriceGroupDetailMapper();
        $price_arr = $tour_price_group_detail_mapper->getByTourIdAndOrGroupIds($tour->tour_type_id);
        
        $type_1_group = array();
        $type_1_private = array();
        $type_2 = array();
        $type_2_add_price = array();
        $type_3 = array();
        //$tour->price_arr = $price_arr;
        if($tour->price_type == 1) {
            //$groupIds = self::$GROUP_PRIVATE_IDS;
            //Zend_Debug::dump($price_arr);die;
            $type_1_group = array();
            $type_1_private = array();
            foreach($price_arr as $p){
                $p->book_url = $tour->book_url .'/'.$p->id;
                $p->tour_price_group_id == self::$PRICE_GROUP_ID ? array_push($type_1_group, $p) : array_push($type_1_private, $p);
            }
            //Zend_Debug::dump($type_1_group);die;
        } else {
            $groupId = $tour->price_type == 2 ? array(0, 1, 2, 3, 4, 5) : array(6, 7, 8, 9);
            foreach($price_arr as $p){
                $p->book_url = $tour->book_url .'/'.$p->id;
                if($p->tour_price_group_id >= 0 && $p->tour_price_group_id <= 5){                    
                    array_push($type_2, $p);
                } else if($p->is_add_price == 1){
                    array_push($type_2_add_price, $p);
                } else {
                    array_push($type_3, $p);
                }
            }
        }
        
        $this->view->type_1_group= $type_1_group;
        $this->view->type_1_private= $type_1_private;
        $this->view->type_2= $type_2;
        $this->view->type_2_add_price= $type_2_add_price;
        $this->view->type_3= $type_3;
        $this->view->HOMESTAY_DORM_ID = self::$HOMESTAY_DORM_ID;
        $this->view->HOMESTAY_PRIVATE_ID = self::$HOMESTAY_PRIVATE_ID;
        $this->view->HOTEL_2_STAR_ID = self::$HOTEL_2_STAR_ID;
        $this->view->HOTEL_3_STAR_ID = self::$HOTEL_3_STAR_ID;
        $this->view->HOTEL_4_STAR_ID = self::$HOTEL_4_STAR_ID;
        $this->view->HOTEL_5_STAR_ID = self::$HOTEL_5_STAR_ID;
        $this->view->CRUISE_3_STAR_ID = self::$CRUISE_3_STAR_ID;
        $this->view->CRUISE_4_STAR_ID = self::$CRUISE_4_STAR_ID;
        $this->view->CRUISE_4_PLUS_STAR_ID = self::$CRUISE_4_PLUS_STAR_ID;
        $this->view->CRUISE_5_STAR_ID = self::$CRUISE_5_STAR_ID;
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
        
        $tour_price_group_detail_mapper = new Application_Model_TourPriceGroupDetailMapper();
        $price_arr = $tour_price_group_detail_mapper->getByTourIdAndOrGroupIds($tour->tour_type_id);
        $price_group_detail_id = $request->getParam('price_group_detail_id');
        
        $price_group_detail = null;       
        foreach($price_arr as $p){
            if($p->id == $price_group_detail_id){
                $price_group_detail = $p;
                break;
            }
        }
        
        //check if additional price
        if($tour->price_type == 2 && $price_group_detail->is_add_price == 1){
            $arr_price_type2= array(self::$HOMESTAY_DORM_ID, self::$HOMESTAY_PRIVATE_ID, self::$HOTEL_2_STAR_ID, self::$HOTEL_3_STAR_ID, self::$HOTEL_4_STAR_ID, self::$HOTEL_5_STAR_ID);
            $price_arr = $tour_price_group_detail_mapper->getByTourIdAndOrGroupIds($tour->tour_type_id, $arr_price_type2, 'DESC');
            //Zend_Debug::dump($price_arr);die;
            $price_group_detail->price += $price_arr[0]->price;
        }
        
        if($price_group_detail->from_pax == null ) {
            $price_group_detail->from_pax = 1;
        }
        if($price_group_detail->to_pax == null ) {
            if($tour->price_type != 1){
                $price_group_detail->to_pax = 1;
            } else {
                $price_group_detail->to_pax = $price_group_detail->from_pax;
            }
        }        
        
        $this->view->price_group_detail = $price_group_detail;
       // Zend_Debug::dump($price_group_detail);die;
    }
    
    
    public function tourBookSendMailAction(){
        $this->_helper->layout()->disableLayout(); //  shuts off of the layout
        $this->_helper->viewRenderer->setNoRender();// stop automatic rendering
        //echo json_encode('12344');
        
        //echo($_POST['id']); die;
        
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $tour_mapper = new Application_Model_TourMapper();
        $tour = $tour_mapper->getById($id);
        
        //get name of tour
        $tourType_mapper = new Application_Model_TourTypeMapper();
        $sub_tour_type = $tourType_mapper->getById($id);
        $tour->name = $sub_tour_type->name;
               
        $booktour_mapper = new Application_Model_BookTourMapper();
        
        if ($request->isPost()) {
            $name = $request->getParam('name');
            $arivaldate = $request->getParam('arivaldate');
            $tour_price_group_id = $request->getParam('tour_price_group_id');
            $total_price = $request->getParam('total_price');
            $booking_type = $request->getParam('booking_type');
            $email = $request->getParam('email');
            $no_traveller = $request->getParam('no_traveller');
            $phone = $request->getParam('phone');
            $nationality = $request->getParam('nationality');
            //die($tour_price_group_id);
            $book_time = $request->getParam('book_time');
            $comment = $request->getParam('comment');
            //die($total_price);
            $latest_book_id = $booktour_mapper->getLatestId();
            $request_code = $this->_generateCode($latest_book_id + 1);
            //echo $request_code; die;
            //generate link
            $parent = $tourType_mapper->getById($sub_tour_type->parent_id);
            $url =  $this->_generateURL($id, $tour->name, 2, $parent->name);                        
            
            //save data
            $book_tour = new Application_Model_BookTour();
            $book_tour->tour_id = $id;
            $book_tour->tour_price_group_id = $tour_price_group_id;
            $book_tour->total_price = $total_price;
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
            $book_tour->create_date = $this->_helper->CommonUtils->getVnDateTime();
            $book_tour->update_date = $this->_helper->CommonUtils->getVnDateTime();

            $book_id = $booktour_mapper->save($book_tour);
            
            //send mail
            $html = new Zend_View();
            $html->setScriptPath(APPLICATION_PATH . '/modules/default/views/scripts/index/');
            // die(APPLICATION_PATH . '/modules/default/views/scripts/index/');
            // assign valeues
            $html->assign('tour_id', $id);
            $html->assign('tour_name', $tour->name);
            $html->assign('request_code', $request_code);
            $html->assign('url', $url);
            $html->assign('book_time', $book_time);
            $html->assign('name', $name);
            $html->assign('arivaldate', $arivaldate);
            $html->assign('total_price', $total_price);
            $html->assign('booking_type', $booking_type);
            $html->assign('email', $email);
            $html->assign('no_traveller', $no_traveller);
            $html->assign('phone', $phone);
            $html->assign('nationality', $nationality);
            $html->assign('email', $email);
            $html->assign('comment', $comment);
            
            //get phone hotline from DB
            $mapper = new Application_Model_SettingMapper();
            $setting = $mapper->get();
            
            $html->assign('hotline', $setting->hotline);
            $html->assign('address', $setting->address);
            //die('a');
            // render view
            
            $bodyHtml = $html->render('tour-book-email.phtml');
            //die($bodyHtml);
            $subject = $request_code.' - Tour Request from '.$name;
            //die($subject);
            $this->_sendMail($subject, $bodyHtml, $email);
            
            echo json_encode($request_code);
        }
        
    }
    
    public function tourBookSuccessAction() {
        $request = $this->getRequest();
        $code = $request->getParam('code');
        $this->view->code = $code;
    }
    
    protected function _generateCode($id) {
        return 'T'.$id.date('jny'); // day, month without leading 0
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


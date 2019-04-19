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
            case 4: //travel guide
                $type = '/travel-guide/';
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
    
    protected function _sendMail($subject, $bodyHtml, $to){
        try{
            //Prepare email
            $config = array(
                'ssl' => 'tls',
                'port'     => 587,
                'auth'     => 'login',
                'username' =>  Zend_Registry::getInstance()->constants->email->username,
                'password' =>  Zend_Registry::getInstance()->constants->email->password
            );
            
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            $mail = new Zend_Mail();
            
            $mail
            ->setFrom(Zend_Registry::getInstance()->constants->email->username, 'VietnamVisaTours.Com')
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
        //switch home page based on setting for ads 
        $mapper = new Application_Model_SettingMapper();
        $setting = $mapper->get();
        //Zend_Debug::dump($setting->homepage);die();
        if($setting->homepage == 'TOUR'){
            //$this->_homePageTour();
            $this->redirect('vietnam-tour');
        } else {
            $this->_homePageVisa();
        }
    }
    
    public function visaGuideAction(){
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $nationality_name = $request->getParam('name');
        $this->view->nationality_name = str_replace("-"," ",$nationality_name);
        $this->view->nationality_id = $id;
        
        $visa_type_mapper = new Application_Model_VisaTypeMapper();
        $visa_type = $visa_type_mapper->getAll(1, null);
        
        $visa_type_ids = array();
        foreach($visa_type as $row){
            array_push($visa_type_ids, $row->id);
        }
        
        $na_visa_mapper = new Application_Model_NationalityVisaTypeMapper();
        $tourist_price = $na_visa_mapper->getPrices('TOURIST VISA', $visa_type_ids, $id);
        $business_price = $na_visa_mapper->getPrices('BUSINESS VISA', $visa_type_ids, $id);
        //Zend_Debug::dump($tourist_price);die();
        $visa_type_mapper = new Application_Model_VisaTypeMapper();
        $data = $visa_type_mapper->getAll(0, $type);
        $tourist_data = array();
        $business_data = array();
        foreach($data as $m){
            foreach($tourist_price as $p){
                if($m->id == $p->visa_type_id){
                    $m->price = $p->price;
                    array_push($tourist_data, $m);
                }
            }
            foreach($business_price as $p){
                if($m->id == $p->visa_type_id){
                    $m->price = $p->price;
                    array_push($business_data, $m);
                }
            }
        }
        
        $this->view->tourist_data = $tourist_data;
        $this->view->business_data = $business_data;
        //Zend_Debug::dump($data);die();
    }
    
    protected function _homePageVisa(){
        $request = $this->getRequest();
        $nationality_mapper = new Application_Model_NationalityMapper();
        $nationality = $nationality_mapper->getAll(1);
        $this->view->nationality = $nationality;
    }
    
    protected function _homePageTour(){
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
        
        
        //travel guides
        
        $request = $this->getRequest();
        $mapper = new Application_Model_TravelGuideMapper();
        $travel_guides = $mapper->getAll();
        //Zend_Debug::dump( $travel_guides);die();
        foreach($travel_guides as $g){
            $g->url = $this->_generateURL($g->id, $g->name, 4, null);
        }
        
        $this->view->travel_guides = $travel_guides;
    }
    
    public function vietnamTourAction(){
        $this->_homePageTour();
    }
    
    public function travelGuideAction(){
        $request = $this->getRequest();
        //Zend_Debug::dump( $request);die();
        $id = $request->getParam('id');
        //die($id);
        $mapper = new Application_Model_TravelGuideMapper();
        $travel_guide = $mapper->getById($id);
        //parse images
        $str =  str_replace('[', '', $travel_guide->image);
        $str =  str_replace(']', '', $str);
        $str =  str_replace('"', '', $str);
        //$str =  str_replace(',', '', $str);
        //Zend_Debug::dump(explode(',', $str));die();
        $travel_guide->image = explode(',', $str);
        $this->view->travel_guide = $travel_guide;
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
		$parent->url = $this->_generateURL($parent->id, $parent->name, 1);
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
            $request_code = $this->_generateCode($latest_book_id + 1, 'T');
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

            $onepay_link = $this->_buildOnePayLink($total_price, $request_code, $phone, $email, $url);
            $book_tour->onepay_link = $onepay_link;
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
            
            echo $onepay_link;
        }
        
    }
    
    public function tourBookSuccessAction() {
        $request = $this->getRequest();
        $code = $request->getParam('code');
        $this->view->code = $code;
    }
    
    protected function _generateCode($id, $type = null) {
        return $type.$id.date('jny'); // day, month without leading 0
    }
    
    public function tourTermConditionAction() {        
    }
    
    public function visaTermConditionAction() {        
    }
    
    public function applyOnlineAction()
    {       
        $request = $this->getRequest();
                
        //edit visa apply online
        $booking_code = $request->getParam('code');
        $booking = new Application_Model_BookVisa();
        $applicants = null;
        if($booking_code != ''){ //update case
            $book_mapper = new Application_Model_BookVisaMapper();
            $booking = $book_mapper->getByCode($booking_code);
            if($booking == null){
                //redirect to home page;
            }
            //Zend_Debug::dump($booking);die;
            $applicant_mapper = new Application_Model_ApplicantVisaMapper();
            $applicants = $applicant_mapper->getApplicants($booking->id);
            
            $this->view->booking = $booking;
            $this->view->applicants = $applicants;
            $this->view->booking_code = $booking_code;
            //die($applicants[0]->nationality_id);            
            //Zend_Debug::dump($booking);die;
        }
        $this->view->booking = $booking;
        $default_purpose = $booking != null && $booking->purpose_of_visit != null ? $booking->purpose_of_visit : 'TOURIST VISA';
        //redirect from visa guide
        $request_visa_type = $request->getParam('purpose-of-visit');
        if($request_visa_type == 'business'){
            $default_purpose = 'BUSINESS VISA';
        }
        //die($booking->purpose_of_visit);
        $visa_type_mapper = new Application_Model_VisaTypeMapper();
        $visa_type = $visa_type_mapper->getAll(1, $default_purpose);
        $this->view->visa_type = $visa_type;
        
        $processing_time_type_mapper = new Application_Model_ProcessingTimeTypeMapper();
        $processing_time_type = $processing_time_type_mapper->getAll(1, $default_purpose);
        $this->view->processing_time_type = $processing_time_type;
        
        
        $nationality_mapper = new Application_Model_NationalityMapper();
        $nationality = $nationality_mapper->getAll(1);
        $this->view->nationality = $nationality;
        
        $visa_setting_mapper = new Application_Model_VisaSettingMapper();
        $visa_setting = $visa_setting_mapper->getAll();
        $this->view->visa_setting = $visa_setting;
        $numerOfVisa = 0;
        $private_visa_letter_price = 0;
        foreach($visa_setting as $s) {
            switch ($s->name){
                case 'Number Of Visa':  $numerOfVisa = $s->value; break;
                case 'Private Visa Letter':  $private_visa_letter_price = $s->value; break;
            }
        }
        $this->view->numerOfVisa = $numerOfVisa;
        $this->view->private_visa_letter_price = $private_visa_letter_price;        
        
        //Zend_Debug::dump($visa_setting[0]);die;
        $bookvisa_mapper = new Application_Model_BookVisaMapper();
        
        if ($request->isPost()) {
            $this->_helper->layout()->disableLayout(); //  shuts off of the layout
            $this->_helper->viewRenderer->setNoRender();// stop automatic rendering
            $purposeOfVisit = $request->getParam('dropPurposeOfVisit');
            $numberApp = $request->getParam('dropNumberApp');
            $type_of_visa = $request->getParam('type_of_visa');
            $type_of_visa_id = $request->getParam('type_of_visa_id');
            $arrival_date = $request->getParam('arrival_date');
            $processing_time = $request->getParam("processing_time");
            $processing_time_id = $request->getParam("processing_time_id");
            $pay = $request->getParam("radioPay");
            $Arrival_Airport =  $request->getParam("Arrival_Airport");
            $contact_name = $request->getParam("contact_name");
            $contact_email = $request->getParam("contact_email");
            $contact_cc_email = $request->getParam("contact_cc_email");
            $contact_phone = $request->getParam("contact_phone");
            $private = $request->getParam("radioPrivate"); //Private/Shared visa
            $booking_code = $request->getParam('code');
            //die($booking_code.'===');
            //create new
            if($booking_code == ''){
                $latest_book_id = $bookvisa_mapper->getLatestId();
                $booking_code = $this->_generateCode($latest_book_id + 1, 'V');
            }
            
            $book_time = $request->getParam('book_time');
            //echo $booking_code; die;

            $nationality1 = $request->getParam("nationality1");
            $fullname1 = $request->getParam("fullname1");
            $gender1 = $request->getParam("gender1");
            $dateOfBirth1 = $request->getParam("dateOfBirth1");
            $passport_number1 = $request->getParam("passport_number1");
            $passportExpiryDate1 = $request->getParam("passportExpiryDate1");
            
            $nationality2 = $request->getParam("nationality2");
            $fullname2 = $request->getParam("fullname2");
            $gender2 = $request->getParam("gender2");
            $dateOfBirth2 = $request->getParam("dateOfBirth2");
            $passport_number2 = $request->getParam("passport_number2");
            $passportExpiryDate2 = $request->getParam("passportExpiryDate2");
                   
            $nationality3 = $request->getParam("nationality3");
            $fullname3 = $request->getParam("fullname3");
            $gender3 = $request->getParam("gender3");
            $dateOfBirth3 = $request->getParam("dateOfBirth3");
            $passport_number3 = $request->getParam("passport_number3");
            $passportExpiryDate3 = $request->getParam("passportExpiryDate3");
            
            $nationality4 = $request->getParam("nationality4");
            $fullname4 = $request->getParam("fullname4");
            $gender4 = $request->getParam("gender4");
            $dateOfBirth4 = $request->getParam("dateOfBirth4");
            $passport_number4 = $request->getParam("passport_number4");
            $passportExpiryDate4 = $request->getParam("passportExpiryDate4");
                        
            $nationality5 = $request->getParam("nationality5");
            $fullname5 = $request->getParam("fullname5");
            $gender5 = $request->getParam("gender5");
            $dateOfBirth5 = $request->getParam("dateOfBirth5");
            $passport_number5 = $request->getParam("passport_number5");
            $passportExpiryDate5 = $request->getParam("passportExpiryDate5");
            
            
            $nationality6 = $request->getParam("nationality6");
            $fullname6 = $request->getParam("fullname6");
            $gender6 = $request->getParam("gender6");
            $dateOfBirth6 = $request->getParam("dateOfBirth6");
            $passport_number6 = $request->getParam("passport_number6");
            $passportExpiryDate6 = $request->getParam("passportExpiryDate6");
            
            $totalPrice = $request->getParam("totalPrice");
            $price_detail =  $request->getParam("price_detail");
                        
            //save/update data
            $book_visa = new Application_Model_BookVisa();
            //Zend_Debug::dump($booking);die;
            if($booking != null){ //update
                $book_visa = $booking;
            }
            //die('123333');
            $book_visa->code = $booking_code;
            
            $book_visa->purpose_of_visit = $purposeOfVisit;
            $book_visa->visa_type_id = $type_of_visa_id;
            $book_visa->processing_time_type_id = $processing_time_id;
            $book_visa->visa_letter = $private;
            $book_visa->number_of_visa = $numberApp;
            $book_visa->price_detail = $price_detail;
            $book_visa->total_price = $totalPrice;
            $book_visa->arrival_date = $arrival_date;
            $book_visa->payment = $pay;
            $book_visa->arrival_airport = $Arrival_Airport;
            $book_visa->contact_name = $contact_name;
            $book_visa->contact_email = $contact_email;
            $book_visa->contact_phone = $contact_phone;
            $book_visa->status = 'NEW';
            $book_visa->create_date = $this->_helper->CommonUtils->getVnDateTime();
            $book_visa->update_date = $this->_helper->CommonUtils->getVnDateTime();
            $onepay_link = $this->_buildOnePayLink($totalPrice, $booking_code, $contact_phone, $contact_email, self::$AGAIN_LINK.$booking_code);
            $book_visa->onepay_link = $onepay_link;
            //die($arrival_date);
            $book_visa_id = $bookvisa_mapper->save($book_visa);
            //save applicants
            $applicant_visa_mapper = new Application_Model_ApplicantVisaMapper();
            //die($book_visa_id);
            //die($request->getParam("nationality1"));
            //delete existing applicants, then reinsert again
            if($applicants != null){
                $applicant_visa_mapper->deleteByBookId($book_visa_id);
            }
            for($i = 1; $i <= $numberApp; $i++) {                
                $app = new Application_Model_ApplicantVisa();
                $app->book_visa_id = $book_visa_id;
                //die($request->getParam("nationality".$i));
                $app->nationality_id = $request->getParam("nationality_id".$i);
                $app->name = $request->getParam("fullname".$i);
                //Zend_Debug::dump($app);die;
                $app->gender = $request->getParam("gender".$i);
                $app->date_of_birth = $request->getParam("dateOfBirth".$i);
                $app->passport_number = $request->getParam("passport_number".$i);
                $app->passport_expiry_date = $request->getParam("passportExpiryDate".$i);
                //Zend_Debug::dump($app);die;
                $applicant_visa_mapper->save($app);
            }
            
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
            $html->assign('image1', $this->_getAgeImage($dateOfBirth1, $gender1));
            $html->assign('passport_number1', $passport_number1);
            $html->assign('passportExpiryDate1', $passportExpiryDate1);
                        
            $html->assign('nationality2', $nationality2);
            $html->assign('fullname2', $fullname2);
            $html->assign('gender2', $gender2);
            $html->assign('dateOfBirth2', $dateOfBirth2);
            $html->assign('image2', $this->_getAgeImage($dateOfBirth2, $gender2));
            $html->assign('passport_number2', $passport_number2);
            $html->assign('passportExpiryDate2', $passportExpiryDate2);
            
            $html->assign('nationality3', $nationality3);
            $html->assign('fullname3', $fullname3);
            $html->assign('gender3', $gender3);
            $html->assign('dateOfBirth3', $dateOfBirth3);
            $html->assign('image3', $this->_getAgeImage($dateOfBirth3, $gender3));
            $html->assign('passport_number3', $passport_number3);
            $html->assign('passportExpiryDate3', $passportExpiryDate3);
            
            $html->assign('nationality4', $nationality4);
            $html->assign('fullname4', $fullname4);
            $html->assign('gender4', $gender4);
            $html->assign('dateOfBirth4', $dateOfBirth4);
            $html->assign('image4', $this->_getAgeImage($dateOfBirth4, $gender4));
            $html->assign('passport_number4', $passport_number4);
            $html->assign('passportExpiryDate4', $passportExpiryDate4);
            
            $html->assign('nationality5', $nationality5);
            $html->assign('fullname5', $fullname5);
            $html->assign('gender5', $gender5);
            $html->assign('dateOfBirth5', $dateOfBirth5);
            $html->assign('image5', $this->_getAgeImage($dateOfBirth5, $gender5));
            $html->assign('passport_number5', $passport_number5);
            $html->assign('passportExpiryDate5', $passportExpiryDate5);
            
            $html->assign('nationality6', $nationality6);
            $html->assign('fullname6', $fullname6);
            $html->assign('gender6', $gender6);
            $html->assign('dateOfBirth6', $dateOfBirth6);
            $html->assign('image6', $this->_getAgeImage($dateOfBirth6, $gender6));
            $html->assign('passport_number6', $passport_number6);
            $html->assign('passportExpiryDate6', $passportExpiryDate6);
            
            $html->assign('totalPrice', $totalPrice); 
            
            //get phone hotline from DB
            $mapper = new Application_Model_SettingMapper();
            $setting = $mapper->get();
            
            $html->assign('hotline', $setting->hotline);
            $html->assign('address', $setting->address);
            
            //die($nationality1);
            // render view
            
            $bodyHtml = $html->render('visa-book-email.phtml');
            //die($bodyHtml);            
            $subject = $booking_code.' - Visa Request from '.$contact_name;
            $this->_sendMail($subject, $bodyHtml, $contact_email);
            
            echo $onepay_link;
        }
    }
    
    public function bookingResultAction() {
        $SECURE_SECRET = self::$SECURE_SECRET;
        
        // get and remove the vpc_TxnResponseCode code from the response fields as we
        // do not want to include this field in the hash calculation
        $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
        $vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
        $vpc_AcqResponseCode = $_GET["vpc_AcqResponseCode"];
        unset($_GET["vpc_SecureHash"]);
        // set a flag to indicate if hash has been validated
        $errorExists = false;
        
        if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {
            
            ksort($_GET);
            //$md5HashData = $SECURE_SECRET;
            //khởi tạo chuỗi mã hóa rỗng
            $md5HashData = "";
            // sort all the incoming vpc response fields and leave out any with no value
            foreach ($_GET as $key => $value) {
                //        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
                //            $md5HashData .= $value;
                //        }
                //      chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
                if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                    $md5HashData .= $key . "=" . $value . "&";
                }
            }
            //  Xóa dấu & thừa cuối chuỗi dữ liệu
            $md5HashData = rtrim($md5HashData, "&");
            
            //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
            //    Thay hàm tạo chuỗi mã hóa
            if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)))) {
                // Secure Hash validation succeeded, add a data field to be displayed
                // later.
                $hashValidated = "CORRECT";
            } else {
                // Secure Hash validation failed, add a data field to be displayed
                // later.
                $hashValidated = "INVALID HASH";
            }
        } else {
            // Secure Hash was not validated, add a data field to be displayed later.
            $hashValidated = "INVALID HASH";
        }
        //die($hashValidated);
        // Define Variables
        // ----------------
        // Extract the available receipt fields from the VPC Response
        // If not present then let the value be equal to 'No Value Returned'
        
        // Standard Receipt Data
        $amount = $this->_null2unknown($_GET["vpc_Amount"]);
        $this->view->amount = $amount/100;
        $locale = $this->_null2unknown($_GET["vpc_Locale"]);
        $batchNo = $this->_null2unknown($_GET["vpc_BatchNo"]);
        $command = $this->_null2unknown($_GET["vpc_Command"]);
        $message = $this->_null2unknown($_GET["vpc_Message"]);
        $this->view->message = $message;
        $version = $this->_null2unknown($_GET["vpc_Version"]);
        $cardType = $this->_null2unknown($_GET["vpc_Card"]);
        $orderInfo = $_GET["vpc_OrderInfo"];
        $this->view->orderInfo = $orderInfo;
        $receiptNo = $this->_null2unknown($_GET["vpc_ReceiptNo"]);
        $merchantID = $this->_null2unknown($_GET["vpc_Merchant"]);
        //$authorizeID = $this->_null2unknown($_GET["vpc_AuthorizeId"]);
        $merchTxnRef = $this->_null2unknown($_GET["vpc_MerchTxnRef"]);
        $this->view->merchTxnRef = $merchTxnRef;
        $transactionNo = $this->_null2unknown($_GET["vpc_TransactionNo"]);
        $this->view->transactionNo = $transactionNo;
        $acqResponseCode = $this->_null2unknown($_GET["vpc_AcqResponseCode"]);
        $txnResponseCode = $this->_null2unknown($_GET["vpc_TxnResponseCode"]);
        $this->view->txnResponseCode = $txnResponseCode;
        // 3-D Secure Data
        $verType = array_key_exists("vpc_VerType", $_GET) ? $_GET["vpc_VerType"] : "No Value Returned";
        $verStatus = array_key_exists("vpc_VerStatus", $_GET) ? $_GET["vpc_VerStatus"] : "No Value Returned";
        $token = array_key_exists("vpc_VerToken", $_GET) ? $_GET["vpc_VerToken"] : "No Value Returned";
        $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";
        $enrolled = array_key_exists("vpc_3DSenrolled", $_GET) ? $_GET["vpc_3DSenrolled"] : "No Value Returned";
        $xid = array_key_exists("vpc_3DSXID", $_GET) ? $_GET["vpc_3DSXID"] : "No Value Returned";
        $acqECI = array_key_exists("vpc_3DSECI", $_GET) ? $_GET["vpc_3DSECI"] : "No Value Returned";
        $authStatus = array_key_exists("vpc_3DSstatus", $_GET) ? $_GET["vpc_3DSstatus"] : "No Value Returned";
        
        // *******************
        // END OF MAIN PROGRAM
        // *******************
        
        // FINISH TRANSACTION - Process the VPC Response Data
        // =====================================================
        // For the purposes of demonstration, we simply display the Result fields on a
        // web page.
        
        // Show 'Error' in title if an error condition
        $errorTxt = "";
        
        // Show this page as an error page if vpc_TxnResponseCode equals '7'
        if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
            $errorTxt = "Error ";
        }
        
        // This is the display title for 'Receipt' page
        $title = $_GET["Title"];
        
        // The URL link for the receipt to do another transaction.
        // Note: This is ONLY used for this example and is not required for
        // production code. You would hard code your own URL into your application
        // to allow customers to try another transaction.
        //TK//$againLink = URLDecode($_GET["AgainLink"]);
        
        
        $transStatus = "";
        if($hashValidated=="CORRECT" && $txnResponseCode=="0"){
            $transStatus = "Transaction Successful";
        }elseif ($hashValidated=="INVALID HASH" && $txnResponseCode=="0"){
            $transStatus = "Transaction Pendding";
        }else {
            $transStatus = "Transaction Failure";
        }
        
        //update DB
        $bookingCode = $orderInfo;
        $this->_updateBooking($bookingCode, $transStatus, $txnResponseCode, $transactionNo);
        
        $this->view->transactionDes = $this->_getResponseDescription($txnResponseCode);
        $this->view->transStatus = $transStatus;
        
        //if user click cancel payment ==> redirect to page before payment page
        if($txnResponseCode == 99){
            if (strpos($bookingCode, 'V') !== false) {
                $this->redirect('visa-apply-online?code='.$bookingCode);
            } else if(strpos($bookingCode, 'T') !== false){
                $mapper = new Application_Model_BookTourMapper();
                //die($bookingCode);
                $booking = $mapper->getByCode($bookingCode);
                
                $tourType_mapper = new Application_Model_TourTypeMapper();
                $sub_tour_type = $tourType_mapper->getById($booking->tour_id);
                $tour->name = $sub_tour_type->name;
                
                $parent = $tourType_mapper->getById($sub_tour_type->parent_id);
                $url =  $this->_generateURL($booking->tour_id, $tour->name, 2, $parent->name);
                $this->redirect($url); // tour detail page
            }
        }
    }
    
    //tour or visa
    private function _updateBooking($bookingCode, $transStatus, $txnResponseCode, $transactionNo){
        if (strpos($bookingCode, 'V') !== false) {
            $mapper = new Application_Model_BookVisaMapper();
            //die($bookingCode);
            $booking = $mapper->getByCode($bookingCode);
            //Zend_Debug::dump( $bookingVisa);die();
            $booking->status = $transStatus;
            $booking->trans_code = $txnResponseCode;
            if ($txnResponseCode != "7" && $txnResponseCode != "No Value Returned"){
                $booking->trans_number = $transactionNo;
            }
            $mapper->save($booking);
        } else if(strpos($bookingCode, 'T') !== false){
            $mapper = new Application_Model_BookTourMapper();
            //die($bookingCode);
            $booking = $mapper->getByCode($bookingCode);
            //Zend_Debug::dump( $booking);die();
            $booking->status = $transStatus;
            $booking->trans_code = $txnResponseCode;
            if ($txnResponseCode != "7" && $txnResponseCode != "No Value Returned"){
                $booking->trans_number = $transactionNo;
            }
            $mapper->save($booking);
        }
    }
    
    public function ipnAction(){
        $this->_helper->layout()->disableLayout(); //  shuts off of the layout
        $this->_helper->viewRenderer->setNoRender();// stop automatic rendering
        
        // $SECURE_SECRET = "secure-hash-secret";        
        $SECURE_SECRET = self::$SECURE_SECRET;
        //$SECURE_SECRET = "93E963BC17BF022F2A03B685784D0CFA";
        // If there has been a merchant secret set then sort and loop through all the
        // data in the Virtual Payment Client response. While we have the data, we can
        // append all the fields that contain values (except the secure hash) so that
        // we can create a hash and validate it against the secure hash in the Virtual
        // Payment Client response.
        
        
        // NOTE: If the vpc_TxnResponseCode in not a single character then
        // there was a Virtual Payment Client error and we cannot accurately validate
        // the incoming data from the secure hash. */
        
        // get and remove the vpc_TxnResponseCode code from the response fields as we
        // do not want to include this field in the hash calculation
        $vpc_Txn_Secure_Hash = $_GET ["vpc_SecureHash"];
        unset ( $_GET ["vpc_SecureHash"] );
        
        // set a flag to indicate if hash has been validated
        $errorExists = false;
        
        if (strlen ( $SECURE_SECRET ) > 0 && $_GET ["vpc_TxnResponseCode"] != "7" && $_GET ["vpc_TxnResponseCode"] != "No Value Returned") {
            ksort($_GET);
            //$stringHashData = $SECURE_SECRET;
            //*****************************khởi tạo chuỗi mã hóa rỗng*****************************
            $stringHashData = "";
            
            // sort all the incoming vpc response fields and leave out any with no value
            foreach ( $_GET as $key => $value ) {
                //        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
                //            $stringHashData .= $value;
                //        }
                //      *****************************chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về*****************************
                if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                    $stringHashData .= $key . "=" . $value . "&";
                }
            }
            //  *****************************Xóa dấu & thừa cuối chuỗi dữ liệu*****************************
            $stringHashData = rtrim($stringHashData, "&");
            
            
            //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $stringHashData ) )) {
            //    *****************************Thay hàm tạo chuỗi mã hóa*****************************
            if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)))) {
                // Secure Hash validation succeeded, add a data field to be displayed
                // later.
                $hashValidated = "CORRECT";
            } else {
                // Secure Hash validation failed, add a data field to be displayed
                // later.
                $hashValidated = "INVALID HASH";
            }
        } else {
            // Secure Hash was not validated, add a data field to be displayed later.
            $hashValidated = "INVALID HASH";
        }
        
        // Define Variables
        // ----------------
        // Extract the available receipt fields from the VPC Response
        // If not present then let the value be equal to 'No Value Returned'
        // Standard Receipt Data
        $amount =  $this->_null2unknown($_GET ["vpc_Amount"] );
        $locale =  $this->_null2unknown($_GET ["vpc_Locale"] );
        //$batchNo = null2unknown ( $_GET ["vpc_BatchNo"] );
        $command =  $this->_null2unknown($_GET ["vpc_Command"] );
        //$message = null2unknown ( $_GET ["vpc_Message"] );
        $version =  $this->_null2unknown($_GET ["vpc_Version"] );
        //$cardType = null2unknown ( $_GET ["vpc_Card"] );
        $orderInfo =  $_GET ["vpc_OrderInfo"];
        //$receiptNo = null2unknown ( $_GET ["vpc_ReceiptNo"] );
        $merchantID =  $this->_null2unknown($_GET ["vpc_Merchant"] );
        //$authorizeID = null2unknown ( $_GET ["vpc_AuthorizeId"] );
        $merchTxnRef =  $this->_null2unknown($_GET ["vpc_MerchTxnRef"] );
        $transactionNo =  $this->_null2unknown($_GET ["vpc_TransactionNo"] );
        //$acqResponseCode = null2unknown ( $_GET ["vpc_AcqResponseCode"] );
        $txnResponseCode =  $this->_null2unknown($_GET ["vpc_TxnResponseCode"] );
        
        // This is the display title for 'Receipt' page
        //$title = $_GET ["Title"];
        
        
        // This method uses the QSI Response code retrieved from the Digital
        // Receipt and returns an appropriate description for the QSI Response Code
        //
        // @param $responseCode String containing the QSI Response Code
        //
        // @return String containing the appropriate description
        //
        ////////////////////////
        if($hashValidated=="CORRECT"){
            echo "responsecode=1&desc=confirm-success";
        }
        else echo "responsecode=0&desc=confirm-fail";
        
        ////////////////////////
        //  ----------------------------------------------------------------------------
        
        $transStatus = "";
        if($hashValidated=="CORRECT" && $txnResponseCode=="0"){
            $transStatus = "Transaction Successful";
        }elseif ($txnResponseCode!="0"){
            $transStatus = "Transaction Failure";
        }elseif ($hashValidated=="INVALID HASH"){
            $transStatus = "Transaction Pendding";
        }
        
        //update DB
        $bookingCode = $orderInfo;                        
        $this->_updateBooking($bookingCode, $transStatus, $txnResponseCode, $transactionNo);
        echo '<br/>'.$transStatus;
    }
    
    private static $VPC_URL = 'https://mtf.onepay.vn/vpcpay/vpcpay.op'; //TODO update 
    private static $SECURE_SECRET = '18D7EC3F36DF842B42E1AA729E4AB010'; //TODO update
    private static $VPC_MERCHANT = 'TESTONEPAYUSD'; //TODO update
    private static $VPC_ACCESS_CODE = '614240F4'; //TODO update
    private static $VPC_RETURN_URL = 'https://vietnamvisatours.com/index/booking-result';
    private static $AGAIN_LINK = 'https://vietnamvisatours.com/visa-apply-online?code=';
    
    private function _buildOnePayLink($amountUSD, $bookingCode, $phone, $email, $againLink) {
        $vpcURL = self::$VPC_URL . '?';
        // This is secret for encoding the MD5 hash
        $SECURE_SECRET = self::$SECURE_SECRET; 
        //$md5HashData = $SECURE_SECRET; Khởi tạo chuỗi dữ liệu mã hóa trống
        $md5HashData = "";
        
        $data = array(
            'Title' => 'VPC 3-Party', //TODO update
            'vpc_Merchant' => self::$VPC_MERCHANT,
            'vpc_AccessCode' => self::$VPC_ACCESS_CODE,
            'vpc_MerchTxnRef' => date('YmdHis') . rand(),
            'vpc_OrderInfo' => $bookingCode,
            'vpc_Amount' => $amountUSD * 100,
            'vpc_ReturnURL' => self::$VPC_RETURN_URL,
            'vpc_Version' => 2,
            'vpc_Command' => pay,
            'vpc_Locale'  => 'en',
            'vpc_TicketNo' => '::1',
            'vpc_SHIP_Street01' => '',
            'vpc_SHIP_Provice' => '',
            'vpc_SHIP_City' => '',
            'vpc_SHIP_Country' => '',
            'vpc_Customer_Phone' => $phone,
            'vpc_Customer_Email' => $email,
            'AgainLink' => $againLink,
        );
        
        ksort($data);
        
        foreach($data as $key => $value) {
            
            // create the md5 input and URL leaving out any fields that have no value
            if (strlen($value) > 0) {
                
                // this ensures the first paramter of the URL is preceded by the '?' char
                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }
                //$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
                if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                    $md5HashData .= $key . "=" . $value . "&";
                }
            }
        }
        //xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
        $md5HashData = rtrim($md5HashData, "&");
        // Create the secure hash and append it to the Virtual Payment Client Data if
        // the merchant secret has been provided.
        if (strlen($SECURE_SECRET) > 0) {
            //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
            // Thay hàm mã hóa dữ liệu
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)));
        }
        return $vpcURL;
    }
    
    public function onePayAction(){
        $request = $this->getRequest();
        $bookingCode = $request->getParam('code');
        
        //die($bookingCode);
        $mapper = null;
        if (strpos($bookingCode, 'V') !== false) {
            $mapper = new Application_Model_BookVisaMapper();
        } else if(strpos($bookingCode, 'T') !== false){
            $mapper = new Application_Model_BookTourMapper();
        }
        $booking = $mapper->getByCode($bookingCode);
        //Zend_Debug::dump( $bookingVisa);die();
        if($booking->onepay_link == '' || $booking->onepay_link == null) {
            $this->redirect('index');
        }
        $this->view->booking = $booking;
    }
    
    
    // This method uses the QSI Response code retrieved from the Digital
    // Receipt and returns an appropriate description for the QSI Response Code
    //
    // @param $responseCode String containing the QSI Response Code
    //
    // @return String containing the appropriate description
    //
    function _getResponseDescription($responseCode)
    {
        
        switch ($responseCode) {
            case "0" :
                $result = "Transaction Successful";
                break;
            case "?" :
                $result = "Transaction status is unknown";
                break;
            case "1" :
                $result = "Bank system reject";
                break;
            case "2" :
                $result = "Bank Declined Transaction";
                break;
            case "3" :
                $result = "No Reply from Bank";
                break;
            case "4" :
                $result = "Expired Card";
                break;
            case "5" :
                $result = "Insufficient funds";
                break;
            case "6" :
                $result = "Error Communicating with Bank";
                break;
            case "7" :
                $result = "Payment Server System Error";
                break;
            case "8" :
                $result = "Transaction Type Not Supported";
                break;
            case "9" :
                $result = "Bank declined transaction (Do not contact Bank)";
                break;
            case "A" :
                $result = "Transaction Aborted";
                break;
            case "C" :
                $result = "Transaction Cancelled";
                break;
            case "D" :
                $result = "Deferred transaction has been received and is awaiting processing";
                break;
            case "F" :
                $result = "3D Secure Authentication failed";
                break;
            case "I" :
                $result = "Card Security Code verification failed";
                break;
            case "L" :
                $result = "Shopping Transaction Locked (Please try the transaction again later)";
                break;
            case "N" :
                $result = "Cardholder is not enrolled in Authentication scheme";
                break;
            case "P" :
                $result = "Transaction has been received by the Payment Adaptor and is being processed";
                break;
            case "R" :
                $result = "Transaction was not processed - Reached limit of retry attempts allowed";
                break;
            case "S" :
                $result = "Duplicate SessionID (OrderInfo)";
                break;
            case "T" :
                $result = "Address Verification Failed";
                break;
            case "U" :
                $result = "Card Security Code Failed";
                break;
            case "V" :
                $result = "Address Verification and Card Security Code Failed";
                break;
            case "99" :
                $result = "User Cancel";
                break;
            default  :
                $result = "Unable to be determined";
        }
        return $result;
    }
    
    // If input is null, returns string "No Value Returned", else returns input
    private function _null2unknown($data)
    {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }
    
    protected function _getAge($dateOfBirth){
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');
    }
    
    protected function _getAgeImage($dateOfBirth, $gender){
        $age = $this->_getAge($dateOfBirth);
        if($age <= 2){
            return $gender == 'Male' ? '/img/maleU1y.png' : '/img/femaleU1y.png';
        } else if($age > 2 && $age <= 6){
            return $gender == 'Male' ? '/img/maleU3y.png' : '/img/femaleU3y.png';
        } else if($age > 6 && $age < 18){
            return $gender == 'Male' ? '/img/maleU12y.png' : '/img/femaleU12y.png';
        } else {
            return $gender == 'Male' ? '/img/male.png' : '/img/female.png';
        }
        return '';
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
    
    public function vietnamVisaExemptionAction() {
        $visa_setting_mapper = new Application_Model_VisaSettingMapper();
        $visa_setting = $visa_setting_mapper->getAll('text');
        
        $exemption_note = '';
        $exemption_nationality = array();
        foreach($visa_setting as $s) {
            switch ($s->name){
                case 'Visa Exemption':  $exemption_note = $s->text; break;
                default: $exemption_nationality[] = $s; break;
            }
        }
        
        $this->view->exemption_note = $exemption_note;
        $this->view->exemption_nationality = $exemption_nationality;
    }
    
    public function purposeOfVisitChangeAction(){
        $this->_helper->layout()->disableLayout(); //  shuts off of the layout
        $this->_helper->viewRenderer->setNoRender();// stop automatic rendering
        $request = $this->getRequest();
        $type = $request->getParam('dropPurposeOfVisit');
        $type_of_visa = $request->getParam('type_of_visa');
        $dropNumberApp = $request->getParam('dropNumberApp');
        $nationality1= $request->getParam('nationality1');
        $visa_type_mapper = new Application_Model_VisaTypeMapper();
        $visa_type = $visa_type_mapper->getAll(1, $type);
        $processing_time_type_mapper = new Application_Model_ProcessingTimeTypeMapper();
        $processing_time_type = $processing_time_type_mapper->getAll(1, $type);
        
        $visa_type_ids = $this->_getIdsOf($visa_type);
        //Zend_Debug::dump($visa_type_ids);die();
        $nationality_visa_type_mapper = new Application_Model_NationalityVisaTypeMapper();
        $visa_type_prices = $nationality_visa_type_mapper->getPrices($type, $visa_type_ids, $nationality1);
        //Zend_Debug::dump($visa_type_prices);die();
        //check when select 6 month , 1year ( price = null)
        $nationality_mapper = new Application_Model_NationalityMapper();
        $nationality_apply = $nationality_mapper->getNationalitiesApplyForVisaType($type);
        foreach($visa_type as $v) {
            $nationality_apply_v = array();
            foreach($visa_type_prices as $vprice) {
                if($v->id == $vprice->visa_type_id) {                   
                    $v->price = $vprice->price;
                }
            }
            foreach($nationality_apply as $n){
                if($v->id == $n->visa_type_id){
                    array_push($nationality_apply_v, $n);
                }
            }
            $v->nationality_apply = $nationality_apply_v;
        }
        
        $processing_time_type_ids = $this->_getIdsOf($processing_time_type);        
        $nationality_processing_type_mapper = new Application_Model_NationalityProcessingTimeTypeMapper();
        $processing_time_type_prices = $nationality_processing_type_mapper->getPrices($type, $processing_time_type_ids, $nationality1);
        foreach($processing_time_type as $v) {
            foreach($processing_time_type_prices as $vprice) {
                if($v->id == $vprice->processing_time_type_id) {
                    $v->price = $vprice->price;
                }
            }
        }
        //checking price data of different nationalities
        $nationality2= $request->getParam('nationality2');
        $nationality3= $request->getParam('nationality3');
        $nationality4= $request->getParam('nationality4');
        $nationality5= $request->getParam('nationality5');
        $nationality6= $request->getParam('nationality6');
        $nationality_arr = array($nationality1);
        if($dropNumberApp >=2 && $nationality2 != ''){
            array_push($nationality_arr, $nationality2);
        }
        if($dropNumberApp >=3 && $nationality3 != ''){
            array_push($nationality_arr, $nationality3);
        }
        if($dropNumberApp >=4 && $nationality4 != ''){
            array_push($nationality_arr, $nationality4);
        }
        if($dropNumberApp >=5 && $nationality5 != ''){
            array_push($nationality_arr, $nationality5);
        }
        if($dropNumberApp >=6 && $nationality6 != ''){
            array_push($nationality_arr, $nationality6);
        }

        $nationality_arr = array_unique($nationality_arr);
       // Zend_Debug::dump($nationality_arr);die();
        $error_msg = '';
        if(sizeof($nationality_arr) > 1){
            foreach($nationality_arr as $nationality){
                if($nationality != $nationality1){
                    $temp = $nationality_visa_type_mapper->getPrices($type, $visa_type_ids, $nationality);
                    foreach($temp as $vprice) {
                        $price1 = $this->_getPriceOfArrById($visa_type, $vprice->visa_type_id);
                        if($price1 != $vprice->price) {
                            $error_msg = 'Price difference between selected nationalities';
                            break 2;
                        }
                    }                    
                }
            }
        }        
        
        //Zend_Debug::dump($processing_time_type);die();
        //Zend_Debug::dump($processing_time_type_prices);die();
        
        //Zend_Debug::dump($visa_type_prices);die();
        $data = array();
        $data['visa_type'] = $visa_type;
        $data['processing_time'] = $processing_time_type;
        $price = 15;
        if($type == 'BUSINESS VISA') $price = 75;
        $data['priceFor1Person'] = $price;
        $data['error_msg'] = $error_msg;
        echo json_encode($data);
    }
    
    private function _getPriceOfArrById($arr, $id){
        foreach($arr as $a){
            if($id == $a->id){
                return $a->price;
            }
        }
        return null;
    }
    
    private function _getIdsOf($data){
        $ids = array();
        foreach($data as $v){
            array_push($ids, $v->id);
        }
        return $ids;
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


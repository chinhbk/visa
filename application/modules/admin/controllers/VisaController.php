<?php

class Admin_VisaController extends Zend_Controller_Action
{
    private static $VISA_TYPE_1MSE = '1 Month Single Entry';
    private static $VISA_TYPE_1MME = '1 Month Multiple Entry';
    private static $VISA_TYPE_3MSE = '3 Months Single Entry';
    private static $VISA_TYPE_3MME = '3 Months Multiple Entry';
    private static $VISA_TYPE_6MME = '6 Months Multiple Entry';
    private static $VISA_TYPE_1YME = '1 Year Multiple Entry';
    private static $PROCESSING_TIME_TYPE_U1_DAY = 'Urgent - 1 working day (MON-FRI)';
    private static $PROCESSING_TIME_TYPE_U2_DAY = 'Urgent - 2 working days (MON-FRI)';
    private static $PROCESSING_TIME_TYPE_U8_HOURS = 'Urgent - 8 working hours (MON-FRI)';
    private static $PROCESSING_TIME_TYPE_U4_HOURS = 'Urgent - 4 working hours (MON-FRI)';
    private static $PROCESSING_TIME_TYPE_U2_HOURS = 'Urgent - 2 working hours (MON-FRI)';
    private static $PROCESSING_TIME_TYPE_U30_MIN = 'Urgent - 30 minutes (MON-FRI)';
    private static $PROCESSING_TIME_TYPE_U15_MIN = 'Urgent - 15 minutes (MON-FRI)';
    private static $PROCESSING_TIME_TYPE_UHoliday = 'Urgent - holiday';
    
    public function init()
    {
		$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $identity = $auth->getIdentity();
            if($identity->ROLE == 0 || $identity->ROLE == 1){
            	$this->view->user_name = $identity->USER_NAME;
            	$layout = $this->_helper->layout();
            	$layout->setLayout('admin');
            }else{ // redirect to access denied page
            	$this->redirect('admin/auth/access-denied');
            }
        } else {
           $this->redirect('admin/auth');
        }
        
        $this->view->VISA_TYPE_1MSE = self::$VISA_TYPE_1MSE;
        $this->view->VISA_TYPE_1MME = self::$VISA_TYPE_1MME;
        $this->view->VISA_TYPE_3MSE = self::$VISA_TYPE_3MSE;
        $this->view->VISA_TYPE_3MME = self::$VISA_TYPE_3MME;
        $this->view->VISA_TYPE_6MME = self::$VISA_TYPE_6MME;
        $this->view->VISA_TYPE_1YME = self::$VISA_TYPE_1YME;
        $this->view->PROCESSING_TIME_TYPE_U1_DAY = self::$PROCESSING_TIME_TYPE_U1_DAY;
        $this->view->PROCESSING_TIME_TYPE_U2_DAY = self::$PROCESSING_TIME_TYPE_U2_DAY;
        $this->view->PROCESSING_TIME_TYPE_U8_HOURS = self::$PROCESSING_TIME_TYPE_U8_HOURS;
        $this->view->PROCESSING_TIME_TYPE_U4_HOURS = self::$PROCESSING_TIME_TYPE_U4_HOURS;
        $this->view->PROCESSING_TIME_TYPE_U2_HOURS = self::$PROCESSING_TIME_TYPE_U2_HOURS;
        $this->view->PROCESSING_TIME_TYPE_U30_MIN = self::$PROCESSING_TIME_TYPE_U30_MIN;
        $this->view->PROCESSING_TIME_TYPE_U15_MIN = self::$PROCESSING_TIME_TYPE_U15_MIN;
        $this->view->PROCESSING_TIME_TYPE_UHoliday = self::$PROCESSING_TIME_TYPE_UHoliday;
    }

    public function normalAction()
    {
    	$request = $this->getRequest();
    	
    	$keyword = $request->getParam('keyword');
		
		$this->view->keyword = $keyword;
    	
    	$this->_managePrices($keyword, 0, 'TOURIST VISA');
    	    	
    	//Zend_Debug::dump( $nationality);die();    	    	   
    }
    
    public function difficultAction()
    {
        $request = $this->getRequest();
        
        $keyword = $request->getParam('keyword');
		
		$this->view->keyword = $keyword;
        
        $this->_managePrices($keyword, 1, 'TOURIST VISA');
        
        //Zend_Debug::dump( $nationality);die();
    }
    
    public function businessAction()
    {
        $request = $this->getRequest();
        
        $keyword = $request->getParam('keyword');
		
		$this->view->keyword = $keyword;
        
        $this->_managePrices($keyword, 0, 'BUSINESS VISA');
        
        //Zend_Debug::dump( $nationality);die();
    }
    
    public function updatePriceAction(){
        $this->_helper->layout()->disableLayout(); //  shuts off of the layout
        $this->_helper->viewRenderer->setNoRender();// stop automatic rendering
        $data = json_decode($_POST["data"]);
        
        $nationality_visa_type_mapper = new Application_Model_NationalityVisaTypeMapper();
        $this->_saveVisaTypeOrProcessingTimeTypePrices($data->purpose_of_visit, 'visa_type', $nationality_visa_type_mapper, $data->visa_type, $data->nationality_id);
        
        //update processing time price
        $nationality_processing_time_type_mapper = new Application_Model_NationalityProcessingTimeTypeMapper();
        $this->_saveVisaTypeOrProcessingTimeTypePrices($data->purpose_of_visit, 'processing_type', $nationality_processing_time_type_mapper, $data->processing_time_type, $data->nationality_id);
        
        //die();
        echo 'Success';
    }
    
    protected  function _managePrices($keyword = null, $is_difficult, $type){
        $nationality_mapper = new Application_Model_NationalityMapper();
        $nationality = $nationality_mapper->getAll(0, $is_difficult, $keyword);
        $this->view->nationality = $nationality;
        
        $visa_type_mapper = new Application_Model_VisaTypeMapper();
        $data = $visa_type_mapper->getAll(0, $type);
        $map_name_id_visa_type = array();
        foreach($data as $mm){
            $map_name_id_visa_type[$mm->name]= $mm ->id;
        }
        $this->view->map_name_id_visa_type = $map_name_id_visa_type;
        //Zend_Debug::dump( $map_name_id_visa_type);die();
        
        $map_name_id_processing_type = $this->_mapNameAndId('processing_type', $type);
        $this->view->map_name_id_processing_type = $map_name_id_processing_type;
        
        //Zend_Debug::dump( $map_name_id_processing_type);die();
        
        $nationality_visa_type_prices = $nationality_mapper->search($keyword, $type);
        $nationality_processing_time_type_prices = $nationality_mapper->searchProcessingTime($keyword, $type);
       // Zend_Debug::dump( $nationality_processing_time_type_prices);die();
        foreach($nationality as $na){
            $arr_visa_type_price = array();
            foreach($nationality_visa_type_prices as $visa_type_price){
                if($visa_type_price->nationality_id == $na->id){
                    switch($visa_type_price->visa_type){
                        case self::$VISA_TYPE_1MSE: $arr_visa_type_price[self::$VISA_TYPE_1MSE] = $visa_type_price->price; break;
                        case self::$VISA_TYPE_1MME: $arr_visa_type_price[self::$VISA_TYPE_1MME] = $visa_type_price->price; break;
                        case self::$VISA_TYPE_3MSE: $arr_visa_type_price[self::$VISA_TYPE_3MSE] = $visa_type_price->price; break;
                        case self::$VISA_TYPE_3MME: $arr_visa_type_price[self::$VISA_TYPE_3MME] = $visa_type_price->price; break;
                        case self::$VISA_TYPE_6MME: $arr_visa_type_price[self::$VISA_TYPE_6MME] = $visa_type_price->price; break;
                        case self::$VISA_TYPE_1YME: $arr_visa_type_price[self::$VISA_TYPE_1YME] = $visa_type_price->price; break;
                    }
                }
            }
            $na->visa_type_prices = $arr_visa_type_price;
            
            $arr_processing_time_type_price = array();
            foreach($nationality_processing_time_type_prices as $nationality_processing_time_type_price){
                if($nationality_processing_time_type_price->nationality_id == $na->id){
                    switch($nationality_processing_time_type_price->processing_time_type){
                        case self::$PROCESSING_TIME_TYPE_U2_DAY: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_U2_DAY] = $nationality_processing_time_type_price->price; break;
                        case self::$PROCESSING_TIME_TYPE_U1_DAY: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_U1_DAY] = $nationality_processing_time_type_price->price; break;
                        case self::$PROCESSING_TIME_TYPE_U8_HOURS: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_U8_HOURS] = $nationality_processing_time_type_price->price; break;
                        case self::$PROCESSING_TIME_TYPE_U4_HOURS: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_U4_HOURS] = $nationality_processing_time_type_price->price; break;
                        case self::$PROCESSING_TIME_TYPE_U2_HOURS: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_U2_HOURS] = $nationality_processing_time_type_price->price; break;
                        case self::$PROCESSING_TIME_TYPE_U30_MIN: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_U30_MIN] = $nationality_processing_time_type_price->price; break;
                        case self::$PROCESSING_TIME_TYPE_U15_MIN: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_U15_MIN] = $nationality_processing_time_type_price->price; break;
                        case self::$PROCESSING_TIME_TYPE_UHoliday: $arr_processing_time_type_price[self::$PROCESSING_TIME_TYPE_UHoliday] = $nationality_processing_time_type_price->price; break;
                    }
                }
            }
            $na->processing_time_type_prices = $arr_processing_time_type_price;
        }
    }
    
    protected function _mapNameAndId($type, $purpose = null) {
        $mapper = $type == 'visa_type' ? new Application_Model_VisaTypeMapper(): new Application_Model_ProcessingTimeTypeMapper();
        $data = $mapper->getAll(0, $purpose == 'BUSINESS VISA' ? 'BUSINESS VISA' : 'TOURIST VISA');
        $map_name_id = array();
        foreach($data as $mm){
            $map_name_id[$mm->name]= $mm ->id;
        }
        return $map_name_id;
    }
    
    protected  function _saveVisaTypeOrProcessingTimeTypePrices($purpose_of_visit, $type, $mapper, $input, $nationality_id){
       
        foreach($input as $v){
            if(strlen(trim($v->price)) == 0){
                $v->price = null;
            }
            if(strlen(trim($v->id)) == 0){
               continue;
            }
            $id = $mapper->getId($purpose_of_visit, $v->id,  $nationality_id);
            //Zend_Debug::dump($id);
            $data = $type == 'visa_type' ? new Application_Model_NationalityVisaType(): new Application_Model_NationalityProcessingTimeType();
            $data->id = $id;
            $data->nationality_id = $nationality_id;
            
            $type == 'visa_type' ? ($data->visa_type_id = $v->id) : ($data->processing_time_type_id = $v->id);
            //$data->visa_type_id = $v->id;
            //$data->processing_time_type_id = $v->id;
            $data->purpose_of_visit = $purpose_of_visit;
            $data->price = $v->price;
            $data->update_date = $this->_helper->CommonUtils->getVnDateTime();
            //Zend_Debug::dump($data);die;
            $mapper->save($data);
        }
    }
    
    public function bookingAction()
    {
        $request = $this->getRequest();
        
        $keyword = $request->getParam('keyword');
        $mapper = new Application_Model_BookTourMapper();
        $bookings = $mapper->search($keyword);
        $this->view->keyword = $keyword;
        //Zend_Debug::dump( $bookings);die();
               
        $this->view->bookings = $bookings;
        //Zend_Debug::dump( $tour);die();
    }
    
    
    public function exemptionAction(){
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
        //Zend_Debug::dump( $visa_setting);die();
        
        $request = $this->getRequest();
        if ($request->isPost()) {           
            $editor_contents =  $request->getParam('editor_contents');
            if(strlen($editor_contents) == 0){
                $this->view->errorMessage = 'Please input data';
                return;
            }
            $model = new Application_Model_VisaSetting();
            $model->name = 'Visa Exemption';
            $model->text = $editor_contents;
            $visa_setting_mapper->save($model);             
            foreach ($_POST as $name => $value) {
               // echo "{$key} = {$value}\r\n";
                
                if (preg_match('/^\d+$/', $value) ) {
                    $model = new Application_Model_VisaSetting();
                    $model->name = $name;
                    $model->text = $value;
                    $visa_setting_mapper->save($model);
                    //die($value);
                }
            }
            $this->redirect('admin/visa/exemption');
            //die();
        }
    }
    
    public function addNationalityExemptionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if (isset($_POST)) {
            //die( $_POST['name']);
            // echo json_encode($_POST['name']);die;
            $model = new Application_Model_VisaSetting();
            $model->name = $_POST['name'];
            $model->text = $_POST['text'];

            $mapper = new Application_Model_VisaSettingMapper();
            $mapper->save($model, true);
            echo json_encode($model);
        }
    }
    
    public function deleteNationalityExemptionAction(){        
        $request = $this->getRequest();
        //Zend_Debug::dump( $request);die();
        $name = $request->getParam('name');
        //die($id);
        $mapper = new Application_Model_VisaSettingMapper();
        $mapper->delete($name);       
        
        $this->redirect('admin/visa/exemption');
    }

}


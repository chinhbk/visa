<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
		 //phpinfo();die('a');
		 // session_start();
        $auth = Zend_Auth::getInstance();
	     
		// Zend_Debug::dump(  $auth->hasIdentity());
     
		// die('abcb');
		 
        if ($auth->hasIdentity()) {
		
            // Identity exists; get it
            $identity = $auth->getIdentity();
            //$this->_redirect('/user/profile/' . $identity->user_id);
            $layout = $this->_helper->layout();
            $layout->setLayout('admin');
        }else{
			 $this->redirect('admin/auth');      
		} 
		
    }

    public function indexAction()
    {
    	 $auth = Zend_Auth::getInstance();
         $identity = $auth->getIdentity();
         //Zend_Debug::dump(  $identity->USER_NAME);die;
         $this->view->user_name = $identity->USER_NAME;


    }
	
	public function contactAction(){
	    
	    $mapper = new Application_Model_SettingMapper();
	    
		$setting = $mapper->get();
		//Zend_Debug::dump( $setting );die();
		$this->view->setting = $setting;
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
								
			$editor_contents =  $request->getParam('editor_contents');
			if(strlen($editor_contents) == 0 || strlen($request->getParam('img_uploaded')) == 0){
			   $this->view->errorMessage = 'Please input data';
			   return;
			}
			
			$setting = new Application_Model_Setting();
			$setting->logo =  $request->getParam('img_uploaded');
			$setting->hotline = $request->getParam('hotline');
			$setting->email = $request->getParam('email');
			$setting->address = $request->getParam('address');
			$setting->contact = $editor_contents;
			$setting->homepage = $request->getParam('homepage');;
		
			$setting_mapper = new Application_Model_SettingMapper();
				
			$setting_mapper->save($setting); //Zend_Debug::dump( $request);die;
			
			$this->redirect('admin/index/contact');
	    }
	}
	
	public function whyUsAction(){
	    
	    $mapper = new Application_Model_SettingMapper();
	    
	    $setting = $mapper->get();
	    //Zend_Debug::dump( $setting );die();
	    $this->view->setting = $setting;
	    
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	        
	        $editor_contents =  $request->getParam('editor_contents');
	        if(strlen($editor_contents) == 0){
	            $this->view->errorMessage = 'Please input data';
	            return;
	        }
	        
	        $setting = new Application_Model_Setting();
	        $setting->whyus = $editor_contents;
	        
	        
	        $setting_mapper = new Application_Model_SettingMapper();
	        
	        $setting_mapper->save($setting); //Zend_Debug::dump( $request);die;
	        
	        $this->redirect('admin/index/why-us');
	    }
	}
	
	public function tourTermAction(){
	    
	    $mapper = new Application_Model_SettingMapper();
	    
	    $setting = $mapper->get();
	    //Zend_Debug::dump( $setting );die();
	    $this->view->setting = $setting;
	    
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	        
	        $editor_contents =  $request->getParam('editor_contents');
	        if(strlen($editor_contents) == 0){
	            $this->view->errorMessage = 'Please input data';
	            return;
	        }
	        
	        $setting = new Application_Model_Setting();
	        $setting->tourterm = $editor_contents;
	        
	        
	        $setting_mapper = new Application_Model_SettingMapper();
	        
	        $setting_mapper->save($setting); //Zend_Debug::dump( $request);die;
	        
	        $this->redirect('admin/index/tour-term');
	    }
	}
	
	public function visaTermAction(){
	    
	    $mapper = new Application_Model_SettingMapper();
	    
	    $setting = $mapper->get();
	    //Zend_Debug::dump( $setting );die();
	    $this->view->setting = $setting;
	    
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	        
	        $editor_contents =  $request->getParam('editor_contents');
	        if(strlen($editor_contents) == 0){
	            $this->view->errorMessage = 'Please input data';
	            return;
	        }
	        
	        $setting = new Application_Model_Setting();
	        $setting->visaterm = $editor_contents;
	        
	        
	        $setting_mapper = new Application_Model_SettingMapper();
	        
	        $setting_mapper->save($setting); //Zend_Debug::dump( $request);die;
	        
	        $this->redirect('admin/index/visa-term');
	    }
	}
	
	
	public function visaStepAction(){
	    
	    $mapper = new Application_Model_SettingMapper();
	    
	    $setting = $mapper->get();
	    //Zend_Debug::dump( $setting );die();
	    $this->view->setting = $setting;
	    
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	        
	        $editor_contents =  $request->getParam('editor_contents');
	        if(strlen($editor_contents) == 0){
	            $this->view->errorMessage = 'Please input data';
	            return;
	        }
	        
	        $setting = new Application_Model_Setting();
	        $setting->visastep = $editor_contents;
	        	       
	        $setting_mapper = new Application_Model_SettingMapper();
	        
	        $setting_mapper->save($setting); //Zend_Debug::dump( $request);die;
	        
	        $this->redirect('admin/index/visa-step');
	    }
	}
	
	public function visaFaqAction(){
	    
	    $mapper = new Application_Model_SettingMapper();
	    
	    $setting = $mapper->get();
	    //Zend_Debug::dump( $setting );die();
	    $this->view->setting = $setting;
	    
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	        
	        $editor_contents =  $request->getParam('editor_contents');
	        if(strlen($editor_contents) == 0){
	            $this->view->errorMessage = 'Please input data';
	            return;
	        }
	        
	        $setting = new Application_Model_Setting();
	        $setting->visafaq = $editor_contents;
	        
	        $setting_mapper = new Application_Model_SettingMapper();
	        
	        $setting_mapper->save($setting); //Zend_Debug::dump( $request);die;
	        
	        $this->redirect('admin/index/visa-faq');
	    }
	}
	
	
	public function introAction(){
		$intro_mapper = new Application_Model_IntroMapper();
	
		$intro = $intro_mapper->getIntro();
			//die('ssssssssss');
		//Zend_Debug::dump( $contact );die();
		$this->view->intro = $intro;
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			
			
			$id =  $request->getParam('intro_id');
			$editor_contents =  $request->getParam('editor_contents');
			
			//Zend_Debug::dump( $editor_contents );die();
			
			if(strlen($editor_contents) == 0){
			   $this->view->errorMessage = 'Lỗi nhập thiếu dữ liệu';
			   return;
			}
			
			$edit_intro = new Application_Model_Intro();
			$edit_intro->id = $id;
			$edit_intro->text = $editor_contents;
		
		
			$intro_mapper = new Application_Model_IntroMapper();
			//	Zend_Debug::dump( $edit_intro);die;
			$intro_mapper->save($edit_intro); //
			
			$this->redirect('admin/index/intro');
	    }
	}
}


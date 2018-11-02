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
		$contact_mapper = new Application_Model_ContactMapper();
	
		$contact = $contact_mapper->getContact();
			//die('ssssssssss');
		//Zend_Debug::dump( $contact );die();
		$this->view->contact = $contact;
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			
			
			$id =  $request->getParam('contact_id');
			$editor_contents =  $request->getParam('editor_contents');
			if(strlen($editor_contents) == 0){
			   $this->view->errorMessage = 'Lỗi nhập thiếu dữ liệu';
			   return;
			}
			
			$edit_contact = new Application_Model_Contact();
			$edit_contact->id = $id;
			$edit_contact->text = $editor_contents;
		
		
			$contact_mapper = new Application_Model_ContactMapper();
				
			$contact_mapper->save($edit_contact); //Zend_Debug::dump( $request);die;
			
			$this->redirect('admin/index/contact');
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


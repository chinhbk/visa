<?php

class Admin_UserController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $identity = $auth->getIdentity();
			$this->view->user_name = $identity->USER_NAME;
            $layout = $this->_helper->layout();
            $layout->setLayout('admin');
        } else {
           $this->redirect('admin/auth');
        }
      
    }
    
    public function changePassAction()
    {
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$input_old_pass = $request->getParam('old_pass');
    		$new_pass = $request->getParam('new_pass');
    		$confirm_new_pass = $request->getParam('confirm_new_pass');
    		$auth = Zend_Auth::getInstance();
    		$identity = $auth->getIdentity();
    		
    		if($identity->PASSWORD != md5($input_old_pass)){
    			$this->view->errorMessage = 'Wrong current password';
    			return;
    		}elseif(strlen($new_pass) == 0 || $new_pass != $confirm_new_pass){
    			$this->view->errorMessage = 'New password and confirm new password must be identical';
    			return;
    		}
    		$enpass = md5($new_pass);
    		$user_mapper = new Application_Model_UserMapper();
    		$user_mapper->changePass($identity->ID, $enpass);
    		$this->redirect('admin/auth/logout');
    	}
    }

}


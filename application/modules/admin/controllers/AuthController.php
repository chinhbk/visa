<?php

class Admin_AuthController extends Zend_Controller_Action
{
    public function preDispatch(){
        $this->_helper->layout()->disableLayout(); 
        //$this->_helper->viewRenderer->setNoRender(true);
    }

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //$form = new Admin_Form_Login();
        $request = $this->getRequest();
		
        if ($request->isPost()) {
        
			//Zend_Debug::dump(  $request->getPost());
        
			$user_name =  $request->getParam('user_name');
            $password =  $request->getParam('password');
            $isValid = $user_name != '' && $password != '' ? true : false;
            
			if ($isValid) {
			
                if ($this->_process($user_name, $password )) {
                    // We're authenticated! Redirect to the home page
                	$auth = Zend_Auth::getInstance();
                	$identity = $auth->getIdentity();
                	switch ($identity->ROLE) {
                		case 1: //admin_product                		   
                		     $this->_helper->redirector('index', 'product');;
                			 break;
                		case 2: //admin_order
                			$this->_helper->redirector('index', 'order');;
                			break;
                		case 3: //admin_news
                				$this->_helper->redirector('index', 'news');;
                				break;
                		default: //super admin
                			$this->_helper->redirector('index', 'index');;;
                			break;
                	}
                    
                }else{
                    $this->view->errorMessage = "Invalid user name or password. Please try again.";
                }
            }else{
                $this->view->errorMessage = "User name or password must be non-blank.";
            }
        }

        //$this->view->form = $form;
    }

    protected function _process($user_name, $password)
    { 
	
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($user_name);
        $adapter->setCredential($password);

        $auth = Zend_Auth::getInstance();
        //echo $values['username'] . '===' . $values['password'];die;

        $result = $auth->authenticate($adapter);

        if ($auth->hasIdentity()) { // user is logged in
            // server should keep session data for AT LEAST 1 hour
            ini_set('session.gc_maxlifetime', 3600);
            
            // each client should remember their session id for EXACTLY 1 hour
            session_set_cookie_params(3600);
            
            session_start(); // ready to go!
            // get an instance of Zend_Session_Namespace used by Zend_Auth
            $authns = new Zend_Session_Namespace($auth->getStorage()->getNamespace());
            
            // set an expiration on the Zend_Auth namespace where identity is held
            $authns->setExpirationSeconds(60 * 30);  // expire auth storage after 30 min
        }
        
        if ($result->isValid()) {                     
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }

        return false;
    }

    protected function _getAuthAdapter()
    {       
		$dbAdapter = Zend_Registry::get("db");
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('USER')
                    ->setIdentityColumn('USER_NAME')
                    ->setCredentialColumn('PASSWORD');
                    //->setCredentialTreatment('SHA1(CONCAT(?,SALT))'); raw password // add security later

        return $authAdapter;
    }
    
    public function accessDenied()
    {
    	
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('auth', 'index'); // back to login page
    }

}




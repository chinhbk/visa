<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDb(){
        // get config from config/application.ini
        $config = $this->getOptions();

        $db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);

        //set default adapter
        Zend_Db_Table::setDefaultAdapter($db);

        //save Db in registry for later use
        Zend_Registry::set("db", $db);
        
        Zend_Controller_Action_HelperBroker::addPath(
        		APPLICATION_PATH .'/helpers');
		
    }
	
     /**
     * Start session
     */
    public function _initCoreSession()
    {
        $this->bootstrap('db');
        $this->bootstrap('session');
        
        
      
        Zend_Session::start();
       
    }
	
	protected function _initResourceAutoloader()
{
		 $autoloader = new Zend_Loader_Autoloader_Resource(array(
			'basePath'  => APPLICATION_PATH,
			'namespace' => 'Application',
		 ));

		 $autoloader->addResourceType( 'model', 'models', 'Model');
		 return $autoloader;
	}
	
	protected function _initConstants()
	{
		$registry = Zend_Registry::getInstance();
		$registry->constants = new Zend_Config( $this->getApplication()->getOption('constants') );
	}
	
	public function _initRoute()

    {
        //TOUR LINKS
        // get instance of front controller
        $frontController = Zend_Controller_Front::getInstance();

        // to retrive it $this->getRequest->getParam(‘id)

        // in the index action of product controller
        // tour/10-hanoi.html
        $route = new Zend_Controller_Router_Route_Regex(
            // The pattern this route matches
            '([a-z0-9-*()]+)/([a-z0-9-*()]+)/([\d]+)', 
            // Configure controller/action
            array(
                'action' => 'tour-detail',
                'controller' => 'index'
            ), 
            // Map the subpatterns to params
            array(

                1 => 'parent_name',

                2 => 'name',
                
                3 => 'id'
            ), 

            // Reverse map used when assembling the route
            'tour/%d-%s');

        $frontController->getRouter()->addRoute('tour-detail', $route);

        // tour-menu
        $route_tour_menu = new Zend_Controller_Router_Route_Regex(
            // The pattern this route matches
            '([a-z0-9-*()]+)/([\d]+)', 
            // Configure controller/action
            array(
                'action' => 'tour-menu',
                'controller' => 'index'
            ), 
            // Map the subpatterns to params
            array(

                1 => 'name',

                2 => 'id'
            ), 

            // Reverse map used when assembling the route
            'tours/%d-%s');
        $frontController->getRouter()->addRoute('tour-menu', $route_tour_menu);
        
        
        $route_tour_book = new Zend_Controller_Router_Route_Regex(
            // The pattern this route matches
            'booking/([a-z0-9-*()]+)/([\d]+)/([\d]+)',
            // Configure controller/action
            array(
                'action' => 'tour-book',
                'controller' => 'index'
            ),
            // Map the subpatterns to params
            array(
                
                1 => 'name',
                
                2 => 'id',
                
                3 => 'price'
            ),
            
            // Reverse map used when assembling the route
            'tour-book/%d-%s');
            $frontController->getRouter()->addRoute('tour-book', $route_tour_book);
            
            $route_tour_term = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'tour-term-condition',
                // Configure controller/action
                array(
                    'action' => 'tour-term-condition',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('tour-term-condition', $route_tour_term);
            
            //GENERAL
            $route_why_us = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'why-us',
                // Configure controller/action
                array(
                    'action' => 'why-us',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('why-us', $route_why_us);
            
            
            $route_contact_us = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'contact-us',
                // Configure controller/action
                array(
                    'action' => 'contact-us',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('contact-us', $route_contact_us);
            
            
            
            //VISA
            $route_visa = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'visa-apply-online',
                // Configure controller/action
                array(
                    'action' => 'apply-online',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('visa-apply-online', $route_visa);
            
            $route_visa_step = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'visa-step',
                // Configure controller/action
                array(
                    'action' => 'visa-step',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('visa-step', $route_visa_step);
            
            $route_visa_faq = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'visa-faq',
                // Configure controller/action
                array(
                    'action' => 'visa-faq',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('visa-faq', $route_visa_faq);            
            
            $route_visa_service = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'visa-service',
                // Configure controller/action
                array(
                    'action' => 'visa-service',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('visa-service', $route_visa_service);
                        
            $route_visa_term = new Zend_Controller_Router_Route_Regex(
                // The pattern this route matches
                'visa-term-condition',
                // Configure controller/action
                array(
                    'action' => 'visa-term-condition',
                    'controller' => 'index'
                ));
            
            $frontController->getRouter()->addRoute('visa-term-condition', $route_visa_term);
                
    }
	
} 
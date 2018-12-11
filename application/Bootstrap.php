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

        // get instance of front controller
        $frontController = Zend_Controller_Front::getInstance();

        // to retrive it $this->getRequest->getParam(‘id)

        // in the index action of product controller
        // tour/10-hanoi.html
        $route = new Zend_Controller_Router_Route_Regex(
            // The pattern this route matches
            'tour/([\d]+)-([a-z0-9-*()]+)', 
            // Configure controller/action
            array(
                'action' => 'tour-detail',
                'controller' => 'index'
            ), 
            // Map the subpatterns to params
            array(

                1 => 'id',

                2 => 'name'
            ), 

            // Reverse map used when assembling the route
            'tour/%d-%s');

        $frontController->getRouter()->addRoute('tour-detail', $route);

        // tour-menu
        $route_tour_menu = new Zend_Controller_Router_Route_Regex(
            // The pattern this route matches
            'tours/([\d]+)-([a-z0-9-*()]+)', 
            // Configure controller/action
            array(
                'action' => 'tour-menu',
                'controller' => 'index'
            ), 
            // Map the subpatterns to params
            array(

                1 => 'id',

                2 => 'name'
            ), 

            // Reverse map used when assembling the route
            'tours/%d-%s');
        $frontController->getRouter()->addRoute('tour-menu', $route_tour_menu);
        
        
        $route_tour_book = new Zend_Controller_Router_Route_Regex(
            // The pattern this route matches
            'tour-book/([\d]+)-([a-z0-9-*()]+)',
            // Configure controller/action
            array(
                'action' => 'tour-book',
                'controller' => 'index'
            ),
            // Map the subpatterns to params
            array(
                
                1 => 'id',
                
                2 => 'name'
            ),
            
            // Reverse map used when assembling the route
            'tour-book/%d-%s');
            $frontController->getRouter()->addRoute('tour-book', $route_tour_book);
    }
	
} 
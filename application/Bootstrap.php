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
	
	
} 
<?php
//echo getcwd();die;
//var_dump(ini_get('upload_tmp_dir'));die;
define('APPLICATION_PATH', 
              realpath(dirname(__FILE__) . '/application'));
define('ROOT_PATH', dirname(__DIR__));
define('APPLICATION_ENV','production'); 
set_include_path(APPLICATION_PATH . '/../library'); 
require_once 'Zend/Application.php' ;
$application = new Zend_Application( 
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini' 
); 
$application->bootstrap()->run();


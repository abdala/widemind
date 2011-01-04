<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }
    
    public function _initConstants()
    {
        date_default_timezone_set('America/Sao_Paulo');
        define('SYSTEM_ID', 6);
        define('APP_CHARSET', 'UTF-8');
        define('URL_JAVASCRIPT_LIBRARY', '/javascript/');
        define('URL_IMAGE', false);
        define('UPLOAD', APPLICATION_PATH . '/../data/uploads/');
        define('DEFAULT_THEME', 'cupertino');
    }

    public function _initRenames()
    {
        $rename = new Zend_Translate('csv', APPLICATION_PATH . '/../data/rename.csv');
        Zend_Registry::set('rename' , $rename);
    }
}
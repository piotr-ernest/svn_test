<?php


/**
 * Description of Bootstrap
 *
 * @author rnest
 */
class Frontend_Bootstrap extends Zend_Application_Module_Bootstrap
{

    protected function _initFront()
    {
        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin(new CloutWork_Plugin_ACL());
                
    }

    protected function _initRouter()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $config = new Zend_Config(include APPLICATION_PATH . '/configs/frontend_routes.php');
        //desc($config, 1);
        $router->addConfig($config, 'routes');
    }

    protected function _initGlobals()
    {
        $config = new CloutWork_Config(null, 'frontend');
        $frontendConfig = $config->getFrontend();

        Zend_Registry::getInstance()->set('frontendConfig', $frontendConfig);
        
        $dbConfig = $frontendConfig->resources->db;
        $adapter = (string) $dbConfig->adapter;
        $db = Zend_Db::factory($adapter, (array) $dbConfig->params);
        Zend_Registry::set('db', $db);
        
        $jsGlobals = array(
            'baseUrl' => $frontendConfig->url
        );
        
        Zend_Registry::getInstance()->set('baseUrl', $frontendConfig->url);
        Zend_Registry::getInstance()->set('jsGlobals', $jsGlobals);
        
    }

    protected function _initAuth()
    {
        $auth = Zend_Auth::getInstance();
        $namespace = Zend_Auth_Storage_Session::NAMESPACE_DEFAULT . '_Frontend';
        $auth->setStorage(new Zend_Auth_Storage_Session($namespace));
    }

}

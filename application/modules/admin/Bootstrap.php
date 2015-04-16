<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author rnest
 */
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{

    protected function _initAdmin()
    {
        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin(new CloutWork_Admin_Plugin_ACL());

        $config = new CloutWork_Config(APPLICATION_PATH . '/configs/modules', 'panel');
        $modules = $config->getModules();
        Zend_Registry::set('modules', $modules);
    }

    protected function _initRouter()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $config = new Zend_Config(include APPLICATION_PATH . '/configs/admin_routes.php');
        $router->addConfig($config, 'routes');
    }

    protected function _initGlobals()
    {
        $config = new CloutWork_Config(null, 'admin');
        $adminConfig = $config->getAdmin();

        Zend_Registry::getInstance()->set('adminConfig', $adminConfig);
        $baseConfig = Zend_Registry::get('adminConfig');
        Zend_Registry::set('baseUrl', $baseConfig->url);
        
        $dbConfig = $adminConfig->resources->db;
        $adapter = (string) $dbConfig->adapter;
        $db = Zend_Db::factory($adapter, (array) $dbConfig->params);
        Zend_Registry::set('db', $db);
        
    }

    protected function _initAuth()
    {
        $auth = Zend_Auth::getInstance();
        $namespace = Zend_Auth_Storage_Session::NAMESPACE_DEFAULT . '_Admin';
        $auth->setStorage(new Zend_Auth_Storage_Session($namespace));
    }

}

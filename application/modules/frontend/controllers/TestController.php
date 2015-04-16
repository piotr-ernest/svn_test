<?php

/**
 * Description of TestController
 *
 * @author rnest
 */
class TestController extends CloutWork_Controller_Action
{
    public function indexAction()
    {
        $config = new CloutWork_Config(null, 'frontend');
        $frontend = $config->getFrontend();
        $this->view->config_db = $frontend->resources->frontController->controllerDirectory;
        
    }
    
    public function blueAction()
    {
        $path = Core_Tools::getBaseUrl();
        $root = Core_Tools::getRootPath();
        desc($root);
        desc($path);
    }
    
}

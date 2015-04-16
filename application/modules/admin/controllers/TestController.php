<?php

/**
 * Description of TestController
 *
 * @author rnest
 */
class TestController extends CloutWork_Admin_Controller_Action
{
    public function indexAction()
    {
        $config = new CloutWork_Config(null, 'admin');
        $frontend = $config->getAdmin();
        $this->view->config_db = $frontend->resources->frontController->controllerDirectory;
        
    }
    
    public function editAction()
    {
        
    }
    
    public function deleteAction()
    {
        
    }
    
}

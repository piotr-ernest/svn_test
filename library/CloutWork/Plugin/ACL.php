<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ACL
 *
 * @author rnest
 */
class CloutWork_Plugin_ACL extends Zend_Controller_Plugin_Abstract
{

    protected $acl;
    protected $auth;
    protected $identity;

    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);

        $config = new CloutWork_Config(null, 'frontend');
        $authConfig = $config->getFrontend();
        $forced = $authConfig->authentication->force;

        if ($forced) {

            $this->acl = new Zend_Acl();
            $this->auth = Zend_Auth::getInstance();
            $this->identity = $this->auth->getIdentity();

            $this->acl->addRole(new Zend_Acl_Role('guest'));
            $this->acl->addRole(new Zend_Acl_Role('member'), 'guest');
            $this->acl->addRole(new Zend_Acl_Role('admin'), 'member');
            $this->acl->addRole(new Zend_Acl_Role('general'), 'admin');

//            $this->acl->addResource(new Zend_Acl_Resource('error'));
//            $this->acl->addResource(new Zend_Acl_Resource('index'));
//            $this->acl->addResource(new Zend_Acl_Resource('start'));
//            $this->acl->addResource(new Zend_Acl_Resource('test'));
            
            $this->addResources($this->getResources());
            $this->acl->addResource(new Zend_Acl_Resource('public'));

            $this->acl->allow(null, array('error', 'start', 'public', 'categories', 'comments', 'validate'));
            $this->acl->allow(null, 'index', array('unauthorized', 'index', 'show'));

//        $this->acl->allow('member', 'index', array('index'));
//        $this->acl->allow('member', 'index', array('blue'));
//        $this->acl->allow('member', 'index', array('unauthorized'));
            //$this->acl->allow('admin', 'test', array('index', 'blue'));

            $this->acl->deny('member', 'test');
            $this->acl->deny('member', 'index', array('red'));

            $this->acl->allow('admin', 'test');
            $this->acl->allow('admin', null);
            $this->acl->allow('general', null);

            if ($this->auth->hasIdentity()) {

                $role = $this->getRole($this->identity);
                
            } else {
                $role = 'guest';
            }

            $ctrl = $request->getControllerName();
            $action = $request->getActionName();

            if (!$this->acl->isAllowed($role, strtolower($ctrl), $action)) {
                
                if ($role == 'guest') {
                    $request->setControllerName('start');
                    $request->setActionName('choice');
                }

                if ($role == 'member') {
                    $request->setControllerName('index');
                    $request->setActionName('unauthorized');
                }

                if ($role == 'admin') {
                    $request->setControllerName('index');
                    $request->setActionName('unauthorized');
                }
            }
        }
    }

    protected function getRole($identity)
    {
        $model = new CloutWork_Model_Customers();
        $res = $model->getRoleByUserName($identity);
        return $res['role'];
    }

    protected function getResources($module = 'frontend')
    {
        $resourcesPath = Core_Tools::getRootPath() . '/application/modules/frontend/controllers';
        if($module != 'frontend'){
            $resourcesPath = $module;
        }
        
        $rowFiles = scandir($resourcesPath);
        $files = array();
        while($rowFile = each($rowFiles)){
            if($rowFile['value'] != '.' && $rowFile['value'] != '..'){
                $name = str_replace('Controller', '', $rowFile['value']);
                $name = str_replace('.php', '', $name);
                $files[] = strtolower($name);
            }
        }
        return $files;
    }

    protected function addResources($resources)
    {
        for($i = 0; $i < count($resources); $i++){
            $this->acl->addResource(new Zend_Acl_Resource($resources[$i]));
        }
    }

}

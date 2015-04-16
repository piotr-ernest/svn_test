<?php


/**
 * Description of ACL
 *
 * @author rnest
 */
class CloutWork_Admin_Plugin_ACL extends Zend_Controller_Plugin_Abstract
{

    protected $acl;
    protected $auth;
    protected $identity;

    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);

        $config = new CloutWork_Config(null, 'admin');
        $authConfig = $config->getAdmin();
        $forced = $authConfig->authentication->force;

        if ($forced) {

            $this->acl = new Zend_Acl();
            $this->auth = Zend_Auth::getInstance();
            $this->identity = $this->auth->getIdentity();

            $this->acl->addRole(new Zend_Acl_Role('guest'), null);
            $this->acl->addRole(new Zend_Acl_Role('admin'), 'guest');
            $this->acl->addRole(new Zend_Acl_Role('general'), 'admin');

            $resourcesPath = Core_Tools::getRootPath() . '/application/modules/admin/controllers';
            $this->addResources($this->getResources($resourcesPath));

//            $this->acl->allow(null, array('error', 'start'));
//            $this->acl->allow(null, 'panel', array('unauthorized', 'index'));

            $this->acl->deny('guest', 'start');
            $this->acl->deny('admin', 'start', array('register'));

            $this->acl->allow('admin', 'start', array('login', 'logout'));
            $this->acl->allow('admin', 'panel');
            $this->acl->allow('general', null);

            if ($this->auth->hasIdentity()) {

                $role = $this->getRole($this->identity);
            } else {
                $role = 'guest';
            }

            $ctrl = $request->getControllerName();
            $action = $request->getActionName();

            if (!$this->acl->isAllowed($role, strtolower($ctrl), strtolower($action))) {

                if ($role == 'guest') {
                    $request->setControllerName('start');
                    $request->setActionName('login');
                }

                if ($role == 'admin') {
                    $request->setControllerName('panel');
                    $request->setActionName('unauthorized');
                }
            }
        }
    }

    protected function getRole($identity)
    {
        $model = new CloutWork_Admin_Model_Administration();
        $res = $model->getRoleByUserName($identity);
        return $res['role'];
    }

    protected function getResources($module = 'frontend')
    {
        $resourcesPath = Core_Tools::getRootPath() . '/application/modules/frontend/controllers';
        if ($module != 'frontend') {
            $resourcesPath = $module;
        }
        
        // Jest problem z kamelkami w nazwie kontrolera/zasobu -
        // Aby Apache nie wyrzucał błędu przy nazwie np: ArticlesRelated (skrypt widoku musi byc w folderze articles-related)
        // (windows toleruje, *nix już nie)
        // trzeba wstawić do nazwy zasobu znak - i duże litery zamienić na małe - ACL przyjmuje małe tylko
        $rowFiles = scandir($resourcesPath);
        $files = array();
        while ($rowFile = each($rowFiles)) {
            if ($rowFile['value'] != '.' && $rowFile['value'] != '..') {
                $name = str_replace('Controller', '', $rowFile['value']);
                $name = str_replace('.php', '', $name);
                $name = lcfirst($name);

                if (preg_match('/[A-Z]/', $name, $matches, PREG_OFFSET_CAPTURE)) {
                    while ($match = each($matches)) {
                        $newname = substr_replace($name, '-', $match['value'][1], 0);
                        $files[] = strtolower($newname);
                    } 
                } else {
                    $files[] = strtolower($name);
                }
            }
        }
        //desc($files);
        return $files;
    }

    protected function addResources($resources)
    {
        for ($i = 0; $i < count($resources); $i++) {
            $this->acl->addResource(new Zend_Acl_Resource($resources[$i]));
        }
    }

}

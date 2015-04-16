<?php

/**
 * Description of Action
 *
 * @author rnest
 */
class CloutWork_Admin_Controller_Action extends Zend_Controller_Action
{

    protected $formAction = null;
    protected $auth = null;
    protected $identity = false;
    protected $fm;

    public function init()
    {
        parent::init();
        
        $this->fm = $this->_helper->getHelper('FlashMessenger');
        $info = $this->getInfo();
        if (!empty($info)) {
            $this->view->messages = $this->getInfo();
        }
    }

    public function preDispatch()
    {
        $config = new CloutWork_Config(null, 'admin');
        $authConfig = $config->getAdmin();
        $secured = $authConfig->authorization->is_secure;
        

        if ($secured) {
            $auth = Zend_Auth::getInstance();

            if ($auth->hasIdentity()) {

                $this->identity = $auth->getIdentity();
                $this->view->identity = $this->identity;
                //$this->info('Witaj, ' . $this->identity . '.');
            } else {
                $this->info('Zaloguj się lub zarejestruj.');
                return $this->_helper->redirector('choice', 'start', 'default');
            }
        }
    }

    protected function info($message = '')
    {
        $this->fm->addMessage($message);
    }

    protected function getInfo()
    {
        return $this->fm->getMessages();
    }

}

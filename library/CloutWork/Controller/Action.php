<?php

/**
 * Description of Action
 *
 * @author rnest
 */
class CloutWork_Controller_Action extends Zend_Controller_Action
{
    /**
     * @description
     * Akcja akcji formularza
     * @var string $formAction
     */
    protected $formAction = null;
    protected $auth = null;
    protected $identity = false;
    protected $fm;
    
    public function init()
    {
        parent::init();
        
        $this->fm = $this->_helper->getHelper('FlashMessenger');
        
        if (!empty($this->getInfo())) {
            $this->view->messages = $this->getInfo();
        }
    }


    public function preDispatch()
    {

        $config = new CloutWork_Config(null, 'frontend');
        $authConfig = $config->getFrontend();
        $secured = $authConfig->authorization->is_secure;

        if ($secured) {
            $auth = Zend_Auth::getInstance();

            if ($auth->hasIdentity()) {
                
                $this->identity = $auth->getIdentity();
                $this->view->identity = $this->identity;
                $view = Zend_Layout::getMvcInstance()->getView();
                $view->assign('identity', $this->identity);
                
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

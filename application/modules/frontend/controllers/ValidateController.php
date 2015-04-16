<?php

/**
 * Description of ValidateController
 *
 * @author rnest
 */
class ValidateController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $v = $this->_getParam('v', 0);

        $model = new CloutWork_Model_Validate();
        $customer = $model->getCustomerByV($v);
        
        if (count($customer) !== 1) {
            $this->info('Błędna rejestracja.');
            $this->_helper->redirector('index', 'index', 'default');
            exit;
        }

        if ($customer[0]['validation'] == 'expired') {
            $this->info('Token został już wykorzystany.');
            $this->_helper->redirector('index', 'index', 'default');
            exit;
        }

        $result = $model->setStatus(1, $customer[0]['id']);

        if (!$result) {
            $this->info('Błąd podczas rejestracji. Nie można się zalogować. Spróbuj ponownie później.');
            $this->_helper->redirector('index', 'index', 'default');
            exit;
        }

        $result = $model->setValidateExpired($customer[0]['id']);

        if ($result) {
            $this->info('Rejestracja prawidłowa można się zalogować.');
            $this->_helper->redirector('login', 'start', 'default');
            exit;
        }

        $this->info('Błąd podczas rejestracji. Spróbuj ponownie później.');
        $this->_helper->redirector('index', 'index', 'default');
        exit;
    }

    protected function info($message = '')
    {
        $fm = $this->_helper->getHelper('FlashMessenger');
        $fm->addMessage($message);
    }

    protected function getInfo()
    {
        $fm = $this->_helper->getHelper('FlashMessenger');
        return $fm->getMessages();
    }

}

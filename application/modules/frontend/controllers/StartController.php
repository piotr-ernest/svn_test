<?php

/**
 * Description of StartController
 *
 * @author rnest
 */
class StartController extends Zend_Controller_Action
{

    public function init()
    {
        parent::init();
        $this->view->messages = $this->getInfo();
    }

    public function choiceAction()
    {
        
    }

    public function loginAction()
    {

        $form = new CloutWork_Form_Login();
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getParams();

            $id = $this->_getParam('id', 0);
            $categoryId = $this->_getParam('category-id', 0);
            $page = $this->_getParam('page', 1);
            $action = $this->_getParam('a', 'index');
            $controller = $this->_getParam('c', 'index');

            $paramsRedirect = array(
                'id' => $id,
                'category-id' => $categoryId,
                'page' => $page
            );

            if ($form->isValid($post)) {

                $validateModel = new CloutWork_Model_Validate();
                $status = $validateModel->getStatusByUsername($post['username']);
                
                if (!$status) {
                    $this->info('Logowanie nieudane. Sprawdź swoje dane logowania lub się zarejestruj.');
                    $this->_helper->redirector('choice', 'start', 'default');
                }
                
                if ((int) $status['status'] !== 1) {
                    $this->info('Logowanie nieudane. Potwierdź adres email, wiadomość powinna być w Twojej skrzynce pocztowej email.');
                    $this->_helper->redirector('choice', 'start', 'default');
                }

                $authAdapter = new Zend_Auth_Adapter_DbTable(
                        null, 'customers', 'username', 'password', 'MD5(CONCAT(?, saltz))'
                );

                $authAdapter->setIdentity($post['username']);
                $authAdapter->setCredential($post['password']);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {

                    $this->info('Zalogowano.');
                    $this->_helper->redirector($action, $controller, 'default', $paramsRedirect);
                } else {

                    $this->info('Logowanie nieudane. Sprawdź hasło i/lub login oraz spróbuj pownownie.');
                    $this->_helper->redirector('choice', 'start', 'default');
                }
            } else {

                $this->view->errors = $form->getMessages();
            }
        }
    }

    public function registerAction()
    {
        $form = new CloutWork_Form_Register();
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $params = $this->getRequest()->getParams();
            $validation = uniqid();

            if (!$params) {
                return;
            }

            $id = $this->_getParam('id', 0);
            $categoryId = $this->_getParam('category-id', 0);
            $page = $this->_getParam('page', 1);
            $action = $this->_getParam('a', 'index');
            $controller = $this->_getParam('c', 'index');

            $paramsRedirect = array(
                'id' => $id,
                'category-id' => $categoryId,
                'page' => $page
            );

            if ($form->isValid($params)) {

                $newParams = array_merge($params, array('validation' => $validation));
                $link = Zend_Registry::get('baseUrl') . '/validate/index/v/' . $validation;

                $message = "<p>"
                        . "W celu weryfikacji Twojego konta email, kliknij w poniższy link:"
                        . "</p>"
                        . "<p>"
                        . "<a href='" . $link . "'>Potwierdź adres email</a>"
                        . "</p>";
                $recipient = $params['email'];

                $model = new CloutWork_Model_Register();
                $id = $model->save($newParams);

                if (!$id) {
                    $this->info('Błąd dodawania konta.');
                    $this->_helper->redirector('start', 'register', 'default');
                }

                $this->verificationMail($message, $recipient);

                $this->info('Rejestracja prawidłowa. Proszę sprawdzić swoją skrzynkę email oraz potwierdzić adres email.');
                $this->_helper->redirector($action, $controller, 'default', $paramsRedirect);
            } else {
                $this->view->errors = $form->getMessages();
            }
        }
    }

    public function logoutAction()
    {

        $id = $this->_getParam('id', 0);
        $categoryId = $this->_getParam('category-id', 0);
        $page = $this->_getParam('page', 1);
        $action = $this->_getParam('a', 'index');
        $controller = $this->_getParam('c', 'index');
        $params = array(
            'id' => $id,
            'category-id' => $categoryId,
            'page' => $page
        );

        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->info('Wylogowano prawidłowo.');
        $this->_helper->redirector($action, $controller, 'default', $params);
    }

    public function unauthorizedAction()
    {
        
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

    protected function verificationMail($message, $recipient)
    {
        $mail = new CloutWork_Mail('frontend');
        $mail->setLayoutScript('verification');
        $mail->setSenderName('Administracja');
        $mail->setRecipient($recipient);
        $mail->setSubTitle('Weryfikacja rejestracji ' . date('Y-m-d H:i:s', time()));
        $mail->sendMessage($message);
    }

}

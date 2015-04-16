<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
        $this->_helper->layout->setLayoutPath(APPLICATION_PATH . '/layouts/scripts/admin/login/');
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

            if ($form->isValid($post)) {

                $authAdapter = new Zend_Auth_Adapter_DbTable(
                        null, 'administration', 'username', 'password', 'MD5(CONCAT(?, saltz))'
                );

                $authAdapter->setIdentity($post['username']);
                $authAdapter->setCredential($post['password']);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {

                    $this->info('Zalogowano.');
                    $this->_helper->redirector('index', 'panel', 'default');
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
        $form = new CloutWork_Admin_Form_Register();
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $params = $this->getRequest()->getParams();

            if (!$params) {
                return;
            }

            if ($form->isValid($params)) {
                $model = new CloutWork_Admin_Model_Register();
                $id = $model->save($params);

                if (!$id) {
                    $this->info('Błąd dodawania konta.');
                    $this->_helper->redirector('panel', 'index', 'default');
                }

                $this->info('Rejestracja prawidłowa. Można się zalogować.');
                $this->_helper->redirector('login', 'start', 'default');
            } else {
                $this->view->errors = $form->getMessages();
            }
        }
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->info('Wylogowano prawidłowo.');
        $this->_helper->redirector('choice', 'start', 'default');
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

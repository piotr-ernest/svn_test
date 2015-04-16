<?php

/**
 * Description of CommentsController
 *
 * @author rnest
 */
class CommentsController extends CloutWork_Controller_Standard
{

    public function indexAction()
    {
        
    }

    public function insertAction()
    {

        $this->_helper->layout->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);

        if ($this->getRequest()->isPost()) {

            $modelComments = new CloutWork_Model_Comments();
            $form = new CloutWork_Form_Comments_Input();

            $params = $this->getRequest()->getParams();
            $data = array();

            if ($identity = Zend_Auth::getInstance()->getIdentity()) {

                $data['customer_username'] = $identity;
                $data['date_created'] = time();
                $data['status'] = 1;
                $data['article_id'] = (int) $params['id'];
                $data['title'] = $params['title'];
                $data['content'] = $params['content'];
            }

            if ($form->isValid($data)) {

                $result = $modelComments->insertComment($data);

                if ($result > 0) {

                    $messages = 'Komentarz został zapisany.';
                    $this->redirectTo($params, null, $messages);
                } else {
                    $errors = 'Błąd zapisu komentarza.';
                    $this->redirectTo($params, $errors);
                }
            } else {
                
                $errors = $form->getMessages();
                $this->redirectTo($params, $errors);
            }
        }
    }

    public function loginAction()
    {
        
    }

}

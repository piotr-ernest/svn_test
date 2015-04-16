<?php


/**
 * Description of CookiesController
 *
 * @author rnest
 */
class CookiesController extends CloutWork_Controller_Standard
{
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();
        $this->_helper->layout()->disableLayout();
        Zend_Session::start();
        setcookie('noinfo', 1, null, '/');
        $this->redirectTo($params);
    }
}

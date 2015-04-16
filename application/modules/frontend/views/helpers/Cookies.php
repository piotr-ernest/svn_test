<?php

/**
 * Description of Cookies
 *
 * @author rnest
 */
class Zend_View_Helper_Cookies extends Zend_View_Helper_Abstract
{
    public function cookies()
    {
        $params = Zend_Controller_Front::getInstance()->getRequest()->getParams();
        
        return $this->view->partial('app-partials/cookies.phtml', null, array('params' => $params));
    }
}

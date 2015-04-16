<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageBox
 *
 * @author rnest
 */
class Zend_View_Helper_MessageBox extends Zend_View_Helper_Abstract
{
    public function messageBox($messages)
    {
        return $this->view->partial('partials/messageBox.phtml', null, array('messages' => $messages));
    }
}

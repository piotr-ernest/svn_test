<?php


/**
 * Description of ModalWindow
 *
 * @author rnest
 */
class Zend_View_Helper_ModalWindow extends Zend_View_Helper_Abstract
{
    public function modalWindow($message)
    {
        $string = '';
        
        if(!is_array($message)){
            $messages = array($message);
        } else {
            $messages = $message;
        }
        
        while ($m = each($messages)){
            $string .= $m['value'] . '</br>';
        }
        
        return $this->view->partial('app-partials/modalWindow.phtml', null, array('string' => $string));
        
    }
}

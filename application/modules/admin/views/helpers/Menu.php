<?php


/**
 * Description of Menu
 *
 * @author rnest
 */
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    public function menu()
    {
        return $this;
    }
    
    public function writeMenu()
    {
        return $this->view->partial('app-partials/menu.phtml', null, array());
    }
}

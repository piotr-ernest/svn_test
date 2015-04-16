<?php

/**
 * Description of JSGlobals
 *
 * @author rnest
 */
class Zend_View_Helper_GlobalsJS extends Zend_View_Helper_Abstract
{
    public function globalsJS()
    {
        $jsGlobals = Zend_Registry::get('jsGlobals');
        return $this->view->partial('app-partials/globalsJS.phtml', null, array('globals' => $jsGlobals));
    }
}

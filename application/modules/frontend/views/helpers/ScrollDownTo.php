<?php


/**
 * Description of ScrollDownTo
 *
 * @author rnest
 */
class Zend_View_Helper_ScrollDownTo extends Zend_View_Helper_Abstract
{
    public function scrollDownTo($target, $scroll, $timeout = 2000)
    {
        return $this->view->partial('app-partials/scrollDownTo.phtml', null, array(
            'target' => $target, 
            'scroll' => $scroll,
            'timeout' => $timeout
        ));
    }
}

<?php


/**
 * Description of Uploader
 *
 * @author rnest
 */
class Zend_View_Helper_Uploader extends Zend_View_Helper_Abstract
{
    public function uploader(Array $opts)
    {
        extract($opts);
        return $this->view->partial(
                'partials/uploadForm.phtml', 
                null, 
                array(
                    'sizeLimit' => $sizeLimit,
                    'controller' => $controller,
                    'action' => $action,
                )
        );
    }
}

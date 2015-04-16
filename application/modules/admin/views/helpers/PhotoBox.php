<?php

/**
 * Description of PhotoBox
 *
 * @author rnest
 */
class Zend_View_Helper_PhotoBox extends Zend_View_Helper_FormElement
{

    public function photoBox($name, $value = null, $attribs = null)
    {
        return $this->view->partial('app-partials/photoBox.phtml', null, array(
                    'name' => $name,
                    'value' => $value,
                    'attribs' => $attribs,
        ));
    }

}

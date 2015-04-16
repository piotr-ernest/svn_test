<?php


/**
 * Description of PanelUnit
 *
 * @author rnest
 */
class Zend_View_Helper_PanelUnit extends Zend_View_Helper_Abstract
{

    public function panelUnit($val, $counter)
    {
        return $this->view->partial(
                        'app-partials/panelUnit.phtml', null, array(
                            'title' => $val->title, 
                            'content' => $val->sublevels,
                            'route' => $val->route,
                            'marker' => $val->marker,
                            'n' => $counter
                        )
        );
    }

}

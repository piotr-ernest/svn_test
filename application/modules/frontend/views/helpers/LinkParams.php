<?php


/**
 * Description of LinkParams
 *
 * @author rnest
 */
class Zend_View_Helper_LinkParams extends Zend_View_Helper_Abstract
{
    public function linkParams($params, $route)
    {
        
        return $this->view->url(array(
            'id' => $params['id'],
            'category-id' => $params['id'],
            'c' => $params['c'],
            'a' => $params['a'],
            'e' => $params['e'],
            'm' => $params['m'],
            'cpage' => $params['cpage'],
            'scroll' => $params['scroll'],
        ), $route);
    }
}

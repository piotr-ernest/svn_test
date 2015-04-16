<?php


/**
 * Description of MainUrl
 *
 * @author rnest
 */
class Zend_View_Helper_CategoryUrl extends Zend_View_Helper_Abstract
{
    public function categoryUrl($categoryId)
    {
        $url = $this->view->url(array('category-id' => $categoryId, 'page' => 1), 'categories');
        return $url;
    }
}

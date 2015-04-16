<?php

/**
 * Description of ArticleUrl
 *
 * @author rnest
 */
class Zend_View_Helper_ArticleUrl extends Zend_View_Helper_Abstract
{
    public function articleUrl($art)
    {
        $id = $art['value']['id'];
        $category = $art['value']['category'];
        return $this->view->url(array('id' => $id, 'category-id' => $category), 'article');
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TinyMce
 *
 * @author rnest
 */
class Zend_View_Helper_Tinymce extends Zend_View_Helper_Abstract
{
    public function tinymce()
    {
        return $this->view->partial('app-partials/tinymce/tinymce_articles.phtml', null, array());
    }
}

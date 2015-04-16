<?php

/**
 * Description of ImageSrc
 *
 * @author rnest
 */
class Zend_View_Helper_ImageSrc extends Zend_View_Helper_Abstract
{
    public function imageSrc($photo, $dir = 'files/articles/')
    {
        return $this->view->baseUrl(rtrim($dir, '/') . '/' . $photo);
    }
}

<?php

/**
 * Description of BootsSliderImage
 *
 * @author rnest
 */
class Zend_View_Helper_BootsSliderImage extends Zend_View_Helper_Abstract
{
    public function bootsSliderImage($path = null, $id = null, $descriptions = null, $class = 'col-sm-10 col-sm-offset-2')
    {
        
//        if(!$path){
//            throw new Zend_View_Exception('Ścieżka do katalogu musi być podana.');
//        }
        
        if(null === $id){
            $id = uniqid();
        }
        
        if(null === $path){
            $path = dirname(APPLICATION_PATH) . '/public/frontend/files/slider';
        }
        
        $files = Core_Tools::listDirectory($path);
        
        return $this->view->partial('app-partials/slider.phtml', null, array(
            'files' => $files,
            'dir' => 'files/slider/',
            'id' => $id,
            'descriptions' => $descriptions,
            'class' => $class
        ));
    }
}

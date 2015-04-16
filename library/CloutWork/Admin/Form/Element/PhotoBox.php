<?php


/**
 * Description of PhotoBox
 *
 * @author rnest
 */
class CloutWork_Admin_Form_Element_PhotoBox extends Zend_Form_Element
{
    public $helper = 'photoBox';
    
    protected $current;
    
    public function setCurrentImage($current)
    {
        $this->current = $current;
        return $this;
    }
    
}

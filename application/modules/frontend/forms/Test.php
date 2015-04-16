<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Test
 *
 * @author rnest
 */
class Frontend_Form_Test extends Zend_Form
{
    public function init()
    {
        //parent::init();
        
        $elements = array(
            $this->createElement('text', 'txt1')
                ->setRequired(true)
                ->setAttrib('maxlength', 20)
                ->addValidator('StringLength', false, array(1, 20))
                ->addErrorMessage('Błędna długość wpisanego tekstu.')
                ->addValidator('NotEmpty', false)
                ->addErrorMessage('Pole nie może być puste'),
        );
        
        $this->addElements($elements);
        
    }
    
//    public function setDefaults(array $defaults)
//    {
//        $this->getElement('txt1')->setValue($defaults['txt1']);
//        //parent::setDefaults($defaults);
//    }
    
}

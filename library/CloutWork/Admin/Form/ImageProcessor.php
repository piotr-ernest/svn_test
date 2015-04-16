<?php

/**
 * Description of ImageProcessor
 *
 * @author rnest
 */
class CloutWork_Admin_Form_ImageProcessor extends Zend_Form
{
    public function init()
    {
        parent::init();
        
        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('id' => 'imageProcessorForm'));
        $this->setAction($view->url(array('controller' => 'image-processor', 'action' => 'index')));
        
        $this->setDecorators(
                array(
                    'FormElements',
                    array('Form', array('role' => 'form')),
                //'FormErrors'
                )
        );

        $this->setElementDecorators(
                array(
                    'ViewHelper',
                    //'Label',
                    array('Errors', array('class' => 'form-errors')),
                    array('HtmlTag', array('tag' => 'div', 'class' => 'form-group')),
                )
        );
        
        $this->addElements(array(
            $this->createElement('file', 'image_processor')
            ->setAttrib('class', 'btn btn-info form-custom-file')
            ->setLabel('Dodaj obrazek'),
            
            $this->createElement('submit', 'Wyślij')
                    ->setAttrib('class', 'btn btn-info')
                    ->setName('Wyślij')
                    ->setValue('Wyślij')
                    ->setLabel('Wybierz')
                    ->removeDecorator('Label'),
            
        ));
        
    }
}

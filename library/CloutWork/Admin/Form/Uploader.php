<?php

/**
 * Description of Uploader
 *
 * @author rnest
 */
class CloutWork_Admin_Form_Uploader extends Zend_Form
{
    public function init()
    {
        parent::init();
        
        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('id' => 'uploadForm'));
        $this->setAction($view->url(array('controller' => 'uploader', 'action' => 'index')));
        
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
            $this->createElement('file', 'uploader')
            ->setAttrib('class', 'btn btn-info form-custom-file')
            ->setLabel('Dodaj obrazek'),
            
            $this->createElement('submit', 'Wyślij')
                    ->setAttrib('class', 'btn btn-info')
                    ->setName('Wyślij')
                    ->setValue('Wyślij')
                    ->setLabel('Wyślij')
                    ->removeDecorator('Label'),
            
        ));
        
    }
}

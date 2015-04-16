<?php

/**
 * Description of ArticlesRelated
 *
 * @author rnest
 */
class CloutWork_Admin_Form_ArticlesRelated extends Zend_Form
{

    protected $url = null;

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function init()
    {
        parent::init();

        
        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('id' => 'relatedForm'));
        $this->setAction($view->url(array(), 'related-edit'));
        $this->setMethod('post');

        //---------------------------

        $titleNotEmpty = new Zend_Validate_NotEmpty();
        $titleNotEmpty->setMessage('Nazwa artykułu jest wymagana.');

        //---------------------------

       
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
                    'Label',
                    array('Errors', array('class' => 'form-errors')),
                    array('HtmlTag', array('tag' => 'div', 'class' => 'form-group')),
                )
        );

        $elements = array(
                    $this->createElement('text', 'related')
                    ->setRequired(false)
                    ->setAttrib('class', 'form-control')
                    ->setAttrib('id', 'related_input')
                    ->setAttrib('autocomplete', 'off')
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz tytuł artykułu'),
            
            $this->createElement('select', 'articles')
                    //->setRequired(true)
                    ->setAttrib('name', 'articles')
                    //->addValidator($titleNotEmpty)
                    ->setAttrib('id', 'related_output')
                    ->setAttrib('class', 'form-control'),
       
            $this->createElement('hidden', 'id')
                    ->setIgnore(true),
            
                 
                    $this->createElement('submit', 'Wyślij')
                    ->setAttrib('class', 'btn btn-info')
                    ->setName('Wyślij')
                    ->setValue('Wyślij')
                    ->setLabel('Wyślij')
                    ->removeDecorator('Label')
                    
            
                    
        );

        $this->addElements($elements);
    }

    public function isValid($data)
    {
        
        if(!isset($data['articles']) || empty($data['articles'] || !$data['articles'])){
            $this->getElement('related')->addError('Wybierz artykuł');
            return false;
        }
        return true;
    }

    
    
    public function setDefaults($defaults)
    {
        parent::setDefaults($defaults);
    }

}

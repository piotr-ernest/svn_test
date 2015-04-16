<?php

/**
 * Description of ArticlesCategories
 *
 * @author rnest
 */
class CloutWork_Admin_Form_ArticlesCategories extends Zend_Form
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

        $this->setOptions(array('id' => 'categoriesForm'));
        $this->setAction($view->url(array(), 'categories-edit'));

        //---------------------------

        $titleNotEmpty = new Zend_Validate_NotEmpty();
        $titleNotEmpty->setMessage('Nazwa jest wymagana.');

      
        //---------------------------
        

        $stringLength_Title = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 256,
        ));

        $stringLength_Title->setMessages(array(
            'stringLengthTooLong' => 'Wpisana nazwa jest za długa - max. 256 znaków.',
            'stringLengthTooShort' => 'Wpisana nazwa jest za krótka - min. 5 znaków.'
        ));

        //-----------------------


      
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
                    $this->createElement('text', 'name')
                    ->setRequired(true)
                    ->setAttrib('class', 'form-control')
                    ->addValidator($stringLength_Title)
                    ->addValidator($titleNotEmpty)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz nazwę kategorii'),
            
            $this->createElement('hidden', 'id')
                    ->setIgnore(true),
            
                    
            
                    $this->createElement('radio', 'status')
                    ->setRequired(true)
                    ->addMultiOptions(array(
                       'Brudnopis',
                       'Opublikowany'
                    ))
                    ->setAttrib('class', 'radio')
                    ->setValue(0),
            
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

        if (parent::isValid($data)) {

            if ($this->validateDetails($data)) {
                return true;
            } else {
                return false;
            }
            return true;
        }

        return false;
    }

    protected function validateDetails($data)
    {
        return true;
    }
    
    public function setDefaults($defaults)
    {
        
        parent::setDefaults($defaults);
    }

}

<?php

/**
 * Description of Input
 *
 * @author rnest
 */
class CloutWork_Form_Comments_Input extends Zend_Form
{

    protected $url = null;

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function init()
    {
        parent::init();

        $fc = Zend_Controller_Front::getInstance();

        $categoryId = $fc->getRequest()->getParam('category-id');
        $id = $fc->getRequest()->getParam('id');
        $page = $fc->getRequest()->getParam('page');
        $controller = $fc->getRequest()->getControllerName();
        $action = $fc->getRequest()->getActionName();

        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('id' => 'commentsForm'));
        $this->setAction($view->url(array(
            'id' => $id, 
            'category-id' => $categoryId,
            'page' => $page,
            'c' => $controller,
            'a' => $action
        ), 'comments-insert'));

        //---------------------------

        $titleNotEmpty = new Zend_Validate_NotEmpty();
        $titleNotEmpty->setMessage('Tytuł jest wymagany.');

        //---------------------------

        $contentNotEmpty = new Zend_Validate_NotEmpty();
        $contentNotEmpty->setMessage('Treść komentarza jest wymagana.');


        //---------------------------

        $stringLength_Title = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 256,
        ));

        $stringLength_Title->setMessages(array(
            'stringLengthTooLong' => 'Wpisany tytuł jest za długi - max. 256 znaków.',
            'stringLengthTooShort' => 'Wpisany tytuł jest za krótki - min. 5 znaków.'
        ));

        //-----------------------

        $stringLengthContent = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 21000,
        ));

        $stringLengthContent->setMessages(array(
            'stringLengthTooLong' => 'Wpisana treść jest za długa - max. 21000 znaków.',
            'stringLengthTooShort' => 'Wpisana treść jest za krótka - min. 5 znaków.'
        ));

        //-------------------------
        
        $usernameNotEmpty = new Zend_Validate_NotEmpty();
        $usernameNotEmpty->setMessage('Aby komentować należy się zalogować.');


        //---------------------------
        
        $titleLengthContent = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 512,
        ));
        
        $titleLengthContent->setMessages(array(
            'stringLengthTooLong' => 'Wpisana treść tytułu jest za długa - max. 512 znaków.',
            'stringLengthTooShort' => 'Wpisana treść tytułu jest za krótka - min. 5 znaków.'
        ));

        //-------------------------
        
        

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
                    array('Label', array('class' => 'btn form-control')),
                    array('Errors', array('class' => 'form-errors')),
                    array('HtmlTag', array('tag' => 'div', 'class' => 'form-group')),
                )
        );

        $elements = array(
            
            $this->createElement('hidden', 'customer_username')
                    ->setRequired(true)
                    ->addValidator($usernameNotEmpty),
            
                    $this->createElement('text', 'title')
                    ->setRequired(true)
                    ->setAttrib('class', 'form-control comments-text')
                    ->setAttrib('id', 'comments-text')
                    ->addValidator($titleLengthContent)
                    ->addValidator($titleNotEmpty)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz tytuł komentarza'),
                    $this->createElement('hidden', 'id')
                    ->setIgnore(true),
            
                    $this->createElement('textarea', 'content')
                    ->setRequired(true)
                    ->setAttrib('class', 'form-control comments-textarea')
                    ->setAttrib('id', 'comments-textarea')
                    ->setAttrib('rows', 5)
                    ->addValidator($stringLengthContent)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->addValidator($contentNotEmpty)
                    ->setLabel('Wpisz treść komentarza'),
                    $this->createElement('submit', 'Wyślij')
                    ->setAttrib('class', 'btn btn-info')
                    ->setAttrib('id', 'save-comments')
                    ->setName('Wyślij')
                    ->setValue('Wyślij')
                    ->setLabel('Zatwierdź')
                    ->removeDecorator('Label')
        );

        $this->addElements($elements);
    }

    public function isValid($data)
    {
        return parent::isValid($data);
    }

    public function setDefaults($defaults)
    {
        parent::setDefaults($defaults);
    }

}

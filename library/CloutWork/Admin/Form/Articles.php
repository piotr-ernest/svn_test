<?php

/**
 * Description of Articles
 *
 * @author rnest
 */
class CloutWork_Admin_Form_Articles extends Zend_Form
{

    protected $url = null;

    public function __construct($options = null)
    {
        parent::__construct($options);
        
    }

    public function init()
    {
        parent::init();
        
        //$this->addPrefixPath($prefix, $path);
        $this->addPrefixPath('CloutWork_Admin_Form', 'CloutWork/Admin/Form/');

        $categoriesModel = new CloutWork_Admin_Model_ArticlesCategories();
        $categories = $categoriesModel->getCategoriesForForm();
                        
        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('id' => 'articlesForm'));
        $this->setAction($view->url(array(), 'articles-edit'));

        //---------------------------

        $titleNotEmpty = new Zend_Validate_NotEmpty();
        $titleNotEmpty->setMessage('Tytuł jest wymagany.');

        //---------------------------

        $contentNotEmpty = new Zend_Validate_NotEmpty();
        $contentNotEmpty->setMessage('Treść artykułu jest wymagana.');

        //---------------------------
        
        $stringLength_Label = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 128,
        ));
        
        $stringLength_Label->setMessages(array(
            'stringLengthTooLong' => 'Wpisana etykieta jest za długa - max. 128 znaków.',
            'stringLengthTooShort' => 'Wpisana etykieta jest za krótka - min. 5 znaków.'
        ));

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

        
        $subtitleNotEmpty = new Zend_Validate_NotEmpty();
        $subtitleNotEmpty->setMessage('Treść opisu jest wymagana.');

        //--------------------------

        $stringLengthSubtitle = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 512,
        ));

        $stringLengthSubtitle->setMessages(array(
            'stringLengthTooLong' => 'Wpisany opis jest za długi - max. 512 liter.',
            'stringLengthTooShort' => 'Wpisany opis jest za krótki - min. 5 liter.'
        ));

        //--------------------

        
        
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
                    $this->createElement('text', 'title')
                    ->setRequired(true)
                    ->setAttrib('class', 'form-control')
                    ->addValidator($stringLength_Title)
                    ->addValidator($titleNotEmpty)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz tytuł artykułu'),
            
            $this->createElement('hidden', 'id')
                    ->setIgnore(true),
            
                    $this->createElement('textarea', 'subtitle')
                    ->setRequired(true)
                    ->setAttrib('class', 'form-control')
                    ->setAttrib('style', 'height:100px')
                    ->addValidator($stringLengthSubtitle)
                    ->addValidator($subtitleNotEmpty)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz opis artykułu'),
            
            $this->createElement('text', 'label')
                    ->setRequired(false)
                    ->setAttrib('class', 'form-control')
                    ->addValidator($stringLength_Label)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz etykietę'),
            
                    $this->createElement('textarea', 'content')
                    ->setRequired(true)
                    ->setAttrib('class', 'form-control')
                    ->setAttrib('id', 'tiny')
                    ->addValidator($stringLengthContent)
                    ->addFilter('StringTrim')
                    ->addValidator($contentNotEmpty)
                    ->setLabel('Wpisz treść artykułu'),
            
                    $this->createElement('select', 'category')
                    ->setRequired(true)
                    ->addMultiOptions($categories)
                    ->setAttrib('class', 'form-control')
                    ->setLabel('Wybierz kategorię'),
            
                    $this->createElement('radio', 'status')
                    ->setRequired(true)
                    ->setLabel('Wybierz status artykułu: ')
                    ->addMultiOptions(array(
                       ' Brudnopis',
                       ' Opublikowany'
                    ))
                    ->setSeparator(' &nbsp &nbsp')
                    ->setAttrib('class', 'radio-inline')
                    ->setValue(0),
            
            $this->createElement('photoBox', 'photo')
                    ->setLabel('Wybierz obrazek')
                    ->setIgnore(true),
            
//            $this->createElement('file', 'photo')
//                    ->setLabel('Wybierz obrazek')
//                    ->setAttrib('class', 'rnestClass'),
                    
            
                    $this->createElement('submit', 'Wyślij')
                    ->setAttrib('class', 'btn btn-info')
                    ->setAttrib('id', 'save-all')
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
        if(!$data['category']){
            $this->getElement('category')->addError('Wybierz kategorię.');
            return false;
        }
        
        return true;
    }
    
    public function setDefaults($defaults)
    {
        parent::setDefaults($defaults);
    }

}

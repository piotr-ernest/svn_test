<?php

/**
 * Description of Login
 *
 * @author rnest
 */
class CloutWork_Form_Login extends Zend_Form
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

        $this->setOptions(array('id' => 'loginForm'));
        $this->setAction($view->url(array(), 'login'));

        //---------------------------

        $usernameEmpty = new Zend_Validate_NotEmpty();
        $usernameEmpty->setMessage('Pole użytkownika jest wymagane i nie może być puste.');

        //---------------------------

        $usernameConfirmEmpty = new Zend_Validate_NotEmpty();
        $usernameConfirmEmpty->setMessage('Pole potwierdzenia nazwy użytkownika jest wymagane i nie może być puste.');

        //---------------------------

        $passwordEmpty = new Zend_Validate_NotEmpty();
        $passwordEmpty->setMessage('Pole hasła jest wymagane i nie może być puste.');

        //---------------------------

        $passwordConfirmEmpty = new Zend_Validate_NotEmpty();
        $passwordConfirmEmpty->setMessage('Pole potwierdzenia hasła jest wymagane i nie może być puste.');

        //---------------------------

        $emailEmpty = new Zend_Validate_NotEmpty();
        $emailEmpty->setMessage('Pole e-mail jest wymagane i nie może być puste.');

        //---------------------------

        $emailConfirmEmpty = new Zend_Validate_NotEmpty();
        $emailConfirmEmpty->setMessage('Pole potwierdzenia e-mail jest wymagane i nie może być puste.');

        //---------------------------


        $stringLength_Username = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 128,
        ));

        $stringLength_Username->setMessages(array(
            'stringLengthTooLong' => 'Wpisana nazwa użytkownika jest za długa - max. 128 znaków.',
            'stringLengthTooShort' => 'Wpisana nazwa użytkownika jest za krótka - min. 5 znaków.'
        ));

        //-----------------------

        $stringLengthConfirm_Username = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 128,
        ));

        $stringLengthConfirm_Username->setMessages(array(
            'stringLengthTooLong' => 'Wpisana nazwa użytkownika jest za długa - max. 128 znaków.',
            'stringLengthTooShort' => 'Wpisana nazwa użytkownika jest za krótka - min. 5 znaków.'
        ));

        $usernameIdentity = new Zend_Validate_Identical('username');
        $usernameIdentity->setMessages(array('notSame' => 'Nazwy użytkownika się różnią.'));

        //--------------------------

        $stringLength_Password = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 128,
        ));

        $stringLength_Password->setMessages(array(
            'stringLengthTooLong' => 'Wpisane hasło jest za długie - max. 128 znaków.',
            'stringLengthTooShort' => 'Wpisane hasło jest za krótkie - min. 5 znaków.'
        ));

        //--------------------

        $stringLengthConfirm_Password = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 128,
        ));

        $stringLengthConfirm_Password->setMessages(array(
            'stringLengthTooLong' => 'Wpisane hasło jest za długie - max. 128 znaków.',
            'stringLengthTooShort' => 'Wpisane hasło jest za krótkie - min. 5 znaków.'
        ));

        $passwordIdentity = new Zend_Validate_Identical('password');
        $passwordIdentity->setMessages(array('notSame' => 'Wpisano różne hasła.'));

        //-------------------------

        $emailValidator = new Zend_Validate_EmailAddress();

        $emailValidator->setMessages(array(
            Zend_Validate_EmailAddress::INVALID_FORMAT => 'Wpisz poprawny adres e-mail',
        ));

        //----------------------------------

        $stringLength_Email = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 128,
        ));

        $stringLength_Email->setMessages(array(
            'stringLengthTooLong' => 'Wpisany adres e-mail jest za długi - max. 128 znaków.',
            'stringLengthTooShort' => 'Wpisany adres e-mail jest za krótki - min. 5 znaków.'
        ));

        //-----------------------

        $stringLengthConfirm_Email = new Zend_Validate_StringLength(array(
            'min' => 5,
            'max' => 128,
        ));

        $stringLengthConfirm_Email->setMessages(array(
            'stringLengthTooLong' => 'Wpisany adres e-mail jest za długi - max. 128 znaków.',
            'stringLengthTooShort' => 'Wpisany adres e-mail jest za krótki - min. 5 znaków.'
        ));

        $emailConfirmValidator = new Zend_Validate_EmailAddress();

        $emailConfirmValidator->setMessages(array(
            Zend_Validate_EmailAddress::INVALID_FORMAT => 'Wpisz poprawny adres e-mail',
        ));

        $emailIdentity = new Zend_Validate_Identical('email');
        $emailIdentity->setMessages(array('notSame' => 'Wpisano różne adresy e-mail.'));

        //---------------------

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
                    array('HtmlTag', array('tag' => 'div', 'class' => 'form-group')),
                )
        );

        $elements = array(
                    $this->createElement('text', 'username')
                    //->setRequired(true)
                    ->setAttrib('class', 'form-control')
                    ->setAttrib('placeholder', 'Wpisz nazwę użytkownika')
                    ->addValidator($stringLength_Username)
                    ->addValidator($usernameEmpty)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz nazwę użytkownika'),
            
                    $this->createElement('password', 'password')
                    ->setRequired(true)
                    ->setAttrib('class', 'form-control')
                    ->setAttrib('placeholder', 'Wpisz hasło')
                    ->addValidator($stringLength_Password)
                    ->addValidator($passwordEmpty)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->setLabel('Wpisz hasło'),
            
            
            //$this->createElement('hash', 'saveme'),
                    $this->createElement('submit', 'Zaloguj')
                    ->setAttrib('class', 'btn btn-info')
                    ->setName('Zaloguj')
                    ->setValue('Zaloguj')
                    ->setLabel('Zaloguj')
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

}

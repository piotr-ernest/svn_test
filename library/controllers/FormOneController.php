<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormController
 *
 * @author rnest
 */
class FormOneController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $form = new Application_Form_Example();
        $form->setAttribs(array(
            'id' => 'formOne',
            'class' => 'classFormOne'
        ));

        $form->setAction('/form-one');

        if ($post = $this->getRequest()->getPost()) {
            if ($form->isValid($post)) {
                $values = $form->getValues();
                $this->view->values = $values;
            }
        }


        $this->view->form = $form;
    }

    public function proccessFormAction()
    {
        
    }

}

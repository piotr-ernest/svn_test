<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UrlFunctionsController
 *
 * @author rnest
 */
class UrlFunctionsController extends Zend_Controller_Action
{
    public function indexAction ()
    {
        $imie = isset($_GET['imie']) ? $_GET['imie'] : 'Monika';
        $this->view->base64encode = base64_encode('imie=' . $imie);
        $this->view->base64decode = base64_decode($this->view->base64encode);
        $this->view->headers = $this->getResponse()->getHeaders();
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GDController
 *
 * @author rnest
 */
class GDController extends Zend_Controller_Action
{
    protected $sizeLimit = 3000000; // 3MB

    public function indexAction()
    {
        $settings = array(
            'view' => $this->view,
            'request' => $this->getRequest(),
            'controller' => 'gd',
            'action' => 'index',
            'dir' => 'files/download',
            'sizeLimit' => 3000000,
            'exts' => array(
                'jpg', 'gif', 'png'
            )
        );
        CloutWork_Images_Uploader::getInstance($settings);

    }

    

}

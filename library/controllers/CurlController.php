<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CurlController
 *
 * @author rnest
 */
class CurlController extends Zend_Controller_Action 
{
    public function indexAction()
    {
        $data = array(
            'imie1' => 'Kornelia',
            'imie2' => 'Klaudia'
        );
        
        $server = 'http://zfp1.dev/index';
        
        $post = $this->sendPost($server, $data);
        $this->view->post = $post;
    }
    
    protected function sendPost($server, $data)
    {
        $post = http_build_query($data);
        $handler = curl_init();
        
        curl_setopt($handler, CURLOPT_URL, $server);
        curl_setopt($handler, CURLOPT_POST, 1);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $post);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($handler);
        curl_close($handler);
        return $response;
    }
    
    
}

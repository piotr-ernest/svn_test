<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PathCorrector
 *
 * @author rnest
 */
class Zend_View_Helper_PathCorrector extends Zend_View_Helper_Abstract
{
    public function pathCorrector($pattern, $wrong)
    {
        $config = new CloutWork_Config(null, 'admin');
        $correct = $config->getAdmin()->url . '/tinymce/uploads';
                
        return preg_replace($pattern, $correct, $wrong);
    }
}

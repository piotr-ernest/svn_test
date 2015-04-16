<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileAccessController
 *
 * @author rnest
 */
class FileAccessController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $text = file_get_contents('files/lorem.txt');
        $text2 = '';
        for($i = 0; $i < strlen($text); $i++){
            $text2 .= preg_replace('/a/', '<span style="color:blue;">a</span>', $text[$i]);
        }
        $this->view->text = $text2;
    }
    
    private function openFile($file, $mode = 'r')
    {
        if(!file_exists($file)){
            throw new Exception("Plik $file nie został odnaleziony.");
        }
        try{
            $fp = fopen($file, $mode);
            if(!$fp){
                throw new Exception('Nie udało się otworzyć pliku ' . $file . '.');
            }
            return $fp;
        } catch (Exception $ex) {
            echo '<h1>' . $ex . '</h1>';
        }
        
    }
    
    private function readFileAsArray($file, $wrap = false)
    {
        if(!file_exists($file)){
            throw new Exception("Plik $file nie został odnaleziony.");
        }
        try{
            $text = file($file);
            if($wrap){
                return explode('.', $text[0]);
            }
            return $text;
        } catch (Exception $ex) {
            echo 'BŁĄD: ' . $ex;
        }
        
    }
    
    private function readFileIncremantally($file)
    {
        if(!file_exists($file)){
            throw new Exception("Plik $file nie został odnaleziony.");
        }
        $fp = $this->openFile($file);
        while(!feof($fp)){
            
        }
    }
    
}

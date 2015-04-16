<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function desc($data, $exit = false, $title = '', $out = false)
{
    
    if($out){
        return print_r($data, $out);
    }
    
    echo '<div style="background: #ff6600; color: #003333; padding: 10px; overflow-x: auto; z-index: 9999;'
    . 'border-radius: 10px; margin: 10px;">';
    echo '<h4>' . $title . '</h4>';
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    
    echo '</div>';
    
    
    
    if($exit){
        exit;
    }
    
}


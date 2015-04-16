<?php

$view = Zend_Layout::getMvcInstance()->getView();

return array(
    'paths' => array(
        
        'index' => array(
            
            'index' => array(
                'name' => 'Strona główna',
                'url' => $view->url(array(), 'home')
            ),
            
        ),
        
        'categories' => array(
            
            'index' => array(
                'name' => 'Kategorie',
                'url' => $view->url(array(), 'categories')
            ),
            
            'show' => array(
                'name' => 'Kategorie',
                'url' => $view->url(array(), 'categories-show')
            ),
            
        ),
        
    ),
);
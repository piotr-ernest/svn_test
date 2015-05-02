<?php

return array(
    'routes' => array(
        
        'login' => array(
            'route' => '/logowanie/id/:id/category-id/:category-id/page/:page/c/:c/a/:a',
            'defaults' => array(
                'controller' => 'start',
                'action' => 'login',
                'id' => 0,
                'category-id' => 0,
                'page' => 1,
                'c' => '',
                'a' => ''
            ),
        ),
        'register' => array(
            'route' => 'rejestracja/id/:id/category-id/:category-id/page/:page/c/:c/a/:a',
            'defaults' => array(
                'controller' => 'start',
                'action' => 'register',
                'id' => 0,
                'category-id' => 0,
                'page' => 1,
                'c' => '',
                'a' => ''
            ),
        ),
        'logout' => array(
            'route' => '/wylogowywanie/id/:id/category-id/:category-id/page/:page/c/:c/a/:a',
            'defaults' => array(
                'controller' => 'start',
                'action' => 'logout',
                'id' => 0,
                'category-id' => 0,
                'page' => 1,
                'c' => '',
                'a' => ''
            ),
        ),
        'home' => array(
            'route' => 'strona-glowna/page/:page',
            'defaults' => array(
                'controller' => 'index',
                'action' => 'index',
                'page' => 1,
            ),
        ),
        'article' => array(
            'route' => '/artykul/id/:id/category-id/:category-id/c/:c/a/:a/e/:e/m/:m/cpage/:cpage/scroll/:scroll',
            'defaults' => array(
                'controller' => 'index',
                'action' => 'show',
                'id' => 0,
                'category-id' => 0,
                'c' => '',
                'a' => '',
                'e' => '',
                'm' => '',
                'cpage' => 1,
                'scroll' => 0
            ),
        ),
        'categories' => array(
            'route' => 'categories/category-id/:category-id/page/:page',
            'defaults' => array(
                'controller' => 'categories',
                'action' => 'index',
                'category-id' => 0,
                'page' => 1
            ),
        ),
        'categories-show' => array(
            'route' => 'categories/category-id/:category-id/id/:id',
            'defaults' => array(
                'controller' => 'categories',
                'action' => 'show',
                'category-id' => 0,
                'id' => 1
            ),
        ),
        'comments-instant-login' => array(
            'route' => 'logowanie-komentarze',
            'defaults' => array(
                'controller' => 'comments',
                'action' => 'login',
            ),
        ),
        'comments-insert' => array(
            'route' => '/komentarze/id/:id/category-id/:category-id/page/:page/c/:c/a/:a/e/:e/m/:m',
            'defaults' => array(
                'controller' => 'comments',
                'action' => 'insert',
                'id' => 0,
                'category-id' => 0,
                'page' => 1,
                'c' => '',
                'a' => '',
                'e' => '',
                'm' => ''
            ),
        ),
        
        'comments-ajax' => array(
            'route' => 'comments-ajax/id/:id',
            'defaults' => array(
                'controller' => 'comments-ajax',
                'action' => 'index',
                'id' => 0,
            ),
        ),
        
        'comments-ajax-get' => array(
            'route' => 'comments-ajax-get',
            'defaults' => array(
                'controller' => 'comments-ajax',
                'action' => 'get-comments',
            ),
        ),
        
        'cookies' => array(
            'route' => '/cookies/id/:id/category-id/:category-id/page/:page/c/:c/a/:a/e/:e/m/:m/scroll/:scroll',
            'defaults' => array(
                'controller' => 'cookies',
                'action' => 'index',
                'id' => 0,
                'category-id' => 0,
                'page' => 1,
                'c' => '',
                'a' => '',
                'e' => '',
                'm' => '',
                'scroll' => 0
            ),
        ),
        
        'validate' => array(
            'route' => 'validate',
            'defaults' => array(
                'controller' => 'validate/v/:v',
                'action' => 'index',
                'v' => 0
            ),
        ),
        
    ),
);

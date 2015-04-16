<?php

return array(
    
    
    'routes' => array(
        
        'login' => array(
            'route' => '/logowanie',
            'defaults' => array(
                'controller' => 'start',
                'action' => 'login'
            ),
        ),
        
        'register' => array(
            'route' => '/rejestracja',
            'defaults' => array(
                'controller' => 'start',
                'action' => 'register'
            ),
        ),
        
        
        'logout' => array(
            'route' => '/wylogowywanie',
            'defaults' => array(
                'controller' => 'start',
                'action' => 'logout'
            ),
        ),
        
        'main' => array(
            'route' => '/administracja',
            'defaults' => array(
                'controller' => 'panel',
                'action' => 'index'
            ),
        ),
        
        'articles' => array(
            'route' => 'articles/page/:page/category-sort/:category-sort/name-sort/:name-sort',
            'defaults' => array(
                'controller' => 'articles',
                'action' => 'index',
                'page' => 1,
                'category-sort' => 0,
                'name-sort' => ''
            ),
        ),
        
        'articles-sort' => array(
            'route' => 'articles/page/:page',
            'defaults' => array(
                'controller' => 'articles',
                'action' => 'sort',
                'page' => 1

            ),
        ),
        
        'articles-edit' => array(
            'route' => 'articles-edit/id/:id/page/:page/category-sort/:category-sort/name-sort/:name-sort',
            'defaults' => array(
                'controller' => 'articles',
                'action' => 'edit',
                'id' => 0,
                'page' => 1,
                'category-sort' => 0,
                'name-sort' => ''
            ),
        ),
        
        'articles-delete' => array(
            'route' => 'articles-delete/id/:id/page/:page/category-sort/:category-sort/name-sort/:name-sort',
            'defaults' => array(
                'controller' => 'articles',
                'action' => 'delete',
                'id' => 0,
                'page' => 1,
                'category-sort' => 0,
                'name-sort' => ''
            ),
        ),
        
        'articles-add' => array(
            'route' => 'articles-add',
            'defaults' => array(
                'controller' => 'articles',
                'action' => 'add'
            ),
        ),
        
        
        'uploader-delete' => array(
            'route' => 'uploader-delete',
            'defaults' => array(
                'controller' => 'uploader',
                'action' => 'delete',
                'id' => 0
            ),
        ),
        
        'uploader-index' => array(
            'route' => '/uploader/index',
            'defaults' => array(
                'controller' => 'uploader',
                'action' => 'index',
            ),
        ),
        
        'categories' => array(
            'route' => 'categories/page/:page',
            'defaults' => array(
                'controller' => 'categories',
                'action' => 'index',
                'page' => 1
            ),
        ),
        
        'categories-add' => array(
            'route' => 'categories-add',
            'defaults' => array(
                'controller' => 'categories',
                'action' => 'add'
            ),
        ),
        
        'categories-edit' => array(
            'route' => 'categories-edit/id/:id',
            'defaults' => array(
                'controller' => 'categories',
                'action' => 'edit',
                'id' => 0
            ),
        ),
        
        'categories-delete' => array(
            'route' => 'categories-delete/id/:id',
            'defaults' => array(
                'controller' => 'categories',
                'action' => 'delete',
                'id' => 0
            ),
        ),
        
        'related' => array(
            'route' => 'related-articles/page/:page/category-sort/:category-sort/name-sort/:name-sort',
            'defaults' => array(
                'controller' => 'related-articles',
                'action' => 'index',
                'page' => 1,
                'category-sort' => 0,
                'name-sort' => ''
            ),
        ),
        
        'related-add' => array(
            'route' => 'related-articles-add/id/:id',
            'defaults' => array(
                'controller' => 'related-articles',
                'action' => 'add',
                'id' => 0
            ),
        ),
        
        'related-edit' => array(
            'route' => 'related-articles-edit/id/:id/page/:page/category-sort/:category-sort/name-sort/:name-sort',
            'defaults' => array(
                'controller' => 'related-articles',
                'action' => 'edit',
                'id' => 0,
                'page' => 1,
                'category-sort' => 0,
                'name-sort' => ''
            ),
        ),
        
        'related-delete' => array(
            'route' => 'related-articles-delete/id/:id/rel/:rel/page/:page/category-sort/:category-sort/name-sort/:name-sort',
            'defaults' => array(
                'controller' => 'related-articles',
                'action' => 'delete',
                'id' => 0,
                'rel' => 0,
                'page' => 1,
                'category-sort' => 0,
                'name-sort' => ''
            ),
        ),
        
        'related-sort' => array(
            'route' => 'related/page/:page',
            'defaults' => array(
                'controller' => 'related-articles',
                'action' => 'sort',
                'page' => 1

            ),
        ),
        
        'get-related' => array(
            'route' => 'related/get-related',
            'defaults' => array(
                'controller' => 'related-articles',
                'action' => 'get-related',
                'id' => 0
            ),
        ),
        
        'test' => array(
            'route' => 'test',
            'defaults' => array(
                'controller' => 'test',
                'action' => 'index'
                
            ),
        ),
        
        'images' => array(
            'route' => 'images/img-name/:img-name/error/:error/message/:message',
            'defaults' => array(
                'controller' => 'image-processor',
                'action' => 'index',
                'img-name' => '',
                'error' => '',
                'message' => ''
            ),
        ),
        
        'images-save' => array(
            'route' => 'images-save/img-name/:img-name',
            'defaults' => array(
                'controller' => 'image-processor',
                'action' => 'save-image',
                'img-name' => ''
            ),
        ),
        
        'log' => array(
            'route' => 'application-reports',
            'defaults' => array(
                'controller' => 'panel',
                'action' => 'log'
                
            ),
        ),
        
        'log-clear' => array(
            'route' => 'application-reports-clear',
            'defaults' => array(
                'controller' => 'panel',
                'action' => 'clear'
                
            ),
        ),
        
        'log-frontend' => array(
            'route' => 'application-reports-frontend',
            'defaults' => array(
                'controller' => 'panel',
                'action' => 'log-frontend'
                
            ),
        ),
        
        'log-clear-frontend' => array(
            'route' => 'application-reports-clear-frontend',
            'defaults' => array(
                'controller' => 'panel',
                'action' => 'clear-frontend'
                
            ),
        ),
        
    ),
);

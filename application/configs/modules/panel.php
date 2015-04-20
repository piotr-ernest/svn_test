<?php

return array(
    'modules' => array(
        'articles' => array(
            'title' => 'Artykuły',
            'route' => '/articles',
            'marker' => array(
                'articles',
                'categories',
                'articles-edit',
                'articles-delete',
                'categories-add',
                'categories-edit',
                'categories-delete',
                'related-articles',
                'related-articles-add',
                'related-articles-edit'
            ),
            'show' => true,
            'sublevels' => array(
                array(
                    'title' => 'Artykuły',
                    'route' => '/articles',
                ),
                array(
                    'title' => 'Kategorie',
                    'route' => '/categories',
                ),
                array(
                    'title' => 'Artykuły powiązane',
                    'route' => '/related',
                ),
            ),
        ),
        'comments' => array(
            'title' => 'Komentarze',
            'route' => '/comments',
            'show' => true,
            'sublevels' => array(
                array(
                    'title' => 'Komentarze',
                    'route' => '/comments',
                ),
            ),
            'marker' => array()
        ),
    ),
);

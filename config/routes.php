<?php

return [
    '/'              => [
        'name'       => 'home',
        'namespace'  => 'App\Controllers',
        'controller' => 'ProductController',
        'action'     => 'index',
		'args'       => [
			'[g]'
		]
    ],

    '/add'       => [
        'name'       => 'product',
        'namespace'  => 'App\Controllers',
        'controller' => 'ProductController',
        'action'     => 'add'
    ],

    '/store'    => [
        'name'       => 'product.store',
        'namespace'  => 'App\Controllers',
        'controller' => 'ProductController',
        'action'     => 'store'
    ],

    '/show/'       => [
        'name'       => 'product.show',
        'namespace'  => 'App\Controllers',
        'controller' => 'ProductController',
        'action'     => 'show',
        'args'       => [
            '[i]'
        ]
    ],

    '/api/review/add'       => [
        'name'       => 'review.add',
        'namespace'  => 'App\Controllers',
        'controller' => 'ReviewsController',
        'action'     => 'add',
		'args'       => [
			'[g]'
		]
    ],



];
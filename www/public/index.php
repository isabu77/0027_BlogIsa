<?php

$basepath = dirname(__dir__) . DIRECTORY_SEPARATOR; // contient /var/www/

require_once $basepath . 'vendor/autoload.php';

$app = \App\App::getInstance();

$app::load();

//$start = microtime(true);
$app->setStartTime(microtime(true));

// définition des routes 
//$router = new App\Router($basepath . 'views');
$app->getRouter($basepath)
    ->get('/', 'Post#all', 'home')
    ->get('/article/[*:slug]-[i:id]', 'Post#show', 'post')
    ->get('/categories', 'Category#all', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'Category#show', 'category')
    ->get('/contact', 'contact#index', 'contact')
    ->get('/identification', 'identification#index', 'identification')
    ->run();

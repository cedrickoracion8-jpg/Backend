<?php

$router->any('/', 'AuthController::login');
$router->any('/login', 'AuthController::login');
$router->any('/register', 'AuthController::register');
$router->get('/logout', 'AuthController::logout');
$router->post('/logout', 'AuthController::logout');
$router->get('/show-users', 'UserController::showUsers');

// API authentication and product CRUD
$router->group(['prefix' => '/api'], function ($router) {
    $router->post('/login', 'ApiController::login');
    $router->post('/register', 'ApiController::register');
    $router->post('/logout', 'ApiController::logout');
    $router->post('/refresh', 'ApiController::refresh');
    $router->get('/profile', 'ApiController::profile');
    $router->get('/users', 'ApiController::list');
    $router->post('/users', 'ApiController::create');
    $router->put('/users/{id}', 'ApiController::update');
    $router->delete('/users/{id}', 'ApiController::delete');
    $router->get('/products', 'ApiController::products');
    $router->post('/products', 'ApiController::product_create');
    $router->put('/products/{id}', 'ApiController::product_update');
    $router->delete('/products/{id}', 'ApiController::product_delete');

    // Browser clients send OPTIONS before JSON requests.
    $router->options('/login', 'ApiController::login');
    $router->options('/register', 'ApiController::register');
    $router->options('/logout', 'ApiController::logout');
    $router->options('/refresh', 'ApiController::refresh');
    $router->options('/profile', 'ApiController::profile');
    $router->options('/users', 'ApiController::list');
    $router->options('/users/{id}', 'ApiController::update');
    $router->options('/products', 'ApiController::products');
    $router->options('/products/{id}', 'ApiController::product_update');
});

$router->group(['middleware' => 'AuthMiddleware'], function ($router) {
    $router->get('/product/display', 'ProductController::read');
    $router->get('/product/create', 'ProductController::create');
    $router->post('/product/create', 'ProductController::create');
    $router->get('/product/edit/{id}', 'ProductController::edit');
    $router->post('/product/edit/{id}', 'ProductController::edit');
    $router->post('/product/delete/{id}', 'ProductController::delete');

    $router->get('/products', 'ProductController::read');
    $router->get('/products/create', 'ProductController::create');
    $router->post('/products/create', 'ProductController::create');
    $router->get('/products/edit/{id}', 'ProductController::edit');
    $router->post('/products/edit/{id}', 'ProductController::edit');
    $router->post('/products/delete/{id}', 'ProductController::delete');
});

$router->get('/migration/create/{migration_class}', 'MigrationController::create_migration');
$router->get('/migration/migrate', 'MigrationController::migrate');
$router->get('/migration/rollback', 'MigrationController::rollback');
$router->get('/migration/rollback-all', 'MigrationController::rollback_all');
$router->get('/migration/refresh', 'MigrationController::refresh');
$router->get('/migration/status', 'MigrationController::status');

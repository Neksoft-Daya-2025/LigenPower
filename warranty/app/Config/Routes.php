<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->get('demo', 'Home::demo');
$routes->get('/', 'Auth::index');
$routes->get('get-csrf', 'Home::csrf');
$routes->post('/savedata', 'Auth::save_data');

// $routes->get('/form', 'YourController::index'); // To display the form
// $routes->post('/yourcontroller/submitForm', 'YourController::submitForm'); // To handle form submission

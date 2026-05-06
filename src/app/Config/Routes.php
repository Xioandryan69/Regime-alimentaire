<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =============================================
// Routes application
// =============================================

$routes->get('/', 'AuthController::loginForm');
$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/notes/new', 'NoteController::new');
$routes->post('/notes', 'NoteController::create');
$routes->post('/notes/retained', 'NoteController::addRetained');
$routes->post('/notes/(:num)/delete', 'NoteController::delete/$1');

$routes->get('/students', 'StudentController::index');
$routes->get('/students/(:num)', 'StudentController::show/$1');

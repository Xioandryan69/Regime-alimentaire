<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =============================================
// Routes application
// =============================================

$routes->get('/', 'Home::index');
// --- Routes pour l'authentification Admin ---

// Afficher le formulaire
$routes->get('admin/login', 'AdminAuth::login');

// Traiter le formulaire
$routes->post('admin/loginCheck', 'AdminAuth::loginCheck');

// Se déconnecter
$routes->get('admin/logout', 'AdminAuth::logout');

$routes->get('admin/dashboard', function() {
    return view('admin/dashboard');
}, ['filter' => 'adminAuth']);

$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');


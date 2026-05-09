<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =============================================
// Routes application
// =============================================

$routes->get('/', 'Home::index');

// --- Routes Admin ---
$routes->get('admin/login',      'AdminAuth::login');
$routes->post('admin/loginCheck','AdminAuth::loginCheck');
$routes->get('admin/logout',     'AdminAuth::logout');
$routes->get('admin/dashboard',  'AdminDashboard::index', ['filter' => 'adminAuth']);

// --- Routes Users : connexion ---
$routes->get('users/login',       'UsersAuth::login');
$routes->post('users/loginCheck', 'UsersAuth::loginCheck');
$routes->get('users/logout',      'UsersAuth::logout');

// --- Routes Users : inscription en 2 étapes ---
$routes->get('users/register',         'UsersAuth::register');           // Affiche étape 1
$routes->post('users/register/step1',  'UsersAuth::registerStep1');      // Traite étape 1
$routes->get('users/register/step2',   'UsersAuth::registerStep2');      // Affiche étape 2
$routes->post('users/register/step2',  'UsersAuth::registerStep2Check'); // Traite étape 2

// --- Page d'accueil connectée ---
$routes->get('users/homepage', 'UsersHomepage::index', ['filter' => 'usersAuth']);
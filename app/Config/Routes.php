<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Display login page
$routes->get('/login', 'AuthController::login');

// Process login form
$routes->post('/login', 'AuthController::attemptLogin');

// Logout user
$routes->post('/logout', 'AuthController::logout',['filter' => 'auth']);

// Display dashboard
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
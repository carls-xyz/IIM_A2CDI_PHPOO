<?php
require_once __DIR__ . '/app/utils/Autoload.php';
require_once __DIR__ . '/app/utils/Router.php';

Autoload::register();
session_start();

$router = new Router();

// ============================================
// ROUTES GET
// ============================================

// Accueil = liste des activités
$router->get('/', ActivityController::class, 'index');
$router->get('/activity', ActivityController::class, 'index');
$router->get('/activity/show', ActivityController::class, 'show');
$router->get('/activity/create', ActivityController::class, 'create');
$router->get('/activity/edit', ActivityController::class, 'edit');
$router->get('/activity/delete', ActivityController::class, 'delete');

// Réservation
$router->get('/reservation', ReservationController::class, 'index');
$router->get('/reservation/show', ReservationController::class, 'show');
$router->get('/reservation/create', ReservationController::class, 'create');
$router->get('/reservation/cancel', ReservationController::class, 'cancel');
$router->get('/reservation/list', ReservationController::class, 'listAll'); // Admin

// Users
$router->get('/user', UserController::class, 'index');
$router->get('/user/login', UserController::class, 'login');
$router->get('/user/register', UserController::class, 'register');
$router->get('/user/logout', UserController::class, 'logout');

// ============================================
// ROUTES POST
// ============================================

// Activités (admin)
$router->post('/activity/store', ActivityController::class, 'store');
$router->post('/activity/update', ActivityController::class, 'update');

// Réservation
$router->post('/reservation/store', ReservationController::class, 'store');

// Users
$router->post('/user/login', UserController::class, 'loginSubmit');
$router->post('/user/register', UserController::class, 'registerSubmit');

// Lancer le routage
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
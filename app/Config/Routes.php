<?php

use CodeIgniter\Router\RouteCollection;

$routes->setAutoRoute(true);
/**
 * @var RouteCollection $routes
 * 
 */
$routes->get('/', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::storeRegister');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::doLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/index', 'AuthController::index');

$routes->get('/chat', 'ChatController::index', ['filter' => 'auth']);
$routes->get('/chat/fetchMessages', 'ChatController::fetchMessages');
$routes->post('/chat/sendMessage', 'ChatController::sendMessage');

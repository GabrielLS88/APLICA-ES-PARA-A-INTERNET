<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\EventController;
use App\Core\Router;

$router = new Router();

$router->get('/', [AuthController::class, 'showLogin']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'index']);
$router->post('/tasks', [DashboardController::class, 'store']);
$router->post('/tasks/{id}/toggle', [DashboardController::class, 'toggle']);
$router->post('/tasks/{id}/delete', [DashboardController::class, 'destroy']);

$router->get('/events', [EventController::class, 'index']);
$router->get('/events/create', [EventController::class, 'create']);
$router->post('/events', [EventController::class, 'store']);
$router->get('/events/{id}/edit', [EventController::class, 'edit']);
$router->post('/events/{id}', [EventController::class, 'update']);
$router->post('/events/{id}/delete', [EventController::class, 'destroy']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

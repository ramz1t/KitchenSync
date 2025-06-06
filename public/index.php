<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/Controller/HomeController.php';
require_once __DIR__ . '/../src/Controller/RestaurantController.php';
require_once __DIR__ . '/../src/Controller/OrderController.php';

$router = new Router($pdo);

$router->add('/', HomeController::class, 'index');
$router->add('/restaurant', RestaurantController::class, 'index');
$router->add('/logout', RestaurantController::class, 'logout');
$router->add('/restaurant/order', OrderController::class, 'index');

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($url);

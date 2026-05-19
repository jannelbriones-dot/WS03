<?php

define('BASE_PATH', dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

use framework\Router;
use framework\Session;

Session::start();

$router = new Router();

// Load routes
require basePath('routes.php');

// Get URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Remove base folder
$basePath = '/WS03/public';

if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

if ($uri === '') {
    $uri = '/';
}

$router->route($uri);
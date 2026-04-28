<?php
define('BASE_PATH', dirname(__DIR__));

require '../helpers.php';
require basePath('Router.php');

$router = new Router();

// Load routes
$routes = require basePath('routes.php');

// Get current URI and method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remove query string from URI if present
$uri = parse_url($uri, PHP_URL_PATH);

// Strip the base path (e.g., /ws03/public) to get just the route
$basePath = '/ws03/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Ensure URI starts with /
if (empty($uri)) {
    $uri = '/';
}

// Dispatch the router (THIS IS MISSING!)
$router->route($uri, $method);
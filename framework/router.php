<?php

namespace framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;
class Router
{
    protected array $routes = [];

    public function registerRoute(string $method, string $uri, string $action, $middleware = [])
    {
        $parts = explode("@", $action);

        if (count($parts) < 2) {
            die("Invalid route action: {$action}");
        }

        [$controller, $controllerMethod] = $parts;

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware'=> $middleware
        ];
    }
    /**
     * Add GET route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function get(string $uri, string $controller, array $middleware = [])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }

    public function post(string $uri, string $action, array $middleware = [])
    {
        $this->registerRoute('POST', $uri, $action, $middleware);
    }

    public function put(string $uri, string $action, array $middleware = [])
    {
        $this->registerRoute('PUT', $uri, $action, $middleware);
    }

    public function delete(string $uri, string $action, array $middleware = [])
    {
        $this->registerRoute('DELETE', $uri, $action, $middleware);
    }

    public function route(string $uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // method override (PUT/DELETE via POST)
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {

            $uriSegments = explode('/', trim($uri, '/'));
            $routeSegments = explode('/', trim($route['uri'], '/'));

            if (
                count($uriSegments) === count($routeSegments) &&
                strtoupper($route['method']) === $requestMethod
            ) {

                $match = true;
                $params = [];

                for ($i = 0; $i < count($uriSegments); $i++) {

                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    } elseif ($routeSegments[$i] !== $uriSegments[$i]) {
                        $match = false;
                        break;
                    }
                }

                if ($match) {

                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    if (!class_exists($controller)) {
                        die("Controller {$controller} not found");
                    }

                    $controllerInstance = new $controller();

                    if (!method_exists($controllerInstance, $controllerMethod)) {
                        die("Method {$controllerMethod} not found");
                    }

                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }

        ErrorController::notFound();
    }
}
<?php

namespace App\Libraries;

class Router {
    private $routes = [];

    public function get($uri, $action) {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action) {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute($method, $uri, $action) {
        // Convert route parameters {id} into regex
        $uriPattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $uri);
        $uriPattern = '#^' . $uriPattern . '$#';
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => $uriPattern,
            'action' => $action
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $uri = '/' . $uri; // Ensure leading slash

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                // Remove numeric keys from matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                $action = $route['action'];

                if (is_callable($action)) {
                    call_user_func_array($action, $params);
                    return;
                }

                if (is_array($action)) {
                    $controllerName = $action[0];
                    $methodName = $action[1];

                    $controller = new $controllerName();
                    call_user_func_array([$controller, $methodName], $params);
                    return;
                }
            }
        }

        // 404 Handle
        http_response_code(404);
        echo "404 Not Found";
    }
}

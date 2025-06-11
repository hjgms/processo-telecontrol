<?php
namespace App\Core;

use App\Core\Request;
use App\Core\Response;

class Router {
    private $routes = [];

    public function register($method, $path, $handler) {
        $this->routes[strtoupper($method)][$this->normalizePath($path)] = $handler;
    }

    public function resolve($method, $path) {
        $method = strtoupper($method);
        $path = $this->normalizePath($path);

        // Verifica rota exata
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            return $this->callHandler($handler);
        }

        // Verifica rotas com parâmetros
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $routePattern = preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $route);
            $routePattern = str_replace('/', '\/', $routePattern);
            
            if (preg_match('/^' . $routePattern . '$/', $path, $matches)) {
                array_shift($matches);
                return $this->callHandler($handler, $matches);
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada']);
    }

    private function normalizePath($path) {
        return '/' . trim($path, '/');
    }

    private function callHandler($handler, $params = []) {
        if (is_array($handler)) {
            $className = $handler[0];
            $method = $handler[1];

            $request = new Request();
            $response = new Response();
            
            $controller = new $className();
            return call_user_func_array([$controller, $method], array_merge([$request, $response], $params));
        }
        
        return call_user_func_array($handler, $params);
    }
}
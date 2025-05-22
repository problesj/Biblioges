<?php

namespace App\Core;

class Router {
    private $routes = [];

    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function put($path, $handler) {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete($path, $handler) {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch($method, $path) {
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            if (is_string($handler)) {
                list($controller, $action) = explode('@', $handler);
                $controllerClass = "\\App\\Controllers\\{$controller}";
                $controllerInstance = new $controllerClass();
                return $controllerInstance->$action();
            }
            return $handler();
        }
        return false;
    }
} 
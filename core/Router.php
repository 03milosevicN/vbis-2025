<?php

namespace app\core;

class Router {

    public Request $request;
    public array $routes = [];
    public $notFoundCallback = null;
    
    public function __construct() {
        $this->request = new Request();
    }

    public function get($path, $callback): void {
        $this->routes['get'][$path] = $callback;
    }
    
    public function post($path, $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve() {

        $path = $this->request->handlePath();
        $method = $this->request->handleMethod();
        $callback = $this->routes[$method][$path] ?? false;

        //? static routing:
        if (is_array($callback)) {
            $callback[0] = new $callback[0]();

            return call_user_func($callback);
        }

        //? dynamic routing:
        foreach($this->routes[$method] as $route => $route_cb) {
            $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '(\d+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);

                if (is_array($route_cb)) {
                    $route_cb[0] = new $route_cb[0]();
                    return call_user_func_array($route_cb, $matches);
                }
            }
        }

        http_response_code(404);
        
        if ($this->notFoundCallback) {
            if (is_array($this->notFoundCallback)) {
                $controller = new $this->notFoundCallback[0]();
                return call_user_func([$controller, $this->notFoundCallback[1]]);
            } else {
                return call_user_func($this->notFoundCallback);
            }
        }

        echo "404 - could not be resolved. \n";
        exit;
    }

    public function notFound($callback): void {
        $this->notFoundCallback = $callback;
    }
    
}
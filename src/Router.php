<?php

namespace ElegantGlacier;

class Router {
    protected $routes = []; // stores routes

    public function addRoute(string $method, string $url, $target) {
        $this->routes[$method][$url] = $target;
    }

    public function matchRoute() {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Use named subpatterns in the regular expression pattern to capture each parameter value separately
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    // Pass the captured parameter values as named arguments to the target function
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    call_user_func_array($target, $params);
                    return;
                }
            }
        }

//        throw new \Exception('Route not found');
    }


    public function matchClassRoute() {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    list($controller, $action) = explode('@', $target);
                    $controller = "Controllers\\{$controller}";
                    if (class_exists($controller) && method_exists($controller, $action)) {
                        $controllerInstance = new $controller();
                        call_user_func_array([$controllerInstance, $action], $params);
                    } else {
                        header("HTTP/1.0 404 Not Found");
                        echo "Not Found";
                    }
                    return;
                }
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}

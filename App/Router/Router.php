<?php

namespace MyApp\Routes;

class Route
{
    protected $routes = [];

    public function add($method, $uri, $action)
    {
        $this->routes[strtoupper($method)][$uri] = $action;
    }

    public function get($uri, $action)
    {
        $this->add('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->add('POST', $uri, $action);
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];

            if (is_callable($action)) {
                call_user_func($action, $_REQUEST);
            } elseif (is_string($action)) {
                [$controllerClass, $method] = explode('@', $action);
                // Assuming the controller class names are fully qualified with namespaces
                $controller = new $controllerClass();
                call_user_func([$controller, $method]);
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "Route not found!";
        }
    }
}



    // public function handleRequest()
    // {
    //     $method = $_SERVER['REQUEST_METHOD'];
    //     $action = $_POST['action'] ?? $_GET['action'] ?? '';

    //     if (isset($this->routes[$method][$action])) {
    //         call_user_func($this->routes[$method][$action], $_REQUEST);
    //     } else {
    //         header("HTTP/1.0 404 Not Found");
    //         echo "Action not found!";
    //     }
    // }


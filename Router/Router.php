<?php
namespace route;
class Route
{
    protected $routes = [];

    public function post($uri, $controllerClass, $methodName)
    {
        $this->routes[] = [
            'method' => 'POST',
            'uri' => $uri,
            'controller' => $controllerClass,
            'method_name' => $methodName,
        ];
    }

    public function handleRequest($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] == $method && $route['uri'] == $uri) {
                $controller = new $route['controller']();
                $method = $route['method_name'];
                $controller->$method();
                return;
            }
        }

        echo "Route not found!";
    }
}
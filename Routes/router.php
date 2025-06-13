<?php
namespace Routes;
use \Exception;
require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

class Router
{
    protected $routes = [];


    public function addRoute(string $method, string $url, $target)
    {
        $this->routes[$method][$url] = $target;
    }

    public function addRoutes(string $method, array $routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($method, $route['url'], $route['target']);
        }
    }
    public function matchRoute()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        $params = $_GET;
        if ($params) {
            $url = strtok($url, '?');
            foreach ($params as $key => $value) {
                $_POST[$key] = $value;
            }
        }


        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {

                if ('/inventory' . $routeUrl === $url) {
                    if (gettype($target) == 'object') {
                        return call_user_func($target);
                    } elseif (gettype($target) == 'array') {
                        $class = $target[0];
                        $method = $target[1];

                        $class::$method($_POST);
                    }
                }
            }
        } else {
            throw new Exception('Route not found');

        }
    }


    public static function get($url, $target) {
        addRoute('GET', $url, $target);
    }
    public static function post($url, $target) {

    }
    public static function delete($url, $target) {

    }
}
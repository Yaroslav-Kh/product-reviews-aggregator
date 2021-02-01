<?php


namespace Engine\Core;
use Engine\Libraries\Helpers;

class RoutesGenerator
{

    private $route;
    private $routes = [];
    private $generated_routes = [];
    private $args = [];
    private $public_routes;
    private $private_routes;

    public function __construct($route)
    {

        $this->route = $route;
        $this->routes = loadFile('config', 'routes');

        $this->generated_routes = $this->generateRoutes($this->routes);

        $this->generateArgs($this->route);

    }

    private function conversionArgs($args = [])
    {
        $arguments = [];
        foreach ($args as $arg) {
            switch ($arg) {
                case $arg == '[s]':
                    $arguments[] = '(.*)';
                    break;
                case $arg == '[g]':
                    $arguments[] = '(\?.*)?';
                    break;
                case $arg == '[i]':
                    $arguments[] = '([0-9]*)';
                    break;
            }
        }

        return implode($arguments);

    }

    private function generateArgs($route)
    {

        foreach ($this->generated_routes as $generated_route) {

            if (preg_match("#^" . $generated_route['route'] . "$#",$route)) {
                $url_explode = explode('/',trim($route,'/'));
                $route_explode = explode('/',trim($generated_route['route'],'/'));

                for ($i = 0;$i < count($url_explode); $i++) {
                    if ($url_explode[$i] !== $route_explode[$i]) {
                        $this->args[] = $url_explode[$i] ;
                    }

                }
            }
        }

    }

    private function generateRoutes($routes = [])
    {


        foreach ($routes as $key => $value) {
            $route = $key;

            if (isset($value['args'])) {
                $args = $this->conversionArgs($value['args']);
                $route = $route . $args;
            }

            $this->generated_routes[$key] = [
                'name'       => $value['name'],
                'route'      => $route,
                'controller' => $value['namespace'] . '\\' . $value['controller'],
                'action'     => $value['action'],
            ];

        }

        return $this->generated_routes;
    }


    public function getRoutes()
    {
        return $this->generated_routes;
    }

    public function getArgs()
    {
        return $this->args;
    }
}
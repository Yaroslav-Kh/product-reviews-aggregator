<?php


namespace Engine\Core;

class Router
{
    private $route = '';
    private $routes = [];
    private $args;

    public function __construct()
    {
        $this->route = $_SERVER['REQUEST_URI'];

        $routesGenerator = new RoutesGenerator($this->route);
        $this->routes = $routesGenerator->getRoutes();
        $this->args = rawurldecode(implode('/', $routesGenerator->getArgs()));

    }

    public function run() {

		$matches = [];

        foreach ($this->routes as $route) {

            if (preg_match("#^" . $route['route'] . '$#',$this->route, $matches)) {

                if (class_exists($route['controller'])) {


                    if (method_exists(new $route['controller'],$route['action'])) {

                        echo call_user_func([new $route['controller'],$route['action']],  $this->args);
                    }
                }

                return true;
            }

        }


        if (!$matches) {
            echo call_user_func( [new \App\Controllers\NotFoundController(),'index'], $this->args);
        }
    }

}
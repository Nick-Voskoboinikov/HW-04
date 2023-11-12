<?php

namespace App\Core;

define('CONTROLLER_NAMESPACE', 'App\\controller\\');
use App\controller;

class Route {
    public static function start() {
        $controllerClassName= 'Home';
        $actionName = 'index';
        $payload = [];

        $routes = explode('/', $_SERVER['REQUEST_URI']);
        //var_dump($routes);

        if(!empty($routes[1])){
            $controllerClassName = ucfirst(strtolower($routes[1]));
        }

        if(!empty($routes[2])){
            $actionName = strtolower($routes[2]);
        }
        
        if(!empty($routes[3])){
            $payload = array_slice($routes, 3);
        }

        $controllerName = CONTROLLER_NAMESPACE . $controllerClassName;

        $controllerFile = $controllerClassName . '.php';

        $controllerPath = CONTROLLER . $controllerFile;

        // var_dump($controllerClassName);
        // die();

        if(file_exists($controllerPath)){
            include_once $controllerPath;
        } else {
            Route::Error();
        }

        $controller = new $controllerName();

        if(method_exists($controller, $actionName)){
            $controller->$actionName($payload);
        } else {
            Route::Error();
        }




    
    }

    public static function Error(){
        // die('requested page - '.$_SERVER['REQUEST_URI']); 
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location: /error');
    }

}

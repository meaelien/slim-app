<?php

namespace App\Support;

use Slim\App;

use Illuminate\Support\Str;

class Route{
    protected static $app;

    public static function setup(App &$app ){
        self::$app = $app;

        return $app;
    }

    public static function __callStatic($name, $arguments)
    {
        $app = self::$app;

        [$route, $action] = $arguments;

        self::validation($route, $name, $action);

        return is_callable($action) ? $app->$name($route, $action) : $app->$name($route, self::resoleViaController($action)); 
    }

    public static function resoleViaController($action){

        $class = Str::before($action, '@');
        $method = Str::after($action, '@');
        $controller = config('routing.controllers.namespace') . $class;


        return [$controller, $method];
    }

    protected static function validation($route, $name, $action){
        $exception = 'Unresolvable Callback/controller action';
        $context = json_encode(compact('route', 'name', 'action'));
        $fails = !(is_callable($action) || ( is_string($action) and Str::is("*@*", $action)));

        throw_when($fails, $exception . $context);
    }

}
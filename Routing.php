<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/ErrorController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/CarsController.php';
require_once 'src/controllers/ReservationController.php';
require_once 'src/controllers/AdminController.php';

class Router {
    public static $routes = [];
    private static $dependencies = [];
    private static $controllerDependencies = [];
    private static $controllerInstances = [];

    public static function init($dependencies, $controllerDependencies) {
        self::$dependencies = $dependencies;
        self::$controllerDependencies = $controllerDependencies;
    }

    public static function get($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function run($url) {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        if (!array_key_exists($action, self::$routes)) {
            ErrorController::getInstance()->error();
            return;
        }

        $controllerName = self::$routes[$action];
        $controller = self::getControllerInstance($controllerName);

        $action = $action ?: 'index';
        $id = $urlParts[1] ?? '';

        $controller->$action($id);
    }

    private static function getControllerInstance($controllerName) {
        if (!isset(self::$controllerInstances[$controllerName])) {
            $dependencies = [];
            if (isset(self::$controllerDependencies[$controllerName])) {
                foreach (self::$controllerDependencies[$controllerName] as $dependency) {
                    $dependencies[] = self::$dependencies[$dependency];
                }
            }
            self::$controllerInstances[$controllerName] = new $controllerName(...$dependencies);
        }
        return self::$controllerInstances[$controllerName];
    }
}
?>

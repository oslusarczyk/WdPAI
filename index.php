<?php

require_once 'Routing.php';
require_once 'src/controllers/AppController.php';

$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');

$path = parse_url( $path, PHP_URL_PATH);


function isAdmin() : bool{
    if(!isset($_SESSION['user'])){
        return false;
    }
    $user = unserialize($_SESSION['user']);
    return $user->getHasAdminPrivileges();
    var_dump(unserialize($_SESSION['user']));
}

if(isset($_SESSION['user'])){
    Router::get('main','CarsController');
    Router::get('cars','CarsController');
    Router::get('history','HistoryController');
    Router::get('carDetails','CarsController');
    Router::get('logout','SecurityController');
}

if(isAdmin()){
    Router::get('carAdmin','AdminController');
}
Router::get('', 'DefaultController');

Router::post('login','SecurityController');
Router::post('register','SecurityController');
Router::post('filterCars','CarsController');
Router::get('error','DefaultController');




Router::run($path);

?>
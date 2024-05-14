<?php

require_once 'Routing.php';
require_once 'src/controllers/AppController.php';

$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');

$path = parse_url( $path, PHP_URL_PATH);


if(isset($_SESSION['user'])){
    Router::get('main','CarsController');
    Router::get('cars','CarsController');
    Router::get('history','CarsController');
    Router::get('logout','SecurityController');
}
Router::get('', 'DefaultController');
Router::post('login','SecurityController');
Router::post('register','SecurityController');
Router::get('error','DefaultController');




Router::run($path);

?>
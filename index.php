<?php

require_once 'Routing.php';
require_once 'src/controllers/AppController.php';

$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');

$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::post('login','DefaultController');

Router::run($path);

?>
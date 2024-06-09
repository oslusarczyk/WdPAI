<?php

require_once 'Routing.php';
require_once 'src/controllers/AppController.php';

require_once 'src/repository/ReservationRepository.php';
require_once 'src/repository/UserRepository.php';
require_once 'src/repository/CarRepository.php';
require_once 'src/repository/LocationRepository.php';
require_once 'src/repository/BrandRepository.php';
require_once 'src/services/FileHandler.php';
require_once 'src/services/PasswordHandler.php';
require_once 'src/services/Validator.php';
require_once 'Database.php';

$controller = new AppController();
$database = Database::getInstance();

$reservationRepository = new ReservationRepository($database);
$carRepository = new CarRepository($database);
$locationRepository = new LocationRepository($database);
$brandRepository = new BrandRepository($database);
$userRepository = new UserRepository($database);
$fileHandler = new FileHandler();
$passwordHandler = new PasswordHandler();
$validator = new Validator();


$dependencies = [
    'userRepository' => $userRepository,
    'passwordHandler' => $passwordHandler,
    'reservationRepository' => $reservationRepository,
    'carRepository' => $carRepository,
    'locationRepository' => $locationRepository,
    'brandRepository' => $brandRepository,
    'fileHandler' => $fileHandler,
    'validator' => $validator,
];

$controllerDependencies = [
    'SecurityController' => ['userRepository', 'passwordHandler', 'validator'],
    'CarsController' => ['locationRepository', 'carRepository', 'brandRepository'],
    'ReservationController' => ['reservationRepository', 'validator'],
    'AdminController' => ['reservationRepository', 'carRepository', 'locationRepository', 'brandRepository', 'fileHandler', 'validator']
];

Router::init($dependencies, $controllerDependencies);

$path = trim($_SERVER['REQUEST_URI'], '/');

$path = parse_url( $path, PHP_URL_PATH);


function isAdmin() : bool{
    if(!isset($_SESSION['user'])){
        return false;
    }
    $user = unserialize($_SESSION['user']);
    return $user->getHasAdminPrivileges();
}

if(isset($_SESSION['user'])){
    Router::get('main','CarsController');
    Router::get('cars','CarsController');
    Router::get('history','ReservationController');
    Router::get('carDetails','CarsController');
    Router::get('logout','SecurityController');

    Router::post('filterCars','CarsController');
    Router::post('makeReservation','ReservationController');

}

if(isAdmin()){
    Router::get('carAdmin','AdminController');
    Router::get('addCar','AdminController');
    Router::post('handleReservation', 'AdminController');
}
Router::get('', 'DefaultController');
Router::get('error','DefaultController');

Router::post('login','SecurityController');
Router::post('register','SecurityController');


Router::run($path);

?>
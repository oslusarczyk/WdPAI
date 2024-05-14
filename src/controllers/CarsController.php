<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/LocationRepository.php';
require_once __DIR__.'/../models/Location.php';
require_once __DIR__.'/../repository/CarRepository.php';
require_once __DIR__.'/../models/Car.php';

class CarsController extends AppController

{
    private $locationRepository;
    private $carRepository;

    public function __construct(){
        parent::__construct();
        $this->locationRepository = new LocationRepository();
        $this->carRepository = new CarRepository();
    }

    public function main()
    {
        if(!$this->isGet()){
            return $this->render('main');
        }
        $locations = $this->locationRepository->getAllLocations();
        $cars = $this->carRepository->getAllCars();
        var_dump($cars);
        return $this->render('main', ['locations' => $locations, 'cars'=> $cars]);

    }

    public function cars()
    {
        return $this->render('cars');

    }

    public function history ()
    {
        return $this->render('history');

    }




}

?>

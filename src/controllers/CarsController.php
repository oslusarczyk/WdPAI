<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/LocationRepository.php';
require_once __DIR__.'/../models/Location.php';
require_once __DIR__.'/../repository/CarsRepository.php';
require_once __DIR__.'/../models/Car.php';

class CarsController extends AppController

{
    private $locationRepository;
    private $carsRepository;

    public function __construct(){
        parent::__construct();
        $this->locationRepository = new LocationRepository();
        $this->carsRepository = new CarsRepository();
    }

    public function main()
    {
        if(!$this->isGet()){
            return $this->render('main');
        }
        $locations = $this->locationRepository->getAllLocations();
        return $this->render('main', ['locations' => $locations]);

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

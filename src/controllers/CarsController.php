<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/LocationRepository.php';
require_once __DIR__.'/../models/Location.php';

class CarsController extends AppController

{
    private $locationRepository;

    public function __construct(){
        parent::__construct();
        $this->locationRepository = new LocationRepository();
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

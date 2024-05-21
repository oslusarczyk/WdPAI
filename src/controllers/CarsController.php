<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/LocationRepository.php';
require_once __DIR__.'/../repository/CarRepository.php';
require_once __DIR__.'/../repository/BrandRepository.php';
require_once __DIR__.'/../models/Location.php';
require_once __DIR__.'/../models/Car.php';
require_once __DIR__.'/../models/Brand.php';


class CarsController extends AppController

{
    private $locationRepository;
    private $carRepository;
    private $brandRepository;

    public function __construct(){
        parent::__construct();
        $this->locationRepository = new LocationRepository();
        $this->carRepository = new CarRepository();
        $this->brandRepository = new BrandRepository();
    }

    public function main()
    {
        if(!$this->isGet()){
            return $this->render('main');
        }
        $locations = $this->locationRepository->getAllLocations();
        $cars = $this->carRepository->getMostPopularCars();
        return $this->render('main', ['locations' => $locations, 'cars'=> $cars]);

    }

    public function cars()
    {
        if(!$this->isGet()){
            return $this->render('cars');
        }
        if(isset($_GET['location'])){
            $cars = $this->carRepository->getAllCars($_GET['location']);
        } else{
            $cars = $this->carRepository->getAllCars();
        }
        $locations = $this->locationRepository->getAllLocations();
        $brands = $this->brandRepository->getAllBrands();
    
        return $this->render('cars', ['locations' => $locations, 'brands' => $brands, 'cars' => $cars, 'selectedLocation'=> $_GET['location'] ?? '' ]);
    }

    public function filterCars(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);
            $seatsValue = intval($decoded['seats']);
            $minPriceValue = intval($decoded['price_min']);
            $maxPriceValue = intval($decoded['price_max']);
            echo json_encode($this->carRepository->getAllCars($decoded['location'],$decoded['brand'],$seatsValue,$minPriceValue,$maxPriceValue));
            
        }
    }

    public function history ()
    {
        return $this->render('history');

    }

    public function carDetails(){
        if(!$this->isGet()){
            return $this->render('carDetails');
        }

        if(isset($_GET['id'])){
            $car_id = $_GET['id'];
        }
        $locations = $this->locationRepository->getLocationsByCar($car_id);
        $car = $this->carRepository->getCarById($car_id);
        return $this->render('carDetails', ['car' => $car, 'locations' => $locations]);
    }




}

?>

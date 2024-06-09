<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/ILocationRepository.php';
require_once __DIR__.'/../repository/ICarRepository.php';
require_once __DIR__.'/../repository/IBrandRepository.php';
require_once __DIR__.'/../models/Location.php';
require_once __DIR__.'/../models/Car.php';
require_once __DIR__.'/../models/Brand.php';

class CarsController extends AppController
{
    private ILocationRepository $locationRepository;
    private ICarRepository $carRepository;
    private IBrandRepository $brandRepository;

    public function __construct(ILocationRepository $locationRepository, ICarRepository $carRepository, IBrandRepository $brandRepository){
        parent::__construct();
        $this->locationRepository = $locationRepository;
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
    }

    public function main(): void
    {
        if (!$this->isGet()) {
            $this->render('main');
            return;
        }

        $locations = $this->locationRepository->getAllLocations();
        $cars = $this->carRepository->getMostPopularCars();
        $this->render('main', ['locations' => $locations, 'cars' => $cars]);
    }

    public function cars(): void
    {
        if (!$this->isGet()) {
            $this->render('cars');
            return;
        }

        $location = $_GET['location'] ?? null;
        $cars = $this->carRepository->getAllCars($location);
        $locations = $this->locationRepository->getAllLocations();
        $brands = $this->brandRepository->getAllBrands();

        $this->render('cars', [
            'locations' => $locations,
            'brands' => $brands,
            'cars' => $cars,
            'selectedLocation' => $location ?? ''
        ]);
    }

    public function filterCars(): void
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType !== "application/json") {
            return;
        }

        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);


        header('Content-type: application/json');
        http_response_code(200);

        $seatsValue = intval($decoded['seats']);
        $minPriceValue = intval($decoded['price_min']);
        $maxPriceValue = intval($decoded['price_max']);
        $filteredCars = $this->carRepository->getAllCars(
            $decoded['location'],
            $decoded['brand'],
            $seatsValue,
            $minPriceValue,
            $maxPriceValue
        );

        echo json_encode($filteredCars);
    }

    public function carDetails(): void
    {
        if (!$this->isGet()) {
            $this->render('carDetails');
            return;
        }

        if (!isset($_GET['id'])) {
            $this->render('carDetails');
            return;
        }



        $car_id = $_GET['id'];
        $car = $this->carRepository->getCarById($car_id);
        if (!$car) {
            $this->render('carDetails', ['messages' => ['Nie znaleziono samochodu o takim id.']]);
            return;
        }
        $locations = $this->locationRepository->getLocationsByCar($car_id);

        $this->render('carDetails', ['car' => $car, 'locations' => $locations]);
    }
}
?>

<?php
require_once 'AppController.php';

require_once __DIR__.'/../repository/ReservationRepository.php';
require_once __DIR__.'/../repository/CarRepository.php';
require_once __DIR__.'/../models/Reservation.php';
require_once __DIR__.'/../models/Car.php';

class AdminController extends AppController

{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/uploads/';
    private $message = [];
    private $reservationRepository;
    private $carRepository;
    private $locationRepository;
    private $brandRepository;
    public function __construct(){
        parent::__construct();
        $this->reservationRepository = new ReservationRepository();
        $this->carRepository = new CarRepository();
        $this->locationRepository = new LocationRepository();
        $this->brandRepository = new BrandRepository();
    }



    public function carAdmin()
    {
        if(!$this->isGet()){
            return $this->render('carAdmin');
        }

        $reservationsToManage = $this->reservationRepository->getPendingReservations();
        return $this->render("carAdmin",['reservations' => $reservationsToManage]);
    }

    function handleReservation(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);
            $this->reservationRepository->updateReservationStatus($decoded['action'],$decoded['reservation_id']);
        }
    }

    function addCar(){
        if($this->isPost() && $this->validateFile($_FILES['car_photo'])){
            if($this->validateForm($_POST)){
                $brand_id = intval($_POST['brand']);
                $model = $_POST['model_select'];
                $price = intval($_POST['price_input']);
                $seats = intval($_POST['seats']);
                $car_photo = $_FILES['car_photo']['name'];
                $production_year = intval($_POST['production_year']);
                $locations = $_POST['locations'];
                $description = htmlentities($_POST['car_description']);

                $this->upload_file($_FILES['car_photo']);
                $car = new Car($brand_id,$model,$price,$seats,$car_photo,"" , 0, $production_year, $description);
                $this->carRepository->addCar($car,$locations);

            };
        }

        $locations = $this->locationRepository->getAllLocations();
        $brands = $this->brandRepository->getAllBrands();
        return $this->render('addCar',['locations' => $locations, 'brands' => $brands,'messages' => $this->message]);
    }


    private function validateFile(array $file): bool
    {
        if (!is_uploaded_file($file['tmp_name'])){
            $this->message[] = 'Brak pliku';
            return false;
        }
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'Wybrany plik jest za duży';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'Wybrany plik ma złe rozszerzenie.';
            return false;
        }
        return true;
    }

    private function validateForm(array $post_data) :bool
    {
        $required_fields = [
            'brand',
            'model_select',
            'price_input',
            'seats',
            'production_year',
            'locations',
            'car_description'
        ];

        foreach ($required_fields as $field) {
            if (empty($post_data[$field])) {
                $this->message[] = 'Brak podanej wartości';
                return false;

            }
            if ($field === 'locations' && !is_array($post_data[$field])){
                $this->message[] = 'Brak podanych lokalizacji dla samochodu';
                return false;
            }
        }
        return true;
    }

//    private function addLocations($returned_id, mixed $locations)
//    {
//
//    }
    private function upload_file(mixed $car_photo): void
    {
        move_uploaded_file(
            $car_photo['tmp_name'],
            dirname(__DIR__) . self::UPLOAD_DIRECTORY . $car_photo['name']
        );
    }

}
?>

<?php
require_once 'AppController.php';

require_once __DIR__.'/../models/Reservation.php';
require_once __DIR__.'/../models/Car.php';
require_once __DIR__.'/../services/IFileHandler.php';

class AdminController extends AppController
{

    private array $message = [];
    private IReservationRepository $reservationRepository;
    private ICarRepository $carRepository;
    private ILocationRepository $locationRepository;
    private IBrandRepository $brandRepository;
    private IFileHandler $fileHandler;
    private IValidator $validator;

    public function __construct(
        IReservationRepository $reservationRepository,
        ICarRepository $carRepository,
        ILocationRepository $locationRepository,
        IBrandRepository $brandRepository,
        IFileHandler $fileHandler,
        IValidator $validator
    ){
        parent::__construct();
        $this->reservationRepository = $reservationRepository;
        $this->carRepository = $carRepository;
        $this->locationRepository = $locationRepository;
        $this->brandRepository = $brandRepository;
        $this->fileHandler = $fileHandler;
        $this->validator = $validator;
    }

    public function carAdmin() :void
    {
        $reservationsToManage = $this->reservationRepository->getPendingReservations();
        $this->render("carAdmin", ['reservations' => $reservationsToManage]);
    }

    public function handleReservation() : void{
        if(!$this->isPost()){
            return;
        }

        $action = $_POST['action'] ?? null;
        $reservationId = $_POST['reservation_id'] ?? null;

        if ($action === null || $reservationId === null) {
            return;
        }

        $this->reservationRepository->updateReservationStatus($action, $reservationId);
        $this->redirectToReferer();
    }

    public function addCar(): void
    {
        if ($this->isPost()) {
            if (!$this->fileHandler->validate($_FILES['car_photo'])) {
                $this->message[] = $this->fileHandler->getError();
            }

            if (!$this->validator->validateCarForm($_POST)) {
                $this->message[] = 'Brak wypełnionego formularza';
            }

            if (empty($this->message)) {
                $brand_id = intval($_POST['brand']);
                $model = $_POST['model_select'];
                $price = intval($_POST['price_input']);
                $seats = intval($_POST['seats']);
                $car_photo = $_FILES['car_photo']['name'];
                $production_year = intval($_POST['production_year']);
                $locations = $_POST['locations'];
                $description = htmlentities($_POST['car_description']);

                $this->fileHandler->upload($_FILES['car_photo']);

                $car = (new CarBuilder())
                    ->setBrand($brand_id)
                    ->setModel($model)
                    ->setPricePerDay($price)
                    ->setSeatsAvailable($seats)
                    ->setPhoto($car_photo)
                    ->setProductionYear($production_year)
                    ->setCarDescription($description)
                    ->build();
                $this->carRepository->addCar($car, $locations);

                $this->redirectToReferer();
            }
        }

        $locations = $this->locationRepository->getAllLocations();
        $brands = $this->brandRepository->getAllBrands();
        $this->render('addCar', ['locations' => $locations, 'brands' => $brands, 'messages' => $this->message]);
    }




}
?>
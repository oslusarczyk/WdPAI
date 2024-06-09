<?php

use PHPUnit\Framework\TestCase;

require_once 'src/controllers/AdminController.php';
require_once 'src/repository/IReservationRepository.php';
require_once 'src/repository/ICarRepository.php';
require_once 'src/repository/ILocationRepository.php';
require_once 'src/repository/IBrandRepository.php';
require_once 'src/models/Reservation.php';
require_once 'src/models/CarBuilder.php';
require_once  'src/services/Validator.php';
require_once 'src/services/IFileHandler.php';

class AdminControllerTest extends TestCase
{
    private $reservationRepositoryMock;
    private $carRepositoryMock;
    private $locationRepositoryMock;
    private $brandRepositoryMock;
    private $fileHandlerMock;
    private $validatorMock;
    private $adminController;

    protected function setUp(): void
    {
        $this->reservationRepositoryMock = $this->createMock(IReservationRepository::class);
        $this->carRepositoryMock = $this->createMock(ICarRepository::class);
        $this->locationRepositoryMock = $this->createMock(ILocationRepository::class);
        $this->brandRepositoryMock = $this->createMock(IBrandRepository::class);
        $this->fileHandlerMock = $this->createMock(IFileHandler::class);
        $this->validatorMock = $this->createMock(Validator::class);

        $this->adminController = $this->getMockBuilder(AdminController::class)
            ->setConstructorArgs([
                $this->reservationRepositoryMock,
                $this->carRepositoryMock,
                $this->locationRepositoryMock,
                $this->brandRepositoryMock,
                $this->fileHandlerMock,
                $this->validatorMock
            ])
            ->onlyMethods(['render', 'isGet', 'isPost','redirectToReferer'])
            ->getMock();
    }



    public function testCarAdminRendersViewWhenGetRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $reservations = ['reservation1', 'reservation2'];
        $this->reservationRepositoryMock->method('getPendingReservations')->willReturn($reservations);

        $this->adminController->expects($this->once())
            ->method('render')
            ->with('carAdmin', ['reservations' => $reservations]);

        $this->adminController->carAdmin();
    }

    public function testHandleReservationUpdatesReservationAndRedirects()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->adminController->method('isPost')->willReturn(true);

        $_POST['action'] = 'approve';
        $_POST['reservation_id'] = 123;

        $this->reservationRepositoryMock->expects($this->once())
            ->method('updateReservationStatus')
            ->with('approve', 123);

        $this->expectOutputString('');

        $this->adminController->handleReservation();

    }

    public function testHandleReservationDoesNothingWhenNotPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->adminController->method('isPost')->willReturn(false);

        $this->reservationRepositoryMock->expects($this->never())
            ->method('updateReservationStatus');

        $this->expectOutputString('');

        $this->adminController->handleReservation();
    }

    public function testAddCarRendersViewWhenNotPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->adminController->method('isPost')->willReturn(false);

        $locations = ['location1', 'location2'];
        $brands = ['brand1', 'brand2'];

        $this->locationRepositoryMock->method('getAllLocations')->willReturn($locations);
        $this->brandRepositoryMock->method('getAllBrands')->willReturn($brands);

        $this->adminController->expects($this->once())
            ->method('render')
            ->with('addCar', ['locations' => $locations, 'brands' => $brands, 'messages' => []]);

        $this->adminController->addCar();
    }

    public function testAddCarValidatesAndAddsCarWhenPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->adminController->method('isPost')->willReturn(true);

        $_FILES['car_photo'] = ['name' => 'photo.jpg', 'tmp_name' => 'tmp_photo.jpg', 'error' => 0];
        $_POST = [
            'brand' => 1,
            'model_select' => 'Model S',
            'price_input' => 100,
            'seats' => 4,
            'production_year' => 2020,
            'locations' => [1, 2],
            'car_description' => 'Description'
        ];

        $this->fileHandlerMock->method('validate')->willReturn(true);
        $this->validatorMock->method('validateCarForm')->willReturn(true);

        $this->fileHandlerMock->expects($this->once())->method('upload')->with($_FILES['car_photo']);

        $this->carRepositoryMock->expects($this->once())
            ->method('addCar')
            ->with($this->callback(function ($car) {
                return $car->getBrand() == 1 && $car->getModel() == 'Model S';
            }), [1, 2]);



        $this->adminController->addCar();

    }

}
?>

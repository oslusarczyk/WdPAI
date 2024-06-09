<?php

use PHPUnit\Framework\TestCase;

require_once 'src/controllers/CarsController.php';
require_once 'src/models/Location.php';
require_once 'src/models/Car.php';
require_once 'src/models/Brand.php';

class CarsControllerTest extends TestCase
{
    private $locationRepositoryMock;
    private $carRepositoryMock;
    private $brandRepositoryMock;
    private $carsController;

    protected function setUp(): void
    {
        $this->locationRepositoryMock = $this->getMockBuilder(ILocationRepository::class)
            ->getMock();

        $this->carRepositoryMock = $this->getMockBuilder(ICarRepository::class)
            ->getMock();

        $this->brandRepositoryMock = $this->getMockBuilder(IBrandRepository::class)
            ->getMock();

        $this->carsController = new CarsController($this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock);
    }


    public function testMainRendersMainPageWhenNotGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(false);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('main');

        $this->carsController->main();
    }

    public function testMainRendersMainPageWithLocationsAndCars()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $locations = [new Location('Location 1', 1), new Location('Location 2', 2)];
        $cars = [new Car('Brand 1', 'Model 1', 100, 4, 'photo1.png', 'Location 1', 1, 2020, 'Description 1'),
            new Car('Brand 2', 'Model 2', 200, 5, 'photo2.png', 'Location 2', 2, 2021, 'Description 2')];


        $this->locationRepositoryMock->expects($this->once())
            ->method('getAllLocations')
            ->willReturn($locations);

        $this->carRepositoryMock->expects($this->once())
            ->method('getMostPopularCars')
            ->willReturn($cars);

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(true);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('main', ['locations' => $locations, 'cars' => $cars]);

        $this->carsController->main();
    }

    public function testCarsRendersCarsPageWhenNotGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(false);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('cars');

        $this->carsController->cars();
    }

    public function testCarsRendersCarsPageWithLocationsBrandsAndCars()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['location'] = 'Location 1';

        $locations = [new Location('Location 1', 1), new Location('Location 2', 2)];
        $brands = [new Brand('Brand 1', 1), new Brand('Brand 2', 2)];
        $cars = [new Car('Brand 1', 'Model 1', 100, 4, 'photo1.png', 'Location 1', 1, 2020, 'Description 1'),
            new Car('Brand 2', 'Model 2', 200, 5, 'photo2.png', 'Location 2', 2, 2021, 'Description 2')];

        $this->carRepositoryMock->expects($this->once())
            ->method('getAllCars')
            ->with('Location 1')
            ->willReturn($cars);

        $this->locationRepositoryMock->expects($this->once())
            ->method('getAllLocations')
            ->willReturn($locations);

        $this->brandRepositoryMock->expects($this->once())
            ->method('getAllBrands')
            ->willReturn($brands);

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(true);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('cars', [
                'locations' => $locations,
                'brands' => $brands,
                'cars' => $cars,
                'selectedLocation' => 'Location 1'
            ]);

        $this->carsController->cars();
    }

    public function testCarDetailsRendersCarDetailsPageWhenNotGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(false);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('carDetails');

        $this->carsController->carDetails();
    }

    public function testCarDetailsRendersCarDetailsPageWhenNoId()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(true);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('carDetails');

        $this->carsController->carDetails();
    }

    public function testCarDetailsRendersErrorWhenCarNotFound()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['id'] = 1;

        $this->carRepositoryMock->expects($this->once())
            ->method('getCarById')
            ->with(1)
            ->willReturn([]);

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(true);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('carDetails', ['messages' => ['Nie znaleziono samochodu o takim id.']]);

        $this->carsController->carDetails();
    }

    public function testCarDetailsRendersCarDetailsPageWithCarAndLocations()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['id'] = 1;

        $car = [
            'brand_name' => 'Brand 1',
            'model' => 'Model 1',
            'price_per_day' => 100,
            'seats_available' => 4,
            'photo' => 'photo1.png',
            'locations' => 'Location 1',
            'car_id' => 1,
            'production_year' => 2020,
            'car_description' => 'Description 1'
        ];
        $locations = [new Location('Location 1', 1), new Location('Location 2', 2)];

        $this->carRepositoryMock->expects($this->once())
            ->method('getCarById')
            ->with(1)
            ->willReturn($car);

        $this->locationRepositoryMock->expects($this->once())
            ->method('getLocationsByCar')
            ->with(1)
            ->willReturn($locations);

        $this->carsController = $this->getMockBuilder(CarsController::class)
            ->setConstructorArgs([$this->locationRepositoryMock, $this->carRepositoryMock, $this->brandRepositoryMock])
            ->onlyMethods(['render', 'isGet'])
            ->getMock();

        $this->carsController->expects($this->once())
            ->method('isGet')
            ->willReturn(true);

        $this->carsController->expects($this->once())
            ->method('render')
            ->with('carDetails', ['car' => $car, 'locations' => $locations]);

        $this->carsController->carDetails();
    }
}

?>

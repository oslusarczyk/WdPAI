<?php

use PHPUnit\Framework\TestCase;

require_once 'src/repository/CarRepository.php';
require_once 'src/models/Car.php';
require_once 'src/models/CarBuilder.php';

class CarRepositoryTest extends TestCase
{
    private $mockDatabase;
    private $mockConnection;
    private $mockStatement;
    private $carRepository;

    protected function setUp(): void
    {
        $this->mockDatabase = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockConnection = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockStatement = $this->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockDatabase->method('getConnection')
            ->willReturn($this->mockConnection);

        $this->carRepository = new CarRepository($this->mockDatabase);
        $this->setProtectedProperty($this->carRepository, 'database', $this->mockDatabase);
    }

    private function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    public function testGetAllCars()
    {
        $carsData = [
            ['brand_name' => 'Toyota', 'model' => 'Corolla', 'price_per_day' => 100, 'seats_available' => 4, 'photo' => 'photo.png', 'locations' => 'Location A', 'car_id' => 1],
            ['brand_name' => 'Honda', 'model' => 'Civic', 'price_per_day' => 90, 'seats_available' => 4, 'photo' => 'photo2.png', 'locations' => 'Location B', 'car_id' => 2]
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM all_cars WHERE 1=1'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($carsData);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $cars = $this->carRepository->getAllCars();

        $this->assertCount(2, $cars);
        $this->assertEquals($carsData, $cars);
    }

    public function testGetMostPopularCars()
    {
        $carsData = [
            ['brand_name' => 'Toyota', 'model' => 'Corolla', 'price_per_day' => 100, 'seats_available' => 4, 'photo' => 'photo.png', 'locations' => 'Location A', 'car_id' => 1, 'reservation_count' => 10],
            ['brand_name' => 'Honda', 'model' => 'Civic', 'price_per_day' => 90, 'seats_available' => 4, 'photo' => 'photo2.png', 'locations' => 'Location B', 'car_id' => 2, 'reservation_count' => 5]
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT all_cars.*, reservation_counts.reservation_count'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($carsData);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $cars = $this->carRepository->getMostPopularCars();

        $this->assertCount(2, $cars);
        $this->assertInstanceOf(ICar::class, $cars[0]);
        $this->assertInstanceOf(ICar::class, $cars[1]);
    }

    public function testGetCarById()
    {
        $carId = 1;
        $expectedResult = [
            'car_id' => 1,
            'brand_name' => 'Brand1',
            'model' => 'Model1'
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM all_cars'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('bindParam')
            ->with(':id', $carId, PDO::PARAM_INT);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetch')
            ->willReturn($expectedResult);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $result = $this->carRepository->getCarById($carId);
        $this->assertEquals($expectedResult, $result);
    }

}
?>

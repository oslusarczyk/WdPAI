<?php

use PHPUnit\Framework\TestCase;

require_once 'src/repository/ReservationRepository.php';
require_once 'src/models/ReservationBuilder.php';
require_once 'src/repository/IReservationRepository.php';

class ReservationRepositoryTest extends TestCase
{
    private $mockDatabase;
    private $mockConnection;
    private $mockStatement;
    private $reservationRepository;

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

        $this->reservationRepository = new ReservationRepository($this->mockDatabase);
        $this->setProtectedProperty($this->reservationRepository, 'database', $this->mockDatabase);
    }

    private function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    public function testGetRepositoryByEmail()
    {
        $email = 'test@example.com';
        $status = 'confirmed';
        $expectedResult = [
            ['reservation_id' => 1, 'car_name' => 'Car1', 'location_name' => 'Location1', 'photo' => 'photo1', 'reservation_start_date' => '2023-01-01', 'reservation_end_date' => '2023-01-10', 'reservation_price' => 100, 'reservation_status' => 'confirmed', 'email' => 'test@example.com'],
            ['reservation_id' => 2, 'car_name' => 'Car2', 'location_name' => 'Location2', 'photo' => 'photo2', 'reservation_start_date' => '2023-02-01', 'reservation_end_date' => '2023-02-10', 'reservation_price' => 200, 'reservation_status' => 'confirmed', 'email' => 'test@example.com']
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('WHERE email=:email'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->exactly(2))
            ->method('bindParam')
            ->willReturnCallback(function ($param, $value, $type) use ($email, $status) {
                if ($param == ':email') {
                    $this->assertEquals($email, $value);
                    $this->assertEquals(PDO::PARAM_STR, $type);
                } elseif ($param == ':status') {
                    $this->assertEquals($status, $value);
                    $this->assertEquals(PDO::PARAM_STR, $type);
                }
                return true;
            });

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedResult);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $result = $this->reservationRepository->getRepositoryByEmail($email, $status);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(IReservation::class, $result[0]);
        $this->assertEquals('Car1', $result[0]->getCarName());
        $this->assertEquals('Location1', $result[0]->getLocationName());
    }

    public function testGetPendingReservations()
    {
        $expectedResult = [
            ['reservation_id' => 1, 'car_name' => 'Car1', 'location_name' => 'Location1', 'photo' => 'photo1', 'reservation_start_date' => '2023-01-01', 'reservation_end_date' => '2023-01-10', 'reservation_price' => 100, 'reservation_status' => 'pending', 'email' => 'test1@example.com'],
            ['reservation_id' => 2, 'car_name' => 'Car2', 'location_name' => 'Location2', 'photo' => 'photo2', 'reservation_start_date' => '2023-02-01', 'reservation_end_date' => '2023-02-10', 'reservation_price' => 200, 'reservation_status' => 'pending', 'email' => 'test2@example.com']
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains("WHERE reservation_status='pending'"))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedResult);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $result = $this->reservationRepository->getPendingReservations();
        $this->assertCount(2, $result);
        $this->assertInstanceOf(IReservation::class, $result[0]);
        $this->assertEquals('Car1', $result[0]->getCarName());
        $this->assertEquals('Location1', $result[0]->getLocationName());
    }

    public function testAddReservation()
    {
        $reservationEndDate = '2023-01-10';
        $reservationStartDate = '2023-01-01';
        $locationId = 1;
        $carId = 1;
        $userId = 1;

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains("INSERT INTO reservations"))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('execute')
            ->with([$userId, $carId, $locationId, $reservationStartDate, $reservationEndDate]);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $this->reservationRepository->addReservation($reservationEndDate, $reservationStartDate, $locationId, $carId, $userId);
    }

    public function testUpdateReservationStatus()
    {
        $action = 'confirmed';
        $reservationId = 1;

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains("UPDATE reservations"))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->exactly(2))
            ->method('bindParam')
            ->willReturnCallback(function ($param, $value, $type) use ($action, $reservationId) {
                if ($param == ':action') {
                    $this->assertEquals($action, $value);
                    $this->assertEquals(PDO::PARAM_STR, $type);
                } elseif ($param == ':id') {
                    $this->assertEquals($reservationId, $value);
                    $this->assertEquals(PDO::PARAM_INT, $type);
                }
                return true;
            });
        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $this->reservationRepository->updateReservationStatus($action, $reservationId);
    }
}

?>

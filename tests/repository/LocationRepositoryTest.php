<?php

use PHPUnit\Framework\TestCase;

require_once 'src/repository/LocationRepository.php';
require_once 'src/models/Location.php';
require_once 'src/repository/ILocationRepository.php';

class LocationRepositoryTest extends TestCase
{
    private $mockDatabase;
    private $mockConnection;
    private $mockStatement;
    private $locationRepository;

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

        $this->locationRepository = new LocationRepository($this->mockDatabase);
        $this->setProtectedProperty($this->locationRepository, 'database', $this->mockDatabase);
    }

    private function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    public function testGetAllLocations()
    {
        $expectedResult = [
            ['location_id' => 1, 'location_name' => 'Location1'],
            ['location_id' => 2, 'location_name' => 'Location2']
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM locations'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedResult);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $result = $this->locationRepository->getAllLocations();
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Location::class, $result[0]);
        $this->assertEquals('Location1', $result[0]->getLocationName());
        $this->assertEquals(1, $result[0]->getLocationId());
    }

    public function testGetLocationsByCar()
    {
        $carId = 1;
        $expectedResult = [
            ['location_id' => 1, 'location_name' => 'Location1'],
            ['location_id' => 2, 'location_name' => 'Location2']
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM public.locations'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('bindParam')
            ->with(':id', $carId, PDO::PARAM_INT);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedResult);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $result = $this->locationRepository->getLocationsByCar($carId);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Location::class, $result[0]);
        $this->assertEquals('Location1', $result[0]->getLocationName());
        $this->assertEquals(1, $result[0]->getLocationId());
    }
}

?>

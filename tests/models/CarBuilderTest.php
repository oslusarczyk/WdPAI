<?php

use PHPUnit\Framework\TestCase;

require_once 'src/models/Car.php';
require_once 'src/models/CarBuilder.php';


class CarBuilderTest extends TestCase
{
    public function testBuildCreatesCarWithCorrectDefaultValues()
    {
        $carBuilder = new CarBuilder();
        $car = $carBuilder->build();

        $this->assertEquals('', $car->getBrand());
        $this->assertEquals('', $car->getModel());
        $this->assertEquals(0, $car->getPricePerDay());
        $this->assertEquals(0, $car->getSeatsAvailable());
        $this->assertEquals('', $car->getPhoto());
        $this->assertEquals('', $car->getLocations());
        $this->assertEquals(0, $car->getId());
        $this->assertEquals(0, $car->getProductionYear());
        $this->assertEquals('', $car->getCarDescription());
    }

    public function testBuildCreatesCarWithSpecifiedValues()
    {
        $carBuilder = new CarBuilder();
        $car = $carBuilder
            ->setBrand('Toyota')
            ->setModel('Corolla')
            ->setPricePerDay(100)
            ->setSeatsAvailable(5)
            ->setPhoto('photo.jpg')
            ->setLocations('Kraków')
            ->setId(1)
            ->setProductionYear(2020)
            ->setCarDescription('Fajne auto')
            ->build();

        $this->assertEquals('Toyota', $car->getBrand());
        $this->assertEquals('Corolla', $car->getModel());
        $this->assertEquals(100, $car->getPricePerDay());
        $this->assertEquals(5, $car->getSeatsAvailable());
        $this->assertEquals('photo.jpg', $car->getPhoto());
        $this->assertEquals('Kraków', $car->getLocations());
        $this->assertEquals(1, $car->getId());
        $this->assertEquals(2020, $car->getProductionYear());
        $this->assertEquals('Fajne auto', $car->getCarDescription());
    }

}

?>

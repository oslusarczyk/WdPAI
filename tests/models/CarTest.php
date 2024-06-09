<?php


use PHPUnit\Framework\TestCase;

require_once 'src/models/Car.php';


class CarTest extends TestCase
{
    private $car;

    protected function setUp(): void
    {
        $this->car = new Car(
            'Toyota',
            'Corolla',
            100,
            5,
            'photo.jpg',
            'Kraków',
            1,
            2020,
            'Fajne auto'
        );
    }

    public function testConstructorSetsBrand()
    {
        $this->assertEquals('Toyota', $this->car->getBrand());
    }

    public function testConstructorSetsModel()
    {
        $this->assertEquals('Corolla', $this->car->getModel());
    }

    public function testConstructorSetsPricePerDay()
    {
        $this->assertEquals(100, $this->car->getPricePerDay());
    }

    public function testConstructorSetsSeatsAvailable()
    {
        $this->assertEquals(5, $this->car->getSeatsAvailable());
    }

    public function testConstructorSetsPhoto()
    {
        $this->assertEquals('photo.jpg', $this->car->getPhoto());
    }

    public function testConstructorSetsLocations()
    {
        $this->assertEquals('Kraków', $this->car->getLocations());
    }

    public function testConstructorSetsId()
    {
        $this->assertEquals(1, $this->car->getId());
    }

    public function testConstructorSetsProductionYear()
    {
        $this->assertEquals(2020, $this->car->getProductionYear());
    }

    public function testConstructorSetsCarDescription()
    {
        $this->assertEquals('Fajne auto', $this->car->getCarDescription());
    }


    public function testConstructorSetsDefaultValues()
    {
        $car = new Car();
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

}



<?php

use PHPUnit\Framework\TestCase;

require_once 'src/models/Reservation.php';

class ReservationTest extends TestCase
{
    private $reservation;

    protected function setUp(): void
    {
        $this->reservation = new Reservation(
            'Toyota Corolla',
            'Kraków',
            'photo.jpg',
            '2023-05-01',
            '2023-05-10',
            '500',
            'confirmed',
            'test@example.com',
            1
        );
    }

    public function testConstructorSetsCarName()
    {
        $this->assertEquals('Toyota Corolla', $this->reservation->getCarName());
    }

    public function testConstructorSetsLocationName()
    {
        $this->assertEquals('Kraków', $this->reservation->getLocationName());
    }

    public function testConstructorSetsPhoto()
    {
        $this->assertEquals('photo.jpg', $this->reservation->getPhoto());
    }

    public function testConstructorSetsReservationStartDate()
    {
        $this->assertEquals('2023-05-01', $this->reservation->getReservationStartDate());
    }

    public function testConstructorSetsReservationEndDate()
    {
        $this->assertEquals('2023-05-10', $this->reservation->getReservationEndDate());
    }

    public function testConstructorSetsReservationPrice()
    {
        $this->assertEquals('500', $this->reservation->getReservationPrice());
    }

    public function testConstructorSetsReservationStatus()
    {
        $this->assertEquals('confirmed', $this->reservation->getReservationStatus());
    }

    public function testConstructorSetsEmail()
    {
        $this->assertEquals('test@example.com', $this->reservation->getEmail());
    }

    public function testConstructorSetsReservationId()
    {
        $this->assertEquals(1, $this->reservation->getReservationId());
    }


    public function testConstructorSetsDefaultValues()
    {
        $reservation = new Reservation(
            'Toyota Corolla',
            'Kraków',
            'photo.jpg',
            '2023-05-01',
            '2023-05-10',
            '500',
            'confirmed',
            'test@example.com',
        );
        $this->assertEquals(0, $reservation->getReservationId());
    }

}

?>

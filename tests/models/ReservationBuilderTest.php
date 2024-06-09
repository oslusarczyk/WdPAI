<?php

use PHPUnit\Framework\TestCase;

require_once 'src/models/Reservation.php';
require_once 'src/models/ReservationBuilder.php';

class ReservationBuilderTest extends TestCase
{
    public function testBuildCreatesReservationWithCorrectDefaultValues()
    {
        $reservationBuilder = new ReservationBuilder();
        $reservation = $reservationBuilder->build();

        $this->assertEquals('', $reservation->getCarName());
        $this->assertEquals('', $reservation->getLocationName());
        $this->assertEquals('', $reservation->getPhoto());
        $this->assertEquals('', $reservation->getReservationStartDate());
        $this->assertEquals('', $reservation->getReservationEndDate());
        $this->assertEquals('', $reservation->getReservationPrice());
        $this->assertEquals('', $reservation->getReservationStatus());
        $this->assertEquals('', $reservation->getEmail());
        $this->assertEquals(0, $reservation->getReservationId());
    }

    public function testBuildCreatesReservationWithSpecifiedValues()
    {
        $reservationBuilder = new ReservationBuilder();
        $reservation = $reservationBuilder
            ->setCarName('Toyota Corolla')
            ->setLocationName('Kraków')
            ->setPhoto('photo.jpg')
            ->setReservationStartDate('2023-05-01')
            ->setReservationEndDate('2023-05-10')
            ->setReservationPrice('500')
            ->setReservationStatus('confirmed')
            ->setEmail('test@example.com')
            ->setReservationId(1)
            ->build();

        $this->assertEquals('Toyota Corolla', $reservation->getCarName());
        $this->assertEquals('Kraków', $reservation->getLocationName());
        $this->assertEquals('photo.jpg', $reservation->getPhoto());
        $this->assertEquals('2023-05-01', $reservation->getReservationStartDate());
        $this->assertEquals('2023-05-10', $reservation->getReservationEndDate());
        $this->assertEquals('500', $reservation->getReservationPrice());
        $this->assertEquals('confirmed', $reservation->getReservationStatus());
        $this->assertEquals('test@example.com', $reservation->getEmail());
        $this->assertEquals(1, $reservation->getReservationId());
    }

    public function testBuildWithPartialValues()
    {
        $reservationBuilder = new ReservationBuilder();
        $reservation = $reservationBuilder
            ->setCarName('Toyota Corolla')
            ->setLocationName('Kraków')
            ->build();

        $this->assertEquals('Toyota Corolla', $reservation->getCarName());
        $this->assertEquals('Kraków', $reservation->getLocationName());
        $this->assertEquals('', $reservation->getPhoto());
        $this->assertEquals('', $reservation->getReservationStartDate());
        $this->assertEquals('', $reservation->getReservationEndDate());
        $this->assertEquals('', $reservation->getReservationPrice());
        $this->assertEquals('', $reservation->getReservationStatus());
        $this->assertEquals('', $reservation->getEmail());
        $this->assertEquals(0, $reservation->getReservationId());
    }

}

?>

<?php

include_once 'Reservation.php';
include_once 'IReservation.php';

class ReservationBuilder {
    private $reservation_id = 0;
    private $car_name = '';
    private $location_name = '';
    private $photo = '';
    private $reservation_start_date = '';
    private $reservation_end_date = '';
    private $reservation_price = '';
    private $reservation_status = '';
    private $email = '';

    public function setCarName(string $car_name): ReservationBuilder {
        $this->car_name = $car_name;
        return $this;
    }

    public function setLocationName(string $location_name): ReservationBuilder {
        $this->location_name = $location_name;
        return $this;
    }

    public function setPhoto(string $photo): ReservationBuilder {
        $this->photo = $photo;
        return $this;
    }

    public function setReservationStartDate(string $reservation_start_date): ReservationBuilder {
        $this->reservation_start_date = $reservation_start_date;
        return $this;
    }

    public function setReservationEndDate(string $reservation_end_date): ReservationBuilder {
        $this->reservation_end_date = $reservation_end_date;
        return $this;
    }

    public function setReservationPrice(string $reservation_price): ReservationBuilder {
        $this->reservation_price = $reservation_price;
        return $this;
    }

    public function setReservationStatus(string $reservation_status): ReservationBuilder {
        $this->reservation_status = $reservation_status;
        return $this;
    }

    public function setEmail(string $email): ReservationBuilder {
        $this->email = $email;
        return $this;
    }

    public function setReservationId(int $reservation_id): ReservationBuilder {
        $this->reservation_id = $reservation_id;
        return $this;
    }

    public function build(): IReservation {
        return new Reservation(
            $this->car_name,
            $this->location_name,
            $this->photo,
            $this->reservation_start_date,
            $this->reservation_end_date,
            $this->reservation_price,
            $this->reservation_status,
            $this->email,
            $this->reservation_id
        );
    }
}
?>

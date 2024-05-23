<?php
class Reservation{
    private $reservation_id;
    private $car_name;
    private $location_name;
    private $photo;
    private $reservation_start_date;
    private $reservation_end_date;
    private $reservation_price;
    private $reservation_status;
    private $email;

    public function __construct(string $car_name,string $location_name,string $photo,string $reservation_start_date,string $reservation_end_date,string $reservation_price, string $reservation_status, string $email,int $reservation_id=0){
        $this->car_name = $car_name;
        $this->location_name = $location_name;
        $this->photo = $photo;
        $this->reservation_start_date = $reservation_start_date;
        $this->reservation_end_date = $reservation_end_date;
        $this->reservation_price = $reservation_price;
        $this->reservation_status = $reservation_status;
        $this->email = $email;
        $this->reservation_id = $reservation_id;
}

    public function getCarName(): string {
        return $this->car_name;
    }

    public function getLocationName(): string {
        return $this->location_name;
    }

    public function getPhoto(): string {
        return $this->photo;
    }

    public function getReservationStartDate(): string {
        return $this->reservation_start_date;
    }

    public function getReservationEndDate(): string {
        return $this->reservation_end_date;
    }

    public function getReservationPrice(): string {
        return $this->reservation_price;
    }

    public function getReservationStatus(): string {
        return $this->reservation_status;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getReservationId(): int {
        return $this->reservation_id;
    }
}

?>
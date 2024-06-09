<?php
include_once 'ICar.php';
class Car implements ICar {
    private $id;
    private $brand;
    private $model;
    private $price_per_day;
    private $seats_available;
    private $photo;
    private $locations;
    private $production_year;
    private $car_description;

    public function __construct( string $brand = '',
                                 string $model = '',
                                 int $price_per_day = 0,
                                 int $seats_available = 0,
                                 string $photo = '',
                                 string $locations = '',
                                 int $id = 0,
                                 int $production_year = 0,
                                 string $car_description = ''){
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->price_per_day = $price_per_day;
        $this->seats_available = $seats_available;
        $this->photo = $photo;
        $this->locations = $locations;
        $this->production_year = $production_year;
        $this->car_description = $car_description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getPricePerDay(): int
    {
        return $this->price_per_day;
    }

    public function getSeatsAvailable(): int
    {
        return $this->seats_available;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getLocations(): string
    {
        return $this->locations;
    }

    public function getProductionYear(): int
    {
        return $this->production_year;
    }

    public function getCarDescription(): string
    {
        return $this->car_description;
    }

}
?>
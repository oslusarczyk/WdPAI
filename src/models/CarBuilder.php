<?php

include_once 'Car.php';
include_once 'ICar.php';

class CarBuilder {
    private $id = 0;
    private $brand = '';
    private $model = '';
    private $price_per_day = 0;
    private $seats_available = 0;
    private $photo = '';
    private $locations = '';
    private $production_year = 0;
    private $car_description = '';

    public function setId(int $id): CarBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setBrand(string $brand): CarBuilder
    {
        $this->brand = $brand;
        return $this;
    }

    public function setModel(string $model): CarBuilder
    {
        $this->model = $model;
        return $this;
    }

    public function setPricePerDay(int $price_per_day): CarBuilder
    {
        $this->price_per_day = $price_per_day;
        return $this;
    }

    public function setSeatsAvailable(int $seats_available): CarBuilder
    {
        $this->seats_available = $seats_available;
        return $this;
    }

    public function setPhoto(string $photo): CarBuilder
    {
        $this->photo = $photo;
        return $this;
    }

    public function setLocations(string $locations): CarBuilder
    {
        $this->locations = $locations;
        return $this;
    }

    public function setProductionYear(int $production_year): CarBuilder
    {
        $this->production_year = $production_year;
        return $this;
    }

    public function setCarDescription(string $car_description): CarBuilder
    {
        $this->car_description = $car_description;
        return $this;
    }

    public function build(): Car
    {
        return new Car(
            $this->brand,
            $this->model,
            $this->price_per_day,
            $this->seats_available,
            $this->photo,
            $this->locations,
            $this->id,
            $this->production_year,
            $this->car_description
        );
    }
}
?>

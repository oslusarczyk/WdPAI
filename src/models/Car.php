<?php
    class Car {
        private $id;
        private $brand;
        private $model;
        private $price_per_day;
        private $seats_available;
        private $photo;
        private $locations;
        private $productionYear;
        private $carDescription;

        public function __construct(string $brand, string $model, int $price_per_day, int $seats_available, string $photo, string $locations, int $productionYear, string $carDescription,int $id=0){
            $this->id = $id;
            $this->brand = $brand;
            $this->model = $model;
            $this->price_per_day = $price_per_day;
            $this->seats_available = $seats_available;
            $this->photo = $photo;
            $this->locations = $locations;
            $this->productionYear = $productionYear;
            $this->carDescription = $carDescription;
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
        return $this->productionYear;
    }

    public function getCarDescription(): string
    {
        return $this->carDescription;
    }

    }
?>
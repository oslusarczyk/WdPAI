<?php
interface ICar {
    public function getId(): int;
    public function getBrand(): string;
    public function getModel(): string;
    public function getPricePerDay(): int;
    public function getSeatsAvailable(): int;
    public function getPhoto(): string;
    public function getLocations(): string;
    public function getProductionYear(): int;
    public function getCarDescription(): string;
}
?>
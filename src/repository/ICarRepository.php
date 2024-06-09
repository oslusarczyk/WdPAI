<?php
interface ICarRepository {
    public function addCar(ICar $car, array $locations): void;
    public function getAllCars(string $location = null, string $brand = null, int $seats = null, int $minPrice = null, int $maxPrice = null): array;
    public function getMostPopularCars(): array;
    public function getCarById(int $id): array;
}
?>
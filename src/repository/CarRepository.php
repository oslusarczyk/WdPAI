<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Car.php';

class CarRepository extends Repository{
    public function getAllCars() : array{
    $this->database->connect();
    $stmt = $this->database->getConnection()->prepare('
        SELECT * FROM all_cars
    ');
    $stmt->execute();
    $this->database->disconnect();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cars as $car) {
        $result[] = new Car($car['brand_name'],$car['model'],$car['price_per_day'],$car['seats_available'],$car['photo'],$car['locations'],$car['productionYear'],$car['carDescription'],$car['car_id']);
    }
    return $result;
    }
}
?>
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
        $result[] = new Car($car['brand_name'],$car['model'],$car['price_per_day'],$car['seats_available'],$car['photo'],$car['locations'],$id=$car['car_id']);
    }
    return $result;
    }

    public function getMostPopularCars() : array{
        $this->database->connect();
        $stmt = $this->database->getConnection()->prepare('
        SELECT all_cars.*, reservation_counts.reservation_count
        FROM public.all_cars
        LEFT JOIN (
            SELECT car_id, COUNT(*) AS reservation_count
            FROM reservations
            GROUP BY car_id
        ) AS reservation_counts
        ON all_cars.car_id = reservation_counts.car_id
        ORDER BY reservation_count DESC NULLS LAST
        LIMIT 3;
        ');
        $stmt->execute();
        $this->database->disconnect();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cars as $car) {
            $result[] = new Car($car['brand_name'],$car['model'],$car['price_per_day'],$car['seats_available'],$car['photo'],$car['locations'],$id=$car['car_id']);
        }
        return $result;
        }
}
?>
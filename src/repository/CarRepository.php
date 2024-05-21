<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Car.php';

class CarRepository extends Repository{
    public function getAllCars(string $location = null, string $brand = null, int $seats = null, int $minPrice = null, int $maxPrice = null) : array{
    $this->database->connect();

    $query = "SELECT * FROM all_cars WHERE 1=1";
    $params = [];
    
    if (!empty($location)) {
        $query .= ' AND :location = ANY(locations)';
        $params[':location'] = $location;
    }

      if (!empty($brand)) {
        $query .= ' AND brand_name = :brand';
        $params[':brand'] = $brand;
    }
    if (!empty($seats)) {
        $query .= ' AND seats_available = :seats';
        $params[':seats'] = $seats;
    }
    if (!empty($minPrice)) {
        $query .= ' AND price_per_day >= :minPrice';
        $params[':minPrice'] = $minPrice;
    }

    if(!empty($maxPrice)){
        $query .= " AND price_per_day <= :maxPrice";
        $params[':maxPrice'] = $maxPrice;
    }


    $stmt = $this->database->getConnection()->prepare($query);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    $stmt->execute();
    $this->database->disconnect();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
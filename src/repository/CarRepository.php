<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/ICar.php';
require_once __DIR__.'/../models/CarBuilder.php';
require_once 'ICarRepository.php';

class CarRepository extends Repository implements ICarRepository {
    public function __construct(IDatabase $database)
    {
        parent::__construct($database);
    }
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
        $stmt = $this->database->getConnection()->prepare("
        SELECT all_cars.*, reservation_counts.reservation_count
        FROM public.all_cars
        LEFT JOIN (
            SELECT car_id, COUNT(*) AS reservation_count
            FROM reservations
            WHERE reservation_status='confirmed'
            GROUP BY car_id
        ) AS reservation_counts
        ON all_cars.car_id = reservation_counts.car_id
        ORDER BY reservation_count DESC NULLS LAST
        LIMIT 3;
        ");
        $stmt->execute();
        $this->database->disconnect();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cars as $car) {

            $result[] = (new CarBuilder())
                ->setBrand($car['brand_name'])
                ->setModel($car['model'])
                ->setPricePerDay($car['price_per_day'])
                ->setSeatsAvailable($car['seats_available'])
                ->setPhoto($car['photo'])
                ->setLocations($car['locations'])
                ->setId($car['car_id'])
                ->build();
        }
        return $result;
        }

        public function getCarById(int $id) : array{
            $this->database->connect();
            $stmt = $this->database->getConnection()->prepare('
            SELECT * FROM all_cars
            WHERE car_id=:id
            ');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->database->disconnect();
            $car = $stmt->fetch(PDO::FETCH_ASSOC);
            return $car ?: [];
        }

    public function addCar(ICar $car, array $locations) : void
    {
        $this->database->connect();
        try{
            $this->database->getConnection()->beginTransaction();
            $stmt = $this->database->getConnection()->prepare('
        INSERT INTO cars (brand_id, model, price_per_day, seats_available, photo, production_year, car_description)
        VALUES (?,?,?,?,?,?,?)
        RETURNING car_id
    ');
            $stmt->execute([
                $car->getBrand(),
                $car->getModel(),
                $car->getPricePerDay(),
                $car->getSeatsAvailable(),
                $car->getPhoto(),
                $car->getProductionYear(),
                $car->getCarDescription()
            ]);
            $car_id = $stmt->fetchColumn();
            $locationStmt = $this->database->getConnection()->prepare('
        INSERT INTO cars_locations (car_id, location_id)
        VALUES (?, ?)
        ');

            foreach ($locations as $location) {
                $locationStmt->execute([$car_id, intval($location)]);
            }

            $this->database->getConnection()->commit();
            $this->database->disconnect();
        } catch (Exception $e){
            $this->database->getConnection()->rollBack();
            $this->database->disconnect();
            throw $e;
        }
    }
}
?>
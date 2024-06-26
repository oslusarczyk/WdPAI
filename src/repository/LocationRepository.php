<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Location.php';
require_once 'ILocationRepository.php';

class LocationRepository extends Repository implements ILocationRepository{
    public function __construct(IDatabase $database)
    {
        parent::__construct($database);
    }
    public function getAllLocations() :array{
    $this->database->connect();
        $stmt = $this->database->getConnection()->prepare('
        SELECT * FROM locations
    ');
    $stmt->execute();
    $this->database->disconnect();
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $result = [];
    foreach ($locations as $location) {
        $result[] = new Location($location['location_name'],$location['location_id']);
    }

    return $result;
    }

    public function getLocationsByCar(int $id) :array{
        $this->database->connect();
            $stmt = $this->database->getConnection()->prepare('
            SELECT * FROM public.locations
            INNER JOIN cars_locations USING(location_id)
            WHERE car_id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect();
        $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($locations as $location) {
            $result[] = new Location($location['location_name'],$location['location_id']);
        }
    
        return $result;
        }

}
?>
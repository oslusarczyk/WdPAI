<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Location.php';

class LocationRepository extends Repository{
    public function getAllLocations() :array{
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM locations
    ');
    $stmt->execute();
    $this->database->disconnect();
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($locations as $location) {
        $result[] = new Location($location['location_name'],$location['location_id']);
    }

    return $result;
    }
}
?>
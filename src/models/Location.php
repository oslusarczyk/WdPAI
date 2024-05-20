<?php
class Location{
    private $location_id;
    private $location_name;

    public function __construct(string $location_name, int $location_id=0){
        $this->location_id = $location_id;
        $this->location_name = $location_name;
}

    public function getLocationId():int {
        return $this->location_id;
    }

    public function getLocationName():string {
        return $this->location_name;
    }
}

?>
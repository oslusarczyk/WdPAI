<?php

use PHPUnit\Framework\TestCase;

require_once 'src/models/Location.php';

class LocationTest extends TestCase
{

    public function testConstructorSetsLocationName()
    {
        $location = new Location('Kraków');
        $this->assertEquals('Kraków', $location->getLocationName());
        $this->assertEquals(0, $location->getLocationId());
    }

    public function testConstructorSetsLocationId()
    {
        $location = new Location('Kraków', 1);
        $this->assertEquals(1, $location->getLocationId());
    }

}

?>

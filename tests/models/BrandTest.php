<?php

use PHPUnit\Framework\TestCase;

require_once 'src/models/Brand.php';

class BrandTest extends TestCase
{
    public function testConstructorSetsBrandName()
    {
        $brand = new Brand('Toyota');
        $this->assertEquals('Toyota', $brand->getBrandName());
        $this->assertEquals(0, $brand->getBrandId());
    }

    public function testConstructorSetsBrandId()
    {
        $brand = new Brand('Toyota', 123);
        $this->assertEquals(123, $brand->getBrandId());
    }

}

?>
<?php

use PHPUnit\Framework\TestCase;

require_once 'src/repository/BrandRepository.php';
require_once 'src/models/Brand.php';
require_once 'src/repository/IBrandRepository.php';

class BrandRepositoryTest extends TestCase
{
    private $mockDatabase;
    private $mockConnection;
    private $mockStatement;
    private $brandRepository;

    protected function setUp(): void
    {
        $this->mockDatabase = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockConnection = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockStatement = $this->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockDatabase->method('getConnection')
            ->willReturn($this->mockConnection);

        $this->brandRepository = new BrandRepository($this->mockDatabase);
        $this->setProtectedProperty($this->brandRepository, 'database', $this->mockDatabase);
    }

    private function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    public function testGetAllBrands()
    {
        $expectedResult = [
            ['brand_id' => 1, 'brand_name' => 'Brand1'],
            ['brand_id' => 2, 'brand_name' => 'Brand2']
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM brands'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedResult);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $result = $this->brandRepository->getAllBrands();
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Brand::class, $result[0]);
        $this->assertEquals('Brand1', $result[0]->getBrandName());
        $this->assertEquals(1, $result[0]->getBrandId());
    }
}

?>

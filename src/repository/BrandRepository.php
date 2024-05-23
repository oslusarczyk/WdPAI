<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Brand.php';

class BrandRepository extends Repository{
    public function getAllBrands() :array{
    $this->database->connect();
        $stmt = $this->database->getConnection()->prepare('
        SELECT * FROM brands
    ');
    $stmt->execute();
    $this->database->disconnect();
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($brands as $brand) {
        $result[] = new Brand($brand['brand_name'],$brand['brand_id']);
    }

    return $result;
    }
}
?>
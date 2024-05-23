<?php
class Brand {
    private $brand_id;
    private $brand_name;

    public function __construct(string $brand_name, int $brand_id = 0) {
        $this->brand_id = $brand_id;
        $this->brand_name = $brand_name;
    }

    public function getBrandId(): int {
        return $this->brand_id;
    }

    public function getBrandName(): string {
        return $this->brand_name;
    }
}
?>
<?php
interface ILocationRepository {
    public function getAllLocations(): array;
    public function getLocationsByCar(int $id): array;
}
?>
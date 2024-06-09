<?php
interface IReservation {
    public function getCarName(): string;
    public function getLocationName(): string;
    public function getPhoto(): string;
    public function getReservationStartDate(): string;
    public function getReservationEndDate(): string;
    public function getReservationPrice(): string;
    public function getReservationStatus(): string;
    public function getEmail(): string;
    public function getReservationId(): int;
}
?>
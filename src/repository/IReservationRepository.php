<?php
interface IReservationRepository {
    public function getPendingReservations(): array;
    public function updateReservationStatus(string $action, int $reservation_id): void;
    public function getRepositoryByEmail(string $email, string $status): array;
    public function addReservation(string $reservation_end_date, string $reservation_start_date, int $location_id, int $car_id, int $user_id): void;
}
?>

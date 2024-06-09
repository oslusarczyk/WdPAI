<?php

interface IValidator
{
    public function validateReservation(string $reservation_start_date, string $reservation_end_date, string $location_id): ?string;

    public function validateRegisterForm(string $email, string $password, string $passwordConfirmation): ?string;

    public function validateCarForm(array $post_data): bool;
}

?>

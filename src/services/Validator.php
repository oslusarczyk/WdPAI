<?php

require_once 'IValidator.php';

class Validator implements IValidator {

    public function validateReservation(string $reservation_start_date, string $reservation_end_date, string $location_id): ?string
    {
        if (empty($reservation_start_date) || empty($reservation_end_date)) {
            return 'Obie daty są wymagane.';
        }

        if (strtotime($reservation_start_date) >= strtotime($reservation_end_date)) {
            return 'Koniec rezerwacji musi być później od początku!';
        }

        if (empty($location_id)) {
            return 'Nie wybrano lokalizacji';
        }

        return null;
    }

    public function validateRegisterForm(string $email, string $password, string $passwordConfirmation): ?string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Zły email';
        }

        if ($password !== $passwordConfirmation) {
            return 'Podane hasła się różnią';
        }

        return null;
    }


    public function validateCarForm(array $post_data): bool
    {
        $required_fields = [
            'brand',
            'model_select',
            'price_input',
            'seats',
            'production_year',
            'locations',
            'car_description'
        ];

        foreach ($required_fields as $field) {
            if (empty($post_data[$field])) {
                return false;
            }
            if ($field === 'locations' && !is_array($post_data[$field])) {
                return false;
            }
        }
        return true;
    }


}
?>

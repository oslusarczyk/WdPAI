<?php

use PHPUnit\Framework\TestCase;

require_once 'src/services/Validator.php';

class ValidatorTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testValidateReturnsErrorWhenDatesAreEmpty()
    {
        $result = $this->validator->validateReservation('', '', '1');
        $this->assertEquals('Obie daty są wymagane.', $result);
    }

    public function testValidateReturnsErrorWhenStartDateIsAfterEndDate()
    {
        $result = $this->validator->validateReservation('2023-05-25', '2023-05-24', '1');
        $this->assertEquals('Koniec rezerwacji musi być później od początku!', $result);
    }

    public function testValidateReturnsErrorWhenLocationIsEmpty()
    {
        $result = $this->validator->validateReservation('2023-05-24', '2023-05-25', '');
        $this->assertEquals('Nie wybrano lokalizacji', $result);
    }

    public function testValidateReturnsNullWhenAllDataIsValid()
    {
        $result = $this->validator->validateReservation('2023-05-24', '2023-05-25', '1');
        $this->assertNull($result);
    }

    public function testValidateRegisterFormReturnsErrorForInvalidEmail()
    {
        $result = $this->validator->validateRegisterForm('test', 'haslo', 'haslo');
        $this->assertEquals('Zły email', $result);
    }

    public function testValidateRegisterFormReturnsErrorForMismatchedPasswords()
    {
        $result = $this->validator->validateRegisterForm('test@example.com', 'haslo', 'innehaslo');
        $this->assertEquals('Podane hasła się różnią', $result);
    }

    public function testValidateRegisterFormReturnsNullForValidData()
    {
        $result = $this->validator->validateRegisterForm('test@example.com', 'haslo', 'haslo');
        $this->assertNull($result);
    }

    public function testValidateCarFormReturnsFalseWhenRequiredFieldsAreMissing()
    {
        $post_data = [
            'brand' => 'Toyota',
            'model_select' => '',
            'price_input' => 100,
            'seats' => 4,
            'production_year' => 2022,
            'locations' => ['1'],
            'car_description' => 'Fajne auto'
        ];

        $this->assertFalse($this->validator->validateCarForm($post_data));
    }

    public function testValidateCarFormReturnsFalseWhenLocationsIsNotArray()
    {
        $post_data = [
            'brand' => 1,
            'model_select' => 'Corolla',
            'price_input' => 100,
            'seats' => 4,
            'production_year' => 2022,
            'locations' => '1',
            'car_description' => 'Nice car'
        ];

        $this->assertFalse($this->validator->validateCarForm($post_data));
    }

    public function testValidateCarFormReturnsTrueWhenAllDataIsValid()
    {
        $post_data = [
            'brand' => 1,
            'model_select' => 'Corolla',
            'price_input' => 100,
            'seats' => 4,
            'production_year' => 2022,
            'locations' => ['1'],
            'car_description' => 'Nice car'
        ];

        $this->assertTrue($this->validator->validateCarForm($post_data));
    }
}

?>

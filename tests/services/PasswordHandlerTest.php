<?php

use PHPUnit\Framework\TestCase;

require_once 'src/services/PasswordHandler.php';

class PasswordHandlerTest extends TestCase
{
    private $passwordHandler;

    protected function setUp(): void
    {
        $this->passwordHandler = new PasswordHandler();
    }

    public function testHashPasswordReturnsHashedPassword()
    {
        $password = 'haslo';
        $hashedPassword = $this->passwordHandler->hashPassword($password);

        $this->assertNotEmpty($hashedPassword);
        $this->assertNotEquals($password, $hashedPassword);
        $this->assertTrue(password_verify($password, $hashedPassword));
    }

    public function testVerifyPasswordReturnsTrueForValidPassword()
    {
        $password = 'haslo';
        $hashedPassword = $this->passwordHandler->hashPassword($password);

        $this->assertTrue($this->passwordHandler->verifyPassword($password, $hashedPassword));
    }

    public function testVerifyPasswordReturnsFalseForInvalidPassword()
    {
        $password = 'haslo';
        $hashedPassword = $this->passwordHandler->hashPassword($password);

        $this->assertFalse($this->passwordHandler->verifyPassword('zlehaslo', $hashedPassword));
    }
}

?>

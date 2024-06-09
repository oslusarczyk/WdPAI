<?php

require_once 'IPasswordHandler.php';

class PasswordHandler implements IPasswordHandler {
    public function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password, string $hashedPassword): bool {
        return password_verify($password, $hashedPassword);
    }
}
?>
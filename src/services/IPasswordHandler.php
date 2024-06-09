<?php

interface IPasswordHandler
{
    public function hashPassword(string $password): string;

    public function verifyPassword(string $password, string $hashedPassword): bool;
}

?>

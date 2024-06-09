<?php
interface IUserRepository {
    public function addUser(User $user): void;
    public function getUser(string $email): ?User;
    public function doesEmailExists(string $email): bool;
}
?>

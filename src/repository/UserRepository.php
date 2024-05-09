<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository{
    public function addUser(User $user){
        $stmt = $this->database->connect()->prepare('
        INSERT INTO users (email,password)
        VALUES (?, ?)
    ');
    $stmt->execute([
        $user->getEmail(),
        $user->getPassword(),
    ]);
    }
}
?>
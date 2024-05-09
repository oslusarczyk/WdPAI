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

    public function getUserByEmail(string $email){
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
    ');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user){
        return true;
    }

    return false;

    }
}
?>
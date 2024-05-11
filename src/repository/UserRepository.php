<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository{
    public function addUser(User $user) : void{
    $stmt = $this->database->connect()->prepare('
        INSERT INTO users (email,password)
        VALUES (?, ?)
    ');
    $stmt->execute([
        $user->getEmail(),
        $user->getPassword(),
    ]);

    $this->database->disconnect();
    }

    public function getUser(string $email) : ?User {
    $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
    ');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->database->disconnect();
    if(!$user){
        return null;
    }
    return new User($user['email'],$user['password'],$user['hasAdminPrivileges'],$user['id']);

    }

    public function doesEmailExists(string $email):bool{
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE email = :email
    ');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->database->disconnect();
    if($user){
        return true;
    }
    return false;
    }
}
?>
<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once 'IUserRepository.php';

class UserRepository extends Repository implements IUserRepository{
    public function __construct(IDatabase $database)
    {
        parent::__construct($database);
    }
    public function addUser(User $user) : void{
    $this->database->connect();
    $stmt = $this->database->getConnection()->prepare('
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
    $this->database->connect();
    $stmt = $this->database->getConnection()->prepare('
        SELECT * FROM users WHERE email = :email
    ');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->database->disconnect();
    if(!$user){
        return null;
    }
    return new User($user['email'],$user['password'],$user['has_admin_privileges'],$user['id']);

    }

    public function doesEmailExists(string $email):bool{
    $this->database->connect();
    $stmt = $this->database->getConnection()->prepare('
        SELECT * FROM users WHERE email = :email
    ');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->database->disconnect();
    return $user !== false;
    }
}
?>
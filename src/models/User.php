<?php
class User{
    private $id;
    private $email;
    private $password;
    private $hasAdminPrivileges;

    public function __construct(string $email, string $password, bool $hasAdminPrivileges=FALSE,int $id=0){
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->hasAdminPrivileges = $hasAdminPrivileges;
}

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getHasAdminPrivileges()
    {
        return $this->hasAdminPrivileges;
    }

}

?>
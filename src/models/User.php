<?php
class User{
    private $id;
    private $email;
    private $password;
    private $has_admin_privileges;

    public function __construct(string $email, string $password, bool $has_admin_privileges=FALSE,int $id=0){
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->has_admin_privileges = $has_admin_privileges;
}

    public function getId() :int
    {
        return $this->id;
    }

    public function getEmail() :string
    {
        return $this->email;
    }

    public function getPassword() :string
    {
        return $this->password;
    }

    public function getHasAdminPrivileges() :bool
    {
        return $this->has_admin_privileges;
    }

}

?>
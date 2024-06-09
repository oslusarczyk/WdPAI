<?php

use PHPUnit\Framework\TestCase;

require_once 'src/models/User.php';

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User('test@example.com', 'password123', true, 1);
    }

    public function testConstructorSetsEmail()
    {
        $this->assertEquals('test@example.com', $this->user->getEmail());
    }

    public function testConstructorSetsPassword()
    {
        $this->assertEquals('password123', $this->user->getPassword());
    }

    public function testConstructorSetsAdminPrivileges()
    {
        $this->assertTrue($this->user->getHasAdminPrivileges());
    }

    public function testConstructorSetsId()
    {
        $this->assertEquals(1, $this->user->getId());
    }

    public function testConstructorSetsDefaultAdminPrivilegesToFalse()
    {
        $user = new User('test@example.com', 'password123');
        $this->assertFalse($user->getHasAdminPrivileges());
        $this->assertEquals(0, $user->getId());
    }


    public function testGetEmail()
    {
        $user = new User('test2@example.com', 'password123');
        $this->assertEquals('test2@example.com', $user->getEmail());
    }

    public function testGetPassword()
    {
        $user = new User('test@example.com', 'password456');
        $this->assertEquals('password456', $user->getPassword());
    }

    public function testGetHasAdminPrivileges()
    {
        $user = new User('test@example.com', 'password123', true);
        $this->assertTrue($user->getHasAdminPrivileges());

        $user = new User('test@example.com', 'password123', false);
        $this->assertFalse($user->getHasAdminPrivileges());
    }

    public function testGetId()
    {
        $user = new User('test@example.com', 'password123', true, 5);
        $this->assertEquals(5, $user->getId());
    }
}

?>

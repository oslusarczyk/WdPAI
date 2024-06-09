<?php

use PHPUnit\Framework\TestCase;

require_once 'Database.php';

class DatabaseTest extends TestCase
{
    private $database;

    protected function setUp(): void
    {
        $this->database = Database::getInstance();
    }

    public function testSingletonInstance()
    {
        $instance1 = Database::getInstance();
        $instance2 = Database::getInstance();

        $this->assertSame($instance1, $instance2);
    }

    public function testConnect()
    {
        $this->database->connect();
        $this->assertInstanceOf(PDO::class, $this->database->getConnection());
    }

    public function testDisconnect()
    {
        $this->database->connect();
        $this->assertInstanceOf(PDO::class, $this->database->getConnection());

        $this->database->disconnect();
        $this->assertNull($this->database->getConnection());
    }
}

?>

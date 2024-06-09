<?php

use PHPUnit\Framework\TestCase;

require_once 'src/services/RequestHandler.php';

class RequestHandlerTest extends TestCase
{
    private $originalRequestMethod;
    public function setUp(): void
    {
        $this->originalRequestMethod = $_SERVER['REQUEST_METHOD'] ?? null;
    }

    public function tearDown(): void
    {
        if ($this->originalRequestMethod !== null) {
            $_SERVER['REQUEST_METHOD'] = $this->originalRequestMethod;
        }
    }

    public function testIsGetReturnsTrueWhenRequestMethodIsGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $requestHandler = new RequestHandler();

        $this->assertTrue($requestHandler->isGet());
        $this->assertFalse($requestHandler->isPost());
    }

    public function testIsPostReturnsTrueWhenRequestMethodIsPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $requestHandler = new RequestHandler();

        $this->assertTrue($requestHandler->isPost());
        $this->assertFalse($requestHandler->isGet());
    }

    public function testIsGetReturnsFalseWhenRequestMethodIsNotGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $requestHandler = new RequestHandler();

        $this->assertFalse($requestHandler->isGet());
    }

    public function testIsPostReturnsFalseWhenRequestMethodIsNotPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $requestHandler = new RequestHandler();

        $this->assertFalse($requestHandler->isPost());
    }
}

?>

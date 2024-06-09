<?php

use PHPUnit\Framework\TestCase;

require_once 'src/controllers/ErrorController.php';

class ErrorControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    protected function tearDown(): void
    {
        unset($_SERVER['REQUEST_METHOD']);
    }
    public function testGetInstanceReturnsSingletonInstance()
    {
        $firstInstance = ErrorController::getInstance();
        $secondInstance = ErrorController::getInstance();

        $this->assertSame($firstInstance, $secondInstance);
    }

    public function testErrorMethodRedirectsToErrorPage()
    {
        $errorController = $this->getMockBuilder(ErrorController::class)
            ->onlyMethods(['redirect'])
            ->getMock();

        $errorController->expects($this->once())
            ->method('redirect')
            ->with($this->equalTo('error'));

        $errorController->error();
    }
}

?>

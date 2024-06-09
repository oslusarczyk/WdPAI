<?php


use PHPUnit\Framework\TestCase;

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/AppController.php';

class DefaultControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        $this->controller = $this->getMockBuilder(DefaultController::class)
            ->onlyMethods(['render', 'redirect'])
            ->getMock();

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        $_SESSION = [];
        session_start();

        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    public function testIndexRedirectsToLoginWhenUserIsNotLoggedIn(): void
    {
        $this->controller->expects($this->once())
            ->method('render')
            ->with('login');

        $this->controller->index();
    }

    public function testIndexRedirectsToMainWhenUserIsLoggedIn(): void
    {
        $_SESSION['user'] = 'test_user';

        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('main');

        $this->controller->index();
    }

    public function testErrorRendersErrorPage(): void
    {
        $this->controller->expects($this->once())
            ->method('render')
            ->with('error');

        $this->controller->error();
    }

    protected function tearDown(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}

?>

<?php

use PHPUnit\Framework\TestCase;

require_once  'src/controllers/SecurityController.php';
require_once  'src/repository/IUserRepository.php';
require_once  'src/services/PasswordHandler.php';
require_once  'src/services/Validator.php';
require_once  'src/models/User.php';

class SecurityControllerTest extends TestCase
{
    private $userRepositoryMock;
    private $passwordHandlerMock;
    private $validatorMock;
    private $securityController;

    protected function setUp(): void
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->userRepositoryMock = $this->createMock(IUserRepository::class);
        $this->passwordHandlerMock = $this->createMock(PasswordHandler::class);
        $this->validatorMock = $this->createMock(Validator::class);

        $this->securityController = $this->getMockBuilder(SecurityController::class)
            ->setConstructorArgs([$this->userRepositoryMock, $this->passwordHandlerMock, $this->validatorMock])
            ->onlyMethods(['render', 'redirect', 'isPost'])
            ->getMock();
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        unset($_SERVER['REQUEST_METHOD']);
        if (session_status() !== PHP_SESSION_NONE) {
            session_destroy();
        }
    }

    public function testLoginRendersLoginViewWhenNotPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->securityController->method('isPost')->willReturn(false);

        $this->securityController->expects($this->once())
            ->method('render')
            ->with('login');

        $this->securityController->login();
    }

    public function testLoginRendersLoginViewWhenUserNotFound()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->securityController->method('isPost')->willReturn(true);

        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'password';

        $this->userRepositoryMock->expects($this->once())
            ->method('getUser')
            ->with('test@example.com')
            ->willReturn(null);

        $this->securityController->expects($this->once())
            ->method('render')
            ->with('login', ['messages' => ['Nie znaleziono użytkownika o takim mailu.']]);

        $this->securityController->login();
    }

    public function testLoginRendersLoginViewWhenPasswordIncorrect()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->securityController->method('isPost')->willReturn(true);

        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'wrongpassword';

        $user = $this->createMock(User::class);
        $user->method('getPassword')->willReturn('hashedpassword');

        $this->userRepositoryMock->method('getUser')->willReturn($user);

        $this->passwordHandlerMock->method('verifyPassword')
            ->with('wrongpassword', 'hashedpassword')
            ->willReturn(false);

        $this->securityController->expects($this->once())
            ->method('render')
            ->with('login', ['messages' => ['Podano złe hasło użytkownika']]);

        $this->securityController->login();
    }

    public function testLoginRedirectsToMainWhenLoginSuccessful()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->securityController->method('isPost')->willReturn(true);

        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'correctpassword';

        $user = $this->createMock(User::class);
        $user->method('getPassword')->willReturn('hashedpassword');

        $this->userRepositoryMock->method('getUser')->willReturn($user);

        $this->passwordHandlerMock->method('verifyPassword')
            ->with('correctpassword', 'hashedpassword')
            ->willReturn(true);

        $this->securityController->expects($this->once())
            ->method('redirect')
            ->with('main');

        $this->securityController->login();
    }

    public function testRegisterRendersRegisterViewWhenNotPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->securityController->method('isPost')->willReturn(false);

        $this->securityController->expects($this->once())
            ->method('render')
            ->with('register');

        $this->securityController->register();
    }

    public function testRegisterRendersRegisterViewWhenValidationFails()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->securityController->method('isPost')->willReturn(true);

        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'password';
        $_POST['password_confirmation'] = 'password';

        $this->validatorMock->method('validateRegisterForm')
            ->willReturn('Validation error');

        $this->securityController->expects($this->once())
            ->method('render')
            ->with('register', ['messages' => ['Validation error']]);

        $this->securityController->register();
    }

    public function testRegisterRendersRegisterViewWhenEmailExists()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->securityController->method('isPost')->willReturn(true);

        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'password';
        $_POST['password_confirmation'] = 'password';

        $this->validatorMock->method('validateRegisterForm')
            ->willReturn(null);

        $this->userRepositoryMock->method('doesEmailExists')
            ->willReturn(true);

        $this->securityController->expects($this->once())
            ->method('render')
            ->with('register', ['messages' => ["Użytkownik o takim e-mailu już istnieje."]]);

        $this->securityController->register();
    }

    public function testRegisterAddsUserAndRendersLoginViewWhenSuccessful()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->securityController->method('isPost')->willReturn(true);

        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'password';
        $_POST['password_confirmation'] = 'password';

        $this->validatorMock->method('validateRegisterForm')
            ->willReturn(null);

        $this->userRepositoryMock->method('doesEmailExists')
            ->willReturn(false);

        $this->passwordHandlerMock->method('hashPassword')
            ->willReturn('hashedpassword');

        $this->userRepositoryMock->expects($this->once())
            ->method('addUser')
            ->with($this->callback(function ($user) {
                return $user->getEmail() === 'test@example.com' && $user->getPassword() === 'hashedpassword';
            }));

        $this->securityController->expects($this->once())
            ->method('render')
            ->with('login', ['messages' => ['Zostałeś zarejestrowany!']]);

        $this->securityController->register();
    }

    public function testLogoutClearsSessionAndRedirects()
    {
        $_SESSION['user'] = 'some_user_data';

        $this->securityController->expects($this->once())
            ->method('redirect')
            ->with('');

        $this->securityController->logout();

        $this->assertArrayNotHasKey('user', $_SESSION);
    }
}

?>

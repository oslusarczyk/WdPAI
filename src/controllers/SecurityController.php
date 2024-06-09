<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/IUserRepository.php';
require_once __DIR__.'/../services/PasswordHandler.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController
{
    private IUserRepository $userRepository;
    private IPasswordHandler $passwordHandler;
    private IValidator $validator;

    public function __construct(IUserRepository $userRepository, IPasswordHandler $passwordHandler, IValidator $validator)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->passwordHandler = $passwordHandler;
        $this->validator = $validator;
    }

    public function login(): void
    {
        if (!$this->isPost()) {
            $this->render('login');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            $this->render('login', ['messages' => ['Nie znaleziono użytkownika o takim mailu.']]);
            return;
        }

        if (!$this->passwordHandler->verifyPassword($password, $user->getPassword())) {
            $this->render('login', ['messages' => ['Podano złe hasło użytkownika']]);
            return;
        }

        $_SESSION['user'] = serialize($user);

        $this->redirect('main');
    }

    public function register(): void
    {
        if (!$this->isPost()) {
            $this->render('register');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        $validationResult = $this->validator->validateRegisterForm($email, $password, $passwordConfirmation);

        if ($validationResult !== null) {
            $this->render('register', ['messages' => [$validationResult]]);
            return;
        }

        if($this->userRepository->doesEmailExists($email)){
           $this->render('register', ['messages' => ["Użytkownik o takim e-mailu już istnieje."]]);
           return;
        }

        $hashedPassword = $this->passwordHandler->hashPassword($password);
        $user = new User($email, $hashedPassword);

        $this->userRepository->addUser($user);
        $this->render('login', ['messages' => ['Zostałeś zarejestrowany!']]);
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect('');
    }
}
?>

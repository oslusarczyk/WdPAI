<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController

{
    private $userRepository;

    public function __construct(){
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        $this->render('login');
    }

    public function register()
    {
        if(!$this->isPost()){
            return $this->render('register');
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        if($password !== $passwordConfirmation){
            $this->render('register', ['messages' => ["Podane hasła się różnią"]]); 
        }

        if($this->userRepository->getUserByEmail($email)){
            $this->render('register', ['messages' => ["Użytkownik o takim e-mailu już istnieje."]]); 
        }


        $passwordHash = password_hash($password,PASSWORD_BCRYPT);
        $user = new User($email,$passwordHash);
        $doesEmailExists = $this->userRepository->getUserByEmail($email);
       
        $this->userRepository->addUser($user);
        return $this->render('login', ['messages' => ['Zostałeś zarejestrowany!']]);
    }
}

?>

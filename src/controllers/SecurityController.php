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
        if(!$this->isPost()){
            return $this->render('login');
        }
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);


        if(!$user){
            return $this->render('login', ['messages' => ['Nie znaleziono użytkownika o takim mailu.']]);
        }
        if(!password_verify($password, $user->getPassword())){
            return $this->render('login', ['messages' => ['Podano złe hasło użytkownika']]);
        }


        $_SESSION['user'] = serialize($user);
        
        $url = "http://$_SERVER[HTTP_HOST]";
        return header("Location: {$url}/main");
    }

    public function main()
    {
        return $this->render('main');

    }

    public function cars()
    {
        return $this->render('cars');

    }

    public function history ()
    {
        return $this->render('history');

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
            return $this->render('register', ['messages' => ["Podane hasła się różnią"]]); 
        }

        if($this->userRepository->doesEmailExists($email)){
            return $this->render('register', ['messages' => ["Użytkownik o takim e-mailu już istnieje."]]); 
        }


        $passwordHash = password_hash($password,PASSWORD_BCRYPT);
        $user = new User($email,$passwordHash);
       
        $this->userRepository->addUser($user);
        return $this->render('login', ['messages' => ['Zostałeś zarejestrowany!']]);
    }

    public function logout(){
        session_unset();
        session_destroy();
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}");
    }
}

?>

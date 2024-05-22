<?php

require_once 'AppController.php';


class DefaultController extends AppController {

    public function index()
    {
        if(!isset($_SESSION['user'])){
           return $this->render('login');
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/main");
    }

    public function error(){
        return $this->render('error');
    }

 
}

?>
<?php

require_once 'AppController.php';


class DefaultController extends AppController {

    public function index()
    {
        if(!isset($_SESSION['user'])){
           return $this->render('login');
        }
      return $this->render('main');
    }

 
}

?>
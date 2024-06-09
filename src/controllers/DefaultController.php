<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function index(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->render('login');
            return;
        }
        $this->redirect('main');
    }

    public function error(): void
    {
        $this->render('error');
    }
}
?>
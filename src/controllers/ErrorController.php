<?php

require_once 'AppController.php';

class ErrorController extends AppController
{
    private static ?ErrorController $instance = null;

    public function error(): void
    {
        $this->redirect('error');
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

?>
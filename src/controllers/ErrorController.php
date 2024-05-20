<?php

require_once 'AppController.php';


class ErrorController extends AppController {
    private static $instance;

    public function error(){
         $url = "http://$_SERVER[HTTP_HOST]";
        return header("Location: {$url}/error");
    }


    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}

?>
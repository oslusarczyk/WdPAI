<?php
class RequestHandler{
    private $request;

    public function __construct() {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    public function isGet(): bool {
        return $this->request === 'GET';
    }

    public function isPost(): bool {
        return $this->request === 'POST';
    }
}
?>

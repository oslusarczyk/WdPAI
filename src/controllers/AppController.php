<?php
session_start();
require_once __DIR__.'/../services/RequestHandler.php';
require_once __DIR__.'/../services/ViewRenderer.php';
class AppController {
    private $requestHandler;
    private $viewRenderer;


    public function __construct(RequestHandler $requestHandler = null, ViewRenderer $viewRenderer = null) {
        $this->requestHandler = $requestHandler ?? new RequestHandler();
        $this->viewRenderer = $viewRenderer ?? new ViewRenderer();
    }


    protected function isGet(): bool
    {
        return $this->requestHandler->isGet();
    }

    protected function isPost(): bool
    {
        return $this->requestHandler->isPost();
    }

    protected function redirect(string $path): void
    {
        $url = "http://$_SERVER[HTTP_HOST]/{$path}";
        header("Location: {$url}");
    }

    protected function redirectToReferer(): void{
        $url = $_SERVER['HTTP_REFERER'];
        header("Location: {$url}");
    }
    

    protected function render(string $template = null, array $variables = [])
    {
        $this->viewRenderer->render($template, $variables);
    }
}
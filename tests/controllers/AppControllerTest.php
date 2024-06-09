<?php

use PHPUnit\Framework\TestCase;

require_once 'src/controllers/AppController.php';
require_once 'src/services/RequestHandler.php';
require_once 'src/services/ViewRenderer.php';

class AppControllerTest extends TestCase
{
    private $requestHandlerMock;
    private $viewRendererMock;
    private $appController;

    protected function setUp(): void
    {
        $this->requestHandlerMock = $this->createMock(RequestHandler::class);
        $this->viewRendererMock = $this->createMock(ViewRenderer::class);
        $this->appController = new AppController($this->requestHandlerMock, $this->viewRendererMock);
    }


    private function callProtectedMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testIsGetReturnsTrue()
    {
        $this->requestHandlerMock->expects($this->once())
            ->method('isGet')
            ->willReturn(true);

        $result = $this->callProtectedMethod($this->appController, 'isGet');
        $this->assertTrue($result);
    }

    public function testIsGetReturnsFalse()
    {
        $this->requestHandlerMock->expects($this->once())
            ->method('isGet')
            ->willReturn(false);

        $result = $this->callProtectedMethod($this->appController, 'isGet');
        $this->assertFalse($result);
    }

    public function testIsPostReturnsTrue()
    {
        $this->requestHandlerMock->expects($this->once())
            ->method('isPost')
            ->willReturn(true);

        $result = $this->callProtectedMethod($this->appController, 'isPost');
        $this->assertTrue($result);
    }

    public function testIsPostReturnsFalse()
    {
        $this->requestHandlerMock->expects($this->once())
            ->method('isPost')
            ->willReturn(false);

        $result = $this->callProtectedMethod($this->appController, 'isPost');
        $this->assertFalse($result);
    }

    public function testRenderCallsViewRendererWithCorrectParameters()
    {
        $template = 'test_template';
        $variables = ['key' => 'value'];

        $this->viewRendererMock->expects($this->once())
            ->method('render')
            ->with($template, $variables);

        $this->callProtectedMethod($this->appController, 'render', [$template, $variables]);
    }

}

?>
<?php

use PHPUnit\Framework\TestCase;

require_once 'src/services/ViewRenderer.php';

class ViewRendererTest extends TestCase

{
    private $viewRenderer;

    protected function setUp(): void
    {
        $this->viewRenderer = new ViewRenderer();
    }

    public function testRenderRendersTemplateWithVariables()
    {
        $template = 'login';
        $variables = ['message' => 'Hello, World!'];

        ob_start();
        try {
            $this->viewRenderer->render($template, $variables);
            $output = ob_get_clean();
        } catch (Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        $dom = new DOMDocument;
        @$dom->loadHTML($output);
        $titles = $dom->getElementsByTagName('title');

        $this->assertGreaterThan(0, $titles->length);
        $this->assertEquals('LOGIN', $titles->item(0)->textContent);
    }

    public function testRenderRendersErrorTemplateWhenTemplateNotFound()
    {
        $template = 'nonexistent_template';
        $variables = ['message' => 'This should not be displayed'];

        ob_start();
        try {
            $this->viewRenderer->render($template, $variables);
            $output = ob_get_clean();
        } catch (Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        $dom = new DOMDocument;
        @$dom->loadHTML($output);
        $titles = $dom->getElementsByTagName('title');

        $this->assertGreaterThan(0, $titles->length);
        $this->assertEquals('ERROR', $titles->item(0)->textContent);
    }
}

?>

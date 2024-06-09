<?php
class ViewRenderer{
    public function render(string $template = null, array $variables = []) {
        $templatePath = 'public/views/' . $template . '.php';

        if (!file_exists($templatePath)) {
            $templatePath = 'public/views/error.php';
        }
        extract($variables);

        ob_start();
        include $templatePath;
        $output = ob_get_clean();
        print $output;
    }
}
?>

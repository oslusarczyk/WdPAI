<?php

require_once 'IFileHandler.php';

class FileHandler implements IFileHandler
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/uploads/';

    private string $error = '';

    public function validate(array $file): bool
    {
        $this->error = '';

        if (!$this->isUploadedFile($file['tmp_name'])) {
            $this->error = 'Brak pliku';
            return false;
        }
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->error = 'Wybrany plik jest za duży';
            return false;
        }
        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->error = 'Wybrany plik ma złe rozszerzenie.';
            return false;
        }
        return true;
    }
    public function upload(array $file): void
    {
        move_uploaded_file(
            $file['tmp_name'],
            dirname(__DIR__) . self::UPLOAD_DIRECTORY . $file['name']
        );
    }


    public function getError(): string
    {
        return $this->error;
    }

    protected function isUploadedFile(string $filename): bool
    {
        return is_uploaded_file($filename);
    }
}
?>

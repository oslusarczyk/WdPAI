<?php

interface IFileHandler {
    public function validate(array $file): bool;
    public function upload(array $file): void;
    public function getError(): string;
}
?>
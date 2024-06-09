<?php

use PHPUnit\Framework\TestCase;

require_once 'src/services/FileHandler.php';
require_once 'src/services/IFileHandler.php';

class FileHandlerTest extends TestCase
{
    private $fileHandler;

    protected function setUp(): void
    {
        $this->fileHandler = $this->getMockBuilder(FileHandler::class)
            ->onlyMethods(['isUploadedFile'])
            ->getMock();
    }

    public function testValidateReturnsFalseWhenNoFileUploaded()
    {
        $file = ['tmp_name' => '', 'size' => 0, 'type' => ''];

        $this->assertFalse($this->fileHandler->validate($file));
        $this->assertEquals('Brak pliku', $this->fileHandler->getError());
    }

    public function testValidateReturnsFalseWhenFileTooLarge()
    {
        $file = ['tmp_name' => __DIR__ . '/testfile.png', 'size' => FileHandler::MAX_FILE_SIZE + 1, 'type' => 'image/png'];


        $this->fileHandler->method('isUploadedFile')
            ->willReturn(true);

        $this->assertFalse($this->fileHandler->validate($file));
        $this->assertEquals('Wybrany plik jest za duży', $this->fileHandler->getError());

    }

    public function testValidateReturnsFalseWhenFileTypeIsNotSupported()
    {
        $file = ['tmp_name' => __DIR__ . '/testfile.gif', 'size' => FileHandler::MAX_FILE_SIZE, 'type' => 'image/gif'];


        $this->fileHandler->method('isUploadedFile')
            ->willReturn(true);

        $this->assertFalse($this->fileHandler->validate($file));
        $this->assertEquals('Wybrany plik ma złe rozszerzenie.', $this->fileHandler->getError());

    }

    public function testValidateReturnsTrueWhenFileIsValid()
    {
        $file = ['tmp_name' => __DIR__ . '/testfile.png', 'size' => FileHandler::MAX_FILE_SIZE, 'type' => 'image/png'];


        $this->fileHandler->method('isUploadedFile')
            ->willReturn(true);

        $this->assertTrue($this->fileHandler->validate($file));
        $this->assertEquals('', $this->fileHandler->getError());

    }

}

?>

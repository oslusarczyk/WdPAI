<?php

require_once __DIR__.'/../../Database.php';
require_once __DIR__.'/../../IDatabase.php';

class Repository {
    protected IDatabase $database;

    public function __construct(IDatabase $database)
    {
        $this->database = Database::getInstance();
    }
}

?>
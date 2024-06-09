<?php

interface IDatabase {
    public function connect();
    public function getConnection();
    public function disconnect();
}

?>
<?php

namespace System\Db;

class MySQLConnection extends Connection{
    public function __construct($host, $username, $password, $databaseName, $port){
        parent::__construct($host, $username, $password, $port);
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $databaseName, $port);
    }

    public function execute($query): \mysqli_result|bool{
        return $this->connection->query($query);
    }

    public function close(){
        mysqli_close($this->connection);
    }
}
<?php

namespace System\Db;

abstract class Connection{
    protected string $host;
    protected string $username;
    protected string $password;
    protected string $port;

    protected $connection;

    public function __construct ($host, $username, $password, $port){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    abstract public function execute($query);

    abstract public function close();
}
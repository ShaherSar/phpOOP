<?php

namespace System\Db;

class DB{
    protected static Connection $connection;

    public static function setConnection($connection){
        self::$connection = $connection;
    }

    public function getConnection(): Connection {
        return self::$connection;
    }
}
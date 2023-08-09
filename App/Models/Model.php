<?php

namespace Models;

use Interfaces\Arrayable;
use Interfaces\Jsonable;

abstract class Model implements Jsonable, Arrayable {
    protected $tableName;

    public function setTableName($tableName){
        $this->tableName = $tableName;
    }

    public static function all(){

    }
}
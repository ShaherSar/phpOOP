<?php

namespace System\Models;

abstract class Model {
    public static string $tableName;

    public static string $primaryKey;

    abstract public static function all();
}
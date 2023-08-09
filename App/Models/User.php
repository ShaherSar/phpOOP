<?php

namespace App\Models;

use System\Models\Model;

class User extends Model{
    public static string $tableName = "users";
    public static string $primaryKey = "id";

    public static function all(){

    }
}

<?php

require_once './model/DBConnect.php';

class BaseModel extends DBConnect
{
    protected static $db;

    public function __construct()
    {
        if(!self::$db)
        {
            self::$db = DBConnect::getInstance()->getConnection();
        }
    }

    protected static function getDB() {
        if (!self::$db) {
            self::$db = DBConnect::getInstance()->getConnection();
        }
        return self::$db;
    }
}

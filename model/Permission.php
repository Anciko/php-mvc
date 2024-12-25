<?php

require_once './model/BaseModel.php';

class Permission extends BaseModel
{
    public static function all()
    {
        $statement = self::getDB()->prepare('SELECT * FROM permissions');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public static function create()
    {
        
    }
}

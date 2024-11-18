<?php

require_once './model/BaseModel.php';

class Admin extends BaseModel
{
    public  static function all()
    {
        $statement = self::getDB()->prepare('SELECT * FROM admin_users');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

<?php

require_once './model/BaseModel.php';

class Admin extends BaseModel
{
    public static function all()
    {
        $statement = self::getDB()->prepare('SELECT * FROM admin_users');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getAdminByEmail($email)
    {
        try {
            $statement = self::getDB()->prepare('SELECT * FROM admin_users WHERE email=:email');
            $statement->bindParam(':email', $email);
            $statement->execute();
    
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            dd("Error Message " . $e->getMessage());
        }
    }

    public static function create()
    {
        try {
            $statement = self::getDB()->prepare("INSERT INTO `admin_users`
        (`name`, `username`, `role_id`, `phone`, `email`, `address`, `password`, `gender`, `is_active`)
        VALUES
        (:name, :username, :role_id, :phone, :email, :address, :password, :gender, :is_active)
    ");

            $statement->bindParam(":name", $_POST['name']);
            $statement->bindParam(":username", $_POST['username']);
            $statement->bindParam(":role_id", $_POST['role_id']);
            $statement->bindParam(":phone", $_POST['phone']);
            $statement->bindParam(":email", $_POST['email']);
            $statement->bindParam(":address", $_POST['address']);
            $statement->bindParam(":gender", $_POST['gender']);
            $statement->bindParam(":password", $_POST['password']);
            $statement->bindParam(":is_active", $_POST['is_active']);

            $statement->execute();
        } catch (PDOException $e) {
            dd("Error Message => " . $e->getMessage());
        }
    }
}

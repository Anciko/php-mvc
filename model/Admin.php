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

    public static function getAdminById($id)
    {
        try {
            $statement = self::getDB()->prepare('SELECT * FROM admin_users WHERE id=:id');
            $statement->bindParam(':id', $id);
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
        (`name`, `username`, `role_id`, `phone`, `email`, `address`, `password`, `gender`, `is_active`, `created_at`)
        VALUES
        (:name, :username, :role_id, :phone, :email, :address, :password, :gender, :is_active, :created_at)
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
            $statement->bindParam(":created_at", date('Y-m-d H:i:s'));

            $statement->execute();
        } catch (PDOException $e) {
            dd("Error Message => " . $e->getMessage());
        }
    }

    public static function update($id)
    {
        $statement = self::getDB()->prepare("UPDATE admin_users
        SET name=:name, username=:username, role_id=:role_id, phone=:phone,
        email=:email, address=:address, gender=:gender, password=:password,
        is_active=:is_active
        WHERE id=:id
    ");

        $statement->bindParam(":id", $id);
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
    }

    public static function delete($id)
    {
        $statement = self::getDB()->prepare("DELETE FROM `admin_users`
        WHERE id = :id
    ");
        $statement->bindParam(':id', $id);

        $statement->execute();
    }
}

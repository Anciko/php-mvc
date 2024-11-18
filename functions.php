<?php

function DBConnection()
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=user_management", "root", "");
        return $pdo;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function fetchAdminUser($pdo)
{
    $statement = $pdo->prepare('SELECT * FROM admin_users');
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

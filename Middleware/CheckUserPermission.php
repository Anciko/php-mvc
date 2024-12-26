<?php

require_once './model/BaseModel.php';

class CheckUserPermission extends BaseModel
{
    public static function has($permissionName)
    {
        $userId = authUserId();
        $pdo  = self::getDB();
        $permissions = self::getUserPermissions($userId, $pdo);
        return in_array($permissionName, $permissions);
    }

    public static function getUserPermissions($userId, $pdo)
    {
        $sql = "
            SELECT p.name
            FROM permissions p
            JOIN role_permission rp ON p.id = rp.permission_id
            JOIN roles r ON r.id = rp.role_id
            JOIN admin_users u ON u.role_id = r.id
            WHERE u.id = :userId
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

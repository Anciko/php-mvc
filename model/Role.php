<?php

require_once './model/BaseModel.php';

class Role extends BaseModel
{
    public static function all()
    {
        try {
            $statement = self::getDB()->prepare("SELECT
            roles.id AS role_id,
            roles.name AS role_name,
            permissions.id AS permission_id,
            permissions.name AS permission_name
            FROM roles
            LEFT JOIN role_permission ON roles.id = role_permission.role_id
            LEFT JOIN permissions ON role_permission.permission_id = permissions.id
            ORDER BY roles.id, permissions.id
        ");

            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_OBJ);

            // Organize the data by roles and their permissions
            $roles = [];
            foreach ($results as $row) {
                if (!isset($roles[$row->role_id])) {
                    $roles[$row->role_id] = [
                        'id' => $row->role_id,
                        'name' => $row->role_name,
                        'permissions' => [],
                    ];
                }

                if ($row->permission_id) {
                    $roles[$row->role_id]['permissions'][] = (object) [
                        'id' => $row->permission_id,
                        'name' => $row->permission_name,
                    ];
                }
            }

            return $roles;
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public static function create()
    {
        try {
            // Step 1: Insert a new role
            $roleName = 'Manager';
            $stmt = self::getDB()->prepare("INSERT INTO roles (name, created_at) VALUES (:name, NOW())");
            $stmt->execute([':name' => $roleName]);
            $roleId = self::getDB()->lastInsertId();

            // Step 2: Insert permissions (if not already existing)
            $permissions = [
                ['name' => 'create_user', 'feature_id' => 1],
                ['name' => 'edit_user', 'feature_id' => 1],
            ];

            $permissionIds = [];
            foreach ($permissions as $permission) {
                $stmt = self::getDB()->prepare("SELECT id FROM permissions WHERE name = :name");
                $stmt->execute([':name' => $permission['name']]);
                $permissionId = $stmt->fetchColumn();

                if (!$permissionId) {
                    $stmt = self::getDB()->prepare("INSERT INTO permissions (name, feature_id, created_at) VALUES (:name, :feature_id, NOW())");
                    $stmt->execute([
                        ':name' => $permission['name'],
                        ':feature_id' => $permission['feature_id'],
                    ]);
                    $permissionId = self::getDB()->lastInsertId();
                }

                $permissionIds[] = $permissionId;
            }

            // Step 3: Insert into the pivot table
            $stmt = self::getDB()->prepare("INSERT INTO role_permission (role_id, permission_id, created_at) VALUES (:role_id, :permission_id, NOW())");
            foreach ($permissionIds as $permissionId) {
                $stmt->execute([
                    ':role_id' => $roleId,
                    ':permission_id' => $permissionId,
                ]);
            }

            echo "Role and permissions have been successfully created and linked!";
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}

<?php

require_once './model/BaseModel.php';

class Role extends BaseModel
{
    public static function getOnlyRoles()
    {
        $statement = self::getDB()->prepare('SELECT * FROM roles');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
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
        self::getDB()->beginTransaction();
        try {
            $roleName = $_POST['name'];
            $stmt = self::getDB()->prepare("INSERT INTO roles (name, created_at) VALUES (:name, NOW())");
            $stmt->execute([':name' => $roleName]);
            $roleId = self::getDB()->lastInsertId();

            // Insert into the pivot table
            $permissionIds = $_POST['permission_id'];
            $stmt = self::getDB()->prepare("INSERT INTO role_permission (role_id, permission_id, created_at) VALUES (:role_id, :permission_id, NOW())");
            foreach ($permissionIds as $permissionId) {
                $stmt->execute([
                    ':role_id' => $roleId,
                    ':permission_id' => $permissionId,
                ]);
            }
            self::getDB()->commit();
            echo "Role and permissions have been successfully created and linked!";
        } catch (PDOException $e) {
            self::getDB()->rollback();
            dd($e->getMessage());
        }
    }

    public static function getRoleById($id)
    {
        $role_id = $id;
        try {
            $statement = self::getDB()->prepare("SELECT
                roles.id AS role_id,
                roles.name AS role_name,
                permissions.id AS permission_id,
                permissions.name AS permission_name
                FROM roles
                LEFT JOIN role_permission ON roles.id = role_permission.role_id
                LEFT JOIN permissions ON role_permission.permission_id = permissions.id
                WHERE roles.id=:role_id
            ");
            $statement->bindParam(':role_id', $role_id, PDO::PARAM_INT);
            $statement->execute();

            // Fetch the results
            $roleData = $statement->fetchAll(PDO::FETCH_OBJ);

            // dd($roleData);
            if (!empty($roleData)) {
                // Format the data
                $role = [
                    'id' => $roleData[0]->role_id,
                    'name' => $roleData[0]->role_name,
                    'permissions' => [],
                ];

                foreach ($roleData as $data) {
                    if (!empty($data->permission_id)) {
                        $role['permissions'][] = [
                            'id' => $data->permission_id,
                            'name' => $data->permission_name,
                        ];
                    }
                }

                return $role;
            } else {
                dd("No role found.");
            }
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public static function update($id, $newPermissionIds)
    {
        self::getDB()->beginTransaction();
        try {
            $statement = self::getDB()->prepare("UPDATE roles SET name = :name WHERE id = :id;");
            $statement->bindParam(":name", $_POST['name']);
            $statement->bindParam(":id", $id);
            $statement->execute();

            $statement = self::getDB()->prepare("DELETE FROM role_permission WHERE role_id = :role_id");
            $statement->execute(['role_id' => $id]);

            $statement = self::getDB()->prepare("INSERT INTO role_permission (role_id, permission_id) VALUES (:role_id, :permission_id)");
            foreach ($newPermissionIds as $permissionId) {
                $statement->execute(['role_id' => $id, 'permission_id' => $permissionId]);
            }

            self::getDB()->commit();

        } catch (PDOException $e) {
            self::getDB()->rollback();
            dd($e->getMessage());
        }
    }

    public static function delete($id)
    {
        self::getDB()->beginTransaction();
        try {
            $statement = self::getDB()->prepare("DELETE FROM role_permission WHERE role_id = :role_id");
            $statement->execute(['role_id' => $id]);

            $stmt = self::getDB()->prepare("DELETE FROM roles WHERE id = :id");
            $stmt->execute(['id' => $id]);

            self::getDB()->commit();
        } catch (PDOException $e) {
            self::getDB()->rollBack();
            dd($e->getMessage());
        }
    }
}

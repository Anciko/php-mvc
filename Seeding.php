<?php

require_once './model/BaseModel.php';

class Seeding extends BaseModel
{
    public function start()
    {
        $this->migrateAdminUser();
        $this->migrateRole();
        $this->migratePermission();
        $this->migrateFeature();
        $this->migrateRolePermission();
    }

    // admin table seeding start
    public function migrateAdminUser()
    {
        try {
            $this->createAdminTable();
            if (!$this->checkAdminExists('admin@gmail.com')) {
                $this->addAdmin();
            }
        } catch (PDOException $pdo) {
            dd($pdo->getMessage());
        }
    }

    public function createAdminTable()
    {
        self::getDB()->exec("CREATE TABLE IF NOT EXISTS admin_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) DEFAULT NULL,
            username VARCHAR(50) DEFAULT NULL,
            role_id INT DEFAULT 1,
            phone VARCHAR(100) DEFAULT NULL,
            email VARCHAR(100) DEFAULT NULL,
            address VARCHAR(100) DEFAULT NULL,
            password VARCHAR(255) DEFAULT NULL,
            gender VARCHAR(50) NOT NULL,
            is_active INT DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function checkAdminExists($email)
    {
        $statement = self::getDB()->prepare('SELECT * FROM admin_users WHERE email=:email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addAdmin()
    {
        $statement = self::getDB()->prepare("INSERT INTO `admin_users`
        (`name`, `username`, `role_id`, `phone`, `email`, `address`, `password`, `gender`, `is_active`, `created_at`)
        VALUES
        (:name, :username, :role_id, :phone, :email, :address, :password, :gender, :is_active, :created_at)");

        $statement->bindValue(":name", "Admin Tester");
        $statement->bindValue(":username", "AdminTester@123");
        $statement->bindValue(":role_id", 1);
        $statement->bindValue(":phone", "09100100100");
        $statement->bindValue(":email", "admin@gmail.com");
        $statement->bindValue(":address", "Yangon");
        $statement->bindValue(":gender", "male");
        $statement->bindValue(":password", password_hash("100100100", PASSWORD_DEFAULT));
        $statement->bindValue(":is_active", 1);
        $statement->bindValue(":created_at", date('Y-m-d H:i:s'));

        $statement->execute();
    }
    // admin seeding end

    // role table seeding start
    public function migrateRole()
    {
        try {
            $this->createRoleTable();
            if (!$this->checkRoleExists('Admin')) {
                $this->addRole();
            }
        } catch (PDOException $pdo) {
            dd($pdo->getMessage());
        }
    }

    public function createRoleTable()
    {
        self::getDB()->exec("CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function checkRoleExists($name)
    {
        $statement = self::getDB()->prepare('SELECT * FROM roles WHERE name=:name');
        $statement->bindParam(':name', $name);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addRole()
    {
        $statement = self::getDB()->prepare("INSERT INTO `roles`
        (`name`, `created_at`)
        VALUES
        (:name, :created_at)");

        $statement->bindValue(":name", "Admin");
        $statement->bindValue(":created_at", date('Y-m-d H:i:s'));

        $statement->execute();
    }
    // role table seeding end

    // feature table seeding start
    public function migrateFeature()
    {
        try {
            $this->createFeatureTable();
            if (!$this->checkFeatureExists()) {
                $this->addFeature();
            }
        } catch (PDOException $pdo) {
            dd($pdo->getMessage());
        }
    }

    public function createFeatureTable()
    {
        self::getDB()->exec("CREATE TABLE IF NOT EXISTS features (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function checkFeatureExists()
    {
        $features = ['user', 'role'];
        $placeholders =   implode(',', array_fill(0, count($features), '?'));
        $statement = self::getDB()->prepare("SELECT * FROM features WHERE name IN ($placeholders);");
        $statement->execute($features);
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function addFeature()
    {
        $features = [
            ['name' => 'user'],
            ['name' => 'role']
        ];

        foreach ($features as $feature) {
            $statement = self::getDB()->prepare("INSERT INTO `features`
            (`name`, `created_at`)
            VALUES
            (:name, :created_at);");

            $statement->bindParam(":name", $feature['name']);
            $statement->bindValue(":created_at", date('Y-m-d H:i:s'));

            $statement->execute();
        }  
    }
    // feature table seeding end

    // permissions table seeding start
    public function migratePermission()
    {
        try {
            $this->createPermissionTable();
            if (!$this->checkPermissionExists(['test_manage'])) {
                $this->addPermissions();
            }
        } catch (PDOException $pdo) {
            dd($pdo->getMessage());
        }
    }

    public function createPermissionTable()
    {
        self::getDB()->exec("CREATE TABLE IF NOT EXISTS permissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) DEFAULT NULL,
            feature_id INT(10),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function checkPermissionExists()
    {
        $permissions = ['create_user'];
        $placeholders =   implode(',', array_fill(0, count($permissions), '?'));
        $statement = self::getDB()->prepare("SELECT * FROM permissions WHERE name IN ($placeholders);");
        $statement->execute($permissions);
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function addPermissions()
    {
        $permissions = [
            ['name' => 'create_user', 'feature_id' => 1],
            ['name' => 'update_user', 'feature_id' => 1],
            ['name' => 'delete_user', 'feature_id' => 1],
            ['name' => 'create_role', 'feature_id' => 2],
            ['name' => 'update_role', 'feature_id' => 2],
            ['name' => 'delete_role', 'feature_id' => 2]
        ];

        foreach ($permissions as $permission) {
            $statement = self::getDB()->prepare("INSERT INTO `permissions`
            (`name`, `feature_id`, `created_at`)
            VALUES
            (:name, :feature_id, :created_at)");

            $statement->bindParam(":name", $permission['name']);
            $statement->bindParam(":feature_id", $permission['feature_id']);
            $statement->bindValue(":created_at", date('Y-m-d H:i:s'));

            $statement->execute();
        }   
    }
    // permissions table seeding end


    // role_permission table seeding start
    public function migrateRolePermission()
    {
        try {
            $this->createRolePermissionTable();
            if (!$this->checkRolePermissionExists()) {
                $this->addRolePermission();
            }
        } catch (PDOException $pdo) {
            dd($pdo->getMessage());
        }
    }

    public function createRolePermissionTable()
    {
        self::getDB()->exec("CREATE TABLE IF NOT EXISTS role_permission (
            id INT AUTO_INCREMENT PRIMARY KEY,
            role_id INT,
            permission_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function checkRolePermissionExists()
    {
        $statement = self::getDB()->prepare('SELECT * FROM role_permission;');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return count($result) > 0 ? true : false;
    }

    public function addRolePermission()
    {
        $role_permissions = [
            ['role_id' => 1, 'permission_id' => 1],
            ['role_id' => 1, 'permission_id' => 2],
            ['role_id' => 1, 'permission_id' => 3],
            ['role_id' => 2, 'permission_id' => 4],
            ['role_id' => 2, 'permission_id' => 5],
            ['role_id' => 2, 'permission_id' => 6]  
        ];

        foreach ($role_permissions as $role_permission) {
            $statement = self::getDB()->prepare("INSERT INTO `role_permission`
            (`role_id`, `permission_id`, `created_at`)
            VALUES
            (:role_id, :permission_id, :created_at);");

            $statement->bindParam(":role_id", $role_permission['role_id']);
            $statement->bindParam(":permission_id", $role_permission['permission_id']);
            $statement->bindValue(":created_at", date('Y-m-d H:i:s'));

            $statement->execute();
        }  
    }

    // role_permission table seeding end
}

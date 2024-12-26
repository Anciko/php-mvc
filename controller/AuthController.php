<?php

require_once './controller/Controller.php';
require_once "./model/Admin.php";

class AuthController extends Controller
{
    public function index()
    {
        $this->view('auth/login');
    }

    public function login()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $admin_user = Admin::getAdminByEmail($email);
            
            if ($admin_user && password_verify($password, $admin_user->password)) {
                $_SESSION['auth_user']    = $admin_user->name;
                $_SESSION['auth_user_id'] = $admin_user->id;
                redirectRoute('/');
            } else {
                echo "Invalid email or password!";
            }
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        redirectRoute('/login');
    }
}

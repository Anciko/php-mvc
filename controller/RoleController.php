<?php

require_once './controller/Controller.php';
require_once "./model/Role.php";
require_once "./model/Permission.php";

class RoleController extends Controller
{
    public function __construct()
    {
        redirectBackIfNotAuthUser();
    }

    public function index()
    {
        $roles = Role::all();
        $this->view('role/index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        // dd($permissions);
        $this->view('role/create', compact('permissions'));
    }

    public function store()
    {
        // dd($_POST);
        Role::create();
        redirectRoute('/roles');
    }

    public function edit($id)
    {
        $role = Role::getRoleById($id);
        $permissions = Permission::all();
        $old_permissions = array_column($role['permissions'], 'id');

        $this->view('role/edit', compact('role','permissions', 'old_permissions'));
    }

    public function update($id)
    {
        $newPermissionIds = $_POST['permission_id'];
        Role::update($id, $newPermissionIds);
        redirectRoute('/roles');
    }

    public function destroy($id)
    {
        Role::delete($id);
        redirectRoute('/roles');
    }
}

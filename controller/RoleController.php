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
        if (!CheckUserPermission::has('create_role')) {
            dd('You do not have the permission to control.');
        }

        $permissions = Permission::all();
        // dd($permissions);
        $this->view('role/create', compact('permissions'));
    }

    public function store()
    {
        if (!CheckUserPermission::has('create_role')) {
            dd('You do not have the permission to control.');
        }

        Role::create();
        redirectRoute('/roles');
    }

    public function edit($id)
    {
        if (!CheckUserPermission::has('update_role')) {
            dd('You do not have the permission to control.');
        }

        $role = Role::getRoleById($id);
        $permissions = Permission::all();
        $old_permissions = array_column($role['permissions'], 'id');

        $this->view('role/edit', compact('role', 'permissions', 'old_permissions'));
    }

    public function update($id)
    {
        if (!CheckUserPermission::has('update_role')) {
            dd('You do not have the permission to control.');
        }

        $newPermissionIds = $_POST['permission_id'];
        Role::update($id, $newPermissionIds);
        redirectRoute('/roles');
    }

    public function destroy($id)
    {
        if (!CheckUserPermission::has('delete_role')) {
            dd('You do not have the permission to control.');
        }

        Role::delete($id);
        redirectRoute('/roles');
    }
}

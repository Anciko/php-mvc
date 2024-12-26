<?php

require_once "./model/Admin.php";
require_once "./model/Role.php";

class AdminUserController extends Controller
{
    public function __construct()
    {
        redirectBackIfNotAuthUser();
    }
    public function index()
    {
        $admins = Admin::all();
        $this->view('admin/index', ['admins' => $admins]);
    }

    public function create()
    {
        if (!CheckUserPermission::has('create_user')) {
            dd('You do not have the permission to control.');
        }
        
        $roles = Role::getOnlyRoles();
        $this->view('admin/create', compact('roles'));
    }

    public function store()
    {
        if (!CheckUserPermission::has('create_user')) {
            dd('You do not have the permission to control.');
        }

        Admin::create();
        redirectRoute('/admin-users');
    }

    public function edit($id)
    {
        if (!CheckUserPermission::has('update_user')) {
            dd('You do not have the permission to control.');
        }

        $admin = Admin::getAdminById($id);
        $this->view('admin/edit', compact('admin'));
    }

    public function update($id)
    {
        if (!CheckUserPermission::has('update_user')) {
            dd('You do not have the permission to control.');
        }

        Admin::update($id);
        redirectRoute('/admin-users');
    }

    public function destroy($id)
    {
        if (!CheckUserPermission::has('delete_user')) {
            dd('You do not have the permission to control.');
        }

        Admin::delete($id);
        redirectRoute('/admin-users');
    }
}

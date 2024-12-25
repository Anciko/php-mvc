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
        dd($_POST);
        Role::create();
        redirectRoute('/roles');
    }

    public function edit($id)
    {
        $admin = Admin::getAdminById($id);
        $this->view('admin/edit', compact('admin'));
    }

    public function update($id)
    {
        Admin::update($id);
        redirectRoute('/admin-users');
    }


    public function destroy($id)
    {
        Admin::delete($id);
        redirectRoute('/admin-users');
    }
}

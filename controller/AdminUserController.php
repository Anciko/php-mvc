<?php

require_once "./model/Admin.php";
class AdminUserController extends Controller {
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
        $this->view('admin/create');
    }

    public function store()
    {
        Admin::create();
        redirectRoute('/admin-users');
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


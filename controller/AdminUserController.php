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

    public function edit()
    {
        $this->view('admin/edit');
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}


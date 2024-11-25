<?php

require_once "./model/Admin.php";

class AdminUserController extends Controller {
    public function index()
    {
        $admins = Admin::all();
        $this->view('admin', ['admins' => $admins]);
    }
}


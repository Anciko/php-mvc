<?php

require_once './controller/Controller.php';

class HomeController extends Controller {
    public function index() 
    {
        $data = "Tester";
        $this->view('home', ['data' => $data]);
    }

}
<?php

require_once "functions.php";
require_once "Seeding.php";
require_once "./Middleware/CheckUserPermission.php";

$seeding = new Seeding();
$seeding->start();

$checkUserPermission = new CheckUserPermission();

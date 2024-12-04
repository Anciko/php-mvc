<?php

function dd($value)
{
    echo "<pre>";
    die(var_dump($value));
}

function redirectRoute($uri)
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER["HTTP_HOST"];

    $redirect_url = $protocol . $host . $uri;

    header("location: $redirect_url");
    exit;
}

function redirectBackIfNotAuthUser()
{
    session_start();

    if (!isset($_SESSION['auth_user'])) {
        redirectRoute('/login');
    }
}

function section($path)
{
   require_once __DIR__ . "/view/$path.view.php";
}
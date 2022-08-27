<?php
    session_start();
    
    $session_exists = isset($_SESSION["username"]) || isset($_SESSION["type"]) || isset($_SESSION["id"]);
    $is_login_uri = ($_SERVER['REQUEST_URI'] == "/perrinatas/login.php") || ($_SERVER['REQUEST_URI'] == "/perrinatas/register.php");
    
    if (!$session_exists && !$is_login_uri) {
        header("Location: login.php");
    } else if ($session_exists && $is_login_uri) {
        header("Location: dashboard.php");
    }
?>
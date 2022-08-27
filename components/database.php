<?php
    if ($_SERVER['REQUEST_URI'] == "/perrinatas/database.php") {
        header("Location: index.html");
    }

    $server_name = "localhost";
    $username = "root";
    $password = "";
    $database_name = "perrinatas";

    global $conn;
    $conn = new mysqli($server_name, $username, $password, $database_name);

    if ($conn->connect_error) {
        echo "No se pudo conectar a la DB";
    }
?>
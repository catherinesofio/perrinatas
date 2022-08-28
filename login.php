<?php
    require("components/auth_session.php");
    require("components/database.php");

    function login_user($username, $password) {
        global $conn;

        $query = "SELECT id, type, password FROM `user` WHERE user.username = '$username';";
        $mysql_result = $conn->query($query);
        $num_rows = $mysql_result->num_rows;

        if ($num_rows > 0) {
            $row = $mysql_result->fetch_row();

            $id = $row[0];
            $type = $row[1];
            $pass = $row[2];

            if ($password != $pass) {
                echo "la contra es erronea";
            } else {
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["type"] = $type;

                echo "<script type='text/javascript' src='/perrinatas/scripts/session_storage.js'></script>
                <script type='text/javascript'>
                    login($id, '$username', '$type');
                </script>";
            }
        } else {
            echo "El usuario no existe!";
        }
    }

    if (isset($_POST["username"])) {
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];

        login_user($username, $password);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Perrinatas - Iniciar Sesión</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <meta name="author" content="Catalina Sofio Avogadro" />
        <meta name="keywords" content="Perrinatas,Canes,Perros,Perritos,Caminatas,Paseadores,Paseo de perros,Amantes de animales,Trabaja como paseador,Dueños de Perros" />
        <meta name="description" content="Perrinatas - Servicio de Paseo de Perros" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

        <!-- FontAwesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="">🐕 Perrinatas</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navigation" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link disabled" href="/perrinatas/login.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/perrinatas/register.php">Registrarse</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="main" class="container">
            <form class="form" action="" name="login" method="POST">
                <legend>Iniciar Sesión</legend>

                <fieldset class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="username">@</label>
                    </div>

                    <input id="username" class="form-control" name="username" type="text" placeholder="Usuario" required />
                </fieldset>

                <fieldset class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="password">
                            <i class="fa-solid fa-key"></i>
                        </label>
                    </div>

                    <input id="password" class="form-control" name="password" type="password" placeholder="Contraseña" required />

                    <div class="input-group-append">
                        <button id="toggle-password" class="btn btn-primary" type="button" hide="true" onclick="toggle_password()">
                            <i class="fa-solid fa-eye" title="Mostrar"></i>
                        </button>
                    </div>
                </fieldset>

                <button id="submit" class="btn btn-primary" name="submit" type="submit" value="INICIAR SESION">INICIAR SESION</button>
            </form>
        </div>
        
        <!-- Utils -->
        <script type="text/javascript" src="/perrinatas/scripts/utils.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- FontAwesome JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>
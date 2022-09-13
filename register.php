<?php
    require("components/auth_session.php");
    require("components/database.php");

    function user_exists($username) {
        global $conn;

        $query = "SELECT * FROM `user` WHERE user.username = '$username';";
        $mysql_result = $conn->query($query);
        $num_rows = $mysql_result->num_rows;

        return ($num_rows > 0);
    }

    function create_user($type, $username, $password) {
        global $conn;

        if (user_exists($username)) {
            echo "<script type='text/javascript'>
                setTimeout(() => {
                    show_modal('warning', '<i class=\"fa-solid fa-triangle-exclamation\"></i> Error', '<h5>Lo sentimos, pero el usuario <span class=\"text-warning\">$username</span> ya existe. <a href=\"/perrinatas/login.php\">¡Inicia sesión!</a></h5>');
                }, 1);
            </script>";
            
            return;
        }

        try {
            $query = "INSERT INTO `user` (type, username, password) VALUES ('$type', '$username', '$password');";
            $mysql_result = $conn->query($query);

            echo "<script type='text/javascript'>
                setTimeout(() => {
                    show_modal('success', '<i class=\"fa-solid fa-triangle-exclamation\"></i> Cuenta Creada', '<h5>El usuario <span class=\"text-success\">$username</span> fue creado existosamente. <a href=\"/perrinatas/login.php\">¡Inicia sesión!</a></h5>');
                }, 1);
            </script>";
        } catch (Exception $error) {
            echo "<script type='text/javascript'>
                setTimeout(() => {
                    show_modal('danger', '<i class=\"fa-solid fa-triangle-exclamation\"></i> Error', '<h5>Lo sentimos, hubo un error al crear al usuario <span class=\"text-danger\">$username</span>. Por favor, intenta más tarde.</h5>');
                }, 1);
            </script>";
        }
    }

    if (isset($_POST["type"])) {
        $type = $_REQUEST["type"];
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];

        create_user($type, $username, $password);
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Perrinatas - Registrarse</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <meta name="author" content="Catalina Sofio Avogadro" />
        <meta name="keywords" content="Perrinatas,Canes,Perros,Perritos,Caminatas,Paseadores,Paseo de perros,Amantes de animales,Trabaja como paseador,Dueños de Perros" />
        <meta name="description" content="Perrinatas - Servicio de Paseo de Perros" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

        <!-- FontAwesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- https://startbootstrap.com/theme/sb-admin-2 -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" />
        <link rel="stylesheet" href="css/sb-admin-2.min.css" />
        
        <!-- Stylesheet -->
        <link rel="stylesheet" href="css/style.css" />
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <a class="navbar-brand" href=""><i class="fa-solid fa-paw"></i> Perrinatas</a>
        </nav>

        <!-- Content -->
        <div id="main" class="container-fluid">
            <!-- Register -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">¡Bienvenido a Perrinatas™!</h1>
                                        </div>

                                        <!-- Register Form -->
                                        <form id="register" class="user form needs-validation" name="register" method="POST">
                                            <fieldset class="form-group mb-1">
                                                <label for="type">¿Qué buscas?</label>

                                                <select id="type" class="form-control" name="type" placeholder="Nombre" required />
                                                    <option value="owner" selected>🚶 Paseadores de perritos</option>
                                                    <option value="walker">🐕 Perritos para pasear</option>
                                                </select>
                                            </fieldset>

                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="username">@</label>
                                                </div>

                                                <input id="username" class="form-control" name="username" type="text" placeholder="Tu usuario..." autocomplete="username" required />
                                            </fieldset>

                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="password">
                                                        <i class="fa-solid fa-key"></i>
                                                    </label>
                                                </div>

                                                <input id="password" class="form-control" name="password" type="password" placeholder="Tu contraseña..." autocomplete="new-password" required />

                                                <div class="input-group-append">
                                                    <button id="toggle-password" class="btn btn-primary" type="button" hide="true" onclick="toggle_password()">
                                                        <i class="fa-solid fa-eye" title="Mostrar"></i>
                                                    </button>
                                                </div>
                                            </fieldset>

                                            </br>

                                            <button id="submit" class="btn btn-primary btn-block rounded-pill" name="submit" type="submit" value="Registrarse">Registrarse</button>
                                        </form>
                                        <hr>

                                        <p class="text-center">¿Ya tenes una cuenta?
                                            <br/>
                                            <a href="/perrinatas/login.php">¡Inicia sesión!</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6 d-none d-lg-block bg-register-image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <?php require("components/modal.php"); ?>
        
        <!-- Utils -->
        <script type="text/javascript" src="scripts/utils.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- FontAwesome JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>
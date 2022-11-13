<?php
    require_once("components/auth_session.php");
    require_once("components/database.php");
    require_once("components/modal.php");

    
    main();

    
    // Main
    function main() {
        draw_page();
        check_request();
    }

    function draw_page() {
        $modal = get_modal();

        $page = <<<PAGE
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <title>Perrinatas - Iniciar Sesión</title>
            
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
                        <!-- Login -->
                        <div class="row justify-content-center">
                            <div class="col-xl-10 col-lg-12 col-md-9">
                                <div class="card o-hidden border-0 shadow-lg my-5">
                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
            
                                            <div class="col-lg-6">
                                                <div class="p-5">
                                                    <div class="text-center">
                                                        <h1 class="h4 text-gray-900 mb-4">¡Que lindo verte de vuelta!</h1>
                                                    </div>
            
                                                    <span></span>
            
                                                    <!-- Login Form -->
                                                    <form id="login" class="user form needs-validation" action="" name="login" method="POST">
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
            
                                                            <input id="password" class="form-control" name="password" type="password" placeholder="Tu contraseña..." autocomplete="current-password" required />
            
                                                            <div class="input-group-append">
                                                                <button id="toggle-password" class="btn btn-primary" type="button" hide="true" onclick="toggle_password()">
                                                                    <i class="fa-solid fa-eye" title="Mostrar"></i>
                                                                </button>
                                                            </div>
                                                        </fieldset>
            
                                                        </br>
            
                                                        <button id="submit" class="btn btn-primary btn-block rounded-pill" name="submit" type="submit" value="Iniciar Sesión">Iniciar Sesión</button>
                                                    </form>
                                                    <hr>
            
                                                    <p class="text-center">¿Todavía no tenes una cuenta?
                                                        <br/>
                                                        <a href="/perrinatas/register.php">¡Registrate!</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    {$modal}
                    
                    <!-- Page Scripts -->
                    <script type="text/javascript">
                        function toggle_password() {
                            let button = document.getElementById("toggle-password");
                            let state = button.getAttribute("hide");
                        
                            let icon = button.getElementsByTagName("svg")[0];
                        
                            let input = document.getElementById("password");
                        
                            if (state == "true") {
                                button.setAttribute("hide", "false");
                        
                                icon.classList.add("fa-eye-slash");
                                icon.title = "Ocultar";
                        
                                password.setAttribute("type", "text");
                            } else {
                                button.setAttribute("hide", "true");
                        
                                icon.classList.add("fa-eye");
                                icon.title = "Mostrar";
                        
                                password.setAttribute("type", "password");
                            }
                        }

                        function login(id, username, type) {
                            sessionStorage.clear();
                            sessionStorage.setItem("id", id);
                            sessionStorage.setItem("username", username);
                            sessionStorage.setItem("type", type);
                        
                            setTimeout(() => {
                                window.location.replace("/perrinatas/dashboard.php");
                            }, 1);
                        }
                    </script>
            
                    <!-- Bootstrap JavaScript -->
                    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            
                    <!-- FontAwesome JavaScript -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                </body>
            </html>
PAGE;

        echo($page);
    }

    function check_request() {
        if (isset($_POST["username"]) && isset($_POST["username"])) {
            $username = $_REQUEST["username"];
            $password = $_REQUEST["password"];

            check_login_data($username, $password);
        }
    }
 
    // Login
    function check_login_data($username, $password) {
        $mysql_result = get_user($username, $password);
        $num_rows = $mysql_result->num_rows;

        if ($num_rows > 0) {
            $row = $mysql_result->fetch_row();

            $id = $row[0];
            $type = $row[1];
            $pass = $row[2];

            if ($password != $pass) {
                show_modal("warning", "<i class='fa-solid fa-triangle-exclamation'></i> Error", "<h5>Lo sentimos, pero la contraseña es erronea. Por favor, ¡intentalo nuevamente!</h5>");
            } else {
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["type"] = $type;
                $_SESSION["instant"] = time();

                trigger_login($id, $username, $type);
            }
        } else {
            show_modal("warning", "<i class='fa-solid fa-triangle-exclamation'></i> Error", "Lo sentimos, pero el usuario <span class='text-warning'>$username</span> no existe. <a href='/perrinatas/register.php'>¡Registrate!</a></h5>");
        }
    }

    function trigger_login($id, $username, $type) {
        $login_action = <<<LOGIN
            <script type="text/javascript">
                login({$id}, "{$username}", "{$type}");
            </script>
LOGIN;

        echo($login_action);
    }  
?>
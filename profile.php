<?php
    require("components/auth_session.php");
    require("components/database.php");
    require("components/logout.php");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Perrinatas - Perfil</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <meta name="author" content="Catalina Sofio Avogadro" />
        <meta name="keywords" content="Perrinatas,Canes,Perros,Perritos,Caminatas,Paseadores,Paseo de perros,Amantes de animales,Trabaja como paseador,Dueños de Perros" />
        <meta name="description" content="Perrinatas - Servicio de Paseo de Perros" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
        
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
            
            <ul class="navbar-nav ml-auto">
                <!-- Nav Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/perrinatas/dashboard.php">
                        <i class="fa-solid fa-house" title="Inicio"></i>
                    </a>
                </li>

                <!-- Nav Matches -->
                <li class="nav-item">
                    <a class="nav-link" href="/perrinatas/matches.php">
                        <i class="fa-solid fa-comments" title="Conexiones"></i>
                    </a>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav User -->
                <li class="nav-item dropdown no-arrow">
                    <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["username"]; ?></span>
                        <img class="img-profile rounded-circle" src="img/default-person.jpg" />
                    </a>

                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item disabled" href="/perrinatas/profile.php">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                        </a>

                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item" href="?logout=true">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <div id="main" class="container-fluid">
            <?php
                if ($_SESSION["type"] == "owner") {
                    require("components/profile_owner.php");
                } else {
                    require("components/profile_walker.php");
                }
            ?>
        </div>

        <!-- Modal -->
        <?php require("components/modal.php"); ?>
        
        <!-- Utils -->
        <script type="text/javascript" src="scripts/utils.js"></script>
        
        <!-- Coordinates -->
        <script type="text/javascript" src="scripts/coordinates.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.js"></script>

        <!-- FontAwesome JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>
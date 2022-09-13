<?php
    require("components/auth_session.php");
    require("components/database.php");
    require("components/logout.php");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Perrinatas - Inicio</title>

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
            
            <ul class="navbar-nav ml-auto">
                <!-- Nav Dashboard -->
                <li class="nav-item">
                    <a class="nav-link disabled" href="/perrinatas/dashboard.php">
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
                        <a class="dropdown-item" href="/perrinatas/profile.php">
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

        <!-- Content -->
        <div id="main" class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <?php
                    if ($_SESSION["type"] == "owner") {
                        echo "<h1 class='h3 mb-0 text-gray-800'>Paseadores</h1>
                        <div class='dropdown mb-4'>
                            <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Perro 01</button>
                                
                            <div class='dropdown-menu animated--fade-in' aria-labelledby='dropdownMenuButton'>
                                <a class='dropdown-item' href='#'>Perro 01</a>
                                <a class='dropdown-item' href='#'>Perro 02</a>
                            </div>
                        </div>";

                        
                    } else {
                        echo "<h1 class='h3 mb-0 text-gray-800'>Perritos</h1>";
                    }
                ?>
            </div>

            <?php
                $id = $_SESSION["id"];

                if ($_SESSION["type"] == "owner") {
                    $sql = "SELECT COUNT(profile_dog.dog_id) FROM profile_dog INNER JOIN dog ON profile_dog.dog_id=dog.id AND dog.user_id = $id;";
                    $mysql_result = $conn->query($sql);

                    $row = $mysql_result->fetch_row();
                    $count = $row[0];
                    
                    if ($count > 0) {
                        $data = "";

                        require("components/dashboard_owner.php");
                    } else {
                        echo "<div class='alert alert-info' role='alert'>
                            <h5><i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con paseadores, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a></h5>
                        </div>";
                    }
                } else {
                    $sql = "SELECT COUNT(profile_walker.user_id) FROM profile_walker WHERE profile_walker.user_id = $id;";
                    $mysql_result = $conn->query($sql);
                    
                    $row = $mysql_result->fetch_row();
                    $count = $row[0];

                    if ($count > 0) {
                        $data = "";

                        require("components/dashboard_walker.php");
                    } else {
                        echo "<div class='alert alert-info' role='alert'>
                            <h5><i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con perritos, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a></h5>
                        </div>";
                    }
                }
            ?>   
        </div>

        <!-- Modal -->
        <?php require("components/modal.php"); ?>
        
        <!-- Modal Profiles -->
        <?php require("components/modal_profiles.php"); ?>

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
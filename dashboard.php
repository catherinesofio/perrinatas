<?php
    require("components/auth_session.php");
    require("components/database.php");
    require("components/logout.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Perrinatas - Inicio</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <meta name="author" content="Catalina Sofio Avogadro" />
        <meta name="keywords" content="Perrinatas,Canes,Perros,Perritos,Caminatas,Paseadores,Paseo de perros,Amantes de animales,Trabaja como paseador,Dueños de Perros" />
        <meta name="description" content="Perrinatas - Servicio de Paseo de Perros" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

        <!-- FontAwesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Stylesheet -->
        <link rel="stylesheet" href="/perrinatas/css/style.css" />
    </head>

    <body>
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href=""><i class="fa-solid fa-paw"></i> Perrinatas</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navigation" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link disabled" href="/perrinatas/dashboard.php">
                            <i class="fa-solid fa-house" title="Inicio"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/perrinatas/matches.php">
                            <i class="fa-solid fa-comments" title="Conexiones"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/perrinatas/profile.php">
                            <i class="fa-solid fa-user" title="Perfil"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?logout=true">
                            <i class="fa-solid fa-arrow-right-from-bracket" title="Cerrar Sesión"></i>
                        </a>
                    </li>
                    <?php
                        if ($_SESSION["type"] == "owner") {
                            echo "<li class='nav-item'>
                                <div class='dropdown-menu'>
                                    <a class='dropdown-item' href='#'>Perro 1</a>
                                    <a class='dropdown-item active' href='#'>Perro 2</a>
                                </div>
                            </li>";
                        }
                    ?>
                </ul>
            </div>
        </nav>

        <div id="main" class="container justify-content-center d-flex">
            <?php
                $id = $_SESSION["id"];

                if ($_SESSION["type"] == "owner") {
                    $sql = "SELECT COUNT(profile_dog.dog_id) FROM profile_dog INNER JOIN dog ON profile_dog.dog_id=dog.id AND dog.user_id = $id;";
                    $mysql_result = $conn->query($sql);

                    $row = $mysql_result->fetch_row();
                    $count = $row[0];
                    
                    if ($count > 0) {
                        $data = "";

                        include("components/dashboard_owner.php");
                    } else {
                        echo "<div class='alert alert-info' role='alert'>
                            <p><i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con paseadores, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a></p>
                        </div>";
                    }
                } else {
                    $sql = "SELECT COUNT(profile_walker.user_id) FROM profile_walker WHERE profile_walker.user_id = $id;";
                    $mysql_result = $conn->query($sql);
                    
                    $row = $mysql_result->fetch_row();
                    $count = $row[0];

                    if ($count > 0) {
                        $data = "";

                        include("components/dashboard_walker.php");
                    } else {
                        echo "<div class='alert alert-info' role='alert'>
                            <p><i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con perritos, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a></p>
                        </div>";
                    }
                }
            ?>   
        </div>

        <!-- Bootstrap JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- FontAwesome JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </body>
</html>
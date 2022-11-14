<?php
    require_once("components/auth_session.php");
    require_once("components/database.php");
    require_once("components/logout.php");
    require_once("components/modal.php");
    require_once("components/alert.php");
    require_once("components/cards.php");
    require_once("components/popups.php");


    main();


    // Main
    function main() {
        get_data();
        draw_page();
        check_request();
    }

    function get_data() {
        global $has_profile, $curr_dog, $dogs, $curr_walker, $walker, $walkers;

        $id_user = $_SESSION["id"];
        $type = $_SESSION["type"];
        $curr_dog = -1;

        if ($type == "owner") {
            $has_profile = has_dog_profiles($id_user);
        } else {
            $has_profile = has_walker_profile($id_user);
        }

        if ($has_profile && $type == "owner") {
            // Dog's Name List
            $mysql_result = get_dogs($id_user);
            
            $dogs = array();
            while ($dog = $mysql_result->fetch_assoc()) {
                $dogs[$dog["id"]] = $dog;
            }

            if (isset($_GET["id"])) {
                $curr_dog = $_REQUEST["id"];    
            } else {
                $curr_dog = array_key_first($dogs);
            }
            $id_dog = $curr_dog;
            

            // Walkers List
            $dog = $dogs[$id_dog];
            $latitude = $dog["latitude"];
            $longitude = $dog["longitude"];

            $mysql_result = get_unmatched_walkers($curr_dog, $latitude, $longitude);
            
            $walkers = array();
            while ($walker = $mysql_result->fetch_assoc()) {
                $walkers[$walker["id"]] = $walker;
            }
        } else if ($has_profile) {
            // Walker Id
            $walker = get_walker($id_user);
            
            $curr_walker = $walker["id"];


            // Dogs List
            $latitude = $walker["latitude"];
            $longitude = $walker["longitude"];

            $mysql_result = get_unmatched_dogs($curr_walker, $latitude, $longitude);

            $dogs = array();
            while ($dog = $mysql_result->fetch_assoc()) {
                $dogs[$dog["id"]] = $dog;
            }
        }
    }

    function draw_page() {
        global $has_profile, $curr_dog, $dogs, $walker;

        $type = $_SESSION["type"];
        $username = $_SESSION["username"];
        
        if ($type == "owner") {
            $content = get_content_owners();
            $photo = ($has_profile) ? $dogs[$curr_dog]["photo"] : "default-dog.jpg";
        } else {
            $content = get_content_walkers();
            $photo = ($has_profile) ? $walker["photo"] : "default-person.jpg";
        }
        
        $modal = get_modal();

        $page = <<<PAGE
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
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{$username}</span>
                                    <img class="img-profile rounded-circle" src="img/{$photo}" />
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
                        {$content}
                    </div>

                    <!-- Modal -->
                    {$modal}

                    <!-- Page Scripts -->
                    <script type="text/javascript">
                        // Connect User
                        function connect_user(id_user) {
                            const urlParams = new URLSearchParams(window.location.search);
                            urlParams.set("connect", true);

                            window.location.search = urlParams;
                        }

                        // Show Modal
                        function show_modal_profile(e) {
                            e.preventDefault();

                            let id_user = e.target.closest("a").getAttribute("id_user");
                            const urlParams = new URLSearchParams(window.location.search);
                            urlParams.set("id_user", id_user);

                            window.location.search = urlParams;
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
        global $curr_dog, $dogs, $curr_walker, $walkers;
        
        if (isset($_GET["id_user"]) && isset($_GET["connect"])) {
            $id = $_SESSION["id"];
            $type = $_SESSION["type"];
            $id_user = $_GET["id_user"];

            if ($type == "owner") {
                $id_walker = $id_user;
                $id_dog = $curr_dog;
            } else {
                $id_walker = $curr_walker;
                $id_dog = $id_user;
            }

            if (match_exists($id_walker, $id_dog)) {
                show_modal("warning", "<i class='fa-solid fa-triangle-exclamation'></i> Conexión existente", "<h5>¡Ya estas conectada con este usuario! Chatea con este en la sección de <a href='/perrinatas/matches.php'>conexiones</a></h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
            } else {
                $request = get_request($id_walker, $id_dog);

                if ($request && $request["type_requestor"] != $type) {
                    try {
                        add_match($id_walker, $id_dog);

                        show_modal("success", "<i class='fa-solid fa-triangle-exclamation'></i> Conexión Exitosa", "<h5>¡Ya puedes chatear con este usuario en la ventada de <a href='/perrinatas/matches.php'>conexiones!</a></h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
                        
                    } catch (Exception $error) {
                        show_modal("danger", "<i class='fa-solid fa-triangle-exclamation'></i> Error", "<h5>Lo sentimos, hubo un error al generar la conexión. Por favor, intentalo nuevamente más tarde.</h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
                    }
                } else if (!$request) {
                    try {
                        add_request($id_walker, $id_dog);
            
                        show_modal("success", "<i class='fa-solid fa-triangle-exclamation'></i> Conexión Solicitada", "<h5>¡Se ha enviado tu solicitud de conexión! Si el otro usuario la acepta, ¡pronto podrás chatear con este!</h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
                        
                    } catch (Exception $error) {
                        show_modal("danger", "<i class='fa-solid fa-triangle-exclamation'></i> Error", "<h5>Lo sentimos, hubo un error al mandar la solicitud de conexión. Por favor, intentalo nuevamente más tarde.</h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
                    }
                } else {
                    show_modal("success", "<i class='fa-solid fa-triangle-exclamation'></i> Conexión Solicitada", "<h5>¡Se ha enviado tu solicitud de conexión! Si el otro usuario la acepta, ¡pronto podrás chatear con este!</h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
                }
            }
        } else if (isset($_GET["id_user"])) {
            $id_user = $_REQUEST["id_user"];
            $type = $_SESSION["type"];
            
            if ($type == "owner") {
                $walker = $walkers[$id_user];

                show_walker_profile($walker);
            } else {
                $dog = $dogs[$id_user];

                show_dog_profile($dog);
            }
        }
    }

    // Owners
    function get_content_owners() {
        global $has_profile, $curr_dog, $dogs, $walkers;

        if ($has_profile) {
            $curr_name = $dogs[$curr_dog]["name"];
            
            $dropdown = "";
            foreach ($dogs as $dog_id => $dog) {
                $id = $dog_id;
                $name = $dog["name"];

                $dropdown = $dropdown . "<a class='dropdown-item' href='?id=$id'>$name</a>";
            }

            $heading = <<<HEADING
                <div class="dropdown mb-4">
                    <button id="dropdownMenuButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{$curr_name}</button>
                
                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                        {$dropdown}
                    </div>
                </div>
HEADING;

            if (count($walkers) > 0) {
                $cards = "";
                foreach ($walkers as $walker) {
                    $cards = $cards . get_walker_card($walker);
                }

                $body = <<<BODY
                    <div class="card-columns row justify-content-center">
                        {$cards}
                    </div>
BODY;
            } else {
                $body = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Oops! Parece que te has conectado con todos los paseadores de la aplicación. ¡Comparte la app e invita a tus amigos para que haya más de ellos!");
            }
        } else {
            $heading = "";
            $body = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con paseadores, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a>.");
        }

        $content = <<<CONTENT
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Paseadores</h1>
                {$heading}
            </div>

            <!-- Page Body -->
            {$body}
CONTENT;

        return $content;
    }

    // Walkers
    function get_content_walkers() {
        global $has_profile, $dogs;

        if ($has_profile) {
            if (count($dogs) > 0) {
                $cards = "";
                foreach ($dogs as $dog) {
                    $cards = $cards . get_dog_card($dog);
                }
                
                $body = <<<BODY
                    <div class="card-columns row justify-content-center">
                        {$cards}
                    </div>
BODY;
            } else {
                $body = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Oops! Parece que te has conectado con todos los perritos de la aplicación. ¡Comparte la app e invita a tus amigos para que haya más de ellos!");
            }
        } else {
            $body = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con perritos, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a>.");
        }

        $content = <<<CONTENT
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Perritos</h1>
            </div>

            <!-- Page Body -->
            {$body}
CONTENT;

        return $content;
    }
?>
<?php
    require_once("components/auth_session.php");
    require_once("components/database.php");
    require_once("components/logout.php");
    require_once("components/modal.php");
    require_once("components/alert.php");
    require_once("components/popups.php");
    require_once("components/chat.php");
    

    main();

    
    // Main
    function main() {
        get_data();
        draw_page();
        check_request();
    }

    function get_data() {
        global $has_profile, $curr_dog, $dogs, $curr_walker, $walker, $contacts, $chats;

        $id = $_SESSION["id"];
        $type = $_SESSION["type"];
        $curr_dog = -1;
        $contacts = array();
        $chats = array();

        if ($type == "owner") {
            $has_profile = has_dog_profiles($id);
        } else {
            $has_profile = has_walker_profile($id);
        }

        if ($has_profile && $type == "owner") {
            // Dog's Name List
            $mysql_result = get_dogs($id);
            
            $dogs = array();
            while ($dog = $mysql_result->fetch_assoc()) {
                $dogs[$dog["id"]] = $dog;
            }
            
            if (isset($_GET["id"])) {
                $curr_dog = $_REQUEST["id"];    
            } else {
                $curr_dog = array_key_first($dogs);
            }
            

            // Dog Matches
            if ($curr_dog > -1) {
                $matches = get_dog_matches($curr_dog);
            
                while ($contact = $matches->fetch_assoc()) {
                    $id_user = $contact["id"];
                    $id_match = $contact["id_match"];
                    $name = $contact["name"];
                    $photo = $contact["photo"];
    
                    $messages = get_messages($id_match, $id);
                    
                    $contacts[$id_user] = $contact;
    
                    while ($message = $messages->fetch_assoc()) {
                        if ($message) {
                            $message["id_user"] = $id_user;
                            $message["name"] = $name;
                            $message["photo"] = $photo;
    
                            $chats[] = $message;
                        }
                    }
                }
            }
        } else if ($has_profile) {
            // Walker
            $walker = get_walker($id);
            
            $curr_walker = $walker["id"];


            // Walker Matches
            $matches = get_walker_matches($curr_walker);
            
            while ($contact = $matches->fetch_assoc()) {
                $id_user = $contact["id"];
                $id_match = $contact["id_match"];
                $name = $contact["name"];
                $photo = $contact["photo"];

                $messages = get_messages($id_match, $id);
                
                $contacts[$id_user] = $contact;

                while ($message = $messages->fetch_assoc()) {
                    if ($message) {
                        $message["id_user"] = $id_user;
                        $message["name"] = $name;
                        $message["photo"] = $photo;

                        $chats[] = $message;
                    }
                }
            }
        }
    }

    function draw_page() {
        global $has_profile, $curr_dog, $dogs, $contacts, $chats, $walker;

        $type = $_SESSION["type"];
        $username = $_SESSION["username"];

        if ($has_profile) {
            if ($type == "owner") {
                $content = get_content_owners();
                $photo = $dogs[$curr_dog]["photo"];
            } else {
                $content = get_content_walkers();
                $photo = $walker["photo"];
            }

            $chat = get_chat($contacts, $chats, $photo);
        } else {
            $content = "";

            if ($type == "owner") {
                $chat = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con paseadores, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a>.");
                $photo = "default-dog.jpg";
            } else {
                $chat = get_alert("info", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Alto ahí! Para conectar con perritos, primero tenes que <a href='/perrinatas/profile.php'>completar tu perfil</a>.");
                $photo = "default-person.jpg";
            }
        }

        $modal = get_modal();

        $page = <<<PAGE
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <title>Perrinatas - Conexiones</title>
            
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
                                <a class="nav-link" href="/perrinatas/dashboard.php">
                                    <i class="fa-solid fa-house" title="Inicio"></i>
                                </a>
                            </li>
            
                            <!-- Nav Matches -->
                            <li class="nav-item">
                                <a class="nav-link disabled" href="/perrinatas/matches.php">
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
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class='h3 mb-0 text-gray-800'>Mis Conexiones</h1>
                            {$content}
                        </div>
                        
                        {$chat}
                    </div>

                    <!-- Modal -->
                    {$modal}

                    <!-- Page Scripts -->
                    <script type="text/javascript">
                        // Confirm Disconnect User
                        function confirm_disconnect(id_user) {
                            const urlParams = new URLSearchParams(window.location.search);
                            urlParams.set("confirm-disconnect", true);

                            window.location.search = urlParams;
                        }
                        
                        // Disconnect User
                        function disconnect_user(id_match) {
                            const urlParams = new URLSearchParams(window.location.search);
                            urlParams.set("disconnect", true);
                            urlParams.set("id_match", id_match);

                            window.location.search = urlParams;
                        }

                        // Change Tab
                        function change_tab(tab) {
                            $("#myTab button[data-target='#" + tab + "']").tab("show");
                        }

                        // Scroll Top
                        function scroll_top(id) {
                            var element = document.getElementById(id);
                            element.scrollTop = 0;
                        }
                        
                        // Scroll Bottom
                        function scroll_bottom(id) {
                            var element = document.getElementById(id);
                            element.scrollTop = element.scrollHeight - element.clientHeight;
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
        global $curr_dog, $curr_walker, $contacts, $contacts;

        $id = $_SESSION["id"];
        $type = $_SESSION["type"];

        if (isset($_POST["id_match"]) && isset($_POST["message"])) {
            $id_match = $_REQUEST["id_match"];
            $message = $_REQUEST["message"];

            try {
                add_message($id_match, $id, $message);

                echo "<meta http-equiv='refresh' content='0'>";
            } catch (Exception $error) {
                show_modal("danger", "<i class='fa-solid fa-triangle-exclamation'></i> Error", "<h5>Lo sentimos, no se puedo enviar el mensaje. Por favor, intentalo nuevamente más tarde.</h5>", "", "");
            }

            return false;
        }
        
        if (isset($_GET["id_match"]) && isset($_GET["disconnect"])) {
            $id_match = $_REQUEST["id_match"];

            try {
                delete_match($id_match);
    
                show_modal("success", "<i class='fa-solid fa-triangle-exclamation'></i> Conexión Borrada", "<h5>¡Se ha removido la conexión con exito!</h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
            } catch (Exception $error) {
                show_modal("danger", "<i class='fa-solid fa-triangle-exclamation'></i> Error", "<h5>Lo sentimos, hubo un error al mandar tratar de remover la conexión. Por favor, intentalo nuevamente más tarde.</h5>", "", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
            }
        } else if (isset($_GET["id_user"]) && isset($_GET["confirm-disconnect"])) {
            $id_user = $_REQUEST["id_user"];
            $name_user = $contacts[$id_user]["name"];

            show_modal("danger", "<i class='fa-solid fa-triangle-exclamation'></i> Desconectar", "<h5>¿Estas seguro que queres desconectarte de <span class='text-danger'>{$name_user}</span>?</h5>", "<button class='btn btn-danger' type='button' onclick='disconnect_user({$id});'>Aceptar</button><button class='btn btn-secondary' type='button' onclick='hide_modal();'>Cancelar</button>", "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
        } else if (isset($_GET["id_match"])) {
            echo "HOLA ACA TENGO QUE MODIFICAR";
        } else if (isset($_GET["id_user"])) {
            $id_user = $_REQUEST["id_user"];
            $contact = $contacts[$id_user];

            if ($type == "owner") {
                show_walker_profile($contact, true);
            } else {
                show_dog_profile($contact, true);
            }
        }
    }

    // Owner
    function get_content_owners() {
        global $curr_dog, $dogs;

        $curr_name = $dogs[$curr_dog]["name"];
            
        $dropdown = "";
        foreach ($dogs as $dog_id => $dog) {
            $id = $dog_id;
            $name = $dog["name"];

            $dropdown = $dropdown . "<a class='dropdown-item' href='?id=$id'>$name</a>";
        }

        $content = <<<CONTENT
            <div class="dropdown mb-4">
                <button id="dropdownMenuButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{$curr_name}</button>
            
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                    {$dropdown}
                </div>
            </div>
CONTENT;

        return $content;
    }

    // Walker
    function get_content_walkers() {
        $content = <<<CONTENT
CONTENT;

        return $content;
    }
?>
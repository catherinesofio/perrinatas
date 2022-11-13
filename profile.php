<?php
    require_once("components/auth_session.php");
    require_once("components/database.php");
    require_once("components/logout.php");
    require_once("components/modal.php");
    

    main();

    
    // Main
    function main() {
        get_data();
        draw_page();
        check_request();
    }

    function get_data() {
        global $curr_dog, $dogs, $walker;

        $id = $_SESSION["id"];
        $type = $_SESSION["type"];
        $curr_dog = -1;

        if ($type == "owner") {
            $mysql_result = get_dogs_profile($id);

            $dogs = array();
            while ($dog = $mysql_result->fetch_assoc()) {
                $dogs[$dog["id"]] = $dog;
            }
            
            $dogs[] = array(
                "id" => -1,
                "user_id" => $id,
                "name" => "Nuevo Perro",
                "photo" => "default-dog.jpg",
                "description" => "",
                "id_location" => -1,
                "location" => "",
                "latitude" => null,
                "longitude" => null,
                "breed" => "",
                "sex" => "",
                "size" => ""
            );

            $curr_dog = array_key_first($dogs);
        } else {
            $mysql_result = get_walker_profile($id);

            $walker = $mysql_result->fetch_assoc();
            if (!$walker) {
                $walker = array(
                    "id" => -1,
                    "user_id" => $id,
                    "name" => "",
                    "photo" => "default-person.jpg",
                    "description" => "",
                    "id_location" => -1,
                    "location" => "",
                    "latitude" => null,
                    "longitude" => null,
                    "id_schedule" => -1,
                    "days" => array(),
                    "hours" => array(),
                    "price" => 1
                );
            } else {
                $days = $walker["days"];
                $walker["days"] = json_decode($days, true);

                $hours = $walker["hours"];
                $walker["hours"] = json_decode($hours, true);
            }
        }
    }

    function draw_page() {
        $modal = get_modal();

        $username = $_SESSION["username"];
        $type = $_SESSION["type"];
        
        if ($type == "owner") {
            $photo = "default-dog.jpg";
            $content = get_content_owner();
        } else {
            $photo = "default-person.jpg";
            $content = get_content_walker();
        }

        $page = <<<PAGE
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
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{$username}</span>
                                    <img class="img-profile rounded-circle" src="img/{$photo}" />
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
                        {$content}
                    </div>

                    <!-- Modal -->
                    {$modal}

                    <!-- Page Scripts -->
                    <script type="text/javascript">
                        // Change Tab
                        function change_tab(tab) {
                            $("#myTab button[data-target='#" + tab + "']").tab("show");
                        }

                        // Profile Picture
                        // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
                        function update_profile_pic(e) {
                            let curFiles = e.target.files;

                            let preview = document.querySelector("#photo-preview");
                            let label = document.querySelector("#photo-name");
                            if (curFiles.length > 0) {
                                for (let file of curFiles) {
                                    let url = URL.createObjectURL(file);

                                    label.innerText = url;
                                    preview.src = url;
                                }
                            } else {
                                label.innerText = "Selecciona una foto...";
                                preview.src = "img/{$photo}";
                            }
                        }

                        // Get Geolocation
                        function get_user_coordinates() {
                            navigator.geolocation.getCurrentPosition(position => {
                                document.getElementById("latitude").value = position.coords.latitude;
                                document.getElementById("longitude").value = position.coords.longitude;
                            }, () => {
                                alert("¡Tenes que permitir la locacion para continuar!");
                            });
                        }

                        // Get Latitude and Longitude from Map
                        function get_map_coordinates() {
                            try {
                                let container = document.getElementsByClassName("wm-attribution-control__latlng")[0];
                                let text = container.getElementsByTagName("span")[0].innerHTML;

                                let regex = /([-]?[0-9]*[.][0-9]*)/g;
                                let match = text.match(regex);

                                coords = {
                                    latitude: match[0],
                                    longitude: match[1]
                                };

                                console.log(coords);
                            } catch (error) {
                                console.log("ERROR AL GUARDAR LA UBICACION :(");
                            }
                        }
                    </script>

                    <!-- Bootstrap JavaScript -->
                    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.js"></script>
            
                    <!-- FontAwesome JavaScript -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                </body>
            </html>
PAGE;
        
        echo($page);
    }
    
    function check_request() {
        if (isset($_GET["id_dog"])) {
            echo "owner";
        }

        if (isset($_GET["delete_account"])) {
            $type = $_SESSION["type"];

            if ($type == "owner") {
            } else {
            }
        }
    }

    // Owner
    function get_content_owner() {
        global $curr_dog, $dogs;
        
        require_once("data/breeds.php");

        $dog = $dogs[$curr_dog];

        $id_dog = $dog["id"];
        $id_user = $dog["id_user"];
        $name = $dog["name"];
        $photo = $dog["photo"];
        $description = $dog["description"];
        $location = $dog["location"];
        $latitude = $dog["latitude"];
        $longitude = $dog["longitude"];
        
        $dropdown = "";
        foreach ($dogs as $dog) {
            $dropdown = $dropdown . "<a class='dropdown-item' href='?id=" . $dog["id"] ."'>" . $dog["name"] . "</a>";
        }

        $sex = $dog["sex"];
        if ($sex == "f") {
            $sex = <<<SEX
                <option value="" disabled>Selecciona un sexo...</option>
                <option value="f" selected>Hembra</option>"
                <option value="m">Macho</option>"
SEX;
            $sex_female = "selected";
        } else if ($sex == "m") {
            $sex = <<<SEX
                <option value="" disabled>Selecciona un sexo...</option>
                <option value="f">Hembra</option>"
                <option value="m" selected>Macho</option>"
SEX;
        } else {
            $sex = <<<SEX
                <option value="" selected disabled>Selecciona un sexo...</option>
                <option value="f">Hembra</option>"
                <option value="m">Macho</option>"
SEX;
        }

        $breed = $dog["breed"];
        if ($breed == "") {
            $breeds_options = "<option value='' selected disabled>Selecciona una raza...</option>";
        } else {
            $breeds_options = "<option value='' disabled>Selecciona una raza...</option>";
        }
        foreach ($breeds as $b) {
            $selected = ($breed == $b) ? "selected" : "";

            $breeds_options = $breeds_options . "<option id='days' value='$b $selected>$b</option>";
        }
        
        $size = $dog["size"];
        if ($size == "S") {
            $size = <<<SIZE
                <option value="" disabled>Selecciona un tamaño...</option>
                <option value="S" selected>Pequeño</option>
                <option value="M">Mediano</option>
                <option value="XL">Grande</option>
SIZE;
        } else if ($size == "M") {
            $size = <<<SIZE
                <option value="" disabled>Selecciona un tamaño...</option>
                <option value="S">Pequeño</option>
                <option value="M" selected>Mediano</option>
                <option value="XL">Grande</option>
SIZE;
        } else if ($size == "XL") {
            $size = <<<SIZE
                <option value="" disabled>Selecciona un tamaño...</option>
                <option value="S">Pequeño</option>
                <option value="M">Mediano</option>
                <option value="XL" selected>Grande</option>
SIZE;
        } else {
            $size = <<<SIZE
                <option value="" selected disabled>Selecciona un tamaño...</option>
                <option value="S">Pequeño</option>
                <option value="M">Mediano</option>
                <option value="XL">Grande</option>
SIZE;
        }

        if ($latitude && $longitude) {
            $map = "<iframe src='https://embed.waze.com/es/iframe?lat={$latitude}&lon={$longitude}&pin=1&zoom=17' height='300' style='width: 100%;'></iframe>";
        } else {
            $map = "<iframe src='https://embed.waze.com/es/iframe?pin=1&zoom=17' height='400' style='width: 100%;'></iframe>";
        }

        $content = <<<CONTENT
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Perfil</h1>

                <div class="dropdown mb-4">
                    <button id="dropdownMenuButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{$name}</button>

                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                        {$dropdown}
                    </div>
                </div>
            </div>

            <!-- Content -->
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-lg-12 col-md-9">
                        <div class="card border-0 shadow-lg">
                            <div class="card shadow">
                                <!-- Tab List -->
                                <div class="card-header p-0">
                                    <ul id="myTab" class="card-header nav nav-tabs m-0 p-0 container-fluid" role="tablist">
                                        <!-- About Tab Button -->
                                        <li class="nav-item" role="presentation">
                                            <button id="about-tab" class="nav-link active" data-toggle="tab" data-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </button>
                                        </li>
                
                                        <!-- Characteristics Tab Button -->
                                        <li class="nav-item" role="presentation">
                                            <button id="characteristics-tab" class="nav-link" data-toggle="tab" data-target="#characteristics" type="button" role="tab" aria-controls="characteristics" aria-selected="false">
                                                <i class="fa-solid fa-dog"></i>
                                            </button>
                                        </li>
                
                                        <!-- Location Tab Button -->
                                        <li class="nav-item" role="presentation">
                                            <button id="location-tab" class="nav-link" data-toggle="tab" data-target="#location" type="button" role="tab" aria-controls="location" aria-selected="false">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </button>
                                        </li>
                
                                        <!-- Delete Dog Button -->
                                        <li class="nav-item">
                                            <button id="btn-delete-dog" class="btn btn-danger" type="button" onclick="delete_dog();">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tab Content -->
                                <form class="card-body">
                                    <div id="myTabContent" class="tab-content">
                                        <!-- About Tab -->
                                        <div id="about" class="tab-pane fade show active" role="tabpanel" aria-labelledby="about-tab">
                                            <div class="row mb-1">
                                                <!-- Picture -->
                                                <div class="col-2">
                                                    <img id="photo-preview" class="w-100" src="img/{$photo}" alt="Foto de Perfil" />
                                                </div>

                                                <div class="col">
                                                    <!-- Profile Picture -->
                                                    <fieldset class="mb-1">
                                                        <div class="custom-file">
                                                            <input id="photo" name="photo" class="custom-file-input" type="file" accept="image/*" onchange="update_profile_pic(event);" />
                                                            
                                                            <label id="photo-name" class="custom-file-label" for="customFileLang">Selecciona una foto...</label>
                                                        </div>
                                                    </fieldset>
                
                                                    <!-- Name -->
                                                    <fieldset class="input-group mb-1">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="name">Nombre</label>
                                                        </div>

                                                        <input id="name" class="form-control" name="name" type="text" placeholder="Escribe tu nombre..." value="{$name}" required />
                                                    </fieldset>
                
                                                    <!-- Description -->
                                                    <fieldset class="input-group mb-1">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text form-label" for="description">Descripción</label>
                                                        </div>

                                                        <textarea id="description" class="form-control" name="description" placeholder="Escribe una descripción..." value="{$description}" required></textarea>
                                                    </fieldset>
                                                </div>
                                            </div>
                                    
                                            <fieldset class="float-right">
                                                <button class="btn btn-primary" type="button" onclick="change_tab('characteristics');">Siguiente</button>
                                            </fieldset>
                                        </div>
                                        
                                        <!-- Characteristics Tab -->
                                        <div id="characteristics" class="tab-pane fade" role="tabpanel" aria-labelledby="characteristics-tab">
                                            <!-- Sex -->
                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text form-label" for="sex">
                                                        <i class="fa-solid fa-venus-mars"></i>
                                                    </label>
                                                </div>
                
                                                <select id="sex" class="selectpicker form-control border" data-live-search="false" data-live-search-style="startsWith">
                                                    {$sex}
                                                </select>
                                            </fieldset>
                
                                            <!-- Breed -->
                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text form-label" for="breed">
                                                        <i class="fa-solid fa-dog"></i>
                                                    </label>
                                                </div>

                                                <select id="breed" class="selectpicker form-control border" data-live-search="true" data-live-search-style="startsWith">
                                                    {$breeds_options} 
                                                </select>
                                            </fieldset>
                
                                            <!-- Size -->
                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text form-label" for="size">Tamaño</label>
                                                </div>
                
                                                <select id="size" class="selectpicker form-control border" data-live-search="false" data-live-search-style="startsWith">
                                                    {$size}
                                                </select>
                                            </fieldset>
                                            
                                            <fieldset class="float-right">
                                                <button class="btn btn-secondary" type="button" onclick="change_tab('about');">Anterior</button>
                                                <button class="btn btn-primary" type="button" onclick="change_tab('location');">Siguiente</button>
                                            </fieldset>
                                        </div>
                
                                        <!-- Location Tab -->
                                        <div id="location" class="tab-pane fade" role="tabpanel" aria-labelledby="location-tab">
                                            <!-- Map -->
                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="location">Ubicación</label>
                                                </div>
                                                <input id="location" class="form-control" name="location" type="text" placeholder="{$location}" disabled />
                                            </fieldset>

                                            {$map}
                                        
                                            <fieldset class="float-right">
                                                <button class="btn btn-secondary" type="button" onclick="change_tab('characteristics');">Anterior</button>
                                                <button id="submit" class="btn btn-primary" name="submit" type="button" value="Guardar" onclick="get_map_coordinates();">Guardar</button>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Account Button -->
                    <button id="btn-delete-account" class="btn btn-danger mt-2" type="button" onclick="delete_account();">ELIMINAR CUENTA</button>
                </div>
            </div>
CONTENT;

        return $content;
    }

    // Walker
    function get_content_walker() {
        global $walker;

        $id_user = $walker["id"];
        $name = $walker["name"];
        $photo = $walker["photo"];
        $description = $walker["description"];
        $price = $walker["price"];
        $location = $walker["location"];
        $latitude = $walker["latitude"];
        $longitude = $walker["longitude"];
        
        $days = $walker["days"];
        $days_info = array(
            array("value" => "monday", "display" => "Lunes"),
            array("value" => "tuesday", "display" => "Martes"),
            array("value" => "wednesday", "display" => "Miércoles"),
            array("value" => "thursday", "display" => "Jueves"),
            array("value" => "friday", "display" => "Viernes"),
            array("value" => "saturday", "display" => "Sabado"),
            array("value" => "sunday", "display" => "Domingo")
        );
        $days_display = "";
        foreach ($days_info as $day) {
            $value = $day["value"];
            $display = $day["display"];

            $selected = in_array($value, $days) ? "selected" : "";

            $days_display = $days_display . "<option id='days' value='$value' $selected>$display</option>";
        }

        $hours = $walker["hours"];
        $hours_display = "";
        for ($h = 1; $h <= 24; $h++) {
            if ($h < 10) {
                $display = "0$h:00";
            } else {
                $display = "$h:00";
            }

            $selected = in_array($display, $hours) ? "selected" : "";

            $hours_display = $hours_display . "<option id='hours' value='$h' $selected>$display</option>";
        }

        if ($latitude && $longitude) {
            $map = "<iframe src='https://embed.waze.com/es/iframe?lat=$latitude&lon=$longitude&pin=1&zoom=17' height='300' style='width: 100%;'></iframe>";
        } else {
            $map = "<iframe src='https://embed.waze.com/es/iframe?pin=1&zoom=17' height='400' style='width: 100%;'></iframe>";
        }

        $content = <<<CONTENT
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Perfil</h1>
            </div>

            <!-- Content -->
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-9">
                    <div class="card border-0 shadow-lg">
                        <div class="card shadow">
                            <!-- Tab List -->
                            <div class="card-header p-0">
                                <ul id="myTab" class="card-header nav nav-tabs m-0 p-0" role="tablist">
                                    <!-- About Tab Button -->
                                    <li class="nav-item" role="presentation">
                                        <button id="about-tab" class="nav-link active" data-toggle="tab" data-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                    </li>

                                    <!-- Availability Tab Button -->
                                    <li class="nav-item" role="presentation">
                                        <button id="availability-tab" class="nav-link" data-toggle="tab" data-target="#availability" type="button" role="tab" aria-controls="availability" aria-selected="false">
                                            <i class="fa-solid fa-business-time"></i>
                                        </button>
                                    </li>

                                    <!-- Location Tab Button -->
                                    <li class="nav-item" role="presentation">
                                        <button id="location-tab" class="nav-link" data-toggle="tab" data-target="#location" type="button" role="tab" aria-controls="location" aria-selected="false">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Tab Content -->
                            <form class="card-body" method="POST" enctype="multipart/form-data">
                                <div id="myTabContent" class="tab-content">
                                    <!-- About Tab -->
                                    <div id="about" class="tab-pane fade show active" role="tabpanel" aria-labelledby="about-tab">
                                        <div class="row mb-1">
                                            <!-- Picture -->
                                            <div class="col-2">
                                                <img id="photo-preview" class="w-100" src="img/{$photo}" alt="Foto de Perfil" />
                                            </div>

                                            <div class="col">
                                                <!-- Profile Picture -->
                                                <fieldset class="mb-1">
                                                    <div class="custom-file">
                                                        <input id="photo" name="photo" class="custom-file-input" type="file" accept="image/*" onchange="update_profile_pic(event);" />
                                                        
                                                        <label id="photo-name" class="custom-file-label" for="customFileLang">Selecciona una foto...</label>
                                                    </div>
                                                </fieldset>

                                                <!-- Name -->
                                                <fieldset class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="name">Nombre</label>
                                                    </div>

                                                    <input id="name" class="form-control" name="name" type="text" placeholder="Escribe tu nombre..." value="{$name}" required />
                                                </fieldset>

                                                <!-- Description -->
                                                <fieldset class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text form-label" for="description">Descripción</label>
                                                    </div>

                                                    <textarea id="description" class="form-control" name="description" placeholder="Escribe una descripción..." value="{$description}" required></textarea>
                                                </fieldset>
                                            </div>
                                        </div>
                                        
                                        <fieldset class="float-right">
                                            <button class="btn btn-primary" type="button" onclick="change_tab('availability');">Siguiente</button>
                                        </fieldset>
                                    </div>

                                    <!-- Availability Tab -->
                                    <div id="availability" class="tab-pane fade" role="tabpanel" aria-labelledby="availability-tab">
                                        <!-- Price -->
                                        <fieldset class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text form-label" for="price">
                                                    <i class="fa-solid fa-sack-dollar"></i>
                                                </label>
                                            </div>

                                            <input id="price" class="form-control" name="price" type="number" min="1" placeholder="250" value="{$price}" required />
                                        </fieldset>

                                        <!-- Days -->
                                        <fieldset class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text form-label" for="days">
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                </label>
                                            </div>

                                            <select id="days" class="selectpicker form-control border" data-live-search="true" data-live-search-style="startsWith" multiple required>
                                                {$days_display}
                                            </select>
                                        </fieldset>

                                        <!-- Hours -->
                                        <fieldset class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text form-label" for="hours">
                                                    <i class="fa-solid fa-clock"></i>
                                                </label>
                                            </div>

                                            <select id="hours" class="selectpicker form-control border" data-live-search="true" data-live-search-style="startsWith" multiple required>
                                                {$hours_display}
                                            </select>
                                        </fieldset>
                                        
                                        <fieldset class="float-right">
                                            <button class="btn btn-secondary" type="button" onclick="change_tab('about');">Anterior</button>
                                            <button class="btn btn-primary" type="button" onclick="change_tab('location');">Siguiente</button>
                                        </fieldset>
                                    </div>
                                    
                                    <!-- Location Tab -->
                                    <div id="location" class="tab-pane fade" role="tabpanel" aria-labelledby="location-tab">
                                        
                                        <!-- Map -->
                                        <fieldset class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="location">Ubicación</label>
                                            </div>
                                            <input id="location" class="form-control" name="location" type="text" value="{$location}" disabled required />
                                        </fieldset>

                                        {$map}
                                        
                                        <fieldset class="float-right">
                                            <button class="btn btn-secondary" type="button" onclick="change_tab('availability');">Anterior</button>
                                            <button id="submit" class="btn btn-primary" name="submit" type="button" value="Guardar" onclick="get_map_coordinates();">Guardar</button>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Account Button -->
                    <button id="btn-delete-account" class="btn btn-danger mt-2" type="button" onclick="delete_account();">ELIMINAR CUENTA</button>
                </div>
            </div>
CONTENT;

        return $content;
    }
/*
        <!-- Page Scripts -->
        <script type="text/javascript">
            function delete_dog() {
                show_modal("danger", "<i class='fa-solid fa-triangle-exclamation'></i> Borrar Perro", "<h5>¿Estas seguro que quieres borrar a <?php echo $name; ?>?</h5>", "<a class='btn btn-danger mt-2' href='?delete_dog=true&id_dog=<?php echo $id; ?>'>ELIMINAR</a><button class='btn btn-secondary mt-2' type='button' data-dismiss='modal' aria-label='Close'>CANCELAR</button>");
            }

            function delete_account() {
                show_modal("danger", "<i class='fa-solid fa-triangle-exclamation'></i> Borrar Cuenta", "<h5>¿Estas seguro que quieres borrar tu cuenta?</h5>", "<a class='btn btn-danger mt-2' href='?delete_account=true'>ELIMINAR</a><button class='btn btn-secondary mt-2' type='button' data-dismiss='modal' aria-label='Close'>CANCELAR</button>");
            }
        </script>
*/
?>
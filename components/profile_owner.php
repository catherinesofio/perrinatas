<?php

    /*
    function get_profile() {
        global $conn,$dog_id,$name,$photo,$description,$sex,$breed,$size,$location;

        $id = $_SESSION["id"];

        $sql = "SELECT dog.id,profile_dog.name,profile_dog.photo,profile_dog.description,profile_dog.sex,profile_dog.breed,profile_dog.size,profile_dog.location FROM profile_dog INNER JOIN dog ON dog.id=profile_dog.dog_id WHERE dog.id=$id;";
        $mysql_result = $conn->query($sql);

        $row = $mysql_result->fetch_row();
        
        if ($row) {
            $dog_id = $row[0];
            $name = $row[1];
            $photo = $row[2];
            $description = $row[3];
            $sex = $row[4];
            $breed = $row[5];
            $size = $row[6];
            $location = json_decode($row[7], true);
        } else {
            $name = "";
            $photo = "default-dog.jpg";
            $description = "";
            $sex = "";
            $breed = "";
            $size = "";
            $location = array("name" => "", "latitude" => "", "longitude" => "");
        }
    }

    get_profile();
    
    // Get current location
    if (isset($_GET["latitude"])) {
        global $location;

        $latitude = $_REQUEST["latitude"];
        $longitude = $_REQUEST["longitude"];

        $location["latitude"] = $latitude;
        $location["longitude"] = $longitude;
    }

    // Switch dog
    if (isset($_GET["id"])) {
        $dog_id = $_REQUEST["id"];

        if ($dog_id == -1) {
            $name = "";
            $photo = "default-dog.jpg";
            $description = "";
            $sex = "";
            $breed = "";
            $size = "";
            $location = array();
        } else {
            $name = "La Divaza";
            $photo = "dog_img_01_01.jpg";
            $description = "Sin mentiras ni mañas la divaza no te engaña";
            $sex = "f";
            $breed = "Akita";
            $size = "big";
            $location = array("latitude" => 50, "longitude" => 10);
        }
    }

    // Save dog profile
    if (isset($_POST["name"])) {

    }
    */

    // PLACEHOLDER
    $dog_id = 1;
    $name = "Akira";
    $photo = "dog_img_01_01.jpg";
    $description = "Woof woof!";
    $sex = "f";
    $breed = "Akita";
    $size = "S";
    $location = array("name" => "UCA, Rosario", "latitude" => 30, "longitude" => 50);
?>

<!DOCTYPE html>
<html lang="es">
    <body>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Perfil</h1>
                    
            <div class="dropdown mb-4">
                <button id="dropdownMenuButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nuevo Perro</button>
                                
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="?id=-1">Nuevo Perro</a>
                    <a class="dropdown-item" href="?id=<?php echo $dog_id; ?>"><?php echo $name; ?></a>
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
                            <ul id="myTab" class="card-header nav nav-tabs m-0 p-0" role="tablist">
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
                                            <img id="photo-preview" class="w-100" src="img/<?php echo $photo; ?>" alt="Foto de Perfil" />
                                        </div>

                                        <div class="col">
                                            <!-- Profile Picture -->
                                            <fieldset class="mb-1">
                                                <div class="custom-file">
                                                    <input id="photo" name="photo" class="custom-file-input" type="file" />
                                                    
                                                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                                </div>
                                            </fieldset>

                                            <!-- Name -->
                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="name">Nombre</label>
                                                </div>

                                                <input id="name" class="form-control" name="name" type="text" placeholder="<?php echo $name; ?>" />
                                            </fieldset>

                                            <!-- Description -->
                                            <fieldset class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text form-label" for="description">Descripción</label>
                                                </div>

                                                <textarea id="description" class="form-control" name="description"><?php echo $description; ?></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                            
                                    <fieldset class="float-right">
                                        <button class="btn btn-primary" type="button" onclick="change_tab('characteristics')">Siguiente</button>
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
                                            <option value="" <?php echo ($sex == "") ? "selected" : ""; "disabled" ?>>Selecciona un sexo...</option>
                                            <option value="f" <?php echo ($sex == "f") ? "selected" : ""; ?>>Hembra</option>"
                                            <option value="f" <?php echo ($sex == "m") ? "selected" : ""; ?>>Macho</option>"
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
                                            <option value="" <?php echo ($breed == "") ? "selected" : ""; "disabled" ?>>Selecciona una raza...</option>
                                            <?php
                                                require("data/breeds.php");

                                                foreach ($breeds as $b) {
                                                    $selected = ($breed == $b) ? "selected" : "";

                                                    echo "<option id='days' value='$b' $selected>$b</option>";
                                                }
                                            ?>
                                        </select>
                                    </fieldset>

                                    <!-- Size -->
                                    <fieldset class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text form-label" for="size">Tamaño</label>
                                        </div>

                                        <select id="size" class="selectpicker form-control border" data-live-search="false" data-live-search-style="startsWith">
                                            <option value="" <?php echo ($size == "") ? "selected" : ""; "disabled" ?>>Selecciona un tamaño...</option>
                                            <option value="S" <?php echo ($size == "S") ? "selected" : ""; ?>>Pequeño</option>
                                            <option value="M" <?php echo ($size == "M") ? "selected" : ""; ?>>Mediano</option>
                                            <option value="XL" <?php echo ($size == "XL") ? "selected" : ""; ?>>Grande</option>
                                        </select>
                                    </fieldset>
                                    
                                    <fieldset class="float-right">
                                        <button class="btn btn-secondary" type="button" onclick="change_tab('about')">Anterior</button>
                                        <button class="btn btn-primary" type="button" onclick="change_tab('location')">Siguiente</button>
                                    </fieldset>
                                </div>

                                <!-- Location Tab -->
                                <div id="location" class="tab-pane fade" role="tabpanel" aria-labelledby="location-tab">
                                    <!-- Map -->
                                    <fieldset class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="location">Ubicación</label>
                                        </div>
                                        <input id="location" class="form-control" name="location" type="text" placeholder="<?php echo $location["name"]; ?>" disabled />
                                    </fieldset>
                                            
                                    <?php
                                        if (isset($location["latitude"])) {
                                            echo "<iframe src='https://embed.waze.com/es/iframe?lat=" . $location["latitude"] . "&lon=" . $location["longitude"] . "&pin=1&zoom=17' height='300' style='width: 100%;'></iframe>";
                                        } else {
                                            echo "<iframe src='https://embed.waze.com/es/iframe?pin=1&zoom=17' height='400' style='width: 100%;'></iframe>";
                                        }
                                    ?>
                                    
                                    <fieldset class="float-right">
                                        <button class="btn btn-secondary" type="button" onclick="change_tab('characteristics')">Anterior</button>
                                        <button id="submit" class="btn btn-primary" name="submit" type="button" value="Guardar" onclick="get_map_coordinates();">Guardar</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<!-- Update Photo Preview -->
<script type="text/javascript">
    function update_photo_preview(e) {
        preview = document.getElementById("photo-preview");
        photo = document.queryselector("input[type=file]");
        path = photo.files[0].path
        console.log(path);
        
        //photo.setAttribute("src", "");

        //history.replaceState(null, null, `?photo=${e.target.value}`);6
    }

    window.addEventListener("load", () => {
        photo = document.getElementById("photo");
        
        photo.onchange = update_photo_preview;
    });
</script>
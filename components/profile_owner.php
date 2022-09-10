<?php
    // INSERT INTO dog (user_id) VALUES (1);
    // INSERT INTO profile_dog (dog_id, name, photo, description, sex, breed, size, location) VALUES (1, "La Divaza", "['dog_img_01_01.jpg']", "Sin mentiras ni mañas la divaza no te engaña", "f", "Akita", "small", "{'latitude': 50, 'longitude': 10}");

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
?>

<!DOCTYPE html>
<html>
    <body>
        <ul class="nav nav-pills flex-column border rounded-left">
            <li class="nav-item">
                <a class="nav-link text-center active" href="?id=-1" aria-current="page">Nuevo Perro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="?id=<?php echo $dog_id; ?>" aria-current="page">La Divaza</a>
            </li>
        </ul>

        <form class="form col border rounded-right" action="" method="post">
            <div class="row">
                <legend class="col">Perfil</legend>
            </div>
            
            <div class="form-row">
                <div class="col-5">
                    <!-- Profile Picture -->
                    <fieldset class="mb-1">
                        <img id="photo-preview" class="profile-photo" src="imgs/<?php echo $photo; ?>" alt="Foto de Perfil" />
                        
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
                
                <div class="col">
                    <!-- Sex -->
                    <fieldset class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text form-label" for="sex">
                                <i class="fa-solid fa-venus-mars"></i>
                            </label>
                        </div>

                        <select id="sex" class="selectpicker form-control border" data-live-search="true" data-live-search-style="startsWith">
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
                                include("data/breeds.php");

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

                        <select id="size" class="selectpicker form-control border" data-live-search="true" data-live-search-style="startsWith">
                            <option value="" <?php echo ($size == "") ? "selected" : ""; "disabled" ?>>Selecciona un tamaño...</option>
                            <option value="S" <?php echo ($size == "S") ? "selected" : ""; ?>>Pequeño</option>
                            <option value="M" <?php echo ($size == "M") ? "selected" : ""; ?>>Mediano</option>
                            <option value="XL" <?php echo ($size == "XL") ? "selected" : ""; ?>>Grande</option>
                        </select>
                    </fieldset>

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
                </div>
            </div>

            <button id="submit" class="btn btn-primary" name="submit" type="button" value="GUARDAR CAMBIOS" onclick="get_map_coordinates();">GUARDAR CAMBIOS</button>
        </form>

        <script type="text/javascript" src="scripts/get_coordinates.js"></script>
    </body>
</html>
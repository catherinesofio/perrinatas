<?php
    // INSERT INTO profile_walker (user_id, name, photo, description, location, schedule, price) VALUES (1, "Cinnamon Roll", "default-person", "La Gabbie Hannah necesita ayuda, pobre.", "{'latitude': 50, 'longitude': 10}", "{ 'days': ['monday'], 'hours': ['5 AM', '12 PM'] }", 200);

    // Get profile data
    function get_profile() {
        global $conn,$name,$photo,$description,$days,$hours,$price,$location;

        $id = $_SESSION["id"];

        $sql = "SELECT name,photo,description,schedule,price,location FROM profile_walker WHERE profile_walker.user_id = $id;";
        $mysql_result = $conn->query($sql);

        $row = $mysql_result->fetch_row();
        
        if ($row) {
            $name = $row[0];
            $photo = $row[1];
            $description = $row[2];
            $schedule = json_decode($row[3], true);
            $days = $schedule["days"];
            $hours = $schedule["hours"];
            $price = $row[4];
            $location = json_decode($row[5], true);
        } else {
            $name = $_SESSION["username"];
            $photo = "default-person.jpg";
            $description = "";
            $days = array();
            $hours= array();
            $price = 1;
            $location = array();
        }
    }
    
    // Update photo preview
    if (isset($_GET["photo"])) {
        global $photo;

        $photo = $_REQUEST["photo"];
        echo $photo;
    }
    
    // Update location preview
    if (isset($_GET["latitude"])) {
        global $location;

        $latitude = $_REQUEST["latitude"];
        $longitude = $_REQUEST["longitude"];

        $location["latitude"] = $latitude;
        $location["longitude"] = $longitude;
    }

    get_profile();
?>

<!DOCTYPE html>
<html>
    <body>
        <form class="form" action="" method="post">
            <div class="form-row">
                <legend>Perfil</legend>
            </div>
            
            <div class="form-row">
                <div class="col-5">
                    <!-- Profile Picture -->
                    <fieldset class="mb-1">
                        <img id="photo-preview" class="profile-photo" src="imgs/<?php echo $photo; ?>" alt="Foto de Perfil" />
                    
                        <div class="custom-file">
                            <input id="photo" class="custom-file-input" name="photo" type="file" lang="es" value="<?php echo $photo; ?>" />
                            
                            <label class="custom-file-label" for="photo"><?php echo $photo; ?></label>
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
                    <!-- Price -->
                    <fieldset class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text form-label" for="price">
                                <i class="fa-solid fa-sack-dollar"></i>
                            </label>
                        </div>

                        <input id="price" class="form-control" name="price" type="number" min="1" placeholder="<?php echo $price; ?>" />
                    </fieldset>

                    <!-- Days -->
                    <fieldset class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text form-label" for="days">
                                <i class="fa-solid fa-calendar-days"></i>
                            </label>
                        </div>

                        <select id="days" class="selectpicker form-control border" data-live-search="true" data-live-search-style="startsWith" multiple>
                            <?php
                                $days_info = array(
                                    array("value" => "monday", "display" => "Lunes"),
                                    array("value" => "tuesday", "display" => "Martes"),
                                    array("value" => "wednesday", "display" => "Miércoles"),
                                    array("value" => "thursday", "display" => "Jueves"),
                                    array("value" => "friday", "display" => "Viernes"),
                                    array("value" => "saturday", "display" => "Sabado"),
                                    array("value" => "sunday", "display" => "Domingo")
                                );

                                foreach ($days_info as $day) {
                                    $value = $day["value"];
                                    $display = $day["display"];

                                    $selected = in_array($value, $days) ? "selected" : "";

                                    echo "<option id='days' value='$value' $selected>$display</option>";
                                }
                            ?>
                        </select>
                    </fieldset>

                    <!-- Hours -->
                    <fieldset class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text form-label" for="hours">
                                <i class="fa-solid fa-clock"></i>
                            </label>
                        </div>

                        <select id="hours" class="selectpicker form-control border" data-live-search="true" data-live-search-style="startsWith" multiple>
                            <?php
                                for ($h = 1; $h <= 24; $h++) {
                                    if ($h < 10) {
                                        $display = "0$h:00";
                                    } else {
                                        $display = "$h:00";
                                    }

                                    $selected = in_array($display, $hours) ? "selected" : "";

                                    echo "<option id='hours' value='$h' $selected>$display</option>";
                                }
                            ?>
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
                            echo "<iframe src='https://embed.waze.com/es/iframe?lat=" . $location["latitude"] . "&lon=" . $location["longitude"] . "&pin=1&zoom=17' height='400' style='width: 100%;'></iframe>";
                        } else {
                            echo "<iframe src='https://embed.waze.com/es/iframe?pin=1&zoom=17' height='400' style='width: 100%;'></iframe>";
                        }
                    ?>
                </div>
            </div>

            <button id="submit" class="btn btn-primary" name="submit" type="button" value="GUARDAR CAMBIOS" onclick="get_map_coordinates();">GUARDAR CAMBIOS</button>
        </form>

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
    </body>
</html>
<?php
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
            $schedule = $row[3];
            $price = $row[4];
            $location = $row[5];
        } else {
            $name = $_SESSION["username"];
            $photo = "imgs/default-person.jpg";
            $description = "";
            $days = array("monday", "friday");
            $hours= array(7,5);
            $price = 200;
            $location = array();
        }
    }
    
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
                        <img src="<?php echo $photo; ?>" alt="Foto de Perfil" />
                        
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

                                    $selected = in_array($h, $hours) ? "selected" : "";

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

                        <input id="location" class="form-control" name="location" type="text" placeholder="Mi ubicacion guardada" disabled />
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
    </body>
</html>
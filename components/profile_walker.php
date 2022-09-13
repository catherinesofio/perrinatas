<?php

    /*
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
    */

    // PLACEHOLDER
    $user_id = 2;
    $name = "Cesar Milan";
    $photo = "default-person.jpg";
    $description = "Me llamo Cesar, y no soy de Milan, pero si soy un reenombrado paseador de Perros.";
    $days = array("wednesday");
    $hours= array("06:00", "07:00");
    $price = 150;
    $location = array("name" => "No de Milan", "latitude" => -60, "longitude" => 10);
?>

<!DOCTYPE html>
<html lang="es">
    <body>
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
                                        <button class="btn btn-primary" type="button" onclick="change_tab('availability')">Siguiente</button>
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
                                        <button class="btn btn-secondary" type="button" onclick="change_tab('availability')">Anterior</button>
                                        <button id="submit" class="btn btn-primary" name="submit" type="button" value="Guardar" onclick="get_map_coordinates();">Guardar</button>
                                    </fieldset>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
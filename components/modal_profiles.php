<?php
    // global $conn,$user_id,$dog_id,$name,$photo,$description,$days,$hours,$price,$sex,$breed,$size,$location;

    
    // PLACEHOLDER
    if ($_SESSION["type"] == "owner") {
        $name = "Cesar Milan";
        $photo = "default-person.jpg";
        $description = "Me llamo Cesar, y no soy de Milan, pero si soy un reenombrado paseador de Perros.";
        $days = array("wednesday");
        $hours= array("06:00", "07:00");
        $price = 150;
        $location = array("name" => "No de Milan", "latitude" => -60, "longitude" => 10);

        $sex = "";
        $breed = "";
        $size = "";
    } else {
        $name = "Akira";
        $photo = "dog_img_01_01.jpg";
        $description = "Woof woof!";
        $sex = "f";
        $breed = "Akita";
        $size = "big";
        $location = array("name" => "UCA, Rosario", "latitude" => 30, "longitude" => 50);

        $days = array();
        $hours= array();
        $price = 0;
    }
                        
?>

<!DOCTYPE html>
<html lang="es">
    <body>
        <script text="text/javascript">
            function show_user_profile(is_connection = false) {
                title = "<?php echo $name; ?>";
                body = `<div class="row mb-1">
                        <!-- Profile Picture -->
                        <div class="col-5">
                            <img id="photo-preview" class="w-100" src="img/<?php echo $photo; ?>" alt="Foto de Perfil" />
                        </div>

                        <!-- Description -->
                        <h5 class="col align-justify"><?php echo $description; ?></h5>
                    </div>

                    <hr />
                    
                    <div class="row text-center">
                        <!-- Days -->
                        <h5 class="col">
                            <i class="fa-solid fa-calendar-days"></i> <?php
                                foreach ($days as $key => $value) {
                                    if ($value == "monday") {
                                        $days[$key] = "Lunes";
                                    } else if ($value == "tuesday") {
                                        $days[$key] = "Martes";
                                    } else if ($value == "wednesday") {
                                        $days[$key] = "Miércoles";
                                    } else if ($value == "thursday") {
                                        $days[$key] = "Jueves";
                                    } else if ($value == "friday") {
                                        $days[$key] = "Viernes";
                                    } else if ($value == "saturday") {
                                        $days[$key] = "Sabado";
                                    } else if ($value == "sunday") {
                                        $days[$key] = "Domingo";
                                    }
                                }

                                echo (implode(", ", $days));
                            ?>
                        </h5>

                        <!-- Hours -->
                        <h5 class="col">
                            <i class="fa-solid fa-clock"></i> <?php echo (implode(", ", $hours)); ?>
                        </h5>
                        
                        <!-- Price -->
                        <h5 class="col">
                            <i class="fa-solid fa-sack-dollar"></i> <?php echo $price; ?>
                        </h5>
                    </div>

                    <hr />
                    
                    <div class="row">
                        <!-- Map -->
                        <h5 class="col">
                            <i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?>
                        </h5>
                                
                        <?php
                            if (isset($location["latitude"])) {
                                echo "<iframe class='m-2 w-100' src='https://embed.waze.com/es/iframe?lat=" . $location["latitude"] . "&lon=" . $location["longitude"] . "&pin=1&zoom=17' height='300'></iframe>";
                            } else {
                                echo "<iframe class='m-2 w-100' src='https://embed.waze.com/es/iframe?pin=1&zoom=17' height='300'></iframe>";
                            }
                        ?>
                    </div>`;
                    
                if (is_connection) {
                    footer = "<button class='btn btn-danger' type='button'>Desconectar</button>";
                } else {
                    footer = "<button class='btn btn-success' type='button'>Conectar</button><button class='btn btn-danger' type='button'>Bloquear</button>";
                }
                
                show_modal("info", title, body, footer);

                return false;
            }

            function show_dog_profile(is_connection = false) {
                title = "<?php echo $name; ?>";
                body = `<div class="row mb-1">
                        <!-- Profile Picture -->
                        <div class="col-5">
                            <img id="photo-preview" class="w-100" src="img/<?php echo $photo; ?>" alt="Foto de Perfil" />
                        </div>

                        <!-- Description -->
                        <h5 class="col align-justify"><?php echo $description; ?></h5>
                    </div>

                    <hr />
                    
                    <div class="row text-center">
                        <!-- Sex -->
                        <h5 class="col">
                            <?php echo ($sex == "f") ? '<i class="fa-solid fa-venus text-success"></i>' : '<i class="fa-solid fa-mars text-danger"></i>'; ?>
                        </h5>

                        <!-- Breed -->
                        <h5 class="col">
                            <i class="fa-solid fa-dog"></i> <?php echo $breed; ?>
                        </h5>

                        <!-- Size -->
                        <h5 class="col">
                            <?php echo $size; ?>
                        </h5>
                    </div>

                    <hr />
                    
                    <div class="row">
                        <!-- Map -->
                        <h5 class="col">
                            <i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?>
                        </h5>
                                
                        <?php
                            if (isset($location["latitude"])) {
                                echo "<iframe class='m-2 w-100' src='https://embed.waze.com/es/iframe?lat=" . $location["latitude"] . "&lon=" . $location["longitude"] . "&pin=1&zoom=17' height='300'></iframe>";
                            } else {
                                echo "<iframe class='m-2 w-100' src='https://embed.waze.com/es/iframe?pin=1&zoom=17' height='300'></iframe>";
                            }
                        ?>
                    </div>`;
                    
                if (is_connection) {
                    footer = "<button class='btn btn-danger' type='button'>Desconectar</button>";
                } else {
                    footer = "<button class='btn btn-success' type='button'>Conectar</button><button class='btn btn-danger' type='button'>Bloquear</button>";
                }
                
                show_modal("info", title, body, footer);

                return false;
            }
        </script>
    </body>
<html>
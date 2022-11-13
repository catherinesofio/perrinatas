<?php
    function show_walker_profile($data, $is_connection = false) {
        if ($data) {
            $id = $data["id"];
            $name = $data["name"];
            $photo = $data["photo"];
            $description = $data["description"];
            $price = $data["price"];
            $location = $data["location"];
            $latitude = $data["latitude"];
            $longitude = $data["longitude"];

            $hours = $data["hours"];
            $hours = json_decode($hours, true);
            if (count($hours) > 0) {
                $hours = implode(", ", $hours);
            } else {
                $hours = "No hay info disponible";
            }
            
            $days = $data["days"];
            $days = json_decode($days, true);
            if (count($days) > 0) {
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
    
                $days = implode(", ", $days);
            } else {
                $days = "No hay info disponible";
            }

            if ($latitude && $longitude) {
                $map = <<<MAP
                    <iframe class="m-2 w-100" src="https://embed.waze.com/es/iframe?lat={$latitude}&lon={$longitude}&pin=1&zoom=17" height="300"></iframe>
MAP;
            } else {
                $map = <<<MAP
                    <iframe class="m-2 w-100" src="https://embed.waze.com/es/iframe?pin=1&zoom=17" height="300"></iframe>
MAP;
            }

            $title = $name;

            $body = <<<BODY
                <div class="row mb-1">
                    <!-- Profile Picture -->
                    <div class="col-5">
                        <img id="photo-preview" class="w-100" src="img/{$photo}" alt="Foto de Perfil" />
                    </div>

                    <!-- Description -->
                    <h5 class="col align-justify">{$description}</h5>
                </div>

                <hr />
        
                <div class="row text-center">
                    <!-- Days -->
                    <h5 class="col">
                        <i class="fa-solid fa-calendar-days"></i> {$days}
                    </h5>
    
                    <!-- Hours -->
                    <h5 class="col">
                        <i class="fa-solid fa-clock"></i> {$hours}
                    </h5>
                    
                    <!-- Price -->
                    <h5 class="col">
                        <i class="fa-solid fa-sack-dollar"></i> {$price}
                    </h5>
                </div>
    
                <hr />
        
                <div class="row">
                    <!-- Map -->
                    <h5 class="col">
                        <i class="fa-solid fa-location-dot"></i> {$location}
                    </h5>

                    {$map}
                </div>
BODY;

            if ($is_connection) {
                $id_match = $data["id_match"];
                
                $footer = <<<FOOTER
                    <button class="btn btn-danger" type="button" onclick="disconnect_user({$id_match});">Desconectar</button>
 FOOTER;
            } else {
                $footer = <<<FOOTER
                    <button class="btn btn-success" type="button" onclick="connect_user({$id});">Conectar</button>
 FOOTER;
            }

            show_modal("info", $title, $body, $footer, "['id_user', 'connect', 'disconnect', 'confirm_disconnect']");
        }
    }

    function show_dog_profile($data, $is_connection = false) {
        if ($data) {
            $id = $data["id"];
            $name = $data["name"];
            $photo = $data["photo"];
            $description = $data["description"];
            $breed = $data["breed"];
            $location = $data["location"];
            $latitude = $data["latitude"];
            $longitude = $data["longitude"];

            $sex = $data["sex"];
            if ($sex == "f") {
                $sex = "<i class='fa-solid fa-venus text-success'></i>";
            } else {
                $sex = "<i class='fa-solid fa-mars text-danger'></i>";
            }

            $size = $data["size"];
            if ($size == "S") {
                $size = "Chico";
            } else if ($size == "M") {
                $size = "Mediano";
            } else {
                $size = "Grande";
            }

            if ($latitude && $longitude) {
                $map = <<<MAP
                    <iframe class="m-2 w-100" src="https://embed.waze.com/es/iframe?lat={$latitude}&lon={$longitude}&pin=1&zoom=17" height="300"></iframe>
MAP;
            } else {
                $map = <<<MAP
                    <iframe class="m-2 w-100" src="https://embed.waze.com/es/iframe?pin=1&zoom=17" height="300"></iframe>
MAP;
            }

            $title = $name;
            $body = <<<BODY
                <div class="row mb-1">
                    <!-- Profile Picture -->
                    <div class="col-5">
                        <img id="photo-preview" class="w-100" src="img/{$photo}" alt="Foto de Perfil" />
                    </div>

                    <!-- Description -->
                    <h5 class="col align-justify">{$description}</h5>
                </div>

                <hr />
        
                <div class="row text-center">
                    <!-- Sex -->
                    <h5 class="col">{$sex}</h5>

                    <!-- Breed -->
                    <h5 class="col">
                        <i class="fa-solid fa-dog"></i> {$breed}
                    </h5>

                    <!-- Size -->
                    <h5 class="col">{$size}</h5>
                </div>
    
                <hr />
        
                <div class="row">
                    <!-- Map -->
                    <h5 class="col">
                        <i class="fa-solid fa-location-dot"></i> {$location}
                    </h5>

                    {$map}
                </div>
BODY;

            if ($is_connection) {
                $id_match = $data["id_match"];
                
                $footer = <<<FOOTER
                    <button class="btn btn-danger" type="button" onclick="disconnect_user({$id_match});">Desconectar</button>
FOOTER;
            } else {
                $footer = <<<FOOTER
                    <button class="btn btn-success" type="button" onclick="connect_user({$id});">Conectar</button>
FOOTER;
            }

            show_modal("info", $title, $body, $footer, "['id_user', 'connect', 'confirm-disconnect', 'disconnect', 'id_match']");
        }
    }
?>
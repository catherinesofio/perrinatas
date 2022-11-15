<?php
    function get_walker_card($data) {
        $id = $data["id"];
        $name = $data["name"];
        $photo = $data["photo"];
        $location = $data["location"];
        $price = $data["price"];

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

        $card = <<<CARD
            <div class="card shadow mb-4 h-100" style="width: 18rem;">
                <a href="#" id_user="{$id}" onclick="show_modal_profile(event);">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span>{$name}</span>
                            <span class="float-right">
                                <i class="fa-solid fa-sack-dollar"></i> {$price}
                            </span>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/{$photo}" alt="{$name}" />

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fa-solid fa-calendar-days"></i> {$days}
                        </li>
                        <li class="list-group-item">
                            <i class="fa-solid fa-clock"></i> {$hours}
                        </li>
                    </ul>
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> {$location}</small>
                    </div>
                </a>
            </div>
CARD;

        return $card;
    }
    
    function get_dog_card($data) {
        $id = $data["id"];
        $name = $data["name"];
        $photo = $data["photo"];
        $location = $data["location"];

        $sex = $data["sex"];
        if ($sex == "F") {
            $sex = "<i class='fa-solid fa-venus float-right'></i>";
        } else {
            $sex = "<i class='fa-solid fa-mars float-right'></i>";
        }

        $card = <<<CARD
            <div class="card shadow mb-4 h-100" style="width: 18rem;">
                <a href="#" id_user="{$id}" onclick="show_modal_profile(event);">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{$name}{$sex}</h6>
                    </div>

                    <img class="card-img-top" src="img/{$photo}" alt="{$name}" />
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> {$location}</small>
                    </div>
                </a>
            </div>
CARD;

        return $card;
    }
?>
<?php
    
    function get_walkers() {
        global $conn,$user_id,$name,$photo,$description,$days,$hours,$price,$location;

        $id = $_SESSION["id"];

        $sql = "SELECT user_id,name,photo,description,schedule,price,location FROM profile_walker;";
        $mysql_result = $conn->query($sql);

        $row = $mysql_result->fetch_row();
        
        if ($row) {
            $user_id = $row[0];
            $name = $row[1];
            $photo = $row[2];
            $description = $row[3];
            $schedule = json_decode($row[4], true);
            $days = $schedule["days"];
            $hours = $schedule["hours"];
            $price = $row[5];
            $location = json_decode($row[6], true);
        } else {
            echo "<div class='alert alert-warning' role='alert'>
                <p><i class='fa-solid fa-triangle-exclamation'></i> Lo sentimos, parece que no se pudieron encontrar paseadores en este momento. ¡Intenta más tarde!</p>
            </div>";
        }
    }

    get_walkers();

?>

<!DOCTYPE html>
<html>
    <body>
        <div class="card-columns">
            <a href="?id=<?php echo $user_id; ?>">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        <span>
                            <?php echo $name; ?>
                        </span>
                        <span class="float-right">
                            <i class="fa-solid fa-sack-dollar"></i> <?php echo $price; ?>
                        </span>
                    </div>

                    <img class="card-img-top" src="imgs/<?php echo $photo; ?>" alt="<?php echo $name; ?>">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
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
                        </li>
                        <li class="list-group-item">
                            <i class="fa-solid fa-clock"></i> <?php echo (implode(", ", $hours)); ?>
                        </li>
                    </ul>

                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </div>
            </a>
        </div>
    </body>
</html>
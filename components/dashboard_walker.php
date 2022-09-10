<?php

    function get_dogs() {
        global $conn,$dog_id,$name,$photo,$description,$sex,$breed,$size,$location;

        $id = $_SESSION["id"];

        $sql = "SELECT dog_id,name,photo,description,sex,breed,size,location FROM profile_dog;";
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
            echo "<div class='alert alert-warning' role='alert'>
                <p><i class='fa-solid fa-triangle-exclamation'></i> Lo sentimos, parece que no se pudieron encontrar perritos en este momento. ¡Intenta más tarde!</p>
            </div>";
        }
    }

    get_dogs();

?>

<!DOCTYPE html>
<html>
    <body>
        <div class="card-columns">
            <a href="?id=<?php echo $dog_id; ?>">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        <?php
                            echo $name;

                            if ($sex == "f") {
                                echo "<i class='fa-solid fa-venus float-right'></i>";
                            } else {
                                echo "<i class='fa-solid fa-mars float-right'></i>";
                            }
                        ?>
                    </div>

                    <img class="card-img-top" src="imgs/<?php echo $photo; ?>" alt="<?php echo $name; ?>">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="float-left"><?php echo $breed; ?></span>
                            <span class="float-right"><?php echo $size; ?></span>
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
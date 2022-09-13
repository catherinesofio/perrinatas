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
                <h5><i class='fa-solid fa-triangle-exclamation'></i> Lo sentimos, parece que no se pudieron encontrar perritos en este momento. ¡Intenta más tarde!</h5>
            </div>";
        }
    }

    get_dogs();

?>

<!DOCTYPE html>
<html lang="es">
    <body>
        <div class="card-columns row justify-content-center">
            <div class="card shadow mb-4" style="width: 18rem;">
                <a href="#dog_id=<?php echo $dog_id; ?>" onclick="show_dog_profile();">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                echo $name;

                                if ($sex == "f") {
                                    echo "<i class='fa-solid fa-venus float-right'></i>";
                                } else {
                                    echo "<i class='fa-solid fa-mars float-right'></i>";
                                }
                            ?>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </a>
            </div>

            <div class="card shadow mb-4" style="width: 18rem;">
                <a href="#dog_id=<?php echo $dog_id; ?>" onclick="show_dog_profile();">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                echo $name;

                                if ($sex == "f") {
                                    echo "<i class='fa-solid fa-venus float-right'></i>";
                                } else {
                                    echo "<i class='fa-solid fa-mars float-right'></i>";
                                }
                            ?>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </a>
            </div>

            <div class="card shadow mb-4" style="width: 18rem;">
                <a href="#dog_id=<?php echo $dog_id; ?>" onclick="show_dog_profile();">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                echo $name;

                                if ($sex == "f") {
                                    echo "<i class='fa-solid fa-venus float-right'></i>";
                                } else {
                                    echo "<i class='fa-solid fa-mars float-right'></i>";
                                }
                            ?>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </a>
            </div>

            <div class="card shadow mb-4" style="width: 18rem;">
                <a href="#dog_id=<?php echo $dog_id; ?>" onclick="show_dog_profile();">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                echo $name;

                                if ($sex == "f") {
                                    echo "<i class='fa-solid fa-venus float-right'></i>";
                                } else {
                                    echo "<i class='fa-solid fa-mars float-right'></i>";
                                }
                            ?>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </a>
            </div>

            <div class="card shadow mb-4" style="width: 18rem;">
                <a href="#dog_id=<?php echo $dog_id; ?>" onclick="show_dog_profile();">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                echo $name;

                                if ($sex == "f") {
                                    echo "<i class='fa-solid fa-venus float-right'></i>";
                                } else {
                                    echo "<i class='fa-solid fa-mars float-right'></i>";
                                }
                            ?>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </a>
            </div>

            <div class="card shadow mb-4" style="width: 18rem;">
                <a href="#dog_id=<?php echo $dog_id; ?>" onclick="show_dog_profile();">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                echo $name;

                                if ($sex == "f") {
                                    echo "<i class='fa-solid fa-venus float-right'></i>";
                                } else {
                                    echo "<i class='fa-solid fa-mars float-right'></i>";
                                }
                            ?>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </a>
            </div>

            <div class="card shadow mb-4" style="width: 18rem;">
                <a href="#dog_id=<?php echo $dog_id; ?>" onclick="show_dog_profile();">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                echo $name;

                                if ($sex == "f") {
                                    echo "<i class='fa-solid fa-venus float-right'></i>";
                                } else {
                                    echo "<i class='fa-solid fa-mars float-right'></i>";
                                }
                            ?>
                        </h6>
                    </div>

                    <img class="card-img-top" src="img/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    
                    <div class="card-footer">
                        <small class="text-muted"><i class="fa-solid fa-location-dot"></i> <?php echo $location["name"]; ?></small>
                    </div>
                </a>
            </div>
        </div>
    </body>
</html>
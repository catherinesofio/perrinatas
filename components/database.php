<?php
    require_once("components/alert.php");
    date_default_timezone_set("America/Argentina/Buenos_Aires");

    function start_db_connection() {
        $server_name = "localhost";
        $username = "root";
        $password = "";
        $database_name = "perrinatas";
    
        $conn = new mysqli($server_name, $username, $password, $database_name);
    
        if ($conn->connect_error) {
            $alert = get_alert("danger", "<i class='fa-solid fa-triangle-exclamation'></i> ¡Oops! No se pudo conectar a la base de datos de <span class='text-danger'>Perrinatas</span>.");
    
            die($alert);
        }

        return $conn;
    }

    function stop_db_connection($conn) {
        $conn->close();
    }


    // User
    function user_exists($username) {
        $conn = start_db_connection();

        $sql = "SELECT `id`
                FROM `user`
                WHERE `username` = '$username';";
        $mysql_result = $conn->query($sql);
        $count = $mysql_result->num_rows;

        stop_db_connection($conn);

        return ($count > 0);
    }

    function get_user($username, $password) {
        $conn = start_db_connection();

        $sql = "SELECT `id`, `type`, `password`
                FROM `user`
                WHERE `username` = '$username';";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function add_user($username, $password, $type) {
        $conn = start_db_connection();

        $sql = "INSERT INTO `user` (`username`, `password`, `type`)
                VALUES ('$username', '$password', '$type');";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }


    // Dog
    function has_dog_profiles($id_user) {
        $conn = start_db_connection();
        
        $sql = "SELECT `id_user`
                FROM `dog`
                WHERE `id_user` = $id_user;";
        $mysql_result = $conn->query($sql);
        $count = $mysql_result->num_rows;

        stop_db_connection($conn);

        return ($count > 0);
    }

    function get_dogs($id_user) {
        $conn = start_db_connection();

        $sql = "SELECT `id`, `name`, `photo`
                FROM `dog`
                WHERE `id_user` = $id_user;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function get_unmatched_dogs($id_walker) {
        $conn = start_db_connection();

        $sql = "SELECT dog.id, dog.id_user, dog.name, dog.photo, dog.description, location.name as location, location.latitude, location.longitude, dog.sex, dog.breed, dog.size
                FROM `dog`
                INNER JOIN `location`
                    ON location.id = dog.id_location
                WHERE dog.id NOT IN (
                    SELECT id_dog
                    FROM `match`
                    WHERE id_walker = $id_walker
                );";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function get_dog_matches($id_dog) {
        $conn = start_db_connection();

        $sql = "SELECT walker.id, walker.id_user, walker.name, walker.photo, walker.description, location.name as location, location.latitude, location.longitude, schedule.days, schedule.hours, walker.price, match.id as id_match, match.datetime as datetime_match, message.content as message, message.datetime as datetime
                FROM `walker`
                INNER JOIN `location`
                    ON location.id = walker.id_location
                INNER JOIN `schedule`
                    ON schedule.id = walker.id_schedule
                INNER JOIN `match`
                    ON match.id_dog = $id_dog AND match.id_walker = walker.id
                LEFT JOIN (
                    SELECT id_match, content, max(datetime) as datetime
                    FROM message
                    GROUP BY id_match, datetime
                ) message ON message.id_match = match.id
                GROUP BY walker.id;";
        $mysql_result = $conn->query($sql);
        
        stop_db_connection($conn);

        return $mysql_result;
    }

    function get_dogs_profile($id_user) {
        $conn = start_db_connection();
        
        $sql = "SELECT dog.id, dog.id_user, dog.name, dog.photo, dog.description, location.id as id_location, location.name as location, location.latitude, location.longitude, dog.sex, dog.breed, dog.size
                FROM `dog`
                INNER JOIN `location`
                    ON location.id = dog.id_location
                WHERE `id_user` = $id_user;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function add_dog($id_user, $name, $photo, $description, $sex, $breed, $size, $location, $latitude, $longitude) {
        $conn = start_db_connection();
        
        $sql = "INSERT INTO `location` (`name`, `latitude`, `longitude`)
                VALUES ('$location', $latitude, $longitude);";
        $mysql_result = $conn->query($sql);

        $id_location = mysql_insert_id();
        
        $sql = "INSERT INTO `dog` (`id_user`, `name`, `photo`, `description`, `id_location`, `sex`, `breed`, `size`)
                VALUES ($id_user, '$name', '$photo', '$description', $id_location, '$sex', '$breed', '$size');";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }

    function delete_dog($id_dog) {
        $conn = start_db_connection();
        
        $sql = "SELECT `id`, `id_location`
                FROM `match`
                WHERE id_dog = $id_dog;";
        $mysql_result = $conn->query($sql);
        
        while ($row = $mysql_result->fetch_row()) {
            $id_match = $row[0];
            $id_location = $row[1];

            $sql = "DELETE FROM `message`
                    WHERE `id_match` = $id_match;";
            $mysql_result = $conn->query($sql);

            $sql = "DELETE FROM `location`
                    WHERE `id` = $id_location;";
            $mysql_result = $conn->query($sql);
        }

        $sql = "DELETE FROM `match`
                WHERE `id_dog` = $id_dog;";
        $mysql_result = $conn->query($sql);

        $sql = "DELETE FROM `request`
                WHERE `id_dog` = $id_dog;";
        $mysql_result = $conn->query($sql);

        $sql = "DELETE FROM `dog`
                WHERE `id` = $id_dog;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }

    function update_dog_profile($id_dog, $name, $photo, $description, $sex, $breed, $size, $id_location, $location, $latitude, $longitude) {
        $conn = start_db_connection();
        
        $sql = "UPDATE `location`
                SET `name` = '$location', `latitude` = $latitude, `longitude` = $longitude
                WHERE id = $id_location;";
        $mysql_result = $conn->query($sql);

        $sql = "UPDATE `dog`
                SET `name` = '$name', `photo` = '$photo', `description` = '$description', `sex` = '$sex', `breed` = '$breed', `size` = '$size'
                WHERE id = $id_dog;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }

    function delete_owner_account($id_user) {
        $conn = start_db_connection();

        $mysql_result = get_dogs($id_user);

        while ($row = mysql_result->fetch_row()) {
            $id_dog = $row[0];

            delete_dog($id_dog);
        }

        $sql = "DELETE FROM `user`
                WHERE id = $id_user;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }


    //Walker
    function has_walker_profile($id_user) {
        $conn = start_db_connection();
        
        $sql = "SELECT `id_user`
                FROM `walker`
                WHERE `id_user` = $id_user;";
        $mysql_result = $conn->query($sql);
        $count = $mysql_result->num_rows;

        stop_db_connection($conn);

        return ($count > 0);
    }

    function get_walker($id_user) {
        $conn = start_db_connection();

        $sql = "SELECT `id`, `name`, `photo`
                FROM `walker`
                WHERE `id_user` = $id_user;";
        $mysql_result = $conn->query($sql);
        $walker = $mysql_result->fetch_assoc();

        stop_db_connection($conn);

        return $walker;
    }

    function get_unmatched_walkers($id_dog) {
        $conn = start_db_connection();

        $sql = "SELECT walker.id, walker.id_user, walker.name, walker.photo, walker.description, location.name as location, location.latitude, location.longitude, schedule.days, schedule.hours, walker.price
                FROM `walker`
                INNER JOIN `location`
                    ON location.id = walker.id_location
                INNER JOIN `schedule`
                    ON schedule.id = walker.id_schedule
                WHERE walker.id NOT IN (
                    SELECT id_walker
                    FROM `match`
                    WHERE id_dog = $id_dog
                );";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function get_walker_matches($id_walker) {
        $conn = start_db_connection();

        $sql = "SELECT dog.id, dog.id_user, dog.name, dog.photo, dog.description, location.name as location, location.latitude, location.longitude, dog.sex, dog.breed, dog.size, match.id as id_match, match.datetime as datetime_match, message.content as message, message.datetime as datetime
            FROM `dog`
                INNER JOIN `location`
                    ON location.id = dog.id_location
                INNER JOIN `match`
                    ON match.id_dog = dog.id AND match.id_walker = $id_walker
                LEFT JOIN (
                    SELECT id_match, content, max(datetime) as datetime
                    FROM message
                    GROUP BY id_match, datetime
                ) message ON message.id_match = match.id
            GROUP BY dog.id;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function get_walker_profile($id_user) {
        $conn = start_db_connection();
        
        $sql = "SELECT walker.id, walker.id_user, walker.name, walker.photo, walker.description, location.id as id_location, location.name as location, location.latitude, location.longitude, schedule.id as id_schedule, schedule.days, schedule.hours, walker.price
                FROM `walker`
                INNER JOIN `location`
                    ON location.id = walker.id_location
                INNER JOIN `schedule`
                    ON schedule.id = walker.id_schedule
                WHERE `id_user` = $id_user;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function add_walker($id_user, $name, $photo, $description, $price, $location, $latitude, $longitude, $days, $hours) {
        $conn = start_db_connection();

        $sql = "INSERT INTO `location` (`name`, `latitude`, `longitude`)
                VALUES ('$location', $latitude, $longitude);";
        $mysql_result = $conn->query($sql);

        $id_location = mysql_insert_id();

        $sql = "INSERT INTO `schedule` (`days`, `hours`)
                VALUES ('$days', '$hours');";
        $mysql_result = $conn->query($sql);

        $id_schedule = mysql_insert_id();
        
        $sql = "INSERT INTO `dog` (`id_user`, `name`, `photo`, `description`, `id_location`, `id_schedule`, `price`)
                VALUES ($id_user, '$name', '$photo', '$description', $id_location, $id_schedule, $price);";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }

    function update_walker_profile($id_walker, $name, $photo, $description, $price, $id_location, $location, $latitude, $longitude, $id_schedule, $days, $hours) {
        $conn = start_db_connection();

        $sql = "UPDATE `walker`
                SET `name` = '$name', `photo` = '$photo', `description` = '$description', `price` = $price
                WHERE id = $id_walker;";
        $mysql_result = $conn->query($sql);
        
        $sql = "UPDATE `location`
                SET `name` = '$location', `latitude` = $latitude, `longitude` = $longitude
                WHERE id = $id_location;";
        $mysql_result = $conn->query($sql);
        
        $sql = "UPDATE `schedule`
                SET `days` = '$days', `hours` = '$hours'
                WHERE id = $id_schedule;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }

    function delete_walker_account($id_user, $id_walker) {
        $conn = start_db_connection();

        $sql = "SELECT `id`
                FROM `match`
                WHERE id_walker = $id_walker;";
        $mysql_result = $conn->query($sql);
        
        while ($row = $mysql_result->fetch_row()) {
            $id_match = $row[0];

            $sql = "DELETE FROM `message`
                    WHERE `id_match` = $id_match;";
            $mysql_result = $conn->query($sql);
        }

        $sql = "DELETE FROM `match`
                WHERE `id_walker` = $id_walker;";
        $mysql_result = $conn->query($sql);

        $sql = "DELETE FROM `request`
                WHERE `id_walker` = $id_walker;";
        $mysql_result = $conn->query($sql);

        $sql = "SELECT `id_location`, `id_schedule`
                FROM `walker`
                WHERE id = $id_walker;";
        $mysql_result = $conn->query($sql);

        $row = $mysql_result->fetch_row();
        $id_location = $row[0];
        $id_schedule = $row[1];

        $sql = "DELETE FROM `location`
                WHERE `id` = $id_location;";
        $mysql_result = $conn->query($sql);
        
        $sql = "DELETE FROM `schedule`
                WHERE `id` = $id_schedule;";
        $mysql_result = $conn->query($sql);

        $sql = "DELETE FROM `walker`
                WHERE `id` = $id_walker;";
        $mysql_result = $conn->query($sql);

        $sql = "DELETE FROM `user`
                WHERE id = $id_user;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }


    // Request
    function get_request($id_walker, $id_dog) {
        $conn = start_db_connection();

        $sql = "SELECT `id`, `type_requestor`
                FROM `request`
                WHERE `id_walker` = $id_walker AND `id_dog` = $id_dog;";
        $mysql_result = $conn->query($sql);
        $request = $mysql_result->fetch_assoc();

        stop_db_connection($conn);

        return $request;
    }

    function add_request($id_walker, $id_dog) {
        $conn = start_db_connection();

        $type = $_SESSION["type"];
        $datetime = time();

        $sql = "INSERT INTO `request` (`id_walker`, `id_dog`, `type_requestor`, `datetime`)
                VALUES ($id_walker, $id_dog, '$type', $datetime);";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }


    // Match
    function match_exists($id_walker, $id_dog) {
        $conn = start_db_connection();

        $type = $_SESSION["type"];

        $sql = "SELECT `id`
                FROM `match`
                WHERE `id_walker` = $id_walker AND `id_dog` = $id_dog;";
        $mysql_result = $conn->query($sql);
        $count = $mysql_result->num_rows;

        stop_db_connection($conn);
        
        return ($count > 0);
    }

    function add_match($id_walker, $id_dog) {
        $conn = start_db_connection();

        $datetime = time();

        $sql = "DELETE FROM `request`
                WHERE `id_walker` = $id_walker AND `id_dog` = $id_dog;";
        $mysql_result = $conn->query($sql);

        $sql = "INSERT INTO `match` (`id_walker`, `id_dog`, `datetime`)
                VALUES ($id_walker, $id_dog, $datetime);";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }

    function delete_match($id_match) {
        $conn = start_db_connection();

        $sql = "DELETE FROM `message`
                WHERE `id_match` = $id_match;";
        $mysql_result = $conn->query($sql);
        
        $sql = "DELETE FROM `match`
                WHERE `id` = $id_match;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }


    // Message
    function get_messages($id_match, $id_user) {
        $conn = start_db_connection();

        $sql = "SELECT message.id, message.id_match, (message.id_user = $id_user) as is_curr_user, message.content, message.datetime 
                FROM `message`
                WHERE message.id_match = $id_match
                ORDER BY message.datetime ASC;";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);

        return $mysql_result;
    }

    function add_message($id_match, $id_user, $message) {
        $conn = start_db_connection();

        $datetime = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `message` (`id_match`, `id_user`, `content`, `datetime`, `read`)
                VALUES ($id_match, $id_user, '$message', '$datetime', false);";
        $mysql_result = $conn->query($sql);

        stop_db_connection($conn);
    }
?>
# Create dog profile
INSERT INTO `location` (`name`, `latitude`, `longitude`)
VALUES ("", 0, 0);

SELECT `id`
FROM `location`
WHERE `name` = "" && `latitude` = 0 && `longitude` = 0
ORDER BY `id` DESC
LIMIT 1;

INSERT INTO `dog` (`id_user`, `name`, `photo`, `description`, `id_location`, `sex`, `breed`, `size`)
VALUES (0, "", "", "default-dog.jpg", 0, "F", "", "S");
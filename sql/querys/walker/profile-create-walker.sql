# Create walker profile
INSERT INTO `location` (`name`, `latitude`, `longitude`)
VALUES ("", 0, 0);

INSERT INTO `schedule` (`days`, `hours`)
VALUES ("[]", "[]");


SELECT `id`
FROM `location`
WHERE `name` = "" && `latitude` = 0 && `longitude` = 0
ORDER BY `id` DESC
LIMIT 1;

SELECT `id`
FROM `schedule`
WHERE `days` = "[]" && `hours` = "[]"
ORDER BY `id` DESC
LIMIT 1;


INSERT INTO `walker` (`id_user`, `name`, `photo`, `description`, `id_location`, `id_schedule`, `price`)
VALUES (0, "", "default-person.jpg", "", 0, 0, 0);
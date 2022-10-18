# Update owner profile
UPDATE `location`
SET `name` = "", `longitude` = 0, `latitude` = 0
WHERE `id` = 0;

UPDATE `dog`
SET `name` = "", `photo` = "default-dog.jpg", `description` = "", `sex` = "F", `breed` = "", `size` = "S"
WHERE `id` = 0;
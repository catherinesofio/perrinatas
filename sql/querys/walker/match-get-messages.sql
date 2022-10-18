# Get walker match messages
SELECT `id_dog`
FROM `match`
WHERE `id_dog` = 0;

SELECT name, `photo`
FROM `dog`
WHERE `id` = 0;

SELECT `id_user`, `content`, `time`, `read`
FROM `message`
WHERE `id_match` = 0;
# Delete dog profile
SELECT `id`, `id_location`
FROM  `dog`
WHERE `id_dog` = 0;


SELECT `id`
FROM  `match`
WHERE `id_dog` = 0;

DELETE
FROM  `messages`
WHERE `id` = 0 && `id_match` in ();

DELETE
FROM  `match`
WHERE `id_dog` = 0 && `id_match` in ();

DELETE
FROM  `location`
WHERE `id` = 0;

DELETE
FROM  `dog`
WHERE `id` = 0;
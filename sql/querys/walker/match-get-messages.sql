# Get walker match messages
SELECT id_dog
FROM `match`
WHERE id_dog = 0;

SELECT name, photo
FROM `dog`
WHERE id = 0;

SELECT message.id_user, message.content, message.time, message.datetime message.read
FROM `message`
WHERE id_match = 0;
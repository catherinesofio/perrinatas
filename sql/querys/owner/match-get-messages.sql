# Get dog match messages
SELECT id_walker
FROM `match`
WHERE id_walker = 0;

SELECT name, photo
FROM `walker`
WHERE id = 0;

SELECT message.id_user, message.content, message.time, message.datetime message.read
FROM `message`
WHERE id_match = 0;
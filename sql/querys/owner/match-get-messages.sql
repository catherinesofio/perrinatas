# Get dog match messages
SELECT `id_walker`
FROM `match`
WHERE `id_walker` = 0;

SELECT `name`, `photo`
FROM `walker`
WHERE `name` = 0;

SELECT `id_user`, `content`, `time`, `read`
FROM `message`
WHERE `id_match` = 0;
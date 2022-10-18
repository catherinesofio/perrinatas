# Delete walker account
SELECT *
FROM `match`
WHERE id_walker = 0;


DELETE
FROM `messages`
WHERE id_match = 0;

DELETE
FROM `match`
WHERE id_walker = 0;

DELETE
FROM `schedule`
WHERE id = 0;

DELETE
FROM `location`
WHERE id = 0;

DELETE
FROM `walker`
WHERE id_user = 0;

DELETE
FROM `user`
WHERE id = 0;
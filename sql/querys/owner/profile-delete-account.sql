# Delete walker account
SELECT *
FROM `match`
WHERE id_dog = 0;


DELETE
FROM `messages`
WHERE id = 0;

DELETE
FROM `match`
WHERE id_dog = 0;

DELETE
FROM `location`
WHERE id = 0;

DELETE
FROM `dog`
WHERE user_id = 0;

DELETE
FROM `user`
WHERE id = 0;
# Get dog matches
SELECT match.id, walker.name as name, walker.photo as photo, match.time
FROM `match`
    INNER JOIN `walker`
        ON walker.id_user = match.id_user
WHERE id_dog = 0;
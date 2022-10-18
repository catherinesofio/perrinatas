# Get dog matches
SELECT match.id, walker.name as name, walker.photo as photo, match.time
FROM `match`
    INNER JOIN `walker`
        ON walker.id = match.id_walker
WHERE match.id_dog = 0;
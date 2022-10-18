# Get walker matches
SELECT match.id, dog.name as name, dog.photo as photo, match.time
FROM `match`
    INNER JOIN `dog`
        ON dog.id = match.id_dog
WHERE match.id_walker = 0;
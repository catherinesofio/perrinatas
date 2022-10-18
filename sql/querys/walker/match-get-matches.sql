# Get walker matches
SELECT match.id, dog.name as name, dog.photo as photo, match.time
FROM `match`
    INNER JOIN `dog`
        ON dog.id_user = match.id_user
WHERE id_walker = 0;
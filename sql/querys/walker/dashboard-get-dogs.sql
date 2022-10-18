# Get unmatched dogs' profiles
SELECT dog.id, dog.name, dog.photo, dog.description, location.name as location, location.latitude as latitude, location.longitude as longitude, dog.sex, dog.breed, dog.size
FROM `dog`
    INNER JOIN `location`
        ON location.id = dog.id_location
    LEFT OUTER JOIN `match`
        ON match.id_dog = dog.id;
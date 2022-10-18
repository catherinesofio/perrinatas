# Get unmatched walkers' profiles
SELECT walker.id, walker.name, walker.photo, walker.description, location.name as location, location.latitude as latitude, location.longitude as longitude, schedule.days, schedule.hours, walker.price
FROM `walker`
    INNER JOIN `location`
        ON location.id = walker.id_location
    INNER JOIN `schedule`
        ON schedule.id = walker.id_schedule
    LEFT OUTER JOIN `match`
        ON match.id_dog != 1;
# Update walker profile
UPDATE `location`
SET name = "", latitude = 0, longitude = 0

UPDATE `schedule`
SET days = "[]", hours = "[]"
WHERE id = 0;

UPDATE `walker`
SET name = "", photo = "", description = "", price = 0
WHERE id = 0;
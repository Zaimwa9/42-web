SELECT `last_name`, `first_name`
FROM user_card
WHERE `first_name` LIKE '% %'
OR `last_name` LIKE '% %'
OR `first_name` LIKE '%-%'
OR `last_name` like '%-%'
ORDER BY `last_name`, `first_name`;

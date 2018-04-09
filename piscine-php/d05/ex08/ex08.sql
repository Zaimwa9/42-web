SELECT `last_name`, `first_name`, DATE_FORMAT(`birthdate`, '%Y-%m-%d') AS 'birthdate'
FROM user_card
WHERE DATE_FORMAT(`birthdate`, '%Y') = '1989';

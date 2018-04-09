SELECT count(*) AS movies
FROM member_history
WHERE (date BETWEEN '2006-10-30' AND '2007-07-27')
OR (extract(MONTH from date) = 12 AND extract(day from date) = 24);

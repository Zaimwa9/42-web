SELECT floor_number AS floor,
sum(nb_seats) AS seats
FROM cinema
GROUP BY 1
ORDER BY 2 DESC;

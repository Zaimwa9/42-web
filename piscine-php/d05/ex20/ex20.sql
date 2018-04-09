SELECT
f.id_genre AS 'id_genre',
g.name AS 'name_genre',
d.id_distrib AS 'id_distrib',
d.name AS 'name_distrib',
f.title AS 'title_film'
FROM db_wzaim.film AS f
LEFT JOIN genre AS g on f.id_genre = g.id_genre
LEFT JOIN distrib AS d on f.id_distrib = d.id_distrib
WHERE f.id_genre >= 4 and f.id_genre <= 8;

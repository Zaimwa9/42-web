SELECT t.name
FROM (
	SELECT id_distrib, name, length(name) - length(replace(name, 'y', '')) AS smally,
	length(name) - length(replace(name, 'Y', '')) AS bigy
	from distrib
) AS t
WHERE id_distrib in (42, 62, 63, 64, 65, 66, 67, 68, 69, 71, 88, 89, 90)
OR smally + bigy = 2
LIMIT 2, 5;

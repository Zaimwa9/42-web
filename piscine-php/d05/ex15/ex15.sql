SELECT
LEFT(REVERSE(phone_number), 9) AS enohpelet
FROM distrib
WHERE LEFT(phone_number, 2) = 05;

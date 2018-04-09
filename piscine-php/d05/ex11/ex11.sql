SELECT UPPER(user_card.last_name) AS `NAME`, user_card.first_name, subscription.price
 FROM member
 INNER JOIN subscription ON subscription.id_sub = member.id_sub
 INNER JOIN user_card ON user_card.id_user = member.id_member
 WHERE price > 42 ORDER BY NAME ASC, first_name ASC;

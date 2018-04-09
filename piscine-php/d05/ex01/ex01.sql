CREATE TABLE ft_table (
	`id` INT PRIMARY KEY UNIQUE NOT NULL AUTO_INCREMENT,
	`login` char(8) NOT NULL DEFAULT 'toto',
	`group` ENUM('staff', 'student', 'other') NOT NULL,
	`creation_date` DATE NOT NULL
);
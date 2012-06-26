

CREATE DATABASE IF NOT EXISTS 
	`single30_herb_db` 
DEFAULT CHARACTER SET 
	utf8 
COLLATE 
	utf8_general_ci;


GRANT ALL PRIVILEGES ON
	single30_herb_db.*
TO
	'single30_herbapp'@'localhost'
IDENTIFIED BY
	'BaoChangJi';
	

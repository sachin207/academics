CREATE TABLE IF NOT EXISTS `camera_review` (
  `manufacturer` varchar(100) DEFAULT NULL,
  `product_name` varchar(1024) DEFAULT NULL,
  `unixReviewTime` int(11) DEFAULT NULL,
  `prodId` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `help_y` int(11) DEFAULT NULL,
  `help_t` int(11) DEFAULT NULL,
  `reviewTime` varchar(50) DEFAULT NULL,
  `reviewerName` varchar(255) DEFAULT NULL,
  `summary` varchar(100) DEFAULT NULL,
  `reviewText` text,
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
);



LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/canon_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/fujifilm_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/kodak_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/nikon_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/olympus_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/panasonic_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/polaroid_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';


LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/samsung_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE  '/home/sachin/Documents/Topics_In_Database_Management/Project/database/sony_review.csv' INTO TABLE camera_review FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';

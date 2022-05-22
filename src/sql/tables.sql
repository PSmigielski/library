CREATE TABLE `book`(
	`id` UUID PRIMARY KEY DEFAULT UUID(),
	`title` VARCHAR(150) NOT NULL,
	`publication_date` DATE NOT NULL,
	`publisher` VARCHAR(70) NOT NULL,
	`language` VARCHAR(20),
	`pages` INT NOT NULL,
	`ibsn` VARCHAR(13) NOT NULL,
	`genre` ENUM("Classic", "Comic Book", "Fantasy", "Detective", "Historical Fiction", "Horror", "Romance", "Science Fiction", "Thriller", "Biography", "Essay", "History", "Poetry") NOT NULL
);
CREATE TABLE `author`(
	`id` UUID PRIMARY KEY DEFAULT UUID(),
	`name` VARCHAR(60) NOT NULL,
	`surname` VARCHAR(60) NOT NULL,
	`birthday` DATE,
	`bio` TEXT
);
ALTER TABLE `book` ADD COLUMN `author_id` UUID NOT NULL;
ALTER TABLE `book` ADD FOREIGN KEY (`author_id`) REFERENCES `author`(`id`);
CREATE TABLE `book`(
	`bo_id` UUID PRIMARY KEY DEFAULT UUID(),
	`bo_title` VARCHAR(150) NOT NULL,
	`bo_publication_date` DATE NOT NULL,
	`bo_publisher` VARCHAR(70) NOT NULL,
	`bo_language` VARCHAR(20),
	`bo_pages` INT NOT NULL,
	`bo_ibsn` VARCHAR(13) NOT NULL,
);
CREATE TABLE `author`(
	`au_id` UUID PRIMARY KEY DEFAULT UUID(),
	`au_name` VARCHAR(60) NOT NULL,
	`au_surname` VARCHAR(60) NOT NULL,
	`au_birthday` DATE,
	`au_bio` TEXT
);
ALTER TABLE `book` ADD COLUMN `bo_author_id` UUID NOT NULL;
ALTER TABLE `book` ADD FOREIGN KEY (`bo_author_id`) REFERENCES `author`(`au_id`);
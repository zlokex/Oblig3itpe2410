SET foreign_key_checks = 0;

DROP TABLE IF EXISTS authors;
CREATE TABLE IF NOT EXISTS authors (
	authorid INT(11) NOT NULL AUTO_INCREMENT,
	name VARCHAR(55) NOT NULL,
	PRIMARY KEY (authorid)
);

DROP TABLE IF EXISTS books;
CREATE TABLE IF NOT EXISTS books (
	bookid INT(11) NOT NULL AUTO_INCREMENT,
	authorid INT(11),
	title VARCHAR(55) NOT NULL,
	ISBN VARCHAR(25) NOT NULL,
	pub_year SMALLINT(6) NOT NULL,
	available ENUM('Yes', 'No') NOT NULL,
	PRIMARY KEY (bookid),
	FOREIGN KEY (authorid) REFERENCES authors(authorid)
	ON DELETE CASCADE
);

INSERT INTO authors (name) VALUES
	('J.R.R. Tolkien'),
	('Alex Haley'),
	('Tom Clancy'),
	('Isaac Asimov');


INSERT INTO books (title, ISBN, pub_year, available) VALUES
	('The Two Towers', '0-261-10236-2', 1954, 'Yes'),
	('The Return of The King', '0-261-10237-0', 1955, 'No'),
	('Roots', '0-440-17464-3', 1974, 'Yes'),
	('Rainbow Six', '0-425-17034-9', 1998, 'Yes'),
	('Teeth of the Tiger', '0-399-15079-X', 2003, 'Yes'),
	('Executive Orders', '0-425-15863-2', 1996, 'No'),
	('The Hobbit', '0-261-10221-4', 1937, 'Yes'),
	('The Sum of All Fears', '0-425-13354-0', 1991, 'Yes'),
	('Red Rabbit', '0-399-14870-1', 2000, 'No'),
	('I, Robot', '0-553-29438-5', 1950, 'Yes'),
	('Foundation', '0-553-80371-9', 1951, 'Yes'),
	('Foundation''s Edge', '0-553-29338-9', 1982, 'Yes'),
	('Foundation and Empire', '0-553-29337-0', 1952, 'Yes'),
	('Exploring the Earth and the Cosmos', '0-517-546671', 1982, 'No'),
	('Second Foundation', '0-553-29336-2', 1953, 'Yes'),
	('Forward the Foundation', '0-553-56507-9', 1993, 'Yes'),
	('The Best of Isaac Asimov', '0-449-20829-X', 1973, 'Yes'),
	('Isaac Asimov: Gold', '0-06-055652-8', 1995, 'Yes');


UPDATE books b, authors a
SET
	b.authorid = a.authorid
WHERE
	(a.name = 'J.R.R. Tolkien'
		AND (
			 b.title = 'The Two Towers'
			 OR b.title = 'The Return of The King'
			 OR b.title = 'The Hobbit'
	       )
	)
	OR
	(a.name = 'Alex Haley'
	 AND (
		 b.title = 'Roots'
	 )
	)
	 OR
	 (a.name = 'Tom Clancy'
		AND (
			b.title = 'Rainbow Six'
			OR b.title = 'Teeth of the Tiger'
			OR b.title = 'Executive Orders'
			OR b.title = 'The Sum of All Fears'
			OR b.title = 'Red Rabbit'
		)
	 )
	 OR
	 (a.name = 'Isaac Asimov'
		AND (
			b.title = 'I, Robot'
			OR b.title = 'Foundation'
			OR b.title = 'Foundation''s Edge'
			OR b.title = 'Foundation and Empire'
			OR b.title = 'Exploring the Earth and the Cosmos'
			OR b.title = 'Second Foundation'
			OR b.title = 'Forward the Foundation'
			OR b.title = 'The Best of Isaac Asimov'
			OR b.title = 'Isaac Asimov: Gold'
		)
	 );

SET foreign_key_checks = 1;
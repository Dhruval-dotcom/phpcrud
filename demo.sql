use dhruvaldb;
show tables;
CREATE TABLE IF NOT EXISTS practiceajax (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(80),
    image VARCHAR(30),
    email VARCHAR(30),
    doi varchar(30),
    PRIMARY KEY (id)
);
 ALTER TABLE practiceajax MODIFY COLUMN image VARCHAR (500);


select * from practiceajax;
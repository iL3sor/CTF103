SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
create database IF NOT EXISTS vcs;
use vcs;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS messages;

CREATE TABLE users(
    `id` int NOT NULL AUTO_INCREMENT,
    `username` varchar(255),
    `password` varchar(255),
    PRIMARY KEY (id)
);
CREATE TABLE messages(
    `id` int NOT NULL AUTO_INCREMENT,
    `sender` varchar(255),
    `receiver` varchar(255),
    `title` varchar(255),
    `message` varchar(3000),
    PRIMARY KEY (id)
);

INSERT INTO `users` (`username`,`password` ) VALUES ('admin', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8')
CREATE DATABASE perrinatas;

USE perrinatas;

CREATE TABLE `user` (id int NOT NULL AUTO_INCREMENT, type ENUM('owner', 'walker') NOT NULL, username varchar(25) NOT NULL, password varchar(25) NOT NULL, PRIMARY KEY (id));

CREATE TABLE dog (id int NOT NULL AUTO_INCREMENT, user_id INT NOT NULL, FOREIGN KEY (user_id) REFERENCES user(id), PRIMARY KEY (id));

CREATE TABLE profile_walker (user_id INT NOT NULL, name varchar(25) NOT NULL, photo varchar(255) NOT NULL, description varchar(255) NOT NULL, location varchar(255) NOT NULL, schedule varchar(255) NOT NULL, price_range varchar(255) NOT NULL, FOREIGN KEY (user_id) REFERENCES user(id));

CREATE TABLE profile_dog (dog_id INT NOT NULL, name varchar(25) NOT NULL, photos varchar(255) NOT NULL, description varchar(255) NOT NULL, location varchar(255) NOT NULL, schedule varchar(255) NOT NULL, FOREIGN KEY (dog_id) REFERENCES dog(id));

CREATE TABLE `match` (user_id INT NOT NULL, dog_id INT NOT NULL, timestamp datetime NOT NULL, chat BLOB NOT NULL, FOREIGN KEY (user_id) REFERENCES dog(user_id), FOREIGN KEY (dog_id) REFERENCES dog(id));

CREATE TABLE pending (user_id INT NOT NULL, dog_id INT NOT NULL, type ENUM('owner', 'walker') NOT NULL, FOREIGN KEY (user_id) REFERENCES dog(user_id), FOREIGN KEY (dog_id) REFERENCES dog(id));

CREATE TABLE cooldown (user_id INT NOT NULL, dog_id INT NOT NULL, type ENUM('owner', 'walker') NOT NULL, timestamp datetime NOT NULL, FOREIGN KEY (user_id) REFERENCES dog(user_id), FOREIGN KEY (dog_id) REFERENCES dog(id));
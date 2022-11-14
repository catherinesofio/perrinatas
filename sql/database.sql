CREATE DATABASE `perrinatas`;

USE `perrinatas`;

CREATE TABLE `user` (
    `id` int NOT NULL AUTO_INCREMENT,
    `username` varchar(25) NOT NULL,
    `password` varchar(25) NOT NULL,
    `type` ENUM('owner','walker') NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `schedule` (
    `id` int NOT NULL AUTO_INCREMENT,
    `days` varchar(255) NOT NULL,
    `hours` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `location` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(25) NOT NULL,
    `latitude` FLOAT NOT NULL,
    `longitude` FLOAT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `walker` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_user` INT NOT NULL,
    `name` varchar(25),
    `photo` varchar(255),
    `description` varchar(255),
    `id_location` INT,
    `id_schedule` INT,
    `price` INT,
    FOREIGN KEY (`id_user`) REFERENCES `user`(`id`) ON UPDATE RESTRICT,
    FOREIGN KEY (`id_location`) REFERENCES `location`(`id`) ON UPDATE RESTRICT,
    FOREIGN KEY (`id_schedule`) REFERENCES `schedule`(`id`) ON UPDATE RESTRICT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `dog` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_user` INT NOT NULL,
    `name` varchar(25),
    `photo` varchar(255),
    `description` varchar(255),
    `id_location` INT,
    `sex` ENUM('F','M'),
    `breed` varchar(255),
    `size` ENUM('S','M','XL'),
    FOREIGN KEY (`id_user`) REFERENCES `user`(`id`) ON UPDATE RESTRICT,
    FOREIGN KEY (`id_location`) REFERENCES `location`(`id`) ON UPDATE RESTRICT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `request` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_walker` INT NOT NULL,
    `id_dog` INT NOT NULL,
    `type_requestor` ENUM('owner','walker') NOT NULL,
    `datetime` datetime NOT NULL,
    FOREIGN KEY (`id_walker`) REFERENCES `walker`(`id`) ON UPDATE RESTRICT,
    FOREIGN KEY ( `id_dog`) REFERENCES `dog`(`id`) ON UPDATE RESTRICT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `match` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_walker` INT NOT NULL,
    `id_dog` INT NOT NULL,
    `datetime` datetime NOT NULL,
    FOREIGN KEY (`id_walker`) REFERENCES `walker`(`id`) ON UPDATE RESTRICT,
    FOREIGN KEY ( `id_dog`) REFERENCES `dog`(`id`) ON UPDATE RESTRICT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `message` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_match` INT NOT NULL,
    `id_user` INT NOT NULL,
    `content` varchar(255),
    `datetime` datetime NOT NULL,
    `read` boolean NOT NULL,
    FOREIGN KEY ( `id_match`) REFERENCES `match`(`id`) ON UPDATE RESTRICT,
    FOREIGN KEY ( `id_user`) REFERENCES `user`(`id`) ON UPDATE RESTRICT,
    PRIMARY KEY (`id`)
);
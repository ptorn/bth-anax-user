--
-- Ramverk1 SQL
-- Av: peto16, Peder Tornberg
--
-- SET NAMES 'utf8';
-- CREATE DATABASE IF NOT EXISTS your_database;
-- USE your_database;

DROP TABLE IF EXISTS `ramverk1_User`;

CREATE TABLE ramverk1_User
(
    `id` INT AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(30) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) DEFAULT NULL,
    `firstname` VARCHAR(40) DEFAULT NULL,
    `lastname` VARCHAR(40) DEFAULT NULL,
    `administrator` BOOLEAN DEFAULT False,
    `enabled` BOOLEAN DEFAULT True,
    `deleted` DATETIME DEFAULT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `username_unique` (`username`),
    UNIQUE KEY `email_unique` (`email`)

);

INSERT INTO
    ramverk1_User(username, password, email, firstname, lastname, administrator, enabled)
VALUES
    ('admin', '$2y$10$vaqfYKE2TfIzo7EQMxd8fOg3AvnPBZPTtV4l98aN4Ep6TkmjA2/Cm', 'peder.tornberg@gmail.com', 'Peder', 'Tornberg', True, True),
    ('doe', '$2y$10$dYBys9cIIKEsdtQoiIiELOVkuRbcyfMZt7L8Pinw7JHDpZEol7UN6', 'doe@example.com', 'John', 'Doe', False, True),
    ('bob', '$2y$10$bV/btm035m/Hv87RYB04JuTFN7opVra1zlBcvdKJHxTzBISmQeHSy', 'bob@example.com', 'Bob', 'Builder', False, False),
    ('disabled', '$2y$10$bV/btm035m/Hv87RYB04JuTFN7opVra1zlBcvdKJHxTzBISmQeHSy', 'disabled@example.com', 'Pink', 'Panther', False, False);

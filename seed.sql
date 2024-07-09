-- TABLES
CREATE TABLE IF NOT EXISTS `teacher` (
    `teacher_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32) NOT NULL,
    `last_name` VARCHAR(64) NOT NULL
);

CREATE TABLE IF NOT EXISTS `workshop` (
    `workshop_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32) NOT NULL UNIQUE,
    `image_url` VARCHAR(128) NOT NULL,
    `max_capacity` INT(4) NOT NULL,
    `teacher_id` INT(11) NOT NULL,
    FOREIGN KEY(`teacher_id`) REFERENCES `teacher`(`teacher_id`)
);

CREATE TABLE IF NOT EXISTS `career` (
    `career_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `short_name` VARCHAR(32) NOT NULL,
    `name` VARCHAR(128) NOT NULL
);

CREATE TABLE IF NOT EXISTS `record` (
    `record_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `workshop_id` INT(11) NOT NULL,
    `control_number` CHAR(14) NOT NULL UNIQUE,
    `name` VARCHAR(32) NOT NULL,
    `last_name` VARCHAR(64) NOT NULL,
    `sex` ENUM('male', 'female') NOT NULL,
    `career_id` INT(11) NOT NULL,
    `semester` ENUM('1', '2', '3', '4', '5', '6') NOT NULL,
    `group` ENUM('a', 'b', 'c') NOT NULL,
    `register_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(`workshop_id`) REFERENCES `workshop`(`workshop_id`),
    FOREIGN KEY(`career_id`) REFERENCES `career`(`career_id`)
);

CREATE VIEW workshop_view AS
SELECT
    `w`.`workshop_id`,
    `w`.`name`,
    `w`.`image_url`,
    `w`.`max_capacity`,
    `w`.`teacher_id`,
    COUNT(`r`.`record_id`) AS registered
FROM
    `workshop` w
    LEFT JOIN `record` r ON `w`.`workshop_id` = `r`.`workshop_id`
GROUP BY
    `w`.`workshop_id`,
    `w`.`name`,
    `w`.`image_url`,
    `w`.`max_capacity`,
    `w`.`teacher_id`;

CREATE TABLE IF NOT EXISTS `commentary` (
    `commentary_id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `commentary` TEXT NOT NULL,
    `register_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `client_ip` VARCHAR(15)
);

-- DEFAULT VALUES
INSERT INTO
    `career`(`name`, `short_name`)
VALUES
    ('Programacion', 'PROG'),
    ('Produccion Industrial de Alimentos', 'PIA');
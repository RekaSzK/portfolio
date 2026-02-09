--Creating database. 30/12/2025

CREATE DATABASE IF NOT EXISTS `portfolio`
DEFAULT CHARACTER SET utf8mb4 --To store text encoded in UTF-8.
COLLATE utf8mb4_general_ci; --Text comparison is not case sensitive (general_ci).
USE `portfolio`;

--Creating User table. 30/12/2025

CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT,
    `userName` VARCHAR(50) NOT NULL,
    `userRole` ENUM('admin', 'visitor') DEFAULT 'visitor',
    CONSTRAINT PK_userId PRIMARY KEY(`id`)
);

--Creating Year table. 30/12/2025

CREATE TABLE `year` (
    `id` INT AUTO_INCREMENT,
    `yearNumber` INT NOT NULL,
    CONSTRAINT PK_yearId PRIMARY KEY(`id`) 
);

--Creating Category table. 30/12/2025

CREATE TABLE `category` (
    `id` INT AUTO_INCREMENT,
    `categoryName` VARCHAR(100) NOT NULL,
    `categoryYear_id` INT NOT NULL,
    CONSTRAINT PK_categoryId PRIMARY KEY(`id`),
    CONSTRAINT FK_categoryYear_id FOREIGN KEY(`categoryYear_id`) REFERENCES `year`(`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

--Creating File table. 30/12/2025

CREATE TABLE `file` (
    `id` INT AUTO_INCREMENT,
    `fileName` VARCHAR(100) NOT NULL,
    `fileFormat` ENUM('doc', 'docx', 'pdf', 'pptx') NOT NULL,
    `filePath` VARCHAR(255) NOT NULL,
    `fileCategory_id` INT NOT NULL,
    `fileStatus` ENUM('approved', 'submitted', 'rejected') DEFAULT 'submitted',
    CONSTRAINT PK_fileId PRIMARY KEY(`id`),
    CONSTRAINT FK_fileCategory_id FOREIGN KEY(`fileCategory_id`) REFERENCES `category`(`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

--Creating File Access table. 30/12/2025

CREATE TABLE `file_access` (
    `user_id` INT NOT NULL,
    `file_id` INT NOT NULL,
    CONSTRAINT PK_file_access PRIMARY KEY(`user_id`, `file_id`),
    CONSTRAINT FK_file_access_user_id FOREIGN KEY(`user_id`) REFERENCES `user`(`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT FK_file_access_file_id FOREIGN KEY(`file_id`) REFERENCES `file`(`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

--Dumping data. 30/12/2025

INSERT INTO `user` (`userName`, `userRole`)
VALUES
    ("admin", "admin"),
    ("visitor1", "visitor");

INSERT INTO `year` (`yearNumber`)
VALUES
    (1),
    (2),
    (3),
    (4);

INSERT INTO `category` (`categoryName`, `categoryYear_id`)
VALUES
    ("Web Development", 1),
    ("Database Application Management", 1),
    ("Project Innovate", 1);

INSERT INTO `file` (`fileName`, `fileFormat`, `filePath`, `fileCategory_id`, `fileStatus`)
VALUES
    ("Code of Conduct - Y1P1", "docx", "files/notes/Code of Conduct - Y1P1.docx", 1, "submitted"),
    ("Code of Conduct - Y1P2", "docx", "files/notes/Code of Conduct - Y1P2.docx", 2, "submitted"),
    ("Interview Schedule - 11.28", "docx", "files/notes/Interview Schedule - 11.28.docx", 2, "submitted"),
    ("Meeting Agenda - 11.28", "docx", "files/notes/Meeting Agenda - 11.28.docx", 2, "submitted"),
    ("Minutes of Consultation Meeting - 10.07", "doc", "files/notes/Minutes of Consultation Meeting - 10.07.doc", 1, "submitted"),
    ("Minutes of Meetings - 09.12", "docx", "files/notes/Minutes of Meetings - 09.12.docx", 1, "submitted"),
    ("Minutes of Meetings - 09.26", "docx", "files/notes/Minutes of Meetings - 09.26.docx", 1, "submitted"),
    ("Minutes of Meetings - 10.10", "docx", "files/notes/Minutes of Meetings - 10.10.docx", 1, "submitted"),
    ("Minutes of Meetings - 10.31", "docx", "files/notes/Minutes of Meetings - 10.31.docx", 1, "submitted"),
    ("Minutes of Meetings - 11.28", "docx", "files/notes/Minutes of Meetings - 11.28.docx", 2, "submitted"),
    ("Project Plan - Y1P1", "docx", "files/notes/Project Plan - Y1P1.docx", 1, "submitted"),
    ("Project Plan - Y1P2", "docx", "files/notes/Project Plan - Y1P2.docx", 2, "submitted");

INSERT INTO `file_access` (`user_id`, `file_id`)
VALUES
    (2, 6),
    (2, 7),
    (2, 8),
    (2, 9),
    (2, 10);

--Adding password column to User table. 30/12/2025

ALTER TABLE `user`
ADD `password` VARCHAR(255) NOT NULL;

--Adding password for admin user. 30/12/2025

UPDATE `user`
SET `password` = '$2y$12$.x1FhhBOhQ2MXahF0icHtu8S1niftq62ERQGpFGw83nu8jprEogCW'
WHERE `userName` = 'admin';

--Adding files for the Feedback page. 13/01/2026

INSERT INTO `file` (`fileName`, `fileFormat`, `filePath`, `fileCategory_id`, `fileStatus`)
VALUES
    ("Feedback From Jakub Mazur", "docx", "files/feedback/Feedback From Jakub Mazur.docx", 2, "approved"),
    ("Feedback From Rodrigo de Araújo Castanheira", "docx", "files/feedback/Feedback From Rodrigo de Araújo Castanheira", 2, "approved"),
    ("Feedback From Michael Boateng", "docx", "files/feedback/Feedback From Michael Boateng.docx", 2, "approved"),
    ("Feedback From Ai Nguyen", "docx", "files/feedback/Feedback From Ai Nguyen.docx", 1, "approved"),
    ("Feedback From Aynur Tozluyurt", "docx", "files/feedback/Feedback From Aynur Tozluyurt.docx", 1, "approved"),
    ("Feedback From Tamás Kiss", "docx", "files/feedback/Feedback From Tamás Kiss.docx", 1, "approved");

--Adding files for the Presenting page. 13/01/2026

INSERT INTO `file` (`fileName`, `fileFormat`, `filePath`, `fileCategory_id`, `fileStatus`)
VALUES
    ("Presentation - Y1P1", "pptx", "files/presenting/Sunny Socks Website.pptx", 1, "approved"),
    ("Presentation Grading - Y1P1", "pdf", "files/presenting/2025-2026 Assessment form Presenting - IT IE - Tagged.pdf", 1, "approved"),
    ("Presentation - Y1P2", "pptx", "files/presenting/Gemorskos Newspaper", 2, "approved"),
    ("Presentation Grading - Y1P2", "pdf", "files/presenting/placeholder", 2, "approved");

--Adding files for the Professional Skills page. 13/01/2026

INSERT INTO `file` (`fileName`, `fileFormat`, `filePath`, `fileCategory_id`, `fileStatus`)
VALUES
    ("Reflection Report - Y1P2", "docx", "files/proskills/Reflection Report - Y1P2.docx", 2, "approved"),
    ("Study Career Coaching - Y1P2", "docx", "files/proskills/Study Career Coaching - Y1P2.docx", 2, "approved");

--Updating file. 15/01/2026

UPDATE `file`
SET
	`fileName` = 'Feedback From Oleksii Khomiak',
    `filePath` = 'files/feedback/Feedback From Oleksii Khomiak.docx'
WHERE `id` = 18;

--Deleting unnecessary record. 30/01/2026

DELETE FROM `file`
WHERE id = 21;

--Updating placeholder filePath. 30/01/2026

UPDATE `file`
SET `filePath` = "files/presenting/2025-2026 Assessment form Presenting Group 1B.pdf"
WHERE `id` = 22;

--Updating filePath. 30/01/2026

UPDATE `file`
SET `filePath` = "files/presenting/2025-2026 Assessment form Presenting Group 1E.pdf"
WHERE `id` = 20;

--Fixing error. 30/01/2026

UPDATE `file`
SET `filePath` = "files/presenting/2025-2026 Assessment form Presenting ProSkills Assessment.pdf"
WHERE `id` = 22;

--Adding portfolio presentation to database. 30/01/2026

INSERT INTO `file` (`fileName`, `fileFormat`, `filePath`, `fileCategory_id`, `fileStatus`)
VALUES ("Presentation - Y1P2", "pptx", "files/presenting/Portfolio Presentation", 2, "approved");

--Fixing linking. 30/01/2026

UPDATE `file`
SET `fileName` = "files/presenting/Portfolio Presentation.pptx"
WHERE `id` = 25;

--Fixing mistake. 30/01/2026

UPDATE `file`
SET `fileName` = "Presentation - Y1P2", `filePath` = "files/presenting/Portfolio Presentation.pptx"
WHERE `id` = 25;

--Fixing category name. 07/02/2026

UPDATE `category`
SET categoryName = "Project BattleBot"
WHERE id = 3

--To add an `id`column to file_access, we can drop the table.. 07/02/2026

DROP TABLE `file_access`;

CREATE TABLE `file_access` (
    `id` INT AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `file_id` INT NOT NULL,
    CONSTRAINT PK_file_access PRIMARY KEY(`id`),
    CONSTRAINT FK_file_access_user_id FOREIGN KEY(`user_id`) REFERENCES `user`(`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT FK_file_access_file_id FOREIGN KEY(`file_id`) REFERENCES `file`(`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

--Changing userRole to role_id instead of ENUM. 07/02/2026

CREATE TABLE `role` (
    `id` INT AUTO_INCREMENT,
    `roleName` VARCHAR(100) NOT NULL,
    CONSTRAINT PK_role PRIMARY KEY(`id`)
);

INSERT INTO `role` (`roleName`)
VALUES ("admin"), ("visitor"), ("lecturer"), ("student");

ALTER TABLE `user`
ADD COLUMN `role_id` INT NULL;

UPDATE `user`
JOIN `role` ON user.userRole = role.roleName
SET user.role_id = role.id;

ALTER TABLE `user`
ADD
    CONSTRAINT FK_user_roleName FOREIGN KEY (`role_id`) REFERENCES `role`(`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE `user`
DROP COLUMN `userRole`;

ALTER TABLE `user`
MODIFY `role_id` INT NOT NULL;

--Adding role. 07/02/2026

INSERT INTO `role` (`roleName`)
VALUES ("study career coach");
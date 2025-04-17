-- 1) Создать БД
CREATE DATABASE IF NOT EXISTS `studak`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `studak`;

-- 2) Роли
CREATE TABLE `roles` (
  `id`   INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3) Факультеты
CREATE TABLE `faculty` (
  `id`   INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4) Направления
CREATE TABLE `directions` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `faculty_id` INT NOT NULL,
  `name`       VARCHAR(100) NOT NULL,
  FOREIGN KEY (`faculty_id`) REFERENCES `faculty`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5) Группы
CREATE TABLE `groups` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `faculty_id` INT NOT NULL,
  `name`       VARCHAR(100) NOT NULL,
  FOREIGN KEY (`faculty_id`) REFERENCES `faculty`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6) Пользователи
CREATE TABLE `users` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `fio`           VARCHAR(200) NOT NULL,
  `role_id`       INT NOT NULL,
  `faculty_id`    INT NOT NULL,
  `group_id`      INT NOT NULL,
  `direction_id`  INT NOT NULL,
  `login`         VARCHAR(100) NOT NULL UNIQUE,
  `password`      VARCHAR(255) NOT NULL,
  `email`         VARCHAR(150) DEFAULT NULL,
  `phone`         BIGINT       DEFAULT NULL,
  FOREIGN KEY (`role_id`)      REFERENCES `roles`(`id`)     ON DELETE RESTRICT,
  FOREIGN KEY (`faculty_id`)   REFERENCES `faculty`(`id`)   ON DELETE RESTRICT,
  FOREIGN KEY (`direction_id`) REFERENCES `directions`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`group_id`)     REFERENCES `groups`(`id`)     ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7) Новости
CREATE TABLE `news` (
  `id`               INT AUTO_INCREMENT PRIMARY KEY,
  `user_id`          INT NOT NULL,
  `news_title`       VARCHAR(255) DEFAULT '',
  `news_text`        TEXT NOT NULL,
  `publication_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

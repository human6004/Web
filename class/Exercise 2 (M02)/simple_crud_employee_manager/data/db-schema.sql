-- CREATE DATABASE IF NOT EXISTS myDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE myDB;

-- DROP TABLE IF EXISTS employee;

-- CREATE TABLE employee (
--     id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
--     firstname VARCHAR(30) NOT NULL,
--     lastname VARCHAR(30) NOT NULL,
--     email VARCHAR(50) NOT NULL,
--     dob DATE,
--     location VARCHAR(50),
--     startdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

CREATE DATABASE IF NOT EXISTS myDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE myDB;

DROP TABLE IF EXISTS employee;

CREATE TABLE employee (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    dob DATE,
    location VARCHAR(50),
    startdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO employee (firstname, lastname, email, dob, location, startdate)
VALUES
('Minh', 'Nguyen', 'minh.nguyen@example.com', '1990-03-22', 'Soc Trang', '2022-06-01 09:00:00'),
('Lan', 'Pham', 'lan.pham@example.com', '1998-11-05', 'Bac Lieu', '2023-09-10 09:00:00'),
('Hung', 'Le', 'hung.le@example.com', '1987-01-30', 'Can Tho', '2021-04-18 09:00:00');

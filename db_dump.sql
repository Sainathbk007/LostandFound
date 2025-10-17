-- SQL dump for Lost & Found
-- Create database and tables
CREATE DATABASE IF NOT EXISTS `lost_and_found` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lost_and_found`;

-- Admin table
CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Lost items
CREATE TABLE IF NOT EXISTS `lost_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `item_name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `date_lost` DATE,
  `location` VARCHAR(255),
  `contact_info` VARCHAR(255),
  `student_college_id` VARCHAR(100),
  `image` VARCHAR(255),
  `status` VARCHAR(50) DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Found items
CREATE TABLE IF NOT EXISTS `found_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `item_name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `date_found` DATE,
  `location` VARCHAR(255),
  `contact_info` VARCHAR(255),
  `student_college_id` VARCHAR(100),
  `image` VARCHAR(255),
  `status` VARCHAR(50) DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Requests
CREATE TABLE IF NOT EXISTS `requests` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `found_item_id` INT NOT NULL,
  `requester_name` VARCHAR(255) NOT NULL,
  `contact_info` VARCHAR(255) NOT NULL,
  `message` TEXT,
  `status` VARCHAR(50) DEFAULT 'pending',
  FOREIGN KEY (found_item_id) REFERENCES found_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a default admin user
-- Password: admin123 (hashed using PHP password_hash)
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$wH2kQb3E6Zqf0aXx5pQ9eOG9qgYjv6I2Kf9cQw0bE4s1Kj7Pq3L1K');

-- Optional sample data
INSERT INTO found_items (item_name, description, date_found, location, contact_info, student_college_id, image, status) VALUES
('Black Wallet', 'Leather wallet with ID, no cash', '2025-10-01', 'Central Park', 'found@example.com', NULL, NULL, 'available');

INSERT INTO lost_items (item_name, description, date_lost, location, contact_info, student_college_id, image, status) VALUES
('Silver Ring', 'Engraved inside with initials', '2025-09-28', 'Downtown', 'owner@example.com', NULL, NULL, 'open');

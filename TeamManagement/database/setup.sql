CREATE DATABASE TaskManagement;

USE TaskManagement;

-- Users Table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('GeneralUser', 'AdminUser') NOT NULL
);

-- Tasks Table
CREATE TABLE Tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(100) NOT NULL,
    task_description TEXT,
    task_deadline INT CHECK (task_deadline BETWEEN 1 AND 10),
    assigned_to INT DEFAULT NULL,
    status ENUM('Pending', 'In Progress', 'Late', 'Completed') DEFAULT 'Pending',
    task_state ENUM('Unassigned', 'Assigned') DEFAULT 'Unassigned',
    FOREIGN KEY (assigned_to) REFERENCES Users(id) ON DELETE SET NULL
);

-- Admin Preset Password Table
CREATE TABLE AdminPresetPin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    preset_password VARCHAR(255) NOT NULL
);

-- Insert Default Admin Password
INSERT INTO AdminPresetPin (preset_password) VALUES ('AdminBoston');
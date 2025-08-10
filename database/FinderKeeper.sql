-- Create and use the FinderKeeper database
CREATE DATABASE IF NOT EXISTS FinderKeeper;
USE FinderKeeper;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contact VARCHAR(10) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- System Info table
CREATE TABLE IF NOT EXISTS system_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    meta_field VARCHAR(255) NOT NULL,
    meta_value TEXT DEFAULT NULL
);

-- Initial values for system_info
INSERT INTO system_info (meta_field, meta_value) VALUES
('title', 'FinderKeeper'),
('short_name', 'FK'),
('logo', 'assets/logo/logo.png');

-- Items table
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    category ENUM('Electronics', 'Documents', 'Clothing', 'Accessories', 'Others') NOT NULL,
    status ENUM('Lost', 'Found') NOT NULL,
    image TEXT DEFAULT NULL,
    contact_info VARCHAR(100) NOT NULL,
    description TEXT,
    date_reported TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Messages / Contact Form table
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
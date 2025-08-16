-- Library Management System Database Setup

-- Create database
CREATE DATABASE IF NOT EXISTS lms;
USE lms;

-- Create admin_panel table
CREATE TABLE IF NOT EXISTS admin_panel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    user_id VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create manage_books table
CREATE TABLE IF NOT EXISTS manage_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department VARCHAR(50) NOT NULL,
    book_title VARCHAR(255) NOT NULL,
    book_writer VARCHAR(255) NOT NULL,
    quality INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create borrow_list table
CREATE TABLE IF NOT EXISTS borrow_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    department VARCHAR(50) NOT NULL,
    s_id VARCHAR(50) NOT NULL,
    book_id INT,
    book_title VARCHAR(255),
    borrow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    return_date TIMESTAMP NULL,
    status ENUM('borrowed', 'returned') DEFAULT 'borrowed'
);

-- Insert sample admin user (username: admin, password: admin123)
INSERT INTO admin_panel (user_name, user_id, password) VALUES 
('Administrator', 'admin', 'admin123');

-- Insert sample books
INSERT INTO manage_books (department, book_title, book_writer, quality) VALUES 
('CSE', 'Introduction to Algorithms', 'Thomas H. Cormen', 5),
('CSE', 'Clean Code', 'Robert Cecil Martin', 3),
('CSE', 'Design Patterns', 'Gang of Four', 2),
('EEE', 'Electrical Engineering Fundamentals', 'Vincent Del Toro', 4),
('EEE', 'Power System Analysis', 'John Grainger', 3),
('Software', 'Software Engineering', 'Ian Sommerville', 6),
('Software', 'The Pragmatic Programmer', 'Andrew Hunt', 4);


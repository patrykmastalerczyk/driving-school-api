-- Database schema for driving school application
-- 
-- This file contains table structure for storing
-- driving lesson information

-- Create database (optional, if not exists)
CREATE DATABASE IF NOT EXISTS planjazd 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Use database
USE planjazd;

-- Table storing driving lesson information
CREATE TABLE IF NOT EXISTS drives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_date DATE NOT NULL COMMENT 'Lesson date',
    lesson_time TIME NOT NULL COMMENT 'Lesson time',
    instructor_name VARCHAR(255) NOT NULL COMMENT 'Instructor full name',
    student_name VARCHAR(255) NOT NULL COMMENT 'Student full name',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation date',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last update date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indexes for query optimization
CREATE INDEX idx_drives_lesson_date ON drives(lesson_date);
CREATE INDEX idx_drives_lesson_time ON drives(lesson_time);
CREATE INDEX idx_drives_instructor_name ON drives(instructor_name);
CREATE INDEX idx_drives_student_name ON drives(student_name);

-- Sample test data (optional)
INSERT INTO drives (lesson_date, lesson_time, instructor_name, student_name) VALUES
('2024-01-15', '09:00:00', 'Jan Kowalski', 'Anna Nowak'),
('2024-01-15', '11:30:00', 'Piotr Wiśniewski', 'Marek Zieliński'),
('2024-01-16', '14:00:00', 'Jan Kowalski', 'Katarzyna Krawczyk');

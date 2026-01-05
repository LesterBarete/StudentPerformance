
CREATE DATABASE IF NOT EXISTS student_performance;
USE student_performance;


CREATE TABLE IF NOT EXISTS students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    course VARCHAR(50),
    year_level INT
);


CREATE TABLE IF NOT EXISTS subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    final_grade DECIMAL(4,2),
    semester VARCHAR(20),
    academic_year VARCHAR(20),
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE
);

--Sample data--
INSERT INTO students (first_name, last_name, course, year_level) VALUES
('Lester', 'Barete', 'BSCS', 2),
('TJ', 'Buenaobra', 'BSCS', 2),
('Clarence', 'Olave', 'BSCS', 2);

INSERT INTO subjects (subject_name) VALUES
('Discrete Structure 2'),
('Ethics');

INSERT INTO grades (student_id, subject_id, final_grade, semester, academic_year) VALUES
(1, 2, 1.25, '1st Semester', '2025-2026'),
(2, 3, 1.50, '1st Semester', '2025-2026'),
(3, 2, 1.75, '1st Semester', '2025-2026');

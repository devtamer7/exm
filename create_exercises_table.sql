
CREATE TABLE exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    note TEXT,
    type ENUM('file', 'github_repo') NOT NULL,
    file_paths JSON, -- Stores an array of file paths for 'file' type
    github_repo_link VARCHAR(255), -- Stores the URL for 'github_repo' type
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    mentor_feedback TEXT,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

